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



$current_term = get_queried_object();
$category_id = $current_term->term_id;
$ancestors = get_ancestors($current_term->term_id, 'excursion');
if ($current_term && isset($current_term->slug) && $current_term->slug === 'ekskursii-peterburg') {
	wp_redirect('/' , 301);
	exit();
}

$options = get_fields( 'option');
$fields = get_fields($current_term);
$title = (isset($fields['h1']) && $fields['h1']) ? $fields['h1'] : $current_term->name;

$sub = array(".01." => " января ", ".02." => " февраля ",
		".03." => " марта ", ".04." => " апреля ", ".05." => " мая ", ".06." => " июня ",
		".07." => " июля ", ".08." => " августа ", ".09." => " сентября ",
		".10." => " октября ", ".11." => " ноября ", ".12." => " декабря ", "2022" => '2022', '2023' => '2023', '2024'=>'2024', '2025'=>'2025','2026'=>'2026','00:00'=>'');

get_header();
?>



	<section class="primary content--reviews">
		<main id="main">
			<?php if($ancestors): ?>
				<?php  get_template_part( 'template-parts/layout/breadcrumbs', 'content' ); ?>
			<?php else: ?>
			<div class="mt-2 sm:mt-4"></div>
			<?php endif; ?>
			<div class="container">
				<div class="flex-col justify-start items-start gap-[18px] inline-flex">
					<h1 class="sm:text-[38px] font-bold  leading-[1.2]"><?php echo $title; ?></h1>

					<div class="self-stretch"><?php echo do_shortcode(term_description()); ?></div>
				</div>
			</div>

			<div class="container mt-8 pb-8 border-b-[2px] border-[#D6BD7F]">

				<div class="flex gap-8">
					<?php get_sidebar(); ?>

					<section class="product-cards w-full" id="card_link">

						<div id="sticky-element" class="sidebar-toggle flex flex-col gap-2 z-10 hidden bottom-8  w-[138px]  left-1/2 transform -translate-x-1/2 lg:hidden">
							<div class="h-9 bg-white rounded-md shadow-[0px_2px_10px_-2px_rgba(16,24,40,0.10)] shadow-[0px_2px_10px_-2px_rgba(16,24,40,0.10)] flex-col justify-center items-center gap-2.5 inline-flex overflow-hidden">
								<div class="justify-center items-center gap-1.5 inline-flex">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5995 4.55965H8.87945V3.35965C8.87945 2.962 8.5571 2.63965 8.15945 2.63965C7.76181 2.63965 7.43945 2.962 7.43945 3.35965V7.19965C7.43945 7.59729 7.76181 7.91965 8.15945 7.91965C8.5571 7.91965 8.87945 7.59729 8.87945 7.19965V5.99965H21.5995C21.9971 5.99965 22.3195 5.67729 22.3195 5.27965C22.3195 4.882 21.9971 4.55965 21.5995 4.55965ZM21.6002 17.9996H13.6802V16.7996C13.6802 16.4019 13.3579 16.0796 12.9602 16.0796C12.5626 16.0796 12.2402 16.4019 12.2402 16.7996V20.6396C12.2402 21.0372 12.5626 21.3596 12.9602 21.3596C13.3579 21.3596 13.6802 21.0372 13.6802 20.6396V19.4396H21.6002C21.9979 19.4396 22.3202 19.1172 22.3202 18.7196C22.3202 18.3219 21.9979 17.9996 21.6002 17.9996ZM2.39969 5.99965C2.00204 5.99965 1.67969 5.6773 1.67969 5.27965C1.67969 4.88201 2.00204 4.55965 2.39969 4.55965H5.20621C5.60386 4.55965 5.92621 4.88201 5.92621 5.27965C5.92621 5.6773 5.60386 5.99965 5.20621 5.99965H2.39969ZM1.67969 18.7197C1.67969 19.1173 2.00204 19.4397 2.39969 19.4397H10.042C10.4397 19.4397 10.762 19.1173 10.762 18.7197C10.762 18.322 10.4397 17.9997 10.042 17.9997H2.39969C2.00204 17.9997 1.67969 18.322 1.67969 18.7197Z" fill="#2E2E2E"></path>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5991 11.2804H18.4791V10.0804C18.4791 9.68271 18.1567 9.36035 17.7591 9.36035C17.3614 9.36035 17.0391 9.68271 17.0391 10.0804V13.9204C17.0391 14.318 17.3614 14.6404 17.7591 14.6404C18.1567 14.6404 18.4791 14.318 18.4791 13.9204V12.7204H21.5991C21.9967 12.7204 22.3191 12.398 22.3191 12.0004C22.3191 11.6027 21.9967 11.2804 21.5991 11.2804ZM1.67969 12.0004C1.67969 12.398 2.00204 12.7204 2.39969 12.7204H14.7502C15.1478 12.7204 15.4702 12.398 15.4702 12.0004C15.4702 11.6027 15.1478 11.2804 14.7502 11.2804H2.39969C2.00204 11.2804 1.67969 11.6027 1.67969 12.0004Z" fill="#2E2E2E"></path>
									</svg>
									<div class="text-center text-sm font-medium font-['Inter'] leading-normal">Фильтр</div>
								</div>
							</div>
						</div>
						<div class="flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-4 sm:gap-12 mb-4">
							<h2 class="text-left m-0 whitespace-nowrap w-full sm:w-auto">Каталог</h2>
							<div class="flex w-full justify-between sm:justify-end items-center gap-8 text-[14px]">
								<div class="flex flex-col gap-2">
									<div id="sidebar-toggle" class="flex items-center gap-1.5 lg:hidden is-active">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5995 4.55965H8.87945V3.35965C8.87945 2.962 8.5571 2.63965 8.15945 2.63965C7.76181 2.63965 7.43945 2.962 7.43945 3.35965V7.19965C7.43945 7.59729 7.76181 7.91965 8.15945 7.91965C8.5571 7.91965 8.87945 7.59729 8.87945 7.19965V5.99965H21.5995C21.9971 5.99965 22.3195 5.67729 22.3195 5.27965C22.3195 4.882 21.9971 4.55965 21.5995 4.55965ZM21.6002 17.9996H13.6802V16.7996C13.6802 16.4019 13.3579 16.0796 12.9602 16.0796C12.5626 16.0796 12.2402 16.4019 12.2402 16.7996V20.6396C12.2402 21.0372 12.5626 21.3596 12.9602 21.3596C13.3579 21.3596 13.6802 21.0372 13.6802 20.6396V19.4396H21.6002C21.9979 19.4396 22.3202 19.1172 22.3202 18.7196C22.3202 18.3219 21.9979 17.9996 21.6002 17.9996ZM2.39969 5.99965C2.00204 5.99965 1.67969 5.6773 1.67969 5.27965C1.67969 4.88201 2.00204 4.55965 2.39969 4.55965H5.20621C5.60386 4.55965 5.92621 4.88201 5.92621 5.27965C5.92621 5.6773 5.60386 5.99965 5.20621 5.99965H2.39969ZM1.67969 18.7197C1.67969 19.1173 2.00204 19.4397 2.39969 19.4397H10.042C10.4397 19.4397 10.762 19.1173 10.762 18.7197C10.762 18.322 10.4397 17.9997 10.042 17.9997H2.39969C2.00204 17.9997 1.67969 18.322 1.67969 18.7197Z" fill="#2E2E2E"></path>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5991 11.2804H18.4791V10.0804C18.4791 9.68271 18.1567 9.36035 17.7591 9.36035C17.3614 9.36035 17.0391 9.68271 17.0391 10.0804V13.9204C17.0391 14.318 17.3614 14.6404 17.7591 14.6404C18.1567 14.6404 18.4791 14.318 18.4791 13.9204V12.7204H21.5991C21.9967 12.7204 22.3191 12.398 22.3191 12.0004C22.3191 11.6027 21.9967 11.2804 21.5991 11.2804ZM1.67969 12.0004C1.67969 12.398 2.00204 12.7204 2.39969 12.7204H14.7502C15.1478 12.7204 15.4702 12.398 15.4702 12.0004C15.4702 11.6027 15.1478 11.2804 14.7502 11.2804H2.39969C2.00204 11.2804 1.67969 11.6027 1.67969 12.0004Z" fill="#2E2E2E"></path>
										</svg>
										<span>Фильтр</span>
									</div>
								</div>
								<form class="flex items-center gap-3 m-0" id="sort_form">
									<div class="relative inline-block text-left">
										<button type="button" class="dropdown-button items-center mb-0 gap-2 flex" aria-expanded="true" aria-haspopup="true" data-close-on-click="true">
											<span class="dropdown-text md:mt-[3px] text-[#373F41]">По возрастанию цены</span>
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
												<path d="M15 8L10 13L5 8" stroke="#6B7280" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</button>
										<div class="dropdown-menu absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none hidden">
											<div class="py-1">
												<div class="flex flex-col p-5 gap-4 text-[14px]">
													<label class="item flex gap-2 items-center">
														<input type="radio" name="grade_sort" value="expensive" class="scale-150 change_text ">
														<span>По возрастанию цены</span>
													</label>
													<label class="item flex gap-2 items-center">
														<input type="radio" name="grade_sort" value="chip" class="scale-150 change_text">
														<span>По убыванию цены</span>
													</label>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="flex flex-col">
							<?php
							my_custom_template($category_id, 'template-parts/content/content-loop-excursion');
							?>
						</div>
					</section>
				</div>
			</div>

			<div class="bg-white pb-10 lg:pb-14">
				<div class="container">

					<?php if(isset($fields['after_cat_txt']) && !empty($fields['after_cat_txt'])) : ?>
						<div class="custom_titles leading-normal font-medium text-[16px] sm:text-[18px]"><?php echo $fields['after_cat_txt']; ?></div>
					<?php endif; ?>

					<?php if(isset($fields['list_styled']) && !empty($fields['list_styled'])): ?>
					<div class="pt-8 sm:pt-12 pb-[64px] border-b-[2px] border-[#D6BD7F]">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 flex-col sm:flex-row w-full justify-between gap-8 leading-normal">

								<?php foreach($fields['list_styled'] as $item): ?>
									<div class="item flex gap-3 sm:gap-5 items-start">
										<div class="w-10 h-10 mt-1">
											<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M14.5833 20L18.1944 23.6111L25.4167 16.3889M36.25 20C36.25 28.9746 28.9746 36.25 20 36.25C11.0254 36.25 3.75 28.9746 3.75 20C3.75 11.0254 11.0254 3.75 20 3.75C28.9746 3.75 36.25 11.0254 36.25 20Z" stroke="#D6BD7F" stroke-width="2.67" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>

										<div class="font-medium text-[16px] sm:text-[18px] text-[#6B7280]"><?php echo $item['item']; ?></div>
									</div>
								<?php endforeach; ?>

						</div>
					</div>
					<?php endif; ?>


					<?php if(isset($fields['selected_items']) && !empty($fields['selected_items'])) : $item_count = 0; ?>
						<div class="mt-[50px] mb-[36px] custom_titles">
							<h2 class="">Основные достопримечательности</h2>
							<?php if(isset($fields['int_mesta_subtitle']) && !empty($fields['int_mesta_subtitle'])) : ?>
								<div class="text-[18px] font-medium"><?php echo $fields['int_mesta_subtitle']; ?></div>
							<?php endif;  ?>
						</div>
						<div class="int_mesta text_link_underline items grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-5 sm:mb-8">
							<?php foreach ($fields['selected_items'] as $selected_name) : ?>
								<?php $items = $options['int_mesta']; ?>
								<?php foreach ($items as $item) : ?>
									<?php if  ($item['nazvanie_tolko_dlya_adminki'] === $selected_name) : ?>
										<div class="item shadows_custom rounded-[6px] overflow-hidden<?php if(++$item_count > 6) echo ' hidden'; ?> ">
											<img src="<?php echo $item['img']["sizes"]["medium_large"]; ?>"  alt="<?php echo $item['img']["filename"]; ?>" data-src="<?php echo $item['img']["url"]; ?>" class="h-[200px] object-cover w-full">
											<div class="p-6">
												<?php if(isset($item['link']) && !empty($item['link'])): ?>
													<a href="<?php echo $item['link'] ;?>" class="block text-[20px] font-bold mb-2 !no-underline !text-[#111827]"><?php echo $item['name']; ?></a>
												<?php else: ?>
													<div class="text-[20px] font-bold mb-2"><?php echo $item['name']; ?></div>
												<?php endif; ?>
												<div class="text-[#6B7280]"><?php echo $item['description']; ?></div>
											</div>
										</div>
									<?php endif; ?>
								<?php endforeach;   ?>
							<?php endforeach; ?>
						</div>

						<div class="text-center<?php if($item_count < 7) echo ' hidden'; ?>">
							<button  class="show-more inline-flex h-11 items-center justify-center font-medium  px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px]">Посмотреть все</button>
						</div>


					<?php endif;  ?>





					<div class="pt-8  pb-[64px]">
						<h2 class="mb-1 mt-6">Как оплатить и получить билет</h2>
						<div class="font-medium leading-normal mb-[25px] sm:mb-[56px]">Покупка билета на обзорную экскурсию по Санкт-Петербургу осуществляется следующим образом:</div>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
							<div class="rounded-[6px] bg-[#F1EFE9] px-5 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
								<div class="text-[20px] font-bold">Предоплата 20%</div>
								<div class="sm:text-[18px]">Вы можете оплатить только 20% стоимости экскурсии – эта опция доступна для некоторых программ.</div>
								<div class="justify-start items-start gap-2.5 inline-flex">
								<div class="w-6 h-6 relative">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<circle cx="12" cy="12" r="12" fill="#D6BD7F" fill-opacity="0.4"/>
										<path d="M11.16 18.2686V9.49143H13.2286V18.2686H11.16ZM12.2 8.24571C11.8724 8.24571 11.5905 8.13714 11.3543 7.92C11.1181 7.69905 11 7.43429 11 7.12571C11 6.81333 11.1181 6.54857 11.3543 6.33143C11.5905 6.11048 11.8724 6 12.2 6C12.5314 6 12.8133 6.11048 13.0457 6.33143C13.2819 6.54857 13.4 6.81333 13.4 7.12571C13.4 7.43429 13.2819 7.69905 13.0457 7.92C12.8133 8.13714 12.5314 8.24571 12.2 8.24571Z" fill="#D6BD7F"/>
									</svg>
								</div>
								<div class="grow shrink basis-0 flex-col justify-start items-start gap-5 inline-flex">
									<div class="self-stretch text-gray-500 text-[14px] leading-[18px]">В этом случае, перед экскурсионным туром, нужно будет приехать в наш офис по адресу Лиговский проспект, 43/45 (БЦ Ретро, 3 этаж, офис 309) и внести оставшуюся сумму.</div>
								</div>
							</div>
							</div>
							<div class="rounded-[6px] bg-[#F1EFE9] px-5 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
								<div class="text-[20px] font-bold">Оплата 100%</div>
								<div class="sm:text-[18px]">Если вы оплачиваете полную стоимость экскурсии на сайте, вам не нужно беспокоиться о дополнительной оплате в офисе. Достаточно приехать к началу экскурсии в указанное время.</div>
							</div>
							<div class="flex flex-col gap-6">
								<div class="rounded-[6px] bg-[#F1EFE9] px-5 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
									<div class="text-[20px] font-bold">Отправка билета на электронную почту</div>
									<div class="sm:text-[18px]">После оплаты вы получите квитанцию на свою электронную почту, а также билет и схему, как добраться, к месту начала экскурсии, в отдельном письме.</div>
								</div>
								<div class="rounded-[6px] bg-[#F1EFE9] px-5 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
									<div class="text-[20px] font-bold">Приезжайте к месту отправления и наслаждайтесь экскурсией!</div>
								</div>
							</div>
							<div class="flex flex-col sm:px-4">
								<svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 52 52" fill="none">
									<path d="M43.7737 32.5617C43.6722 32.1961 43.8956 31.6883 44.1089 31.3227C44.1741 31.2139 44.2453 31.1087 44.3222 31.0078C46.1465 28.297 47.1223 25.1043 47.1253 21.8367C47.1558 12.4727 39.2542 4.87581 29.4839 4.87581C20.9628 4.87581 13.8534 10.675 12.1878 18.3735C11.9386 19.5145 11.8126 20.679 11.812 21.8469C11.812 31.2211 19.4089 39.0211 29.1792 39.0211C30.7331 39.0211 32.8253 38.5539 33.9729 38.2391C35.1206 37.9242 36.2581 37.5078 36.5526 37.3961C36.8545 37.2823 37.1745 37.2238 37.4972 37.2235C37.8492 37.2221 38.198 37.2912 38.5229 37.4266L44.2815 39.468C44.4078 39.5214 44.5413 39.5557 44.6776 39.5696C44.8931 39.5696 45.0998 39.484 45.2522 39.3316C45.4045 39.1792 45.4901 38.9725 45.4901 38.7571C45.483 38.6641 45.466 38.5722 45.4393 38.4828L43.7737 32.5617Z" stroke="#D6BD7F" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
									<path d="M6.75039 23.5616C5.41833 25.9547 4.77395 28.6695 4.88848 31.4059C5.00302 34.1424 5.872 36.7938 7.39938 39.0672C7.63399 39.4216 7.76602 39.6959 7.72539 39.8797C7.68477 40.0635 6.51375 46.1634 6.51375 46.1634C6.48559 46.3061 6.49627 46.4538 6.54469 46.591C6.5931 46.7282 6.67747 46.8499 6.78899 46.9434C6.93778 47.0619 7.1228 47.1257 7.31305 47.1241C7.41471 47.1244 7.51534 47.1037 7.6086 47.0632L13.3174 44.8288C13.7103 44.6739 14.1486 44.6812 14.5362 44.8491C16.4598 45.5987 18.5865 46.0679 20.7142 46.0679C23.5694 46.0709 26.3745 45.3179 28.8443 43.8853" stroke="#D6BD7F" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
								</svg>
								<div class="flex flex-col mt-6">
									<div class="text-[28px] sm:text-[32px] font-bold mb-3">Остались вопросы?</div>
									<div class="sm:text-[18px] text-[#6B7280]">Свяжитесь с нами - будем рады ответить вам!</div>
									<div class="flex flex-col lg:flex-row gap-8 mt-8 items-start">
										<div class="flex flex-col gap-2 sm:gap-[18px]">
											<div class="sm:text-[20px] text-[#6B7280]">Написать</div>
											<div class="flex gap-[10px]">
												<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', $options['watsapp']);  ?>&text=Здравствуйте.+Я+обращаюсь+с+сайта+groupspb.ru">
													<svg class="w-[32px] sm:w-[48px]" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
														<g id="WhatsApp" clip-path="url(#clip0_200_6133)">
															<g id="WhatsApp_2">
																<path id="Path" d="M24 0C10.752 0 0 10.752 0 24C0 37.248 10.752 48 24 48C37.248 48 48 37.248 48 24C48 10.752 37.248 0 24 0Z" fill="#0DC143"/>
																<path id="Vector" d="M34.7465 13.2115C32.1736 10.5628 28.6168 9.125 24.9844 9.125C17.2655 9.125 11.0601 15.4061 11.1357 23.0493C11.1357 25.4709 11.8168 27.8169 12.9519 29.9358L10.9844 37.125L18.3249 35.2331C20.3682 36.3682 22.6384 36.898 24.9087 36.898C32.5519 36.898 38.7573 30.6169 38.7573 22.9736C38.7573 19.2655 37.3195 15.7845 34.7465 13.2115ZM24.9844 34.552C22.9411 34.552 20.8979 34.0223 19.1573 32.9628L18.7033 32.7358L14.3141 33.8709L15.4492 29.5574L15.1465 29.1034C11.8168 23.7304 13.406 16.6169 18.8546 13.2872C24.3033 9.95743 31.3411 11.5466 34.6709 16.9953C38.0006 22.4439 36.4114 29.4818 30.9628 32.8115C29.2222 33.9466 27.1033 34.552 24.9844 34.552ZM31.6438 26.152L30.8114 25.7736C30.8114 25.7736 29.6006 25.2439 28.8438 24.8655C28.7682 24.8655 28.6925 24.7899 28.6168 24.7899C28.3898 24.7899 28.2384 24.8655 28.0871 24.9412C28.0871 24.9412 28.0114 25.0169 26.9519 26.2277C26.8763 26.3791 26.7249 26.4547 26.5736 26.4547H26.4979C26.4222 26.4547 26.2709 26.3791 26.1952 26.3034L25.8168 26.152C24.9844 25.7736 24.2276 25.3196 23.6222 24.7142C23.4709 24.5628 23.2438 24.4115 23.0925 24.2601C22.5628 23.7304 22.033 23.125 21.6546 22.4439L21.579 22.2926C21.5033 22.2169 21.5033 22.1412 21.4276 21.9899C21.4276 21.8385 21.4276 21.6872 21.5033 21.6115C21.5033 21.6115 21.806 21.2331 22.033 21.0061C22.1844 20.8547 22.2601 20.6277 22.4114 20.4764C22.5628 20.2493 22.6384 19.9466 22.5628 19.7196C22.4871 19.3412 21.579 17.298 21.3519 16.8439C21.2006 16.6169 21.0492 16.5412 20.8222 16.4655H20.5952C20.4438 16.4655 20.2168 16.4655 19.9898 16.4655C19.8384 16.4655 19.6871 16.5412 19.5357 16.5412L19.4601 16.6169C19.3087 16.6926 19.1573 16.8439 19.006 16.9196C18.8546 17.0709 18.779 17.2223 18.6276 17.3736C18.0979 18.0547 17.7952 18.8872 17.7952 19.7196C17.7952 20.325 17.9465 20.9304 18.1736 21.4601L18.2492 21.6872C18.9303 23.125 19.8384 24.4115 21.0492 25.5466L21.3519 25.8493C21.579 26.0764 21.806 26.2277 21.9573 26.4547C23.5465 27.8169 25.3628 28.8007 27.406 29.3304C27.633 29.4061 27.9357 29.4061 28.1628 29.4818C28.3898 29.4818 28.6925 29.4818 28.9195 29.4818C29.2979 29.4818 29.7519 29.3304 30.0546 29.1791C30.2817 29.0277 30.433 29.0277 30.5844 28.8764L30.7357 28.725C30.8871 28.5736 31.0384 28.498 31.1898 28.3466C31.3411 28.1953 31.4925 28.0439 31.5682 27.8926C31.7195 27.5899 31.7952 27.2115 31.8709 26.8331C31.8709 26.6818 31.8709 26.4547 31.8709 26.3034C31.8709 26.3034 31.7952 26.2277 31.6438 26.152Z" fill="white"/>
															</g>
														</g>
														<defs>
															<clipPath id="clip0_200_6133">
																<rect width="48" height="48" fill="white"/>
															</clipPath>
														</defs>
													</svg>
												</a>
												<a target="_blank" href="tg://resolve?domain=<?php echo $options['telegram'];  ?>">
													<svg class="w-[32px] sm:w-[48px]" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" fill="none">
														<g clip-path="url(#clip0_200_6137)">
															<path d="M24 0C10.7625 0 0 10.7625 0 24C0 37.2375 10.7625 48 24 48C37.2375 48 48 37.2375 48 24C48 10.7625 37.2375 0 24 0Z" fill="#419FD9"/>
															<path fill-rule="evenodd" clip-rule="evenodd" d="M29.3331 35.885C31.0106 36.619 31.6397 35.0812 31.6397 35.0812L36.0781 12.7843C36.0432 11.2816 34.0162 12.1902 34.0162 12.1902L9.16807 21.9407C9.16807 21.9407 7.97983 22.3601 8.08468 23.094C8.18952 23.8279 9.13312 24.1774 9.13312 24.1774L15.3888 26.2743C15.3888 26.2743 17.276 32.4601 17.6605 33.6484C18.0099 34.8016 18.3245 34.8366 18.3245 34.8366C18.674 34.9764 18.9885 34.7318 18.9885 34.7318L23.0425 31.0622L29.3331 35.885ZM30.4158 16.733C30.4158 16.733 31.2895 16.2088 31.2546 16.733C31.2546 16.733 31.3944 16.8029 30.94 17.2922C30.5207 17.7115 20.6304 26.5884 19.3023 27.7766C19.1975 27.8465 19.1276 27.9513 19.1276 28.0911L18.7432 31.3763C18.6733 31.7257 18.2189 31.7607 18.1141 31.4461L16.4715 26.0641C16.4016 25.8544 16.4715 25.6098 16.6812 25.47L30.4158 16.733Z" fill="white"/>
														</g>
														<defs>
															<clipPath id="clip0_200_6137">
																<rect width="48" height="48" fill="white"/>
															</clipPath>
														</defs>
													</svg>
												</a>
												<a target="_blank" href="https://vk.com/<?php echo $options['vk'];  ?>">
													<svg class="w-[32px] sm:w-[48px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none">
														<g clip-path="url(#clip0_200_6143)">
															<path d="M24 0C10.752 0 0 10.752 0 24C0 37.248 10.752 48 24 48C37.248 48 48 37.248 48 24C48 10.752 37.248 0 24 0Z" fill="#5181B8"/>
															<path d="M25.4399 33.7202C14.4999 33.7202 8.26 26.2202 8 13.7402H13.48C13.66 22.9002 17.6999 26.7802 20.8999 27.5802V13.7402H26.0601V21.6402C29.2201 21.3002 32.5397 17.7002 33.6597 13.7402H38.8198C37.9598 18.6202 34.3598 22.2202 31.7998 23.7002C34.3598 24.9002 38.46 28.0402 40.02 33.7202H34.3398C33.1198 29.9202 30.0801 26.9802 26.0601 26.5802V33.7202H25.4399Z" fill="white"/>
														</g>
														<defs>
															<clipPath id="clip0_200_6143">
																<rect width="48" height="48" fill="white"/>
															</clipPath>
														</defs>
													</svg>
												</a>
											</div>
										</div>
										<div class="flex flex-col gap-2 sm:gap-[27px]">
											<div class="sm:text-[20px] text-[#6B7280]">Позвонить</div>
											<a href="tel:<?php echo  preg_replace('/[^0-9+]/', '', $options['phone']);  ?>" class="text-[24px] sm:text-[28px] font-bold">
												<span><?php echo $options['phone'];?></span>
												<svg class="hidden sm:block" xmlns="http://www.w3.org/2000/svg" width="269" height="2" viewBox="0 0 269 2" fill="none">
													<path d="M267.5 2C268.052 2 268.5 1.55228 268.5 1C268.5 0.447715 268.052 0 267.5 0V2ZM0.5 2H3.53409V0H0.5V2ZM9.60227 2H15.6705V0H9.60227V2ZM21.7386 2H27.8068V0H21.7386V2ZM33.875 2H39.9432V0H33.875V2ZM46.0114 2H52.0796V0H46.0114V2ZM58.1477 2H64.2159V0H58.1477V2ZM70.2841 2H76.3523V0H70.2841V2ZM82.4205 2H88.4887V0H82.4205V2ZM94.5568 2H100.625V0H94.5568V2ZM106.693 2H112.761V0H106.693V2ZM118.83 2H124.898V0H118.83V2ZM130.966 2H137.034V0H130.966V2ZM143.102 2H149.17V0H143.102V2ZM155.239 2H161.307V0H155.239V2ZM167.375 2H173.443V0H167.375V2ZM179.511 2H185.58V0H179.511V2ZM191.648 2H197.716V0H191.648V2ZM203.784 2H209.852V0H203.784V2ZM215.92 2H221.989V0H215.92V2ZM228.057 2H234.125V0H228.057V2ZM240.193 2H246.261V0H240.193V2ZM252.329 2H258.398V0H252.329V2ZM264.466 2H267.5V0H264.466V2Z" fill="black"/>
												</svg>
												<svg class="block sm:hidden" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 229 2" fill="none">
													<path d="M228 2C228.552 2 229 1.55228 229 1C229 0.447715 228.552 0 228 0V2ZM0 2H3V0H0V2ZM9 2H15V0H9V2ZM21 2H27V0H21V2ZM33 2H39V0H33V2ZM45 2H51V0H45V2ZM57 2H63V0H57V2ZM69 2H75V0H69V2ZM81 2H87V0H81V2ZM93 2H99V0H93V2ZM105 2H111V0H105V2ZM117 2H123V0H117V2ZM129 2H135V0H129V2ZM141 2H147V0H141V2ZM153 2H159V0H153V2ZM165 2H171V0H165V2ZM177 2H183V0H177V2ZM189 2H195V0H189V2ZM201 2H207V0H201V2ZM213 2H219V0H213V2ZM225 2H228V0H225V2Z" fill="black"/>
												</svg>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

					<?php
					$args = ['post_type' => 'gid','posts_per_page' => -1];
					$query = new WP_Query( $args );
					?>
					<?php if ( $query->have_posts() ) : ?>
						<div class="pt-6 sm:pt-12 pb-[64px] bg-[#FAFAFA]">
							<div class="container">
								<h2 class="mb-6 sm:mb-8 mt-4">Наши экскурсоводы</h2>
								<div class="buttons relative flex justify-end gap-2 items-center">
									<div class="gid-button-prev w-[61px] h-[61px] p-0"></div>
									<div class="gid-button-next w-[61px] h-[61px] p-0"></div>
								</div>
								<div class="swiper_gids overflow-hidden px-[2px] pt-[2px] mb-5 sm:mb-8">
									<div class="swiper-wrapper flex h-auto py-[10px]">

										<?php while ( $query->have_posts() ) : $query->the_post(); $fieldsGid = get_fields();?>
											<?php
											$name = isset($fieldsGid['name']) && !empty($fieldsGid['name']) ? $fieldsGid['name'] : get_the_title();
											?>
											<div class="swiper-slide rounded-[6px] shadows_custom overflow-hidden">
												<img src="<?php echo $fieldsGid['img']; ?>" class="h-[255px] object-cover w-full" alt="">
												<div class="p-6">
													<div class="font-bold text-[20px] mb-1"><?php echo $name; ?></div>
													<?php if(isset($fieldsGid['experience']) && !empty($fieldsGid['experience'])) : ?>
														<div class="text-[#6B7280]">Опыт работы: <?php echo $fieldsGid['experience']; ?> </div>
													<?php endif; ?>
												</div>
											</div>
										<?php endwhile; ?>
									</div>
								</div>
								<div class="text-center">
									<a href="#" class="inline-flex h-11 items-center justify-center font-medium  px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px]">Познакомиться с гидами</a>
								</div>
							</div>
						</div>
					<?php endif; wp_reset_postdata(); ?>


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
						<div class="pt-3 sm:pt-12 pb-[30px] sm:pb-[64px]">
							<div class="container">
								<h2 class="mb-6 mt-5">Отзывы <br>
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
												<div class="text-[14px]"><?php the_title() ?>, </div>
												<div class="text-[14px] text-[#6B7280] mb-3">
													<?php
														if (isset($fieldsRev['date']) && !empty($fieldsRev['date'])) {
															echo trim(strtr($fieldsRev['date'], $sub));
														} else {
															echo trim(strtr(get_the_date(), $sub));
														}
													?>
												</div>
												<div class="mb-3 text-[#111827] h-[118px] overflow-y-auto rev-text pe-4"><?php the_content(); ?></div>

												<div class="mt-4 font-bold text-[#52A6B2] lines three-lines h-78px sm:h-[58px]">
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
												<div class="text-[#6B7280] mt-1 sm:pb-4">Гид: Богданова Рената Халимовна</div>
											</div>
										<?php endwhile; ?>
									</div>
								</div>

								<div class="text-center">
									<a href="<?php echo esc_url(get_permalink(184)); ?>" class="inline-flex h-11 items-center justify-center font-medium  px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px]">Посмотреть все отзывы</a>
								</div>
							</div>
						</div>
					<?php endif; wp_reset_postdata(); ?>

				</div>

		</main>
	</section>


<?php
get_footer();
