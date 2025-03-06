
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default. Please note that
 * this is the WordPress construct of pages: specifically, posts with a post
 * type of `page`.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */

get_header();

$sopr = get_field('id_crm_eks');
if($sopr){
	$df = get_field('date_from_dup');
	$dt = get_field('date_till_dup');


	if($df && $dt){
		$df = strtotime($df);
		$dt = strtotime($dt)+3600*24;
		$cur_time = time();

		if($cur_time>=$df && $cur_time<=$dt){
			$args = array(
				'post_type' => 'tours',
				'numberposts' => -1,
				'meta_key' => 'id_crm',
				'meta_value' => $sopr,
				'post_status' => array('publish', 'private') // Получаем и опубликованные, и личные записи
			);
			$posts = get_posts($args);

			if($posts && count($posts)){
				global $post;
				$post = $posts[0]; // перепишем глоб. `$post`
				setup_postdata($posts[0]);
			}
		}
	}
}
$fields = get_fields($post->ID);

$sub = array(".01." => " января ", ".02." => " февраля ",
		".03." => " марта ", ".04." => " апреля ", ".05." => " мая ", ".06." => " июня ",
		".07." => " июля ", ".08." => " августа ", ".09." => " сентября ",
		".10." => " октября ", ".11." => " ноября ", ".12." => " декабря ", "2022" => '2022', '2023' => '2023', '2024'=>'2024', '2025'=>'2025','2026'=>'2026','00:00'=>'');

$returnDuration = true;
$returnPrice = true;
$returnGrade = true;

$json_decode = json_decode(get_post_meta(get_the_ID(), 'tickets', 1));
$sopr = $fields['id_crm_eks'];
if(!$json_decode && $sopr){
	$sopr_posts = get_posts([
			'post_type' => 'tours',
			'post_status' => 'any',
			'meta_query' => [
				[
						'key' => 'id_crm',
						'value' => $sopr
				]
			]
	]);

	$sopr_post = (isset($sopr_posts) && !empty($sopr_posts)) ? $sopr_posts[0] : null;
	if ($sopr_post) {
		$json_decode = json_decode(get_post_meta($sopr_post->ID, 'tickets', 1));
	}
}
$m = [
		'января',
		'февраля',
		'марта',
		'апреля',
		'мая',
		'июня',
		'июля',
		'августа',
		'сентября',
		'октября',
		'ноября',
		'декабря'
];
$uniqueArray = [];
$uniqueDates = [];
$datesArray = [];

if(is_array($json_decode)) {
	foreach ($json_decode as $item) {
		$json_decode_start_date = explode('.', $item->date);
		$start_dates =  $json_decode_start_date[0]. ' ' .$m[(int)$json_decode_start_date[1] -1];
		$startDates =  $json_decode_start_date[2]. '-' .$json_decode_start_date[1] . '-' . $json_decode_start_date[0];
		if (!in_array($start_dates, $uniqueArray)) {
			$uniqueArray[] = $start_dates;
			$uniqueDates[] = $startDates;

		}
		$datesArray[] = $startDates;
	}
}


// Обработка фильтра по duration

if(!empty($duration)) {
	$durationRange = convertTime($fields['duration']) ?? 0 ;
	$returnDuration = false;
	foreach ($duration as $duration_range) {
		if ($duration_range) {
			$explode = explode('-', $duration_range);
			if (($durationRange >= (int)$explode[0]) && ($durationRange <= (int)$explode[1])) {
				$returnDuration = true;
			}
		}
	}
}


$returnDateForm =  true;

// Обработка фильтра по price_range
if (!empty($price_ranges)) {
	$priceRange = get_cost($fields)['cost_sale'] ? get_cost($fields)['cost_sale'] : get_cost($fields)['cost'];
	$returnPrice = false;
	foreach ($price_ranges as $price_range) {
		if ($price_range) {
			list($min_price, $max_price) = explode('-', $price_range);
			$min_price = floatval($min_price);
			$max_price = floatval($max_price);
			if ((int)$priceRange >= (int)$min_price && (int)$priceRange <=  (int)$max_price) {
				$returnPrice = true;
			}
		}
	}
}

$start_time = (isset($fields['start_time']) &&!empty($fields['start_time']))  ? $fields['start_time'] : (get_post_meta(get_the_ID(), 'times_crm', 1) ?? 'по запросу') ;

?>
<section class="primary">
	<main id="main">
		<?php get_template_part( 'template-parts/layout/breadcrumbs', 'content' ); ?>

		<article class="my-4 sm:my-11"  itemscope itemtype="https://schema.org/Product">

			<div id="posts-container" class="mb-[48px]">
				<div class="container">
					<header class="entry-header">
						<h1 class="mt-2 mb-4 sm:mb-2 sm:mb-8 text-[20px] sm:text-[32px] font-bold sm:leading-9 tracking-[0.1px]" itemprop="name"><?php the_title(); ?></h1>
					</header>
					<div class="flex flex-col lg:grid lg:grid-cols-15 gap-8 mb-7">
						<div class="w-full lg:col-span-8 ">
							<div class="swiper_tour flex flex-col gap-1 sm:gap-5">
								<div class="swiper mySwiper2 w-full sm:h-[405px] h-[200px] mx-0 fancy-video">
									<div class="swiper-wrapper">
										<?php if(isset($fields["galery"]) && !empty($fields["galery"])): ?>
											<?php foreach ($fields["galery"] as $image) : ?>
											<div class="swiper-slide text-center flex justify-center items-center bg-cover rounded-md overflow-hidden relative cursor-pointer">
												<img itemprop="image" data-fancybox="gallery" src="<?php echo $image["url"] ?>" class="block w-full h-full object-cover" alt="<?php echo $image["title"] ?>"
												 data-src="<?php echo $image["url"] ?>" data-caption="Павловск">
												 <?php if($image["description"]): ?>
													<?php if($image["caption"]): ?>
														<a target="_blank" href="<?php echo $image["caption"] ?>" class="block absolute bottom-4 left-4 right-4 text-[#FFFFFF] text-[9px] sm:text-[16px] font-semibold opacity-40">
															<span class="block bg-[#000] px-2 py-1 rounded-[4px] text-left leading-[1.3]"><?php echo trim($image["description"])  ?></span>
														</a>
													<?php else: ?>
														<div class="absolute bottom-4 left-4 right-4 text-[#FFFFFF] text-[13px] sm:text-[16px] font-semibold opacity-60 pointer-events-none bg-[#000]">
															<span class="block bg-[#000] px-2 py-1 rounded-[4px] text-left leading-[1.3]"><?php echo trim($image["description"])  ?></span>
														</div>
													<?php endif ?>
												<?php endif ?>
											</div>
											<?php endforeach; ?>
										<?php else: ?>
											<img class="w-full h-full object-cover rounded-lg bg-gray-300" src="<?php echo get_stylesheet_directory_uri(); ?>/img/woocommerce-placeholder.webp" alt="No image available">
										<?php endif ?>
									</div>
								</div>
								<div class="w-full h-[71px] sm:h-[137px] fancy-video">
									<div class="grid grid-cols-3 w-full gap-2 h-full">
										<?php if(isset($fields["galery"]) && !empty($fields["galery"])): $count = 0; ?>
											<?php foreach ($fields["galery"] as $image) : ?>
												<div class="relative text-center h-full flex justify-center items-center bg-cover cursor-pointer rounded-md overflow-hidden<?php if (++$count > 3) echo ' hidden'; ?>">
													<img
													data-fancybox="gallery-2"
													src="<?php echo $image["url"] ?>"
													class="block min-w-[106px] h-full w-full object-cover"
													alt="<?php echo $image["title"] ?>"
													>
													<?php if ($count ===3 && count($fields["galery"])>3): // Если это 4-я скрытая картинка ?>
														<div class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-50 pointer-events-none">
															<span class="text-white text-[14px] md:text-[18px] font-medium">Ещё <?php echo count($fields["galery"])-3; ?> фото</span>
														</div>
													<?php endif; ?>
												</div>

											<?php endforeach; ?>
										<?php endif ?>
									</div>
								</div>
							</div>

						</div>
						<div id="response" class="shadows_custom w-full lg:col-span-7 px-6 sm:px-8 py-7">
							<div class="justify-between flex text-[14px] sm:text-[16px] items-start">
								<div class=""  itemprop="offers" itemscope itemtype="https://schema.org/Offer">
									<meta itemprop="priceCurrency" content="RUB">
									<?php if (get_cost($fields)['cost_sale']) : ?>
										<div class="text-[18px] sm:text-[20px] line-through leading-[1.3] mb-2">
											от <span itemprop="price"><?php echo get_cost($fields)['cost']; ?></span> ₽
										</div>
									<?php endif ?>
									<div class="flex-col justify-start items-start gap-0.5 inline-flex text-[#52a6b2] mb-6">
										<?php if (get_cost($fields)['cost_sale']) : ?>
											<div class="self-stretch font-medium">ваша выгода: <?php $sale = ((int)get_cost($fields)['cost'] - (int)get_cost($fields)['cost_sale'])  ;  echo ($sale)   ; ?> ₽</div>
											<div class="self-stretch text-[28px] font-bold ">
												от <span itemprop="price"><?php echo get_cost($fields)['cost_sale']; ?></span> ₽
											</div>
										<?php else: ?>
											<div class="self-stretch text-[28px] font-bold ">
												от <span itemprop="price"><?php echo get_cost($fields)['cost']; ?></span> ₽
											</div>
										<?php endif; ?>
										<div class="text-gray-500">за человека</div>
									</div>
								</div>
								<button class="wish-btn flex items-center gap-1 group" data-wp-id="830" aria-label="Добавить в избранное">
									<span class="w-9 h-9 rounded-full bg-white flex items-center justify-center">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart.svg" alt="" class="object-cover block group-[:hover]:hidden group-[.active]:hidden">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart-hover.svg" alt="" class="object-cover hidden group-[:hover]:block group-[.active]:hidden">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart-active.svg" alt="" class="object-cover hidden group-[.active]:block">
									</span>
									<span class="bold  group-[:hover]:text-[#D6BD7F] group-[.active]:text-[#D6BD7F]">Избранное</span>
								</button>
							</div>

							<div class="flex-col justify-start items-start gap-[14px] inline-flex mb-6">
								<?php if(count($uniqueArray)) : ?>
									<div class="justify-start items-start gap-2 inline-flex">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M8 7V3M16 7V3M7 11H17M5 21H19C20.1046 21 21 20.1046 21 19V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V19C3 20.1046 3.89543 21 5 21Z" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										<div class="grow shrink basis-0 relative">
											<div class="text-lg font-normal leading-[1.2] flex flex-col sm:flex-row sm:gap-1">
												<span> Ближайшие даты: </span>
												<span>  <?php echo $uniqueArray[0]; ?> | <?php echo $uniqueArray[1]; ?></span>
											</div>
											<?php if(count($uniqueArray)>2) : ?>
												<a href="#order_form-page" class=" text-[#52a6b2] text-lg font-normal leading-[1.2]">Другие даты</a>

											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
								<div class="justify-start items-start gap-2 flex">
									<div сlass="min-w-[24px] w-[24px]">
										<svg class="w-6 mt-[2px]"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M14.7519 11.1679L11.5547 9.03647C10.8901 8.59343 10 9.06982 10 9.86852V14.1315C10 14.9302 10.8901 15.4066 11.5547 14.9635L14.7519 12.8321C15.3457 12.4362 15.3457 11.5638 14.7519 11.1679Z" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
									<div class="grow shrink basis-0 text-[#1a1a18] text-lg font-normal leading-[1.2]">Начало: <?php echo str_replace(",", ", ", $start_time) ; ?></div>
								</div>
								<?php if (isset($fields['duration']) && $fields['duration']) : ?>
									<div class="justify-start items-center gap-2 inline-flex">
										<div сlass="min-w-[24px] w-[24px]">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
										<div class="grow shrink basis-0 text-[#1a1a18] text-lg font-normal leading-[1.2]">Длительность: <?php echo $fields['duration']; ?></div>
									</div>
								<?php endif; ?>
								<div class="justify-start items-center gap-2 inline-flex">
									<div сlass="min-w-[24px] w-[24px]">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M8 14V17M12 14V17M16 14V17M3 21H21M3 10H21M3 7L12 3L21 7M4 10H20V21H4V10Z" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
									<div class="grow shrink basis-0 text-[#1a1a18] text-lg font-normal leading-[1.2]">Дни проведения: <?php echo $fields['periodicity']; ?></div>
								</div>
								<div class="justify-start items-start gap-2 inline-flex">
									<div сlass="min-w-[24px] w-[24px]">
									<svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M17.6569 16.6569C16.7202 17.5935 14.7616 19.5521 13.4138 20.8999C12.6327 21.681 11.3677 21.6814 10.5866 20.9003C9.26234 19.576 7.34159 17.6553 6.34315 16.6569C3.21895 13.5327 3.21895 8.46734 6.34315 5.34315C9.46734 2.21895 14.5327 2.21895 17.6569 5.34315C20.781 8.46734 20.781 13.5327 17.6569 16.6569Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M15 11C15 12.6569 13.6569 14 12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									</div>
									<?php $addr = (get_post_meta(get_the_ID(), 'on_address', 1)) ? 'Московский вокзал или Невский, 17' : 'Московский вокзал'; ?>

									<div class="text-[#1a1a18] text-lg font-normal  leading-[1.2]">Место встречи: <span class="block sm:inline"><?php echo $addr; ?></span></div>
								</div>
								<div class="justify-start items-start gap-2 inline-flex">
								<div сlass="min-w-[24px] w-[24px]">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M17.6569 16.6569C16.7202 17.5935 14.7616 19.5521 13.4138 20.8999C12.6327 21.681 11.3677 21.6814 10.5866 20.9003C9.26234 19.576 7.34159 17.6553 6.34315 16.6569C3.21895 13.5327 3.21895 8.46734 6.34315 5.34315C9.46734 2.21895 14.5327 2.21895 17.6569 5.34315C20.781 8.46734 20.781 13.5327 17.6569 16.6569Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M15 11C15 12.6569 13.6569 14 12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									</div>
									<?php $end_point =  (isset($fields['end_point']) && !empty($fields['end_point'])) ? $fields['end_point'] : ' Лиговский проспект 43/45'; ?>

									<div class="text-[#1a1a18] text-lg font-normal  leading-[1.2]">Место окончания: <span class="block sm:inline"><?php echo $end_point; ?></span> </div>
								</div>
							</div>


							<a href="#order_form-page" class="inline-flex h-11 items-center justify-center font-medium sm:font-medium px-7 sm:px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px] mb-3">Забронировать билет</a>
							<div class="text-gray-500 text-[14px]">Оплатить экскурсию можно на сайте или в нашем офисе</div>


						</div>
					</div>
					<div class="g-scrolling-carousel relative">
					<div class="py-5 sm:py-[18px] sm:px-8 flex gap-5 sm:gap-8 lg:gap-8 mt-5 sm:mt-3 mb-5 sm:mb-[18px]  text-sm sm:text-[12px] lg:text-sm border-b-2 border-[#D6BD7F] text-nowrap no-scrollbar  overflow-x-auto">
						<a href="#sectionDesc" class="font-bold hover:text-[#52a6b2]">Что вас ждет на экскурсии</a>

						<?php if(isset($fields['programm']) && !empty($fields['programm'])): ?>
							<a href="#sectionProgram" class="font-bold hover:text-[#52a6b2]">Программа</a>
						<?php endif; ?>

						<a href="#cost_block" class="font-bold hover:text-[#52a6b2]">Включено в стоимость</a>
						<?php if(!isset($fields['excludes_hide']) || (isset($fields['excludes_hide']) && empty($fields['excludes_hide']))): ?>
							<a href="#pay_else" class="font-bold hover:text-[#52a6b2]">Оплачивается отдельно</a>
						<?php endif; ?>
						<a href="#order_form-page" class="font-bold hover:text-[#52a6b2]">Забронировать</a>
						<a href="#sectionInfo" class="font-bold hover:text-[#52a6b2]">Полезная информация</a>
						<a href="#sectionRev" class="font-bold hover:text-[#52a6b2]">Отзывы</a>
					</div>
					</div>

					<div class="overflow-x-hidden">

						<div class="entry-content">
							<?php if(isset($fields['tour_description']) && !empty($fields['tour_description'])): ?>
							<div class="lg:pt-4 pb-2 big-title border-b-2 border-[#E5E7EB]" id="sectionDesc">
								<?php echo $fields['tour_description']; ?>
							</div>
							<?php endif; ?>

							<?php if(isset($fields['programm']) && !empty($fields['programm'])): ?>
								<div id="sectionProgram" class="swiper_block pt-12 pb-0 sm:pb-2">
									<h3 class="sm:text-[24px] mb-10">Программа экскурсии</h3>
									<div class="program  relative ">
										<div class="pt-2 lg:pt-0">
											<div class="vertical-dash big-title">
												<div class="content">
													<?php echo $fields['programm']; ?>
												</div>
											</div>
											<?php if(isset($fields['programm_dop']) && !empty($fields['programm_dop'])): ?>
											<div class="ps-2 big-title">
												<div class="content">
													<?php echo $fields['programm_dop']; ?>
												</div>
											</div>
											<?php endif; ?>
										</div>
									</div>
									<?php if(isset($fields['programm_slide']) && !empty($fields['programm_slide'])): ?>
										<div class="swiper swiperBlock">
											<div class="swiper-wrapper text-[14px]">
													<?php foreach ($fields['programm_slide'] as $image) : ?>
														<a href="<?php echo $image; ?>" class="swiper-slide" data-fancybox="gallery_slider">
															<img src="<?php echo $image; ?>" alt="image" class="object-cover h-[94px] sm:h-[137px] w-full rounded-[4px]">
														</a>
													<?php endforeach; ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>


							<div class="cost_block mt-4 sm:mt-12 pt-6">
									<?php if(isset($fields['video_after_gates_dzen']) && !empty($fields['video_after_gates_dzen'])): ?>
										<h2 class="sm:mb-8 mt-0">Как проходит экскурсия</h2>
									<?php endif; ?>
								<div class="justify-start items-start gap-8 md:gap-[54px] flex flex-col md:flex-row sm:border-b pb-[32px] sm:pb-[50px] w-full">

									<?php if(isset($fields['video_after_gates_dzen']) && !empty($fields['video_after_gates_dzen'])): ?>

										<?php $previewImage = $fields['video_after_gates_dzen_img'] ??   get_stylesheet_directory_uri() . "/img/woocommerce-placeholder.webp"; ?>

										<div class="w-full md:w-[60%] h-[440px] px-[77px] py-11  rounded justify-center items-center gap-2.5 flex object-cover cursor-pointer" style="background: url(<?php echo $previewImage; ?>)" data-src="<?php echo getDzenEmbedUrl($fields['video_after_gates_dzen']); ?>"  data-fancybox="vidieo" data-type="iframe">
											<div class="w-16 h-16 relative  overflow-hidden">
												<div class="w-12 h-12 left-[8px] top-[8px] absolute">
													<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
														<circle cx="32" cy="32" r="24" fill="#D6BD7F"/>
														<path d="M25.333 43.3901V20.6098C25.333 19.7965 26.2524 19.3234 26.9142 19.7961L42.8604 31.1863C43.4188 31.5851 43.4188 32.4149 42.8604 32.8137L26.9142 44.2039C26.2524 44.6766 25.333 44.2035 25.333 43.3901Z" fill="white"/>
													</svg>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<div class="flex-col justify-start items-start gap-8 sm:gap-12 inline-flex">
										<div id="cost_block">
											<h3 class="text-[20px] sm:text-[24px] mt-0 mb-5 md:mb-8">Что включено в стоимость</h3>
											<div class="self-stretch flex-col justify-start items-start gap-3 flex">

												<?php if(isset($fields['includes']) && !empty($fields['includes'])): ?>
													<?php foreach ($fields['includes'] as $item) : ?>
														<div class="justify-start items-center gap-2 inline-flex">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#52A6B2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
															</svg>
															<div class="text-[#1a1a18] text-lg font-normal leading-normal"><?php echo $item['item']; ?></div>
														</div>
													<?php endforeach; ?>
												<?php else: ?>
													<div class="justify-start items-center gap-2 inline-flex">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#52A6B2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
														<div class="text-[#1a1a18] text-lg font-normal leading-normal">Транспортное обслуживание</div>
													</div>
													<div class="justify-start items-center gap-2 inline-flex">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#52A6B2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
														<div class="text-[#1a1a18] text-lg font-normal leading-normal">Услуги экскурсовода</div>
													</div>
													<div class="justify-start items-center gap-2 inline-flex">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#52A6B2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
														<div class="text-[#1a1a18] text-lg font-normal leading-normal">Билеты в музеи</div>
													</div>
												<?php endif; ?>
											</div>
										</div>
										<div id="pay_else">
											<?php if(!isset($fields['excludes_hide']) || (isset($fields['excludes_hide']) && empty($fields['excludes_hide']))): ?>
												<h3 class="text-[20px] sm:text-[24px] mt-0 mb-5 md:mb-8">Оплачивается дополнительно</h3>
												<div class="self-stretch flex-col justify-start items-start gap-3 flex">

													<?php if(isset($fields['excludes']) && !empty($fields['excludes'])): ?>
														<?php foreach ($fields['excludes'] as $item) : ?>
															<div class="self-stretch justify-start items-center gap-2 inline-flex">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#D6BD7F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
																</svg>
																<div class="grow shrink basis-0 text-[#1a1a18] text-lg font-normal leading-normal"><?php echo $item['item']; ?></div>
															</div>
														<?php endforeach; ?>
													<?php else: ?>
													<div class="self-stretch justify-start items-center gap-2 inline-flex">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#D6BD7F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
														<div class="grow shrink basis-0 text-[#1a1a18] text-lg font-normal leading-normal">Обед</div>
													</div>
													<div class="justify-start items-center gap-2 inline-flex">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#D6BD7F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
														<div class="text-[#1a1a18] text-lg font-normal leading-normal">Посещение дополнительных экскурсий</div>
													</div>
													<?php endif; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
							<?php if(isset($startDates)): ?>
							<form class="flex-col justify-start items-start md:gap-4 flex" id="order_form-page" data-crm="<?php echo $fields['id_crm']; ?>" method="post" enctype="multipart/form-data">
								<h2 class="mt-4">Забронировать экскурсию</h2>
								<h3 class="mt-0 sm:text-[24px]">Выберите дату</h3>
								<label class="hidden">
									<input
										type="date"
										value="<?php echo $startDates ?>"
										required
										class="form__date timeinp"
										name="form_date"
									/>
									<?php
										$sd = explode('-', $startDates);
									?>
									<input type="text" name="fake_form_date" class="fake_form_date" value="<?php echo $sd[2]?>.<?php echo $sd[1]?>.<?=$sd[0]?>">
									<input type="hidden" name="trip" value="">
									<input type="hidden" name="id_crm" id="id_crm" value="<?php echo $fields['id_crm']; ?>">
									<input type="hidden" name="true_price" value="">
									<input type="hidden" name="amount" value="0">
									<input type="hidden" name="date_and_time" id="date_and_time" value="" />
									<input type="hidden" name="post_id" id="date_and_time" value="<?php echo get_the_ID()?>" />
									<input type="hidden" name="clientID" id="clientID" value="<?php echo $_COOKIE["_ym_uid"]; ?>">
									<input type="hidden" name="utm_source" id="utm_source" value="<?php echo $_COOKIE["utm_source"]; ?>"/>
									<input type="hidden" name="discount" id="discount" data-fulldiscount="0" value="100">
									<input type="hidden" name="title" value="<?php echo get_the_title()?>">
									<input type="hidden" name="ex_link" value="<?php echo get_page_link(); ?>">
									<input type="hidden" id="a1" name="adr" value="Московский вокзал, Лиговский проспект 43/45" />


									<?php if(isset($fields["p_doshkolniki_sale"]) && !empty($fields["p_doshkolniki_sale"])) : ?>
										<input type="hidden" name="price_childs" value="<?php echo $fields["p_doshkolniki_sale"]; ?>">
									<?php elseif(isset($fields["p_doshkolniki"]) && !empty($fields["p_doshkolniki"])): ?>
										<input type="hidden" name="price_childs" value="<?php echo $fields["p_doshkolniki"]; ?>">
									<?php endif; ?>

									<?php if(isset($fields["p_shkolniki_sale"]) && !empty($fields["p_shkolniki_sale"])) : ?>
										<input type="hidden" name="price_school" value="<?php echo $fields["p_shkolniki_sale"]; ?>">
									<?php elseif(isset($fields["p_shkolniki"]) && !empty($fields["p_shkolniki"])): ?>
										<input type="hidden" name="price_school" value="<?php echo $fields["p_shkolniki"]; ?>">
									<?php endif; ?>

									<?php if(isset($fields["p_studenty_sale"]) && !empty($fields["p_studenty_sale"])) : ?>
										<input type="hidden" name="price_students" value="<?php echo $fields["p_studenty_sale"]; ?>">
									<?php elseif(isset($fields["p_studenty"]) && !empty($fields["p_studenty"])): ?>
										<input type="hidden" name="price_students" value="<?php echo $fields["p_studenty"]; ?>">
									<?php endif; ?>

									<?php if(isset($fields["p_vzroslie_sale"]) && !empty($fields["p_vzroslie_sale"])) : ?>
										<input type="hidden" name="price_adults" value="<?php echo $fields["p_vzroslie_sale"]; ?>">
									<?php elseif(isset($fields["p_vzroslie"]) && !empty($fields["p_vzroslie"])): ?>
										<input type="hidden" name="price_adults" value="<?php echo $fields["p_vzroslie"]; ?>">
									<?php endif; ?>

									<?php if(isset($fields["p_pensionery_sale"]) && !empty($fields["p_pensionery_sale"])) : ?>
										<input type="hidden" name="price_old" value="<?php echo $fields["p_pensionery_sale"]; ?>">
									<?php elseif(isset($fields["p_pensionery"]) && !empty($fields["p_pensionery"])): ?>
										<input type="hidden" name="price_old" value="<?php echo $fields["p_pensionery"]; ?>">
									<?php endif; ?>

									<?php if(isset($fields["p_vzroslie_inostrancy_sale"]) && !empty($fields["p_vzroslie_inostrancy_sale"])) : ?>
										<input type="hidden" name="price_adults_for" value="<?php echo $fields["p_vzroslie_inostrancy_sale"]; ?>">
									<?php elseif(isset($fields["p_vzroslie_inostrancy"]) && !empty($fields["p_vzroslie_inostrancy"])): ?>
										<input type="hidden" name="price_adults_for" value="<?php echo $fields["p_vzroslie_inostrancy"]; ?>">
									<?php endif; ?>

								</label>
								<div class="justify-start items-start gap-5 hidden md:flex dateButtonsContainer">
									<div class="justify-start items-start gap-5 hidden md:flex dateButtonsContainer" id="dateButtonsContainer"></div>
									<div class="relative">
										<button id="show_calendar"  aria-expanded="true" data-close-on-click="false"  type="button" class="hidden dropdown-button w-[212px] px-10 py-[18px] bg-white border border-gray-200 flex-col justify-start items-center gap-2 inline-flex">
											<svg class="pointer-events-none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M8 7V3M16 7V3M7 11H17M5 21H19C20.1046 21 21 20.1046 21 19V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V19C3 20.1046 3.89543 21 5 21Z" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											<span class="self-stretch justify-center items-center inline-flex pointer-events-none">
													<span class="text-[#1a1a18] text-lg font-normal leading-normal">Выбрать дату</span>
												</span>
										</button>
										<div class="dropdown-menu absolute right-0 z-10 mt-2  w-[310px] origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none hidden left-0 mx-auto">
											<div class="p-4">

												<div id="calendarSelected" class="w-full pointer-events-none"></div>
											</div>
										</div>


									</div>
									<input type="text" id="dateInput" name="date" class="hidden w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Выберите дату">
								</div>



								<h3 class="mt-0 sm:mt-5 sm:text-[24px]">Выберите время</h3>
								<div class="flex-col justify-start items-start gap-5 flex mb-6">
									<div class="tickets_addr_items justify-between items-start flex flex-wrap gap-[10px] md:gap-[14px]">
										<button type="button" class="hidden justify-center items-center gap-8 flex h-[40px] px-[18px] sm:px-7 border-2 bg-white border-gray-200 sm:text-[18px] sm:h-[48px]">
											<span>9:30</span>
										</button>
										<button type="button" class="hidden justify-center items-center gap-8 flex h-[40px] px-[18px] sm:px-7 border-2 bg-[#52a6b2] text-white border-[#52a6b2] sm:text-[18px] sm:h-[48px]">
											<span>10:00</span>
										</button>
									</div>
									<div class="tickets_addr_note"></div>
									<div class="text-[#1a1a18] text-lg font-normal leading-normal">Вы выбрали <span class="selected_info"></span></div>
								</div>
								<div class="self-stretch flex-col justify-start items-start gap-6 flex">
									<h3 class="mt-0 sm:text-[24px]">Выберите количество билетов</h3>

									<div class="self-stretch flex-col justify-start items-start gap-5 flex tours-content__form-title">
										<?php if(isset($fields["p_doshkolniki"]) && !empty($fields["p_doshkolniki"])): ?>
											<div class="self-stretch justify-start items-start gap-8 inline-flex">
												<div class="grow shrink basis-0 self-stretch flex-col justify-start items-start gap-5 flex">
													<div class="self-stretch md:px-4 justify-between md:items-center flex flex-col md:flex-row gap-3 md:gap-0">
														<div class="font-normal leading-normal">
															<span>Дошкольный</span>
														</div>
														<div class="md:justify-end items-center gap-[30px] md:gap-12 flex text-nowrap">
															<?php if(isset($fields["p_doshkolniki_sale"]) && !empty($fields["p_doshkolniki_sale"])) : ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-gray-500 font-normal line-through leading-normal"><?php echo $fields["p_doshkolniki"];?> ₽</div>
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_doshkolniki_sale"]; ?></span> ₽
																	</div>
																</div>
															<?php else: ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_doshkolniki"]; ?></span> ₽
																	</div>
																</div>
															<?php endif; ?>

															<div class="justify-start items-center gap-[30px] md:gap-12 flex">
																<label class="justify-center items-center flex">
																	<button type="button" class="pe-3 decrease-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#6B7280"/>
																			<path d="M16.4716 11.4V13.0705H8V11.4H16.4716Z" fill="#6B7280"/>
																		</svg>
																	</button>
																	<input type="text" class="text-[#1a1a18] text-lg font-normal leading-normal w-[23px] quantity-input" value="0" min="0" name="sold_childs" readonly="">
																	<button type="button" class="increase-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#52A6B2"/>
																			<path d="M11.4489 17.9881V5.40002H13.1491V17.9881H11.4489ZM6 12.5392V10.8489H18.598V12.5392H6Z" fill="#52A6B2"/>
																		</svg>
																	</button>
																</label>
																<div class="text-[#52a6b2] text-lg font-bold leading-normal min-w-[67px]"><span class="price">0</span> ₽</div>
															</div>
														</div>
													</div>
													<div class="self-stretch h-[1.60px] bg-gray-200"></div>
												</div>
											</div>
										<?php endif; ?>
										<?php if(isset($fields["p_shkolniki"]) && !empty($fields["p_shkolniki"])): ?>
											<div class="self-stretch justify-start items-start gap-8 inline-flex">
												<div class="grow shrink basis-0 self-stretch flex-col justify-start items-start gap-5 flex">
													<div class="self-stretch md:px-4 justify-between md:items-center flex flex-col md:flex-row gap-3 md:gap-0">
														<div class="font-normal leading-normal flex items-center gap-3">
															<span>Школьный</span>
															<div class="flex items-center">
																<div class="group relative">
																	<div class="cursor-pointer flex gap-1 items-center">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path fill-rule="evenodd" clip-rule="evenodd" d="M21.2 12.1C21.2 17.4019 16.9019 21.7 11.6 21.7C6.29807 21.7 2 17.4019 2 12.1C2 6.79807 6.29807 2.5 11.6 2.5C16.9019 2.5 21.2 6.79807 21.2 12.1ZM12.8 7.3C12.8 7.96274 12.2627 8.5 11.6 8.5C10.9373 8.5 10.4 7.96274 10.4 7.3C10.4 6.63726 10.9373 6.1 11.6 6.1C12.2627 6.1 12.8 6.63726 12.8 7.3ZM10.4 10.9C9.73726 10.9 9.2 11.4373 9.2 12.1C9.2 12.7627 9.73726 13.3 10.4 13.3V16.9C10.4 17.5627 10.9373 18.1 11.6 18.1H12.8C13.4627 18.1 14 17.5627 14 16.9C14 16.2373 13.4627 15.7 12.8 15.7V12.1C12.8 11.4373 12.2627 10.9 11.6 10.9H10.4Z" fill="#D6BD7F"/>
																		</svg>
																		<div class="flex-col justify-start items-center gap-px inline-flex">
																			<div class="text-gray-500 leading-normal">узнать возраст</div>
																			<div data-svg-wrapper>
																				<svg width="120" height="2" viewBox="0 0 120 2" fill="none" xmlns="http://www.w3.org/2000/svg">
																					<path d="M0.200195 0.599976H136.2" stroke="#6B7280" stroke-dasharray="3 3"/>
																				</svg>
																			</div>
																		</div>
																	</div>
																	<div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 w-[206px] p-2 text-white text-xs bg-gray-900 rounded-md shadow-md opacity-0 invisible transition-opacity duration-200 group-hover:opacity-100 group-hover:visible">
																		Обзорные экскурсии - до 18 лет. <br>
																		Пушкин и Петергоф - до 14 лет. <br>
																		Павловск - до 16 лет. <br>
																		Гатчина - до 18 лет. <br>
																	</div>
																</div>
															</div>
														</div>
														<div class="md:justify-end items-center gap-[30px] md:gap-12 flex text-nowrap">
															<?php if(isset($fields["p_shkolniki_sale"]) && !empty($fields["p_shkolniki_sale"])) : ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-gray-500 font-normal line-through leading-normal"><?php echo $fields["p_shkolniki"];?> ₽</div>
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_shkolniki_sale"]; ?></span> ₽
																	</div>
																</div>
															<?php else: ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_shkolniki"]; ?></span> ₽
																	</div>
																</div>
															<?php endif; ?>
															<div class="justify-start items-center gap-[30px] md:gap-12 flex">
																<label class="justify-center items-center flex">
																	<button type="button" class="pe-3 decrease-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#6B7280"/>
																			<path d="M16.4716 11.4V13.0705H8V11.4H16.4716Z" fill="#6B7280"/>
																		</svg>
																	</button>
																	<input type="text" class="text-[#1a1a18] text-lg font-normal leading-normal w-[23px] quantity-input" value="0" min="0" name="sold_school" readonly="">
																	<button type="button" class="increase-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#52A6B2"/>
																			<path d="M11.4489 17.9881V5.40002H13.1491V17.9881H11.4489ZM6 12.5392V10.8489H18.598V12.5392H6Z" fill="#52A6B2"/>
																		</svg>
																	</button>
																</label>
																<div class="text-[#52a6b2] text-lg font-bold leading-normal min-w-[67px]"><span class="price">0</span> ₽</div>
															</div>
														</div>
													</div>
													<div class="self-stretch h-[1.60px] bg-gray-200"></div>
												</div>
											</div>
										<?php endif; ?>
										<?php if(isset($fields["p_studenty"]) && !empty($fields["p_studenty"])): ?>
											<div class="self-stretch justify-start items-start gap-8 inline-flex">
												<div class="grow shrink basis-0 self-stretch flex-col justify-start items-start gap-5 flex">
													<div class="self-stretch md:px-4 justify-between md:items-center flex flex-col md:flex-row gap-3 md:gap-0">
														<div class="font-normal leading-normal">
															<span>Студенческий </span>
														</div>
														<div class="md:justify-end items-center gap-[30px] md:gap-12 flex text-nowrap">
															<?php if(isset($fields["p_studenty_sale"]) && !empty($fields["p_studenty_sale"])) : ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-gray-500 font-normal line-through leading-normal"><?php echo $fields["p_studenty"];?> ₽</div>
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_studenty_sale"]; ?></span> ₽
																	</div>
																</div>
															<?php else: ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_studenty"]; ?></span> ₽
																	</div>
																</div>
															<?php endif; ?>
															<div class="justify-start items-center gap-[30px] md:gap-12 flex">
																<label class="justify-center items-center flex">
																	<button type="button" class="pe-3  decrease-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#6B7280"/>
																			<path d="M16.4716 11.4V13.0705H8V11.4H16.4716Z" fill="#6B7280"/>
																		</svg>
																	</button>
																	<input type="text" class="text-[#1a1a18] text-lg font-normal leading-normal w-[23px] quantity-input" value="0" min="0" name="sold_students" readonly="">
																	<button type="button" class="increase-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#52A6B2"/>
																			<path d="M11.4489 17.9881V5.40002H13.1491V17.9881H11.4489ZM6 12.5392V10.8489H18.598V12.5392H6Z" fill="#52A6B2"/>
																		</svg>
																	</button>
																</label>
																<div class="text-[#52a6b2] text-lg font-bold leading-normal min-w-[67px]"><span class="price">0</span> ₽</div>
															</div>
														</div>
													</div>
													<div class="self-stretch h-[1.60px] bg-gray-200"></div>
												</div>
											</div>
										<?php endif; ?>
										<?php if(isset($fields["p_vzroslie"]) && !empty($fields["p_vzroslie"])): ?>
											<div class="self-stretch justify-start items-start gap-8 inline-flex">
												<div class="grow shrink basis-0 self-stretch flex-col justify-start items-start gap-5 flex">
													<div class="self-stretch md:px-4 justify-between md:items-center flex flex-col md:flex-row gap-3 md:gap-0">
														<div class="font-normal leading-normal">
															<span>Взрослый</span>
														</div>
														<div class="md:justify-end items-center gap-[30px] md:gap-12 flex text-nowrap">
															<?php if(isset($fields["p_vzroslie_sale"]) && !empty($fields["p_vzroslie_sale"])) : ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-gray-500 font-normal line-through leading-normal"><?php echo $fields["p_vzroslie"];?> ₽</div>
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_vzroslie_sale"]; ?></span> ₽
																	</div>
																</div>
															<?php else: ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_vzroslie"]; ?></span> ₽
																	</div>
																</div>
															<?php endif; ?>
															<div class="justify-start items-center gap-[30px] md:gap-12 flex">
																<label class="justify-center items-center flex">
																	<button type="button" class="pe-3  decrease-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#6B7280"/>
																			<path d="M16.4716 11.4V13.0705H8V11.4H16.4716Z" fill="#6B7280"/>
																		</svg>
																	</button>
																	<input type="text" class="text-[#1a1a18] text-lg font-normal leading-normal w-[23px] quantity-input" value="0" min="0" name="sold_adults" readonly="">
																	<button type="button" class="increase-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#52A6B2"/>
																			<path d="M11.4489 17.9881V5.40002H13.1491V17.9881H11.4489ZM6 12.5392V10.8489H18.598V12.5392H6Z" fill="#52A6B2"/>
																		</svg>
																	</button>
																</label>
																<div class="text-[#52a6b2] text-lg font-bold leading-normal min-w-[67px]"><span class="price">0</span> ₽</div>
															</div>
														</div>
													</div>
													<div class="self-stretch h-[1.60px] bg-gray-200"></div>
												</div>
											</div>
										<?php endif; ?>
										<?php if(isset($fields["p_pensionery"]) && !empty($fields["p_pensionery"])): ?>
											<div class="self-stretch justify-start items-start gap-8 inline-flex">
												<div class="grow shrink basis-0 self-stretch flex-col justify-start items-start gap-5 flex">
													<div class="self-stretch md:px-4 justify-between md:items-center flex flex-col md:flex-row gap-3 md:gap-0">
														<div class="font-normal leading-normal">
															<span>Пенсионный</span>
														</div>
														<div class="md:justify-end items-center gap-[30px] md:gap-12 flex text-nowrap">
															<?php if(isset($fields["p_pensionery_sale"]) && !empty($fields["p_pensionery_sale"])) : ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-gray-500 font-normal line-through leading-normal"><?php echo $fields["p_pensionery"];?> ₽</div>
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_pensionery_sale"]; ?></span> ₽
																	</div>
																</div>
															<?php else: ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_pensionery"]; ?></span> ₽
																	</div>
																</div>
															<?php endif; ?>
															<div class="justify-start items-center gap-[30px] md:gap-12 flex">
																<label class="justify-center items-center flex">
																	<button type="button" class="pe-3  decrease-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#6B7280"/>
																			<path d="M16.4716 11.4V13.0705H8V11.4H16.4716Z" fill="#6B7280"/>
																		</svg>
																	</button>
																	<input type="text" class="text-[#1a1a18] text-lg font-normal leading-normal w-[23px] quantity-input" value="0" min="0" name="sold_old" readonly="">
																	<button type="button" class="increase-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#52A6B2"/>
																			<path d="M11.4489 17.9881V5.40002H13.1491V17.9881H11.4489ZM6 12.5392V10.8489H18.598V12.5392H6Z" fill="#52A6B2"/>
																		</svg>
																	</button>
																</label>
																<div class="text-[#52a6b2] text-lg font-bold leading-normal min-w-[67px]"><span class="price">0</span> ₽</div>
															</div>
														</div>
													</div>
													<div class="self-stretch h-[1.60px] bg-gray-200"></div>
												</div>
											</div>
										<?php endif; ?>
										<?php if(isset($fields["p_vzroslie_inostrancy"]) && !empty($fields["p_vzroslie_inostrancy"])): ?>
											<div class="self-stretch justify-start items-start gap-8 inline-flex">
												<div class="grow shrink basis-0 self-stretch flex-col justify-start items-start gap-5 flex">
													<div class="self-stretch md:px-4 justify-between md:items-center flex flex-col md:flex-row gap-3 md:gap-0">
														<div class="font-normal leading-normal">
															<span>Иностранный</span>
															<span class="text-gray-500">(кроме Белоруссии)</span>
														</div>
														<div class="md:justify-end items-center gap-[30px] md:gap-12 flex text-nowrap">
															<?php if(isset($fields["p_vzroslie_inostrancy_sale"]) && !empty($fields["p_vzroslie_inostrancy_sale"])) : ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-gray-500 font-normal line-through leading-normal"><?php echo $fields["p_vzroslie_inostrancy"];?> ₽</div>
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_vzroslie_inostrancy_sale"]; ?></span> ₽
																	</div>
																</div>
															<?php else: ?>
																<div class="justify-start items-center gap-[30px] flex">
																	<div class="text-lg font-bold leading-normal">
																		<span class="price"><?php echo $fields["p_vzroslie_inostrancy"]; ?></span> ₽
																	</div>
																</div>
															<?php endif; ?>
															<div class="justify-start items-center gap-[30px] md:gap-12 flex">
																<label class="justify-center items-center flex">
																	<button type="button" class="pe-3  decrease-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#6B7280"/>
																			<path d="M16.4716 11.4V13.0705H8V11.4H16.4716Z" fill="#6B7280"/>
																		</svg>
																	</button>
																	<input type="text" class="text-[#1a1a18] text-lg font-normal leading-normal w-[23px] quantity-input" value="0" min="0" name="sold_adults_for" readonly="">
																	<button type="button" class="increase-btn">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="0.5" y="0.5" width="23" height="23" rx="1.5" stroke="#52A6B2"/>
																			<path d="M11.4489 17.9881V5.40002H13.1491V17.9881H11.4489ZM6 12.5392V10.8489H18.598V12.5392H6Z" fill="#52A6B2"/>
																		</svg>
																	</button>
																</label>
																<div class="text-[#52a6b2] text-lg font-bold leading-normal min-w-[67px]"><span class="price">0</span> ₽</div>
															</div>
														</div>
													</div>
													<div class="self-stretch h-[1.60px] bg-gray-200"></div>
												</div>
											</div>
										<?php endif; ?>
									</div>
									<div class="w-full">
										<h3 class="sm:text-[24px] sm:mt-4 sm:mb-6">Внесите свои данные и забронируйте экскурсию</h3>
										<div class="flex justify-between flex-col md:flex-row gap-5 mb-5 w-full">
											<label class="fio_field w-full md:w-1/3 placeholder relative">
												<input class="bg-[#F2F4F9] text-[#373F41] text-[14px] rounded-[6px] w-full h-10 sm:h-11  px-4 focus:outline-none placeholder-transparent" name="name" type="text" placeholder="Номер телефона*">
												<span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#373F41] text-[14px] sm:text-[18px] transition-opacity pointer-events-none">
															Ваше ФИО<span class="text-[#373F41]">*</span>
														</span>
											</label>
											<label class="email_field w-full md:w-1/3 placeholder relative">
												<input class="bg-[#F2F4F9] text-[#373F41] text-[14px] rounded-[6px] w-full h-10 sm:h-11  px-4 focus:outline-none placeholder-transparent" name="mail" type="text" placeholder="Электронная почта*">
												<span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#373F41] text-[14px] sm:text-[18px] transition-opacity pointer-events-none">
															Электронная почта<span class="text-[#373F41]">*</span>
														</span>
											</label>
											<label class="phones_field w-full md:w-1/3 placeholder relative">
												<input class="bg-[#F2F4F9] text-[#373F41] text-[14px] rounded-[6px] w-full h-10 sm:h-11  px-4 focus:outline-none placeholder-transparent" name="phone" type="text" placeholder="Номер телефона*">
												<span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#373F41] text-[14px] sm:text-[18px] transition-opacity pointer-events-none">
															Номер телефона<span class="text-[#373F41]">*</span>
														</span>
											</label>
										</div>
										<label class="cursor-pointer">
											<span class="flex gap-2 items-center">
												<input type="checkbox" class="checkbox-input hidden" checked="">
												<span class="checkbox-box w-[16px] h-[16px]  border border-[#52A6B2] rounded-sm flex items-center justify-center bg-transparent">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
														<path d="M4.37891 9.31366L6.44772 11.3825L11.6197 6.21045" stroke="#52A6B2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													</svg>
												</span>
												<span class="text-[12px] leading-[12px]">Соглашаюсь на обработку <a target="_blank" class="link-underline" href="<?php echo esc_url(get_permalink(3)); ?>">персональных данных</a></span>
											</span>
										</label>
									</div>
									<div class="self-stretch justify-between items-center flex flex-col gap-3 md:flex-row sm:pt-2">
										<div class="flex-col justify-start items-start gap-6 inline-flex">
											<div class="flex-col justify-start items-start gap-6 flex">
												<div class="flex lex-col gap-1">
													<label class="px-6 h-[48px] bg-white rounded-md border border-[#99a4ba] justify-start items-center gap-2.5 inline-flex overflow-hidden">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
															<path d="M2.30307 7H21.6969C21.8643 7 22 7.15095 22 7.33707V10.1202C22 10.3063 21.8643 10.4572 21.6969 10.4572C21.1587 10.4572 20.6712 10.6998 20.3185 11.0921C19.966 11.4842 19.7478 12.0265 19.7478 12.6249C19.7478 13.2235 19.966 13.7657 20.3185 14.1578C20.6712 14.55 21.1587 14.7928 21.6969 14.7928C21.8643 14.7928 22 14.9437 22 15.1298V17.9129C22 18.099 21.8643 18.25 21.6969 18.25H2.30307C2.13573 18.25 2 18.099 2 17.9129V15.1298C2 14.9437 2.13573 14.7928 2.30307 14.7928C2.8413 14.7928 3.32875 14.55 3.6814 14.1579C4.03401 13.7657 4.25218 13.2235 4.25218 12.6249C4.25218 12.0265 4.03401 11.4842 3.6814 11.0921C3.32875 10.6998 2.8413 10.4572 2.30307 10.4572C2.13573 10.4572 2 10.3063 2 10.1202V7.33707C2 7.15095 2.13573 7 2.30307 7ZM21.3939 7.67397H8.34311V11.1241C8.34311 11.3102 8.20738 11.4612 8.04004 11.4612C7.87275 11.4612 7.73696 11.3102 7.73696 11.1241V7.67397H2.60609V9.80297C3.19057 9.87995 3.71463 10.1761 4.10984 10.6154C4.57213 11.1297 4.85827 11.8403 4.85827 12.6249C4.85827 13.4095 4.57213 14.1201 4.10984 14.6344C3.71463 15.0739 3.19057 15.37 2.60609 15.4469V17.5759H7.73696V14.1258C7.73696 13.9397 7.87275 13.7887 8.04004 13.7887C8.20738 13.7887 8.34311 13.9397 8.34311 14.1258V17.5759H21.3939V15.4469C20.8095 15.37 20.2854 15.0739 19.8902 14.6343C19.4279 14.1201 19.1418 13.4095 19.1418 12.6249C19.1418 11.8403 19.4279 11.1297 19.8902 10.6154C20.2854 10.1761 20.8095 9.87995 21.3939 9.80297V7.67397Z" fill="#6B7280"/>
														</svg>
														<input
																id="promoCode"
																type="text"
																name="promo"
																class="text-lg font-normal leading-normal w-[160px]"
																<?php if ($_COOKIE['promoCode']): ?>
																	value="<?php echo $_COOKIE['promoCode'];?>"
																<?php else: ?>
																	placeholder="Введите промокод"
																<?php endif ?>
														>
													</label>
													<span class="promo-loader"></span>
													<span id="promo_ok"></span>

												</div>
												<div class="justify-start items-start gap-6 sm:gap-8 inline-flex">
												<?php if (!$fields['no_advance_payment']): ?>

													<div class="justify-start items-center gap-3 flex relative">
														<div class="justify-start items-start gap-2.5 flex">
															<!-- Скрытый input -->
															<label class="flex items-center gap-1 sm:gap-3 cursor-pointer">
																<input  type="radio" name="20percent" value="on" class="w-4 h-4 accent-[#2595a5] hover:accent-[#2595a5]" />
																<span class="self-stretch text-gray-900 text-[14px] sm:text-[16px] font-medium leading-normal">Предоплата 20%</span>
															</label>
														</div>
														<div class="group relative">
															<svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M19.2 9.6C19.2 14.9019 14.9019 19.2 9.6 19.2C4.29807 19.2 0 14.9019 0 9.6C0 4.29807 4.29807 0 9.6 0C14.9019 0 19.2 4.29807 19.2 9.6ZM10.8 4.8C10.8 5.46274 10.2627 6 9.6 6C8.93726 6 8.4 5.46274 8.4 4.8C8.4 4.13726 8.93726 3.6 9.6 3.6C10.2627 3.6 10.8 4.13726 10.8 4.8ZM8.4 8.4C7.73726 8.4 7.2 8.93726 7.2 9.6C7.2 10.2627 7.73726 10.8 8.4 10.8V14.4C8.4 15.0627 8.93726 15.6 9.6 15.6H10.8C11.4627 15.6 12 15.0627 12 14.4C12 13.7373 11.4627 13.2 10.8 13.2V9.6C10.8 8.93726 10.2627 8.4 9.6 8.4H8.4Z" fill="#E5E7EB"/>
															</svg>
															<div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 w-[250px] p-2 text-white text-xs bg-gray-900 rounded-md shadow-md opacity-0 invisible transition-opacity duration-200 group-hover:opacity-100 group-hover:visible">
																После предоплаты 20%, вам нужно внести остаток у нас в офисе, не менее, чем за 30 минут до начала экскурсии.
															</div>
														</div>
													</div>


													<div class="justify-start items-center gap-3 flex relative">
														<div class="justify-start items-start gap-2.5 flex">
															<!-- Скрытый input -->
															<label class="flex items-center  gap-1 sm:gap-3 cursor-pointer">
																<input  type="radio" name="20percent" value="off" class="w-4 h-4 accent-[#2595a5] hover:accent-[#2595a5]" checked />
																<span class="self-stretch text-gray-900  text-[14px] sm:text-[16px] font-medium leading-normal">Оплата 100%</span>
															</label>
														</div>
														<div class="group relative">
														<svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M19.2 9.6C19.2 14.9019 14.9019 19.2 9.6 19.2C4.29807 19.2 0 14.9019 0 9.6C0 4.29807 4.29807 0 9.6 0C14.9019 0 19.2 4.29807 19.2 9.6ZM10.8 4.8C10.8 5.46274 10.2627 6 9.6 6C8.93726 6 8.4 5.46274 8.4 4.8C8.4 4.13726 8.93726 3.6 9.6 3.6C10.2627 3.6 10.8 4.13726 10.8 4.8ZM8.4 8.4C7.73726 8.4 7.2 8.93726 7.2 9.6C7.2 10.2627 7.73726 10.8 8.4 10.8V14.4C8.4 15.0627 8.93726 15.6 9.6 15.6H10.8C11.4627 15.6 12 15.0627 12 14.4C12 13.7373 11.4627 13.2 10.8 13.2V9.6C10.8 8.93726 10.2627 8.4 9.6 8.4H8.4Z" fill="#E5E7EB"/>
															</svg>
															<div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 w-[250px] p-2 text-white text-xs bg-gray-900 rounded-md shadow-md opacity-0 invisible transition-opacity duration-200 group-hover:opacity-100 group-hover:visible">
																После 100% оплаты, вам не нужно беспокоиться о внесении остатка, сразу приезжайте к месту начала экскурсии.
															</div>
														</div>
													</div>
												<?php endif; ?>
												</div>
											</div>
											<div class="flex-col justify-start items-start gap-[9px] flex">
												<svg xmlns="http://www.w3.org/2000/svg" width="121" height="16" viewBox="0 0 121 16" fill="none">
													<g clip-path="url(#clip0_276_5585)">
														<path d="M0 -1V18H18.973L0 -1Z" fill="white"/>
														<path d="M0 -1V18H18.973L0 -1Z" fill="#46748D"/>
														<path d="M18.973 -1H0V18L18.973 -1Z" fill="#003459"/>
														<path d="M87.7323 9.19305H81.7545V7.51828C81.7545 5.95901 83.1984 4.71737 84.7578 4.71737C86.3172 4.71737 87.7611 5.98788 87.7611 7.51828V9.19305H87.7323ZM84.7289 2.46509C81.9277 2.46509 79.502 4.71737 79.502 7.51828V13.6976H81.7545V11.4453H87.7323V13.6976H89.9848V7.51828C89.9848 4.71737 87.5301 2.46509 84.7578 2.46509H84.7289Z" fill="#E95009"/>
														<path d="M118.776 9.19305H112.798V7.51828C112.798 5.95901 114.242 4.71737 115.802 4.71737C117.361 4.71737 118.805 5.98788 118.805 7.51828V9.19305H118.776ZM115.773 2.46509C112.972 2.46509 110.546 4.71737 110.546 7.51828V13.6976H112.798V11.4453H118.776V13.6976H121.029V7.51828C121.029 4.71737 118.574 2.46509 115.802 2.46509H115.773Z" fill="#E95009"/>
														<path d="M61.9149 11.4453C60.0667 11.4453 58.5361 9.94381 58.5361 8.06691C58.5361 6.19001 60.0378 4.68849 61.9149 4.68849C63.792 4.68849 65.2936 6.19001 65.2936 8.06691C65.2936 9.94381 63.792 11.4453 61.9149 11.4453ZM61.9149 2.46509C58.8249 2.46509 56.3125 4.97725 56.3125 8.09579C56.3125 11.2143 58.8249 13.7265 61.9149 13.7265C65.0049 13.7265 67.5173 11.2143 67.5173 8.09579C67.5173 4.97725 65.0049 2.46509 61.9149 2.46509Z" fill="#003459"/>
														<path d="M52.1252 11.4453H48.8331V9.19305H52.1252C52.7316 9.19305 53.2515 9.68393 53.2515 10.3192C53.2515 10.9544 52.7605 11.4453 52.1252 11.4453ZM48.8331 4.71737H50.9989C51.6054 4.71737 52.1252 5.20825 52.1252 5.84351C52.1252 6.47877 51.6343 6.96965 50.9989 6.96965H48.8331V4.71737ZM53.9445 7.4894C54.2333 6.99852 54.3777 6.44989 54.3777 5.84351C54.3777 3.99548 52.876 2.46509 50.9989 2.46509H46.5806V13.6976H52.1252C53.9734 13.6976 55.504 12.1961 55.504 10.3192C55.504 9.1353 54.8686 8.09579 53.9445 7.4894Z" fill="#003459"/>
														<path d="M39.6786 11.4453C37.8303 11.4453 36.2998 9.94381 36.2998 8.06691C36.2998 6.19001 37.8015 4.68849 39.6786 4.68849C41.5556 4.68849 43.0573 6.19001 43.0573 8.06691C43.0573 9.94381 41.5556 11.4453 39.6786 11.4453ZM39.6786 2.46509C36.5886 2.46509 34.0762 4.97725 34.0762 8.09579C34.0762 11.2143 36.5886 13.7265 39.6786 13.7265C42.7685 13.7265 45.2809 11.2143 45.2809 8.09579C45.2809 4.97725 42.7685 2.46509 39.6786 2.46509Z" fill="#003459"/>
														<path d="M97.0594 6.96965H94.4315C93.825 6.96965 93.3052 6.47877 93.3052 5.84351C93.3052 5.20825 93.7962 4.71737 94.4315 4.71737H98.5322L100.034 2.46509H94.4315C92.5833 2.46509 91.0527 3.96661 91.0527 5.84351C91.0527 7.57603 92.3811 9.0198 94.0561 9.19305H96.684C97.2904 9.19305 97.8102 9.68393 97.8102 10.3192C97.8102 10.9544 97.3193 11.4453 96.684 11.4453H92.5833L91.0816 13.6976H96.684C98.5322 13.6976 100.063 12.1961 100.063 10.3192C100.063 8.58667 98.7344 7.1429 97.0594 6.96965Z" fill="#E95009"/>
														<path d="M103.817 2.46509C101.969 2.46509 100.438 3.96661 100.438 5.84351C100.438 7.57603 101.767 9.0198 103.442 9.19305H106.07C106.676 9.19305 107.196 9.68393 107.196 10.3192C107.196 10.9544 106.705 11.4453 106.07 11.4453H101.969L100.467 13.6976H106.07C107.918 13.6976 109.449 12.1961 109.449 10.3192C109.449 8.58667 108.12 7.1429 106.445 6.96965H103.817C103.211 6.96965 102.691 6.47877 102.691 5.84351C102.691 5.20825 103.182 4.71737 103.817 4.71737H107.918L109.42 2.46509H103.817Z" fill="#E95009"/>
														<path d="M26.3946 7.51828H29.3979C30.2354 7.51828 30.8996 6.85415 30.8996 6.01676C30.8996 5.17937 30.2354 4.51524 29.3979 4.51524H26.3946V7.51828ZM26.3946 13.6976H24.1421V2.46509H29.4268C30.3798 2.46509 31.1884 2.78272 31.8526 3.44685C32.5457 4.11098 33.0944 5.06387 33.0944 6.01676C33.0944 6.88302 32.8922 7.60491 32.3435 8.26904C31.8237 8.9043 31.275 9.39518 30.4664 9.56843L33.2676 13.6976H30.6397L28.0118 9.79943C27.8963 9.65506 27.7519 9.56843 27.5497 9.56843H26.3368V13.6976H26.3946Z" fill="#003459"/>
														<path d="M78.26 2.46509L73.6684 7.34503L78.3755 13.6976H75.7765L72.1956 8.93317L71.2715 10.0304V13.6976H69.0479V2.46509H71.2715V6.88302L75.3144 2.46509H78.26Z" fill="#E95009"/>
														<path d="M0 -1V18H18.973L0 -1Z" fill="#1A1A18"/>
														<path d="M0 -1V18H18.973L0 -1Z" fill="#1A1A18"/>
														<path d="M18.973 -1H0V18L18.973 -1Z" fill="#1A1A18"/>
														<path d="M87.7323 9.19305H81.7545V7.51828C81.7545 5.95901 83.1984 4.71737 84.7578 4.71737C86.3172 4.71737 87.7611 5.98788 87.7611 7.51828V9.19305H87.7323ZM84.7289 2.46509C81.9277 2.46509 79.502 4.71737 79.502 7.51828V13.6976H81.7545V11.4453H87.7323V13.6976H89.9848V7.51828C89.9848 4.71737 87.5301 2.46509 84.7578 2.46509H84.7289Z" fill="#1A1A18"/>
														<path d="M118.776 9.19305H112.798V7.51828C112.798 5.95901 114.242 4.71737 115.802 4.71737C117.361 4.71737 118.805 5.98788 118.805 7.51828V9.19305H118.776ZM115.773 2.46509C112.972 2.46509 110.546 4.71737 110.546 7.51828V13.6976H112.798V11.4453H118.776V13.6976H121.029V7.51828C121.029 4.71737 118.574 2.46509 115.802 2.46509H115.773Z" fill="#1A1A18"/>
														<path d="M61.9149 11.4453C60.0667 11.4453 58.5361 9.94381 58.5361 8.06691C58.5361 6.19001 60.0378 4.68849 61.9149 4.68849C63.792 4.68849 65.2936 6.19001 65.2936 8.06691C65.2936 9.94381 63.792 11.4453 61.9149 11.4453ZM61.9149 2.46509C58.8249 2.46509 56.3125 4.97725 56.3125 8.09579C56.3125 11.2143 58.8249 13.7265 61.9149 13.7265C65.0049 13.7265 67.5173 11.2143 67.5173 8.09579C67.5173 4.97725 65.0049 2.46509 61.9149 2.46509Z" fill="#1A1A18"/>
														<path d="M52.1252 11.4453H48.8331V9.19305H52.1252C52.7316 9.19305 53.2515 9.68393 53.2515 10.3192C53.2515 10.9544 52.7605 11.4453 52.1252 11.4453ZM48.8331 4.71737H50.9989C51.6054 4.71737 52.1252 5.20825 52.1252 5.84351C52.1252 6.47877 51.6343 6.96965 50.9989 6.96965H48.8331V4.71737ZM53.9445 7.4894C54.2333 6.99852 54.3777 6.44989 54.3777 5.84351C54.3777 3.99548 52.876 2.46509 50.9989 2.46509H46.5806V13.6976H52.1252C53.9734 13.6976 55.504 12.1961 55.504 10.3192C55.504 9.1353 54.8686 8.09579 53.9445 7.4894Z" fill="#1A1A18"/>
														<path d="M39.6786 11.4453C37.8303 11.4453 36.2998 9.94381 36.2998 8.06691C36.2998 6.19001 37.8015 4.68849 39.6786 4.68849C41.5556 4.68849 43.0573 6.19001 43.0573 8.06691C43.0573 9.94381 41.5556 11.4453 39.6786 11.4453ZM39.6786 2.46509C36.5886 2.46509 34.0762 4.97725 34.0762 8.09579C34.0762 11.2143 36.5886 13.7265 39.6786 13.7265C42.7685 13.7265 45.2809 11.2143 45.2809 8.09579C45.2809 4.97725 42.7685 2.46509 39.6786 2.46509Z" fill="#1A1A18"/>
														<path d="M97.0594 6.96965H94.4315C93.825 6.96965 93.3052 6.47877 93.3052 5.84351C93.3052 5.20825 93.7962 4.71737 94.4315 4.71737H98.5322L100.034 2.46509H94.4315C92.5833 2.46509 91.0527 3.96661 91.0527 5.84351C91.0527 7.57603 92.3811 9.0198 94.0561 9.19305H96.684C97.2904 9.19305 97.8102 9.68393 97.8102 10.3192C97.8102 10.9544 97.3193 11.4453 96.684 11.4453H92.5833L91.0816 13.6976H96.684C98.5322 13.6976 100.063 12.1961 100.063 10.3192C100.063 8.58667 98.7344 7.1429 97.0594 6.96965Z" fill="#1A1A18"/>
														<path d="M103.817 2.46509C101.969 2.46509 100.438 3.96661 100.438 5.84351C100.438 7.57603 101.767 9.0198 103.442 9.19305H106.07C106.676 9.19305 107.196 9.68393 107.196 10.3192C107.196 10.9544 106.705 11.4453 106.07 11.4453H101.969L100.467 13.6976H106.07C107.918 13.6976 109.449 12.1961 109.449 10.3192C109.449 8.58667 108.12 7.1429 106.445 6.96965H103.817C103.211 6.96965 102.691 6.47877 102.691 5.84351C102.691 5.20825 103.182 4.71737 103.817 4.71737H107.918L109.42 2.46509H103.817Z" fill="#1A1A18"/>
														<path d="M26.3946 7.51828H29.3979C30.2354 7.51828 30.8996 6.85415 30.8996 6.01676C30.8996 5.17937 30.2354 4.51524 29.3979 4.51524H26.3946V7.51828ZM26.3946 13.6976H24.1421V2.46509H29.4268C30.3798 2.46509 31.1884 2.78272 31.8526 3.44685C32.5457 4.11098 33.0944 5.06387 33.0944 6.01676C33.0944 6.88302 32.8922 7.60491 32.3435 8.26904C31.8237 8.9043 31.275 9.39518 30.4664 9.56843L33.2676 13.6976H30.6397L28.0118 9.79943C27.8963 9.65506 27.7519 9.56843 27.5497 9.56843H26.3368V13.6976H26.3946Z" fill="#1A1A18"/>
														<path d="M78.26 2.46509L73.6684 7.34503L78.3755 13.6976H75.7765L72.1956 8.93317L71.2715 10.0304V13.6976H69.0479V2.46509H71.2715V6.88302L75.3144 2.46509H78.26Z" fill="#1A1A18"/>
													</g>
													<defs>
														<clipPath id="clip0_276_5585">
															<rect width="121" height="19" fill="white" transform="translate(0 -1)"/>
														</clipPath>
													</defs>
												</svg>
												<div class="max-w-[604px] text-[#1a1a18] text-sm font-normal font-['Inter']leading-[1]">На сайте подключена безопасная оплата. После нажатия на кнопку оплаты, вы будете перенаправлены в сервис Robokassa для ввода реквизитов.</div>
											</div>
										</div>
										<div class="flex-col justify-start md:items-end flex">
											<div class="md:text-right text-gray-500 text-[14px] md:text-[16px] font-normal leading-normal">Вы выбрали <span class="tickets"></span> на <span class="selected_info_full"></span></div>
											<div class="text-right">
												<span class="leading-normal">на сумму:</span>
												<!--<span class="line-through">11 900 ₽</span>-->
												<span class="text-[#1a1a18] text-2xl font-bold leading-normal"><span class="t_price">0</span> ₽</span>
											</div>
											<div class="total-sale_price text-right hidden text-[#52a6b2]">
												<span class="total-sale_price_text">Предоплата онлайн: </span>
												<span class="total-sale_price_count"></span>
												<span class="total-sale_price_currency"> руб.</span>
											</div>
											<div class="justify-start items-start gap-5 inline-flex my-6">
												<button id="submit_buy" type="button" class="w-1/2 sm:w-auto sm:px-8 h-[40px] md-h-[44px] bg-[#52a6b2]  hover:bg-[#44909B] rounded-md shadow-[0px_2px_10px_-2px_rgba(16,24,40,0.10)] flex-col justify-center items-center gap-2.5 inline-flex overflow-hidden min-w-[194px] relative">
													<span class="btn-text text-white font-medium leading-normal pointer-events-none">Оплатить билет</span>
													<span class="loader hidden absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
														<svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
															<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
														</svg>
													</span>
												</button>

												<button id="submit_request" type="button" class="w-1/2 sm:w-auto sm:px-8 h-[40px] md-h-[44px] bg-[#d6bd7f] rounded-md shadow-[0px_2px_10px_-2px_rgba(16,24,40,0.10)] flex-col justify-center items-center gap-2.5 inline-flex overflow-hidden min-w-[194px] relative">
													<span class="btn-text text-white leading-normal pointer-events-none">Оставить заявку</span>
													<span class="loader hidden absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
														<svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
															<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
														</svg>
													</span>
												</button>
											</div>
											<div class="max-w-[433px] md:text-right text-gray-500 text-[12px] sm:text-[14px]">
												После оплаты вам придет на почту чек, электронный билет и схема прохода к месту начала экскурсии.
											</div>
										</div>
									</div>
								</div>
							</form>
							<?php else: ?>
							<div class="mt-12 w-full px-[42px] py-[15px] bg-white border-2 font-semibold border-[#d6bd7f] text-center">
								Сейчас нет билетов на эту экскурсию.
								<br>
								Выберите, пожалуйста, другую экскурсию в нашем <a class="underline text-[#52A6B2] hover:no-underline" href="/">каталоге.</a></div>
							<?php endif; ?>

						</div><!-- .entry-content -->
					</div>
				</div>
			</div>

			<div id="sectionInfo" class="bg-[#FAFAFA] pt-[48px] pb-[20px] sm:text-[18px] sm:leading-[1.3]">
				<div class="container">
					<div class="flex-col justify-start items-start gap-8 inline-flex mb-8">
					<h3 class="mb-0 sm:text-[24px]">Полезно знать перед экскурсией</h3>
					<div class="flex-col justify-start items-start gap-3 flex">
						<div class="justify-start items-start gap-2 flex">
							<svg class="mt-0" xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
								<path d="M13 16.6001H12V12.6001H11M12 8.6001H12.01M21 12.6001C21 17.5707 16.9706 21.6001 12 21.6001C7.02944 21.6001 3 17.5707 3 12.6001C3 7.62953 7.02944 3.6001 12 3.6001C16.9706 3.6001 21 7.62953 21 12.6001Z" stroke="#D6BD7F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="grow shrink basis-0 text-[16px] sm:text-[18px]">
								Накануне экскурсии, с 15:00 до 18:00, вам придет напоминание в WhatsApp о поездке, с картинками и адресом места посадки.
							</div>
						</div>
						<div class="justify-start items-start gap-2 flex">
							<svg class="mt-0" xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
								<path d="M13 16.6001H12V12.6001H11M12 8.6001H12.01M21 12.6001C21 17.5707 16.9706 21.6001 12 21.6001C7.02944 21.6001 3 17.5707 3 12.6001C3 7.62953 7.02944 3.6001 12 3.6001C16.9706 3.6001 21 7.62953 21 12.6001Z" stroke="#D6BD7F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="grow shrink basis-0 text-[16px] sm:text-[18px]">
								Маршрут и длительность экскурсии могут зависеть от дорожной ситуации, а также от авторской подачи гида. Например, в случае пробок на дороге, перекрытия проезжей части и при других форс-мажорных обстоятельствах. Пожалуйста, учитывайте это при планировании ваших поездок, так как в этих случаях продолжительность экскурсии может значительно увеличиться.
							</div>
						</div>
						<div class="justify-start items-start gap-2 flex">
							<svg class="mt-0" xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
								<path d="M13 16.6001H12V12.6001H11M12 8.6001H12.01M21 12.6001C21 17.5707 16.9706 21.6001 12 21.6001C7.02944 21.6001 3 17.5707 3 12.6001C3 7.62953 7.02944 3.6001 12 3.6001C16.9706 3.6001 21 7.62953 21 12.6001Z" stroke="#D6BD7F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="grow shrink basis-0 text-[16px] sm:text-[18px]">
								По выкупленной брони вам необходимо прийти за 15 минут до начала экскурсии. Пункт отправления: напротив Московского вокзала. Встреча участников экскурсии и регистрация электронных билетов проводится встречающим менеджером по адресу Лиговский пр., дом 43/45. Ориентир – арка справа у столовой №1. Смотрите подробную схему на электронном билете.<br/>После регистрации электронного билета, вас проводят на посадку в ваш автобус.
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>


			<div id="sectionRev">
				<?php
				$args = array(
						'post_type'      => 'reviews',      // Тип записи 'faqs'
						'posts_per_page' => 7,          // Выводим все записи
						'tax_query'      => array(
								array(
									'taxonomy' => 'faqs_category', // Таксономия
									'operator' => 'NOT EXISTS',    // Исключаем записи, имеющие термины
								),
						),
				);
				$query = new WP_Query( $args );
				?>
				<?php if ( $query->have_posts() ) : ?>
					<div class="container">
						<div class="pt-3 sm:pt-6 pb-[30px] sm:pb-[64px]">
							<h2 class="mb-6  mt-5">Отзывы <br>
								наших экскурсантов
							</h2>
							<div class="buttons relative flex justify-end gap-2 items-center">
								<div class="rev-button-prev w-[61px] h-[61px] p-0"></div>
								<div class="rev-button-next w-[61px] h-[61px] p-0"></div>
							</div>
							<div class="swiper_rev overflow-hidden px-[2px] pt-[2px] mb-8">
								<div class="swiper-wrapper flex h-auto py-[10px]">
									<?php while ( $query->have_posts() ) : $query->the_post(); $fieldsRev = get_fields();?>
										<div class="swiper-slide rounded-[6px] shadows_custom p-6 text-[14px] sm:text-[16px]">
											<div class="text-[14px]"><?php the_title() ?></div>
											<div class="text-[14px] text-[#6B7280] mb-3">
												<?php
												if (isset($fieldsRev['date'])) {
													echo trim(strtr($fieldsRev['date'], $sub));
												} else {
													echo trim(strtr(get_the_date(), $sub));
												}
												?>
											</div>
											<div class="mb-3 text-[#111827] h-[118px] overflow-y-auto rev-text pe-4"><?php the_content(); ?></div>

											<div class="mt-4 font-bold text-[#52A6B2]">
												<?php if(isset($fieldsRev['excursion_obj']) && $fieldsRev['excursion_obj']):  ?>
													<?php if(get_post_status($fieldsRev['excursion_obj']) === 'publish') :?>
														<a href="<?php echo esc_url(get_permalink($fieldsRev['excursion_obj'])); ?>">
															<?php  echo get_the_title($fieldsRev['excursion_obj']);  ?>
														</a>
													<?php else: ?>
														<span>
													<?php  echo get_the_title($fieldsRev['excursion_obj']);  ?></span>
													<?php endif; ?>

												<?php elseif(isset($fieldsRev['excursion']) && $fieldsRev['excursion']) : ?>
													Экскурсия: <?php echo $fieldsRev['excursion']; ?>
												<?php endif; ?>
											</div>
											<?php if(isset($fieldsRev['gid']) && !empty($fieldsRev['gid'])) : ?>
												<div class="text-[#6B7280] mt-1 sm:pb-4">Гид: <?php echo $fieldsRev['gid']; ?></div>
											<?php endif; ?>
										</div>
									<?php endwhile; ?>
								</div>
							</div>

							<div class="text-center">
								<a href="<?php echo esc_url(get_permalink(184)); ?>" class="inline-flex h-11 items-center justify-center font-medium  px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px]">Больше отзывов</a>
							</div>
						</div>
					</div>
				<?php endif; wp_reset_postdata(); ?>
			</div>

					<?php

					if (isset($fields['recommended']) && !empty($fields['recommended'])) {
						$args = [ 'post_type'      => 'tours', 'post__in'  => $fields['recommended'] ];
					} else {
						$post_id = get_the_ID();
						$terms = wp_get_post_terms(get_the_ID(), 'excursion');
						$term = $fields['cat_hk'] ? get_term($fields['cat_hk']) : $terms[0];
						$first_term_id = $term->term_id;
						$args = [
							'post_type'      => 'tours',
							'posts_per_page' => 5,
							'post__not_in'   => [$post_id],
							'tax_query'      => [
								[
									'taxonomy' => 'excursion',
									'field'    => 'id',
									'terms'    => $first_term_id,
									'operator' => 'IN',
								],
							],
						];
					}
					$query = new WP_Query( $args );
					$posts = [];
					if ($query->have_posts()) : ?>


						<div class="bg-[#FAFAFA] pb-[48px]">
							<div class="container">

									<div class="pt-3 sm:pt-12 pb-[30px] sm:pb-[64px]">
										<h2 class="mb-6 sm:mb-12 mt-5">Похожие экскурсии</h2>
										<div class="buttons relative flex justify-end gap-2 items-center">
											<div class="similar-button-prev w-[61px] h-[61px] p-0"></div>
											<div class="similar-button-next w-[61px] h-[61px] p-0"></div>
										</div>
										<div class="swiper_similar px-[2px] pt-[2px] mb-8">
											<div class="swiper-wrapper flex h-auto py-[10px]">
												<?php
												while ($query->have_posts()) {
													$query->the_post();
													$fields = get_fields(get_the_ID());
													$returnDuration = true;
													$returnPrice = true;
													$returnGrade = true;

													$json_decode = json_decode(get_post_meta(get_the_ID(), 'tickets', 1));
													$sopr = (isset($fields['id_crm_eks']) && !empty($fields['id_crm_eks'])) ? $fields['id_crm_eks'] : '';
													if(!$json_decode && $sopr){
														$sopr_post = get_posts([
																'post_type' => 'tours',
																'post_status' => 'any',
																'meta_query' => [
																		[
																				'key' => 'id_crm',
																				'value' => $sopr
																		]
																]
														])[0];
														$json_decode = json_decode(get_post_meta($sopr_post->ID, 'tickets', 1));
													}
													$uniqueArray = [];
													$datesArray = [];

													if(is_array($json_decode)) {
														foreach ($json_decode as $item) {
															$json_decode_start_date = explode('.', $item->date);
															$start_dates =  $json_decode_start_date[0]. ' ' .$m[(int)$json_decode_start_date[1] -1];
															$startDates =  $json_decode_start_date[2]. '-' .$json_decode_start_date[1] . '-' . $json_decode_start_date[0];
															if (!in_array($start_dates, $uniqueArray)) {
																$uniqueArray[] = $start_dates;
															}
															$datesArray[] = $startDates;
														}
													}

													// Обработка фильтра по duration

													if(!empty($duration)) {
														$durationRange = convertTime($fields['duration']) ?? 0 ;
														$returnDuration = false;
														foreach ($duration as $duration_range) {
															if ($duration_range) {
																$explode = explode('-', $duration_range);
																if (($durationRange >= (int)$explode[0]) && ($durationRange <= (int)$explode[1])) {
																	$returnDuration = true;
																}
															}
														}
													}


													$returnDateForm =  true;

													// Обработка фильтра по price_range
													if (!empty($price_ranges)) {
														$priceRange = get_cost($fields)['cost_sale'] ? get_cost($fields)['cost_sale'] : get_cost($fields)['cost'];
														$returnPrice = false;
														foreach ($price_ranges as $price_range) {
															if ($price_range) {
																list($min_price, $max_price) = explode('-', $price_range);
																$min_price = floatval($min_price);
																$max_price = floatval($max_price);
																if ((int)$priceRange >= (int)$min_price && (int)$priceRange <=  (int)$max_price) {
																	$returnPrice = true;
																}
															}
														}
													}

													//запрос
													if (!$returnPrice || !$returnDuration ) {
														continue;
													}

													$posts[] = [
															'post' => get_post(),
															'fields' => $fields,
															'datesArray' => $datesArray,
															'uniqueArray' => $uniqueArray,
															'gradeSort' => '',
															'date' => get_the_date('Y-m-d H:i:s'), // Добавляем дату в формате строки
													];
												}


												foreach ($posts as $postData) :

												$post = $postData['post'];
												setup_postdata($post);

												$fields = $postData['fields'];
												$datesArray = $postData['datesArray'];
												$uniqueArray = $postData['uniqueArray'];

												?>
													<div class="swiper-slide flex flex-col bg-white rounded-2xl shadows_custom pb-6" data-cost="<?php echo get_cost($fields)['cost_sale'] ?? get_cost($fields)['cost']; ?>">
														<div class="relative mb-5">
															<a href="<?php echo get_permalink($post->ID); ?>">
																<?php if(isset($fields["galery"]) && !empty($fields["galery"])): ?>
																	<?php $image = $fields["galery"][0]["url"]; ?>
																	<img class="w-full h-[235px] object-cover rounded-t-2xl" src="<?php echo $image; ?>" alt="<?php echo get_the_title($post->ID); ?>" loading="lazy">
																<?php else : ?>
																	<img class="w-full h-[240px] object-cover rounded-lg bg-gray-300" src="<?php echo get_stylesheet_directory_uri(); ?>/img/woocommerce-placeholder.webp" alt="No image available">
																<?php endif; ?>
															</a>

															<?php if (isset($fields['duration']) && $fields['duration']) : ?>
																<div class="absolute left-4 sm:left-6 bottom-[18px] flex gap-1 items-center bg-[#FFFFFF] rounded-[6px] h-[28px] px-2">
																	<svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
																		<g clip-path="url(#clip0_2001_272)">
																			<path d="M9.20006 1.86499C13.6901 1.86499 17.3301 5.50499 17.3301 9.99499C17.3301 14.485 13.6901 18.125 9.20006 18.125C4.71006 18.125 1.06006 14.495 1.06006 10.005C1.06006 5.51499 4.70006 1.86499 9.20006 1.86499Z" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
																			<path d="M8.47021 5.95508V10.3551" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
																			<path d="M12.2802 12.555L8.47021 10.355" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
																		</g>
																		<defs>
																			<clipPath id="clip0_2001_272">
																				<rect width="18.39" height="18.39" fill="white" transform="translate(0 0.804932)"/>
																			</clipPath>
																		</defs>
																	</svg>
																	<div class="text-[#6B7280] leading-0"><?php echo $fields['duration']; ?></div>
																</div>
															<?php endif ?>

															<?php if (isset($fields['sticker']) && $fields['sticker']) : ?>
																<?php
																$bg_stick = (isset($fields['sticker_background']) &&!empty($fields['sticker_background']) ) ? $fields['sticker_background'] : "#D45E5E";
																$bg_color = (isset($fields['sticker_text']) &&!empty($fields['sticker_text']) ) ? $fields['sticker_text'] : "#FFF";
																?>
																<div class="absolute left-4 sm:left-6 top-[18px] flex items-center rounded-[6px] h-[34px] px-4 text-white" style="background: <?php echo $bg_stick;?>;color:<?php echo $bg_color;?>">
																	<div class="leading-0"><?php echo $fields['sticker'];?></div>
																</div>
															<?php endif ?>


															<button class="absolute right-4 sm:right-[18px]  top-[10px] sm:top-[18px] wish-btn w-12 h-12 flex items-center justify-center group" data-wp-id="<?php echo $post->ID; ?>" aria-label="Добавить в избранное">
																<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect width="36" height="36" rx="18" fill="white"/>
																	<path d="M10.318 12.318C8.56066 14.0754 8.56066 16.9246 10.318 18.682L18.0001 26.364L25.682 18.682C27.4393 16.9246 27.4393 14.0754 25.682 12.318C23.9246 10.5607 21.0754 10.5607 19.318 12.318L18.0001 13.6361L16.682 12.318C14.9246 10.5607 12.0754 10.5607 10.318 12.318Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
																</svg>
															</button>
															<?php if (isset($fields['video_after_gates']) && !empty($fields['video_after_gates'])): ?>
																<button class="absolute right-[65px]  top-[10px] sm:top-[18px]  w-12 h-12 flex items-center justify-center group" aria-label="Смотреть видео">
																	<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="36" height="36" rx="18" fill="white"/>
																		<path d="M25.1906 19.8041C26.2698 19.2633 26.2698 17.7367 25.1906 17.1959L13.1422 11.1581C12.2051 10.6885 11 11.3234 11 12.4622L11 24.5378C11 25.6766 12.2051 26.3115 13.1422 25.8419L25.1906 19.8041Z" stroke="black" stroke-width="2"/>
																	</svg>
																</button>
															<?php endif ?>
														</div>
														<div class="px-4 sm:px-6 flex flex-col gap-5 h-full">
															<div class="flex flex-col gap-1 flex-grow relative min-h-[96px]">
																<a href="<?php echo get_permalink($post->ID); ?>" class="card-title text-[18px] lg:text-[20px] font-bold leading-[1.2] three-lines"><?php echo get_the_title($post->ID); ?></a>
																<div class="date flex items-center gap-2 text-[14px] sm:text-[16px]">
																	<?php if(count($uniqueArray)) : ?>
																		<div class="flex items-center gap-[2px] text-[#6B7280]">
																			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
																				<path d="M6 4.75V1.75M12 4.75V1.75M5.25 7.75H12.75M3.75 15.25H14.25C15.0784 15.25 15.75 14.5784 15.75 13.75V4.75C15.75 3.92157 15.0784 3.25 14.25 3.25H3.75C2.92157 3.25 2.25 3.92157 2.25 4.75V13.75C2.25 14.5784 2.92157 15.25 3.75 15.25Z" stroke="#6B7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
																			</svg>
																			<div class="">
																				<span><?php echo $uniqueArray[0]; ?></span>
																				<?php if(count($uniqueArray)>1) : ?>
																					|
																					<span><?php echo $uniqueArray[1]; ?></span>
																				<?php endif; ?>
																			</div>
																		</div>
																		<?php if(count($uniqueArray)>2) : ?>
																			<button aria-expanded="true" data-close-on-click="false" class="dropdown-button text-[#52A6B2]">Другие даты</button>
																			<div class="dropdown-menu absolute right-0 z-10 mt-2  w-[310px] origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none hidden">

																				<div class="">
																					<div class="p-4 calendar-wrapper" data-dates='<?php echo json_encode($datesArray) ;?>'>
																						<div class="flex justify-end relative -t-[2px]">
																							<button class="close-menu ">
																								<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
																									<path d="M12 20L16 16M16 16L19.6667 12.3333M16 16L12 12M16 16L20 20M29 16C29 23.1797 23.1797 29 16 29C8.8203 29 3 23.1797 3 16C3 8.8203 8.8203 3 16 3C23.1797 3 29 8.8203 29 16Z" stroke="#9CA3AF" stroke-width="2.67" stroke-linecap="round" stroke-linejoin="round"/>
																								</svg>
																							</button>
																						</div>
																						<div class="calendar pointer-events-none"></div>
																						<a href="<?php echo get_permalink($post->ID); ?>" class="px-2 h-8 text-[14px] rounded-md bg-[#D6BD7F] flex sm:hidden items-center justify-center text-white">
																							Подробнее
																						</a>
																					</div>
																				</div>
																			</div>
																		<?php endif; ?>
																	<?php endif; ?>
																</div>
															</div>
															<div class="flex items-center justify-between">
																<div class="price flex flex-col gap-1 text-[#111827]">
																	<?php if (get_cost($fields)['cost_sale']) : ?>
																		<div class="old_price line-through">
																			от <span><?php echo get_cost($fields)['cost']; ?></span> ₽/чел.
																		</div>
																		<div class="price text-[20px] font-bold">
																			от <span><?php echo get_cost($fields)['cost_sale']; ?></span> ₽/чел.
																		</div>
																	<?php else: ?>
																		<div class="price text-[20px] font-bold">
																			от <span><?php echo get_cost($fields)['cost']; ?></span> ₽/чел.
																		</div>
																	<?php endif ?>
																</div>
																<a href="<?php echo get_permalink($post->ID); ?>" class="inline-flex h-11 items-center justify-center font-medium px-7 sm:px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px]">Подробнее</a>
															</div>
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									</div>

							</div>
						</div>
					<?php endif; wp_reset_postdata();
					?>


		</article>



<?php get_footer(); // подключаем footer.php ?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
