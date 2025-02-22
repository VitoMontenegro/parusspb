<?php
/**
 * Страница с кастомным шаблоном (page-custom.php)
 * @package WordPress
 * Template Name: Отзывы
 */



get_header();
$excurs_arr = []; // массив экскурсий [id]=>title

$args = ['post_type' => 'tours',
		'posts_per_page' => -1
];
$query = new WP_Query( $args );

foreach($query->posts as $post){
	$excurs_arr[$post->ID] = get_the_title();
}
wp_reset_postdata();
?>
<?php get_template_part( 'template-parts/layout/submenu', 'content' ); ?>
<section class="primary content--reviews">
	<main id="main">
		<?php get_template_part( 'template-parts/layout/breadcrumbs', 'content' ); ?>



		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="container">
					<div class="overflow-x-hidden">
						<div class="entry-content">
                        <h1 class="mt-0 text-2xl sm:text-[32px] font-bold tracking-tight mb-[22px] sm:mb-12"><?php the_title() ; ?></h1>
							<?php the_content(); ?>

							<?php
							$args = ['post_type' => 'reviews',	'posts_per_page' => 10];
							$query = new WP_Query( $args );


							$months = [
								'января'   => '01', 'февраля' => '02', 'марта'    => '03', 'апреля'   => '04',
								'мая'      => '05', 'июня'    => '06', 'июля'     => '07', 'августа'  => '08',
								'сентября' => '09', 'октября' => '10', 'ноября'   => '11', 'декабря'  => '12'
							];

							// Получаем и сортируем записи
							$posts = [];
							if ($query->have_posts()) {
								while ($query->have_posts()) {
									$query->the_post();
									$acf_date = get_field('date');

									if ($acf_date) {
										$date_parts = explode(' ', $acf_date);
										if (count($date_parts) === 3) {
											$day   = str_pad($date_parts[0], 2, '0', STR_PAD_LEFT);
											$month = $months[$date_parts[1]] ?? '01';
											$year  = $date_parts[2];
											$formatted_date = "$year-$month-$day";
										} else {
											$formatted_date = '0000-00-00';
										}
									} else {
										$formatted_date = '0000-00-00';
									}

									$posts[] = [
										'id'    => get_the_ID(),
										'date'  => $acf_date,
										'sort_date' => $formatted_date
									];
								}
							}

							// Сортируем по убыванию даты
							usort($posts, function($a, $b) {
								return strcmp($b['sort_date'], $a['sort_date']);
							});

							// Разбиваем по 10 записей
							$posts_per_page = 10;
							$total_posts = count($posts);
							$total_pages = ceil($total_posts / $posts_per_page);
							$posts_paginated = array_slice($posts, 0, $posts_per_page); // Первые 10 записей

							if (!empty($posts_paginated)) :








							?>

							<div id="rev-container" class="rev-container flex flex-col sm:grid sm:grid-cols-2 gap-[18px]">
									<?php foreach ($posts_paginated as $post) : ?>
										<?php
										// Устанавливаем текущий пост для шаблона
										$post_obj = get_post($post['id']);
										setup_postdata($post_obj);
										get_template_part('template-parts/content/content', 'reviews');
										?>
									<?php endforeach; ?>
									<?php if ($total_posts > $posts_per_page) : ?>
										<button id="load-more" class="col-span-2 pt-1 load-more-excursion" data-page="2">
											<span class="inline-block font-bold text-[#FF7A45] py-2 px-4 sm:px-8 border-2 border-[#FF7A45] rounded-[6px] hover:text-white hover:bg-[#FF7A45]">
												Загрузить ещё
											</span>
										</button>
									<?php endif; ?>
								</div>
							<?php endif; wp_reset_postdata(); ?>



							<form id="reviews_form" class="reviews_form p-8 bg-white rounded-2xl w-full mt-8 mb-[64px]">
								<div class="head mb-[18px]">
									<div class="title text-[18px] font-bold mb-1">Как всё прошло?</div>
									<div class="text-[#373F41] text-[14px]">Поделитесь своим мнением</div>
								</div>
								<div class="flex flex-wrap sm:flex-nowrap gap-[18px] items-center justify-center">
									<div class="flex flex-col w-full">

										<label class="placeholder relative mb-[18px]">
											<input
													class="bg-[#F2F1FA] text-[#373F41] text-[14px] rounded-[6px] w-full h-10 px-4 focus:outline-none placeholder-transparent"
													name="name"
													type="text"
													placeholder="Номер телефона*">
											<span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#373F41] text-[14px] transition-opacity pointer-events-none">
												Имя<span class="text-[#52A6B2]">*</span>
											</span>
										</label>

										<label class="placeholder relative mb-[18px]">
											<input
													class="bg-[#F2F1FA] text-[#373F41] text-[14px] rounded-[6px] w-full h-10 px-4 focus:outline-none placeholder-[#373F41]"
													type="text"
													name="excurs"
													id="inputField"
													autocomplete="off"
													placeholder="Экскурсия/тур" >
											<ul id="suggestions" class="absolute top-full left-0 w-full bg-white border border-gray-300 rounded shadow max-h-52 overflow-y-auto hidden z-10">
												<?php foreach ($excurs_arr as $key => $value): ?>
													<li class="data-item px-4 py-2 hover:bg-gray-100 cursor-pointer"><?php echo $value ?></li>
												<?php endforeach ?>
											</ul>
										</label>


										<div id="rev_upload" class="rounded-xl border border-dashed border-[#52A6B2] px-[11px] py-[14px]">
											<label class="relative justify-center items-center flex flex-col">
												<svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M7 8.375C5.20507 8.375 3.75 9.83008 3.75 11.625V24.625C3.75 26.4199 5.20507 27.875 7 27.875H26.5C28.2949 27.875 29.75 26.4199 29.75 24.625V11.625C29.75 9.83007 28.2949 8.375 26.5 8.375H23.9231C23.4921 8.375 23.0788 8.2038 22.774 7.89905L20.9519 6.0769C20.3424 5.46741 19.5158 5.125 18.6538 5.125H14.8462C13.9842 5.125 13.1576 5.46741 12.5481 6.0769L10.726 7.89905C10.4212 8.2038 10.0079 8.375 9.5769 8.375H7ZM16.75 23C19.4424 23 21.625 20.8174 21.625 18.125C21.625 15.4326 19.4424 13.25 16.75 13.25C14.0576 13.25 11.875 15.4326 11.875 18.125C11.875 20.8174 14.0576 23 16.75 23Z" fill="#52A6B2"/>
												</svg>
												<span id="popup-input-file" class="popup-input-content popup-input-file-content">
														<input type="file" id="browse"  multiple="multiple"  class="popup-input-file opacity-0 photo absolute top-0 bottom-0 left-0 right-0" name="file[]" accept="image/*">
														<span class="popup-input-file-btn text-[11px]">Перетащите или загрузите фото/видео</span>
													</span>
											</label>
										</div>

										<div id="preview" class="file-name"></div>

									</div>
									<div class="flex flex-col gap-[18px] w-full">
										<textarea class="bg-[#F2F1FA] rounded-[12px] w-full px-4 py-[11px] focus:outline-none h-[200px] text-[14px]" name="message" id="" placeholder="Ваши впечатления"></textarea>
									</div>
								</div>

								<button class="inline-flex h-11 items-center justify-center font-bold   px-7 sm:px-10 rounded-md bg-[#52A6B2] text-white text-[12px] lg:text-sm mb-[18px] mt-[18px] ">
									<span class="text-center text-white text-[12px] lg:text-sm font-bold leading-tight">Отправить</span>
								</button>
								<label class=cursor-pointer">
												<span class="flex gap-2 items-center">
												<input type="checkbox" class="checkbox-input hidden" checked />
												<span class="checkbox-box w-[16px] h-[16px]  border border-[#373F41] rounded-sm flex items-center justify-center bg-transparent"">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
														<path d="M4.37891 9.31366L6.44772 11.3825L11.6197 6.21045" stroke="#52A6B2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
												</span>
									<span class="text-[9px] leading-[12px]">Соглашаюсь на обработку <a target="_blank" class="link-underline" href="<?php echo esc_url(get_permalink(3)); ?>">персональных данных</a></span>
								</label>
							</form>
						</div>
					</div>

			</div>


		</article><!-- #post-<?php the_ID(); ?> -->






	</main>
</section>

<?php get_footer(); ?>
