<?php
/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _tw
 */


?><!doctype html>
<html <?php language_attributes(); ?>  class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="yandex-verification" content="1ceaff6110f95652" />
	<meta name="google-site-verification" content="DNW03mN7rSy-0QrhstLJJiGR2y91_XP0rPHk6GwxtKA" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
		(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
			m[i].l=1*new Date();
			for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
			k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		ym(100214599, "init", {


			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true,
			webvisor:true
		});
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/100214599" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-53RESJ9FSQ"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-53RESJ9FSQ');
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php get_template_part( 'template-parts/layout/header', 'content' ); ?>
		<?php /*
		<div class="filter">
			<?php if(is_home() || is_front_page() || is_tax('excursion')) : ?>

				<?php $current_category = (is_tax('excursion')) ? get_queried_object() : get_term_by('slug', 'ekskursii-peterburg','excursion'); ?>

				<!-- Форма с полем для выбора даты -->
				<form id="filter-form" class="flex gap-8 mb-8">
					<input type="hidden" id="category_id" value="<?php echo $current_category->term_id; ?>" />
					<div class="relative inline-block text-left">
						<label class="gap-3 items-center flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
							<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M14.6571 2.17143H10.3143V0.814286C10.3143 0.364568 9.94972 0 9.5 0C9.05028 0 8.68571 0.364568 8.68571 0.814286V2.17143H4.34286V0.814286C4.34286 0.364568 3.97829 0 3.52857 0C3.07885 0 2.71429 0.364568 2.71429 0.814286V2.1836C1.19252 2.32073 0 3.59967 0 5.15714V16.0143C0 17.6632 1.33675 19 2.98571 19H16.0143C17.6633 19 19 17.6632 19 16.0143V5.15714C19 3.59967 17.8075 2.32073 16.2857 2.1836V0.814286C16.2857 0.364568 15.9211 0 15.4714 0C15.0217 0 14.6571 0.364568 14.6571 0.814286V2.17143ZM2.98571 3.8C2.23619 3.8 1.62857 4.40761 1.62857 5.15714V7.05714H17.3714V5.15714C17.3714 4.40761 16.7638 3.8 16.0143 3.8H2.98571ZM1.62857 16.0143V8.68571H17.3714V16.0143C17.3714 16.7638 16.7638 17.3714 16.0143 17.3714H2.98571C2.23619 17.3714 1.62857 16.7638 1.62857 16.0143Z" fill="#777777"/>
							</svg>
							<input type="text" id="datepicker" name="date" required>
							<svg xmlns="http://www.w3.org/2000/svg" class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
							</svg>
						</label>
					</div>
					<div class="relative inline-block text-left">
						<button type="button" class="dropdown-button gap-3 items-center flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="false" aria-haspopup="true" data-close-on-click="true">
							<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
								<path d="M9.5 4.67762C9.90359 4.67762 10.2308 5.0048 10.2308 5.40839V10.1717L12.6041 12.545C12.8894 12.8303 12.8894 13.293 12.6041 13.5784C12.3187 13.8638 11.856 13.8638 11.5706 13.5784L8.98327 10.9911C8.84622 10.854 8.76923 10.6682 8.76923 10.4744V5.40839C8.76923 5.0048 9.09641 4.67762 9.5 4.67762Z" fill="#777777"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 19C14.7467 19 19 14.7467 19 9.5C19 4.25329 14.7467 0 9.5 0C4.25329 0 0 4.25329 0 9.5C0 14.7467 4.25329 19 9.5 19ZM9.5 17.5385C5.06048 17.5385 1.46154 13.9395 1.46154 9.5C1.46154 5.06048 5.06048 1.46154 9.5 1.46154C13.9395 1.46154 17.5385 5.06048 17.5385 9.5C17.5385 13.9395 13.9395 17.5385 9.5 17.5385Z" fill="#777777"/>
							</svg>
							<span class="dropdown-text">Длительность</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
							</svg>
						</button>
						<div class="dropdown-menu absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none hidden text-change-class">
							<div class="flex flex-col p-5 gap-4">
								<label class="item flex gap-2 items-center">
									<input type="radio" name="duration" value="" class="scale-150 change_text">
									<span>Любая</span>
								</label>

								<label class="item flex gap-2 items-center">
									<input type="radio" name="duration" value="3" class="scale-150 change_text">
									<span>До 3-х часов</span>
								</label>

								<label class="item flex gap-2 items-center">
									<input type="radio" name="duration" value="5" class="scale-150 change_text">
									<span>3-5 часов</span>
								</label>

								<label class="item flex gap-2 items-center">
									<input type="radio" name="duration" value="more5" class="scale-150 change_text">
									<span>Более 5 часов</span>
								</label>
							</div>
						</div>
					</div>
					<div class="relative inline-block text-left">
						<button type="button" class="dropdown-button gap-3 items-center flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="false" aria-haspopup="true" data-close-on-click="true">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="13" viewBox="0 0 18 13" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M16.7143 2.09678H1.28571C0.576 2.09678 0 1.625 0 1.04839C0 0.471775 0.576 0 1.28571 0H16.7143C17.424 0 18 0.471775 18 1.04839C18 1.625 17.424 2.09678 16.7143 2.09678ZM0 6.50003C0 5.92342 0.576 5.45165 1.28571 5.45165H11.5714C12.2811 5.45165 12.8571 5.92342 12.8571 6.50003C12.8571 7.07665 12.2811 7.54842 11.5714 7.54842H1.28571C0.576 7.54842 0 7.07665 0 6.50003ZM0 11.9516C0 11.375 0.576 10.9032 1.28571 10.9032H11.5714C12.2811 10.9032 12.8571 11.375 12.8571 11.9516C12.8571 12.5282 12.2811 13 11.5714 13H1.28571C0.576 13 0 12.5282 0 11.9516Z" fill="#777777"/>
							</svg>
							<span class="dropdown-text">По популярности</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
							</svg>
						</button>
						<div class="dropdown-menu absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none hidden">
							<div class="py-1">
								<div class="flex flex-col p-5 gap-4">
									<label class="item flex gap-2 items-center">
										<input type="radio" name="grade" value="pops" class="scale-150 change_text">
										<span>По популярности</span>
									</label>

									<label class="item flex gap-2 items-center">
										<input type="radio" name="grade" value="expensive" class="scale-150 change_text ">
										<span>По возрастанию цены</span>
									</label>

									<label class="flex gap-2 items-center">
										<input type="radio" name="grade" value="chip" class="scale-150 change_text">
										<span>По убыванию цены</span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<label class="flex gap-2 items-center">
						<input type="checkbox" name="have_sale" class="scale-150">
						<span>Со скидкой</span>
					</label>
				</form>

				<!-- Фильтруемый контент -->
				<div id="response" class="mb-8">
					<?php $all_posts = get_posts( ['numberposts' => 99,'post_type' => 'tours',]); ?>

					<div class="content__tours grid gap-8 ms:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="tours">
						<?php foreach($all_posts as $key => $post): ?>
							<?php $fields = get_fields(); $cost = $fields['neva_fullprice_custom'] ?? '';
								if (!empty($fields['duration'])) {
									$duration_no_let = preg_replace("/[^,.:0-9]/", '', correctTime($fields['duration']));
									$duration_clear = str_replace(',','.',$duration_no_let);
								}
								$duration_clear = $duration_clear ?? 'по запросу';
							?>
							<div class="card item px-[15px] basis-0 grow" data-duration="<?php echo $duration_clear; ?>" data-cost="<?php echo $cost; ?>" data-popular="<?php echo $key;?>">
								<div class="shadow-[4px_4px_20px_#0000001a] group overflow-hidden rounded-[10px] bg-white">
									<div class="overflow-hidden mb-5 min-h-[300px]">
										<a href="<?php echo get_permalink(); ?>"><?php echo get_the_title();	?></a>
									</div>
								</div>

							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif ?>
		</div>
		*/
