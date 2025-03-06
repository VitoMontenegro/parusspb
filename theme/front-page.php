<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _tw
 */
$pageFields = get_fields(2);
$options = get_fields( 'option');
$current_category = get_term_by('slug', 'ekskursii-peterburg','excursion');

$category_id = $current_category->term_id;
set_query_var('sidebar_term', $current_category);

$sub = array(".01." => " января ", ".02." => " февраля ",
		".03." => " марта ", ".04." => " апреля ", ".05." => " мая ", ".06." => " июня ",
		".07." => " июля ", ".08." => " августа ", ".09." => " сентября ",
		".10." => " октября ", ".11." => " ноября ", ".12." => " декабря ", "2022" => '2022', '2023' => '2023', '2024'=>'2024', '2025'=>'2025','2026'=>'2026','00:00'=>'');

get_header();

?>


	<!-- Блок Hero -->
	<div class="container mx-auto mt-6 sm:mt-9">
		<div class="rounded-[6px] pt-[42px] sm:pt-[60px] px-[25px] sm:px-[50px] lg:max-h-[420px] text-[#000000] pb-12 sm:pb-8 relative overflow-hidden">
			<img class="hidden sm:block absolute left-0 right-0 bottom-0 top-0 object-cover w-full h-full" src="<?php echo get_stylesheet_directory_uri(); ?>/img/banner.jpg" alt="">
			<img class="block sm:hidden absolute left-0 right-0 bottom-0 top-0 object-cover w-full h-full" src="<?php echo get_stylesheet_directory_uri(); ?>/img/banner_sm.jpg" alt="">
			<div class="lg:w-[70%] max-w-[730px] flex flex-col items-start relative">
				<h1 class="text-[25px] xs:text-[27px] font-bold sm:text-[48px] leading-[1.17] sm:leading-[1.04] mb-3 sm:mb-[18px] order-1">
					Экскурсии <br>
					по Санкт-Петербургу
				</h1>
				<div class="subtitle sm:mb-8 order-2 mb-6 text-[14px] sm:text-[16px] leading-[1.4] sm:leading-[1.2]">Более 50 экскурсий по Санкт-Петербургу и пригородам. Уникальное сочетание исторических и современных маршрутов, которые откроют вам город с разных сторон.
					Цены на экскурсии по СПб - от 500 рублей.</div>
				<ul class="mb-6 sm:mb-0 sm:ps-0 order-3 sm:order-5 sm:flex sm:gap-4 text-[14px] sm:text-[16px]">
					<li class="relative pl-3 sm:pl-5 before:absolute before:left-0 before:content-['•'] ">Аккредитованные гиды</li>
					<li class="relative pl-3 sm:pl-5 before:absolute before:left-0 before:content-['•']">Интересные программы</li>
					<li class="relative pl-3 sm:pl-5 before:absolute before:left-0 before:content-['•']">Новые автобусы</li>
				</ul>
				<a href="#card_link" class="inline-flex h-10 sm:h-11 items-center justify-center font-medium px-[29px] sm:px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px] order-4 sm:mb-10">Выбрать экскурсию</a>
			</div>
			<img class="hidden lg:block absolute right-10 top-1/2 -translate-y-1/2 right-10 object-cover opacity-70" src="<?php echo get_stylesheet_directory_uri(); ?>/img/charch-big.svg" alt="">

		</div>
	</div>


	<div class="container mt-8 lg:mt-[68px] pb-8 border-b-[2px] border-[#D6BD7F]">
		<div class="flex gap-8">
			<?php get_sidebar(); ?>

			<section class="product-cards w-full relative" id="card_link">

				<div id="sticky-element" class="sidebar-toggle flex flex-col gap-2 z-10 hidden bottom-8  w-[138px]  left-1/2 transform -translate-x-1/2 lg:hidden">
					<div class="h-9 bg-white rounded-md shadow-[0px_2px_10px_-2px_rgba(16,24,40,0.10)] shadow-[0px_2px_10px_-2px_rgba(16,24,40,0.10)] flex-col justify-center items-center gap-2.5 inline-flex overflow-hidden pointer-events-none">
						<div class="justify-center items-center gap-1.5 inline-flex  pointer-events-none">
							<svg class=" pointer-events-none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5995 4.55965H8.87945V3.35965C8.87945 2.962 8.5571 2.63965 8.15945 2.63965C7.76181 2.63965 7.43945 2.962 7.43945 3.35965V7.19965C7.43945 7.59729 7.76181 7.91965 8.15945 7.91965C8.5571 7.91965 8.87945 7.59729 8.87945 7.19965V5.99965H21.5995C21.9971 5.99965 22.3195 5.67729 22.3195 5.27965C22.3195 4.882 21.9971 4.55965 21.5995 4.55965ZM21.6002 17.9996H13.6802V16.7996C13.6802 16.4019 13.3579 16.0796 12.9602 16.0796C12.5626 16.0796 12.2402 16.4019 12.2402 16.7996V20.6396C12.2402 21.0372 12.5626 21.3596 12.9602 21.3596C13.3579 21.3596 13.6802 21.0372 13.6802 20.6396V19.4396H21.6002C21.9979 19.4396 22.3202 19.1172 22.3202 18.7196C22.3202 18.3219 21.9979 17.9996 21.6002 17.9996ZM2.39969 5.99965C2.00204 5.99965 1.67969 5.6773 1.67969 5.27965C1.67969 4.88201 2.00204 4.55965 2.39969 4.55965H5.20621C5.60386 4.55965 5.92621 4.88201 5.92621 5.27965C5.92621 5.6773 5.60386 5.99965 5.20621 5.99965H2.39969ZM1.67969 18.7197C1.67969 19.1173 2.00204 19.4397 2.39969 19.4397H10.042C10.4397 19.4397 10.762 19.1173 10.762 18.7197C10.762 18.322 10.4397 17.9997 10.042 17.9997H2.39969C2.00204 17.9997 1.67969 18.322 1.67969 18.7197Z" fill="#2E2E2E"></path>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5991 11.2804H18.4791V10.0804C18.4791 9.68271 18.1567 9.36035 17.7591 9.36035C17.3614 9.36035 17.0391 9.68271 17.0391 10.0804V13.9204C17.0391 14.318 17.3614 14.6404 17.7591 14.6404C18.1567 14.6404 18.4791 14.318 18.4791 13.9204V12.7204H21.5991C21.9967 12.7204 22.3191 12.398 22.3191 12.0004C22.3191 11.6027 21.9967 11.2804 21.5991 11.2804ZM1.67969 12.0004C1.67969 12.398 2.00204 12.7204 2.39969 12.7204H14.7502C15.1478 12.7204 15.4702 12.398 15.4702 12.0004C15.4702 11.6027 15.1478 11.2804 14.7502 11.2804H2.39969C2.00204 11.2804 1.67969 11.6027 1.67969 12.0004Z" fill="#2E2E2E"></path>
							</svg>
							<div class="text-center text-sm font-medium font-['Inter'] leading-normal pointer-events-none">Фильтр</div>
						</div>
					</div>
				</div>
				<div class="flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-4 sm:gap-12 mb-4">
					<h2 class="text-left m-0 whitespace-nowrap w-full sm:w-auto">Каталог</h2>
					<div class="flex w-full justify-between sm:justify-end items-center gap-8 text-[14px]">
						<div class="flex flex-col gap-2">
							<div id="sidebar-toggle" class="sidebar-toggle flex items-center gap-1.5 lg:hidden is-active">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5995 4.55965H8.87945V3.35965C8.87945 2.962 8.5571 2.63965 8.15945 2.63965C7.76181 2.63965 7.43945 2.962 7.43945 3.35965V7.19965C7.43945 7.59729 7.76181 7.91965 8.15945 7.91965C8.5571 7.91965 8.87945 7.59729 8.87945 7.19965V5.99965H21.5995C21.9971 5.99965 22.3195 5.67729 22.3195 5.27965C22.3195 4.882 21.9971 4.55965 21.5995 4.55965ZM21.6002 17.9996H13.6802V16.7996C13.6802 16.4019 13.3579 16.0796 12.9602 16.0796C12.5626 16.0796 12.2402 16.4019 12.2402 16.7996V20.6396C12.2402 21.0372 12.5626 21.3596 12.9602 21.3596C13.3579 21.3596 13.6802 21.0372 13.6802 20.6396V19.4396H21.6002C21.9979 19.4396 22.3202 19.1172 22.3202 18.7196C22.3202 18.3219 21.9979 17.9996 21.6002 17.9996ZM2.39969 5.99965C2.00204 5.99965 1.67969 5.6773 1.67969 5.27965C1.67969 4.88201 2.00204 4.55965 2.39969 4.55965H5.20621C5.60386 4.55965 5.92621 4.88201 5.92621 5.27965C5.92621 5.6773 5.60386 5.99965 5.20621 5.99965H2.39969ZM1.67969 18.7197C1.67969 19.1173 2.00204 19.4397 2.39969 19.4397H10.042C10.4397 19.4397 10.762 19.1173 10.762 18.7197C10.762 18.322 10.4397 17.9997 10.042 17.9997H2.39969C2.00204 17.9997 1.67969 18.322 1.67969 18.7197Z" fill="#2E2E2E"></path>
									<path fill-rule="evenodd" clip-rule="evenodd" d="M21.5991 11.2804H18.4791V10.0804C18.4791 9.68271 18.1567 9.36035 17.7591 9.36035C17.3614 9.36035 17.0391 9.68271 17.0391 10.0804V13.9204C17.0391 14.318 17.3614 14.6404 17.7591 14.6404C18.1567 14.6404 18.4791 14.318 18.4791 13.9204V12.7204H21.5991C21.9967 12.7204 22.3191 12.398 22.3191 12.0004C22.3191 11.6027 21.9967 11.2804 21.5991 11.2804ZM1.67969 12.0004C1.67969 12.398 2.00204 12.7204 2.39969 12.7204H14.7502C15.1478 12.7204 15.4702 12.398 15.4702 12.0004C15.4702 11.6027 15.1478 11.2804 14.7502 11.2804H2.39969C2.00204 11.2804 1.67969 11.6027 1.67969 12.0004Z" fill="#2E2E2E"></path>
								</svg>
								<span>Фильтр</span>
							</div>
						</div>
						<form class="flex items-center gap-3 m-0" id="sort_form">
							<div class="relative inline-block text-left">
								<button type="button" class="dropdown-button items-center mb-0 gap-0.5 sm:gap-2 flex" aria-expanded="true" aria-haspopup="true" data-close-on-click="true">
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
				<div class="flex flex-col relative">
					<?php
					my_custom_template($category_id, 'template-parts/content/content-loop-excursion');
					?>
				</div>
			</section>
		</div>
	</div>
	<section class="bg-white pb-10 lg:pb-14">
			<div class="container">
				<div class="pt-8 sm:pt-12 pb-[64px] border-b-[2px] border-[#D6BD7F]">
					<div class="text-[#D6BD7F] mb-0">с 2016 года</div>
					<h2 class="mb-8 sm:mb-12 mt-3">Дарим впечатления на наших <br class="hidden sm:block"> экскурсиях</h2>
					<div class="flex flex-col sm:flex-row w-full justify-between gap-8">
						<div class="item flex flex-col gap-3 sm:gap-6">
							<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
								<path d="M37.8333 32.3333C34.6167 32.3333 32 34.95 32 38.1667C32 39.75 32.6383 41.1833 33.6667 42.2367V49.0867C33.6667 49.7267 34.0483 50.3 34.64 50.545C35.2367 50.7933 35.9083 50.6567 36.3917 50.1733L37.8333 48.5767L39.305 50.205C39.6083 50.5067 40.01 50.6667 40.42 50.6667C40.6233 50.6667 40.83 50.6267 41.0267 50.545C41.6167 50.3 42 49.7267 42 49.0867V42.2367C43.0283 41.185 43.6667 39.75 43.6667 38.1667C43.6667 34.95 41.05 32.3333 37.8333 32.3333ZM40.3333 48.8567L38.4517 46.7733C38.1367 46.425 37.53 46.425 37.215 46.7733L35.3333 48.8567V43.415C36.0933 43.78 36.935 44 37.8333 44C38.7317 44 39.5733 43.7783 40.3333 43.415V48.8567ZM37.8333 42.3333C35.535 42.3333 33.6667 40.4633 33.6667 38.1667C33.6667 35.87 35.535 34 37.8333 34C40.1317 34 42 35.87 42 38.1667C42 40.4633 40.1317 42.3333 37.8333 42.3333ZM43.6667 28.1667C43.6667 28.6267 43.2933 29 42.8333 29H21.1667C20.7067 29 20.3333 28.6267 20.3333 28.1667C20.3333 27.7067 20.7067 27.3333 21.1667 27.3333H42.8333C43.2933 27.3333 43.6667 27.7067 43.6667 28.1667ZM27.8333 34C28.2933 34 28.6667 34.3733 28.6667 34.8333C28.6667 35.2933 28.2933 35.6667 27.8333 35.6667H21.1667C20.7067 35.6667 20.3333 35.2933 20.3333 34.8333C20.3333 34.3733 20.7067 34 21.1667 34H27.8333ZM52 21.5V39.8333C52 43.2583 49.6867 46.245 46.375 47.0967C45.925 47.21 45.475 46.9417 45.36 46.4967C45.2467 46.05 45.515 45.5967 45.9583 45.4817C48.535 44.82 50.3333 42.495 50.3333 39.8317V21.5C50.3333 18.2833 47.7167 15.6667 44.5 15.6667H19.5C16.2833 15.6667 13.6667 18.2833 13.6667 21.5V39.8333C13.6667 43.05 16.2833 45.6667 19.5 45.6667H29.5C29.96 45.6667 30.3333 46.04 30.3333 46.5C30.3333 46.96 29.96 47.3333 29.5 47.3333H19.5C15.365 47.3333 12 43.9683 12 39.8333V21.5C12 17.365 15.365 14 19.5 14H44.5C48.635 14 52 17.365 52 21.5ZM43.6667 21.5C43.6667 21.96 43.2933 22.3333 42.8333 22.3333H21.1667C20.7067 22.3333 20.3333 21.96 20.3333 21.5C20.3333 21.04 20.7067 20.6667 21.1667 20.6667H42.8333C43.2933 20.6667 43.6667 21.04 43.6667 21.5Z" fill="#D6BD7F"/>
							</svg>
							<div class="font-medium text-[16px] sm:text-[18px] text-[#6B7280]">Работаем официально, <br>
								номер туроператора 025330</div>
						</div>
						<div class="item flex flex-col gap-3 sm:gap-6">
							<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
								<path d="M39.9154 22.9897H23.4614C23.4614 13.6628 39.9154 13.6628 39.9154 22.9897Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M15.3662 42.0114H6.99121V58.1215H15.3662V42.0114Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M15.3662 57.9215V42.0114L16.3101 40.8676V36.4121" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M31.7242 11.8151H31.6362H30.3403V15.9746H31.6362H31.7242H33.02V11.8151H31.7242Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M12.567 54.7779V50.1464C12.567 49.3785 11.9431 48.7626 11.1831 48.7626C10.4232 48.7626 9.79932 49.3865 9.79932 50.1464V54.7779H12.575H12.567Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.32715 47.8347L11.2069 46.7468" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M13.0948 47.8347L11.207 46.7468" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M4.33545 51.0423V48.9226L6.92714 47.9387" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M4.33545 48.9226V58.2495" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M17.9582 32.6926C19.0861 32.6926 20.006 33.6045 20.006 34.7403H15.9185C15.9185 33.6125 16.8303 32.6926 17.9662 32.6926H17.9582Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M2 58.2495H61.3608V59.7533H2V58.2495Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M20.5654 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M20.8695 34.7243H14.6782V36.2121H20.8695V34.7243Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M19.7417 36.2121H43.6188V37.7159H19.7417V36.2121Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M19.7417 36.4121V45.0671" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M19.022 45.299H44.3389V46.8508H19.022V45.299Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M23.7256 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M27.0371 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M29.9805 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M22.2295 26.4053H41.1392V27.9091H22.2295V26.4053Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M24.269 26.4053H39.0913V22.9897H24.269V26.4053Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M22.5015 36.2121H40.8513V34.7083H22.5015V36.2121Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M23.3818 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M26.1328 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M28.2368 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M30.3809 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M19.022 45.299L31.5805 40.1796" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M28.4048 45.299V44.0032L31.6764 43.1233" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M17.9741 32.6765V28.981" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M32.8842 5.55981H30.5005" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M56.3774 42.0114H48.0024V58.1215H56.3774V42.0114Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M47.9947 57.9215V42.0114L47.0508 40.8676V36.4121" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M59.0173 51.0423V48.9226L56.4336 47.9387" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M59.0171 48.9226V58.2495" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M45.3788 32.6926C44.2509 32.6926 43.3311 33.6045 43.3311 34.7403H47.4186C47.4186 33.6125 46.5067 32.6926 45.3708 32.6926H45.3788Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M42.7949 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M48.6747 34.7243H42.4834V36.2121H48.6747V34.7243Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M43.6191 36.4121V44.9951" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M39.6357 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M36.3237 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M33.3804 46.8428V58.2415" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M39.9795 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M37.2275 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M35.124 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M32.98 27.9091V34.7083" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M44.3388 45.299L31.7803 40.1796" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M34.9559 45.299V44.0032L31.6763 43.1233" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M53.5377 54.7779V50.1464C53.5377 49.3785 52.9138 48.7626 52.1539 48.7626C51.3939 48.7626 50.77 49.3865 50.77 50.1464V54.7779H53.5457H53.5377Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M50.2983 47.8347L52.1861 46.7468" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M54.0658 47.8347L52.186 46.7468" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M33.6204 11.7991H29.7568C29.7568 9.60734 33.6204 9.60734 33.6204 11.7991Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M31.6763 10.1673V4" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M19.1742 30.0848H16.7905" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M45.3945 32.6765V28.981" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M46.5942 30.0848H44.2104" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="font-medium text-[18px] text-[#6B7280]">
								Более 50 классических <br>
								и авторских программ
							</div>
						</div>
						<div class="item flex flex-col gap-3 sm:gap-6">
							<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
								<path d="M28.0938 20.0647L28.0938 25.3102M36.9063 20.0647V25.3102" stroke="#D6BD7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M28.7236 48.2857L36.3821 36.0112" stroke="#D6BD7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<rect x="9" y="19.75" width="47" height="35.25" rx="5.03571" stroke="#D6BD7F" stroke-width="1.5"/>
								<rect x="17.3931" y="29.6116" width="30.2143" height="25.3884" rx="5.03571" stroke="#D6BD7F" stroke-width="1.5"/>
								<path d="M19.0713 13.6652C19.0713 10.5364 21.6077 8 24.7365 8H25.261C28.6795 8 31.4508 10.7712 31.4508 14.1897V19.3304H24.7365C21.6077 19.3304 19.0713 16.794 19.0713 13.6652V13.6652Z" stroke="#D6BD7F" stroke-width="1.5"/>
								<rect x="23.2676" y="35.2768" width="5.45536" height="5.45536" rx="2.72768" stroke="#D6BD7F" stroke-width="1.5"/>
								<rect x="36.4863" y="43.6696" width="5.45536" height="5.45536" rx="2.72768" stroke="#D6BD7F" stroke-width="1.5"/>
								<path d="M43.8306 13.6652C43.8306 10.5364 41.2942 8 38.1654 8H37.6408C34.2223 8 31.4511 10.7712 31.4511 14.1897V19.3304H38.1654C41.2942 19.3304 43.8306 16.794 43.8306 13.6652V13.6652Z" stroke="#D6BD7F" stroke-width="1.5"/>
								<path d="M52.9579 11.8817C52.9579 15.7634 50.3771 19.75 38.7949 19.75" stroke="#D6BD7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="font-medium text-[18px] text-[#6B7280]">
								Скидки при покупке билетов <br>
								онлайн и на день рождения
							</div></div>
						<div class="item flex flex-col gap-3 sm:gap-6">
							<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
								<path d="M37.8029 51.4357V59.5812H27.1323V51.4357" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M36.8066 43.2825H28.1211V51.4281H36.8066V43.2825Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M36.8066 35.137H28.1211V43.2825H36.8066V35.137Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M32.6008 30.414C35.7419 30.414 38.2898 32.5283 38.2898 35.137H26.9043C26.9043 32.5283 29.4521 30.414 32.5932 30.414H32.6008Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M30.4863 41.4572V38.9474C30.4863 37.8522 31.3762 36.9623 32.4714 36.9623C33.5666 36.9623 34.4564 37.8522 34.4564 38.9474V41.4572" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M30.4863 49.6103V47.1005C30.4863 46.0053 31.3762 45.1155 32.4714 45.1155C33.5666 45.1155 34.4564 46.0053 34.4564 47.1005V49.6103" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M34.7453 24.0786H30.4634V30.414H34.7453V24.0786Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M32.5854 4V21.6905" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M30.8135 6.76843H34.3577" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M25.2231 51.4357H39.6965" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M25.9155 43.2825H39.0199" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M34.4565 59.5812V51.4585" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M30.418 59.5812V51.4585" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M40.2671 55.5122H54.748L59.7829 59.3606H40.2671" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M57.8208 44.6971C59.4179 44.6971 60.7185 45.7771 60.7185 47.1005H54.9307C54.9307 45.7695 56.2236 44.6971 57.8284 44.6971H57.8208Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M53.6982 48.4163H61.935" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M60.627 48.4163V57.4212" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M54.999 48.4163V52.2951" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M57.813 48.4163V54.706" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M57.8057 40.8107V44.6972" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M24.6681 55.5122H10.1872L5.15234 59.3606H24.6681" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.12232 44.6971C5.52515 44.6971 4.22461 45.7771 4.22461 47.1005H10.0124C10.0124 45.7695 8.71948 44.6971 7.11471 44.6971H7.12232Z" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M11.2444 48.4163H3" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M4.30811 48.4163V57.4212" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.93604 48.4163V52.2951" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.11475 48.4163V54.706" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.11475 40.8107V44.6972" stroke="#D6BD7F" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="font-medium text-[18px] text-[#6B7280]">
								Входы в музеи и дворцы <br>
								включены в стоимость
							</div>
						</div>
					</div>
				</div>

				<div class="pt-8  pb-[64px]">
					<h2 class="mb-12 sm:mb-8 mt-6">Покупка билета на сайте происходит <br> следующим образом:</h2>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
						<div class="rounded-[6px] bg-[#F1EFE9] px-5 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
							<div class="text-[20px] font-bold">Предоплата 20%</div>
							<div class="sm:text-[18px]">По желанию вы можете оплатить только 20% от стоимости экскурсии – такая возможность доступна для некоторых программ.</div>
							<div class="justify-start items-start gap-2.5 inline-flex">
								<div class="w-6 h-6 relative">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<circle cx="12" cy="12" r="12" fill="#D6BD7F" fill-opacity="0.4"/>
										<path d="M11.16 18.2686V9.49143H13.2286V18.2686H11.16ZM12.2 8.24571C11.8724 8.24571 11.5905 8.13714 11.3543 7.92C11.1181 7.69905 11 7.43429 11 7.12571C11 6.81333 11.1181 6.54857 11.3543 6.33143C11.5905 6.11048 11.8724 6 12.2 6C12.5314 6 12.8133 6.11048 13.0457 6.33143C13.2819 6.54857 13.4 6.81333 13.4 7.12571C13.4 7.43429 13.2819 7.69905 13.0457 7.92C12.8133 8.13714 12.5314 8.24571 12.2 8.24571Z" fill="#D6BD7F"/>
									</svg>
								</div>
								<div class="grow shrink basis-0 flex-col justify-start items-start gap-5 inline-flex">
									<div class="self-stretch text-gray-500 text-[14px] leading-[18px]">В таком случае, перед экскурсией, вам необходимо приехать к нам в офис на Лиговском проспекте 43/45 (БЦ Ретро, 3 этаж, 309 офис) и доплатить оставшуюся сумму.</div>
								</div>
							</div>
						</div>
						<div class="rounded-[6px] bg-[#F1EFE9] px-5 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
							<div class="text-[20px] font-bold">Оплата 100%</div>
							<div class="sm:text-[18px]">Оплачивая полную стоимость на сайте вы приезжаете
								к началу экскурсии, ни о чем не беспокоясь.</div>
							<div class="sm:text-[18px]">Вам не нужно за 30 минут до начала экскурсии приезжать в офис, бронировать место и получать билет.</div>
						</div>
						<div class="flex flex-col gap-6">
							<div class="rounded-[6px] bg-[#F1EFE9] px-5 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
								<div class="text-[20px] font-bold">Получение билета</div>
								<div class="sm:text-[18px]">На вашу электронную почту придет билет и схема прохода
									к месту отправления экскурсионного автобуса, а в отдельном письме – квитанция об оплате.</div>
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
					<h2 class="mb-6 sm:mb-8 mt-4">Профессиональные гиды, <br>
						с которыми не скучно</h2>
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
									<div class="swiper-slide rounded-[6px] shadows_custom p-6 text-[14px] sm:text-[16px]" itemprop="review" itemscope itemtype="https://schema.org/Review">
										<div itemprop="author" class="text-[14px]"><?php the_title() ?>, </div>
										<div class="text-[14px] text-[#6B7280] mb-3" itemprop="datePublished" >
											<?php
												if (isset($fieldsRev['date']) && !empty($fieldsRev['date'])) {
													echo trim(strtr($fieldsRev['date'], $sub));
												} else {
													echo trim(strtr(get_the_date(), $sub));
												}
											?>
										</div>
										<div class="mb-3 text-[#111827] h-[118px] overflow-y-auto rev-text pe-4" itemprop="reviewBody"><?php the_content(); ?></div>

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
										<?php if(isset($fieldsRev['gid']) && !empty($fieldsRev['gid'])) : ?>
											<div class="text-[#6B7280] mt-1 sm:pb-4">Гид: <?php echo $fieldsRev['gid']; ?></div>
										<?php endif; ?>
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




			<?php if(isset($pageFields['description_spb']) && !empty($pageFields['description_spb'])): ?>
				<div class="pt-8 sm:pt-12 pb-[10px] sm:pb-[64px] bg-[#FAFAFA]">
					<div class="container">
						<h2 class="mb-8 sm:mb-12">Рекомендуем посетить <br>	в Санкт-Петербурге</h2>
						<div class="swiper swiper_custom overflow-hidden px-[2px] pt-[2px] pb-[40px] mb-7">
							<div class="swiper-wrapper flex h-auto py-[10px]">
								<?php foreach($pageFields['tours_spb_items'] as $tour) : ?>
									<a href="<?php echo get_term_link($tour['item'])?>" class="swiper-slide rounded-[6px] shadows_custom overflow-hidden relative h-[255px]">
										<img src="<?php echo $tour['image']; ?>" alt="" class="absolute inset-0 w-full h-full object-cover z-[-1]">
										<!-- <div class="absolute top-[100px] bottom-0 right-0 left-0 bg-gradient-to-b from-transparent via-[#E0CB97]/70 to-[#E0CB97] z-0"></div> -->
										<div class="absolute top-[100px] bottom-0 right-0 left-0 bg-gradient-to-b from-transparent  via-[#E0CB97]/60 to-[#221e15] to-[90%] z-0"></div>
										<div class="absolute text-white left-6 bottom-6 right-6 pe-0  sm:right[40%] z-[1]">
											<span class="text-[20px] font-bold  leading-[1] sm:leading-[1.3]">
												<?php
													if(isset($tour['item']) && !empty($tour['item'])) {
														$taxonomy = 'excursion_';
														$fields = get_fields($taxonomy . $tour['item']->term_id);
														$title = (isset($fields['h1']) && !empty($fields['h1'])) ? $fields['h1'] : $tour['item']->name;
														echo $title;
													}
												?>
											</span>
											<span>от <?php echo get_min_price($tour['item']->slug) ?> ₽/чел</span>
										</div>
									</a>
								<?php endforeach; ?>
							</div>
							<div class="swiper-pagination"></div>

						</div>
						<div class="entry-content"><?php echo $pageFields['description_spb'] ?></div>
					</div>
				</div>
			<?php endif;?>

			<?php if(isset($pageFields['description_spb_out']) && !empty($pageFields['description_spb_out'])): ?>
				<div class="pt-8 sm:pt-12 pb-[10px] sm:pb-[64px]">
					<div class="container">
						<h2 class="mb-8 sm:mb-12">Что посетить за <br class="block sm:hidden"> пределами <br class="hidden sm:block"> Петербурга?</h2>
						<!-- Swiper для мобильных -->
						<div class="swiper swiper_custom overflow-hidden px-[2px] pt-[2px] pb-[40px] mb-7 lg:hidden">
							<div class="swiper-wrapper flex h-auto py-[10px]">
								<?php foreach($pageFields['tours_out_items'] as $tour) : ?>
									<a href="<?php echo get_term_link($tour['item'])?>" class="swiper-slide rounded-[6px] shadows_custom overflow-hidden relative h-[255px]">
										<img src="<?php echo $tour['image']; ?>" alt="" class="absolute inset-0 w-full h-full object-cover z-[-1]">
										<div class="absolute top-[100px] bottom-0 right-0 left-0 bg-gradient-to-b from-transparent  via-[#52a6b2]/60 to-[#221e15] to-[90%] z-0"></div>
										<div class="absolute text-white left-6 bottom-6 right-6  pe-0 sm:pe-[150px]">
											<span class="text-[20px] font-bold  leading-[1] sm:leading-[1.3]">
												<?php
												$taxonomy = 'excursion_';
												$fields = get_fields($taxonomy . $tour['item']->term_id);
												$title = (isset($fields['h1']) && !empty($fields['h1'])) ? $fields['h1'] : $tour['item']->name;
												echo $title;
												?>
											</span>
											<span>от <?php echo get_min_price($tour['item']->slug) ?> ₽/чел</span>
										</div>
									</a>
								<?php endforeach; ?>
							</div>
							<div class="swiper-pagination"></div>
						</div>
						<!-- Grid для десктопа -->
						<div class="grid-layout hidden lg:grid grid-cols-12 gap-4 mb-[48px]">
							<?php  $count = 0; ?>
							<?php foreach($pageFields['tours_out_items'] as $tour) : ?>
								<?php $class = (++$count < 4) ? 'col-span-4' : 'col-span-6'; ?>
								<a href="<?php echo get_term_link($tour['item'])?>" class="<?php echo $class; ?> rounded-[6px] shadows_custom overflow-hidden relative h-[255px]">
									<img src="<?php echo $tour['image']; ?>" alt="" class="absolute inset-0 w-full h-full object-cover">
									<!-- <div class="absolute top-[100px] bottom-0 right-0 left-0 bg-gradient-to-b from-transparent to-[#52a6b2] z-0"></div> -->
									<div class="absolute top-[100px] bottom-0 right-0 left-0 bg-gradient-to-b from-transparent  via-[#52a6b2]/60 to-[#221e15] to-[90%] z-0"></div>

									<div class="absolute text-white left-6 bottom-6 right-6  pe-0 sm:pe-[150px]">
										<div class="text-[20px] font-bold">
											<?php
											$taxonomy = 'excursion_';
											$fields = get_fields($taxonomy . $tour['item']->term_id);
											$title = (isset($fields['h1']) && !empty($fields['h1'])) ? $fields['h1'] : $tour['item']->name;
											echo $title;
											?>
										</div>
										<div>от <?php echo get_min_price($tour['item']->slug) ?> ₽/чел</div>
									</div>
									<div class="absolute right-6 bottom-6">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/charch.svg" alt="icon">
									</div>
								</a>
							<?php endforeach; ?>
						</div>
						<div class="entry-content"><?php echo $pageFields['description_spb_out'] ?></div>
					</div>
				</div>
			<?php endif;?>

			<?php if(isset($pageFields['description_far']) && !empty($pageFields['description_far'])): ?>
				<div class="pt-6 pb-[10px] sm:pb-[64px] bg-[#FAFAFA]">
					<div class="container">
						<h2 class="mb-8 sm:mb-12">Экскурсии <br> дальнего следования</h2>
						<div class="swiper swiper_custom overflow-hidden px-[2px] pt-[2px] pb-[40px] mb-7 ">
							<div class="swiper-wrapper flex h-auto py-[10px]">
								<?php foreach($pageFields['tours_inside'] as $tour) : ?>
									<a href="<?php echo get_term_link($tour['item'])?>" class="swiper-slide rounded-[6px] shadows_custom overflow-hidden relative h-[255px]">
										<img src="<?php echo $tour['image']; ?>" alt="" class="absolute inset-0 w-full h-full object-cover z-[-1]">
										<div class="absolute top-[100px] bottom-0 right-0 left-0 bg-gradient-to-b from-transparent  via-[#E0CB97]/60 to-[#221e15] to-[90%] z-0"></div>

										<!-- <div class="absolute top-[100px] bottom-0 right-0 left-0 bg-gradient-to-b from-transparent to-[#E0CB97] z-0"></div> -->
										<div class="absolute text-white left-6 bottom-6 right-6  pe-0  sm:right[40%] z-[1]">
											<span class="text-[20px] font-bold leading-[1] sm:leading-[1.3]">
												<?php
												$taxonomy = 'excursion_';
												$fields = get_fields($taxonomy . $tour['item']->term_id);
												$title = (isset($fields['h1']) && !empty($fields['h1'])) ? $fields['h1'] : $tour['item']->name;
												echo $title;
												?>
											</span>
											<span>от <?php echo get_min_price($tour['item']->slug) ?> ₽/чел</span>
										</div>
									</a>
								<?php endforeach; ?>
							</div>
							<div class="swiper-pagination"></div>
						</div>
						<div class="entry-content"><?php echo $pageFields['description_far'] ?></div>
					</div>
				</div>
			<?php endif;?>

			<div class="container">
				<div class="grid grid-cols-12 w-full pt-[64px]" itemscope itemtype="https://schema.org/FAQPage">
					<div class="col-span-12 lg:col-span-6 order-2 sm:order-1">
						<h2 class="hidden sm:block mt-0">Часто задаваемые вопросы <br> туристов</h2>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/petr.svg" alt="">
					</div>
					<?php
					$args = array(
						'post_type'      => 'faqs',      // Тип записи 'faqs'
						'posts_per_page' => -1,
						'tax_query'      => array(
							array(
									'taxonomy' => 'faqs_category', // Таксономия
									'field'    => 'slug',          // Ищем по слагу
									'terms'    => 'osnovnaya',      // Укажите слаг категории
							),
						),
					);

					$query = new WP_Query( $args );

					// Если записи найдены
					if ( $query->have_posts() ) : ?>
					<div class="entry-content col-span-12 lg:col-span-6 order-1 sm:order-2 mb-6 sm:mb-0" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question">
						<h2 class="sm:hidden mt-0 mb-[34px]">Часто задаваемые вопросы туристов</h2>
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<details class="details w-full relative block mb-4" name="faq" itemprop="name">
							<summary class="details__title py-4 ps-4 lg:ps-8 pe-[60px] xs:pe-14 sm:pe-10 text-[#111827] font-bold cursor-pointer list-none leading-[24px]">
								<?php the_title(); ?>
							</summary>
							<div itemprop="acceptedAnswer" itemscope="" itemtype="http://schema.org/Answer" class="details__content ps-4 sm:pe-14 lg:ps-8 pb-6 lg:pb-7 text-[#6B7280] mt-3 sm:mt-0">
								<?php the_content(); ?>
							</div>
						</details>
						<?php endwhile; ?>

					</div>
					<?php endif; wp_reset_postdata(); ?>
				</div>
			</div>

		<div class="block sm:hidden">
			<div class="container mt-[48px] mb-[24px]">
				<div class="w-full px-[42px] py-[15px] bg-white border-2 border-[#d6bd7f] justify-center items-center gap-3.5 flex mt-6">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-sigur.svg" alt="" class="object-cover ">
					<div>
						<div class="text-[14px] font-bold leading-[16px] mb-[4px]">Мы внесены в единый реестр туроператоров<br/></div>
						<div class="text-gray-900 text-[12px] font-normal leading-[22px]">№<?php echo $options['reestr']; ?> ИНН <?php echo $options['inn']; ?></div>
					</div>
				</div>
			</div>
		</div>
	</section>


<?php
get_footer();
