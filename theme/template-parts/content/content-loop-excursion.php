<?php
$category_id = get_query_var('custom_id', false);
$count = 0;
$get_params = custom_get_params();
$duration = (!empty($get_params["duration"])) ? $get_params["duration"] : null;
$price_ranges = (!empty($get_params["price"])) ? $get_params["price"] : null;

if (isset($category_id)) {


	// Получаем все дочерние категории для таксономии excursion
	$child_categories = get_terms([
		'taxonomy' => 'excursion',
		'child_of' => $category_id, // ID родительской категории
		'fields' => 'ids', // Получаем только ID категорий
		'hide_empty' => true, // Показывать только категории с постами
	]);

	// Добавляем родительскую категорию к списку
	$categories = array_merge([$category_id], $child_categories);

	// Настройка WP_Query
	$query = new WP_Query([
		'post_type' => 'tours', // Замените на ваш тип записей, если это не стандартный
		'posts_per_page' => -1, // Показывать все посты (или укажите ограничение)
		'post_status' => array('publish'), // Получаем и опубликованные, и личные записи
		'tax_query' => [
			[
				'taxonomy' => 'excursion',
				'field' => 'term_id',
				'terms' => $categories,
				'include_children' => false, // Дочерние категории уже включены вручную
			],
		],
	]);

	// Проверяем, есть ли посты
	$posts = [];
	if ($query->have_posts()) : ?>
		<div class="filter">
			<!-- Форма с полем для выбора даты -->
			<div id="response" class="mb-8">
				<div class="grid grid-col-12 xs:grid-cols-12 gap-3 sm:gap-6 w-full mt-1 lg:mt-4 content__tours" id="tours">
					<?php
					while ($query->have_posts()) {
						$query->the_post();
						$fields = get_fields(get_the_ID());
						$returnDuration = true;
						$returnPrice = true;
						$returnGrade = true;

						$json_decode = json_decode(get_post_meta(get_the_ID(), 'tickets', 1));
						$sopr = isset($fields['id_crm_eks']) ?? null;
						//$sopr = (isset($fields['id_crm_eks']) && !empty($fields['id_crm_eks']) ) ? $fields['id_crm_eks'] : '' ;
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

					foreach ($posts as $postData) {
						$fields = $postData['fields'];
						$post = $postData['post'];
						$datesArray = $postData['datesArray'];
						$uniqueArray = $postData['uniqueArray'];
						setup_postdata($post);

						$link = get_permalink($post->ID);



						if(isset($fields['id_crm_eks']) && !empty($fields['id_crm_eks'])) {
							$sopr = $fields['id_crm_eks'];
							if($sopr){
								$df = $fields['date_from_dup'];
								$dt = $fields['date_till_dup'];


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
											$post = $posts[0]; // перепишем глоб. `$post`
											setup_postdata($posts[0]);
										}
									}
								}
							}
							$fields = get_fields($post->ID);
						}


						?>
						<!-- Фильтруемый контент -->
						<div itemscope itemtype="https://schema.org/Product" class="card flex flex-col col-span-12 md:col-span-6 bg-white rounded-2xl shadows_custom pb-6 relative" data-cost="<?php echo get_cost($fields)['cost_sale'] ?? get_cost($fields)['cost']; ?>" data-popular="<?php echo ++$count;?>">
							<div class="relative mb-5">
								<a href="<?php echo $link; ?>">
									<?php if(isset($fields["galery"]) && !empty($fields["galery"])): ?>
										<?php $image = $fields["galery"][0]["url"]; ?>
										<img itemprop="image" class="w-full h-[235px] object-cover rounded-t-2xl" src="<?php echo $image; ?>" alt="<?php echo get_the_title($post->ID); ?>" loading="lazy">
									<?php else : ?>
										<img itemprop="image" class="w-full h-[240px] object-cover rounded-lg bg-gray-300" src="<?php echo get_stylesheet_directory_uri(); ?>/img/woocommerce-placeholder.webp" alt="No image available">
									<?php endif; ?>
								</a>

								<?php if (isset($fields['duration']) && $fields['duration']) : ?>
									<div class="absolute left-4 sm:left-6 bottom-[18px] flex gap-1 items-center bg-[#FFFFFF] rounded-[6px] h-[28px] px-2">
										<span class="w-6 h-6 rounded-full bg-white flex items-center justify-center">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/clock.svg" alt="" class="object-cover">
										</span>
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


								<button class="absolute right-4 sm:right-[18px] top-[10px] sm:top-[18px]  wish-btn w-12 h-12 flex items-center justify-center group" data-wp-id="<?php echo $post->ID; ?>" aria-label="Добавить в избранное">
									<span class="w-9 h-9 rounded-full bg-white flex items-center justify-center">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart.svg" alt="" class="object-cover block group-[:hover]:hidden group-[.active]:hidden">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart-hover.svg" alt="" class="object-cover hidden group-[:hover]:block group-[.active]:hidden">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart-active.svg" alt="" class="object-cover hidden group-[.active]:block">
									</span>
								</button>
								<?php if (isset($fields['video_after_gates']) && !empty($fields['video_after_gates'])): ?>
									<button class="absolute right-[65px] top-[10px]  w-12 h-12 flex items-center justify-center group" aria-label="Смотреть видео">
										<span class="w-6 h-6 rounded-full bg-white flex items-center justify-center">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/play.svg" alt="" class="object-cover">
										</span>
									</button>
								<?php endif ?>
							</div>
							<div class="px-4 sm:px-6 flex flex-col gap-5 h-full">
								<div class="flex flex-col gap-1 flex-grow min-h-[96px]">
									<a href="<?php echo $link ?>" class="card-title text-[18px] lg:text-[20px] font-bold leading-[1.2] three-lines">
										<span itemprop="name"><?php echo get_the_title($post->ID); ?></span>
									</a>
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
												<div class="dropdown-menu absolute right-0 z-10 mt-2  w-[310px] origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none hidden left-0 mx-auto">

													<div class="item_alter">
														<div class="p-4 calendar-wrapper" data-dates='<?php echo json_encode($datesArray) ;?>'>
															<div class="flex justify-end relative -t-[2px]">
																<button class="close-menu_old "  aria-expanded="true" aria-haspopup="true" data-close-on-click="true">
																	<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
																		<path d="M12 20L16 16M16 16L19.6667 12.3333M16 16L12 12M16 16L20 20M29 16C29 23.1797 23.1797 29 16 29C8.8203 29 3 23.1797 3 16C3 8.8203 8.8203 3 16 3C23.1797 3 29 8.8203 29 16Z" stroke="#9CA3AF" stroke-width="2.67" stroke-linecap="round" stroke-linejoin="round"/>
																	</svg>
																</button>
															</div>
															<div class="calendar pointer-events-none"></div>
															<a href="<?php echo $link ?>" class="px-2 h-11 text-[14px] rounded-md bg-[#D6BD7F] flex items-center justify-center text-white">
															Перейти в экскурсию
															</a>
														</div>
													</div>
												</div>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="flex items-center justify-between" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
									<meta itemprop="priceCurrency" content="RUB" />
									<div class="price flex flex-col gap-1 text-[#111827]">
										<?php if (get_cost($fields)['cost_sale']) : ?>
											<div class="old_price line-through">
												от <span><?php echo get_cost($fields)['cost']; ?></span> ₽/чел.
											</div>
											<div class="price text-[20px] font-bold">
												от <span itemprop="price"><?php echo get_cost($fields)['cost_sale']; ?></span> ₽/чел.
											</div>
										<?php else: ?>
											<div class="price text-[20px] font-bold">
												от <span itemprop="price"><?php echo get_cost($fields)['cost']; ?></span> ₽/чел.
											</div>
										<?php endif ?>
									</div>
									<a href="<?php echo $link; ?>" class="inline-flex h-11 items-center justify-center font-medium px-7 sm:px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px]">Подробнее</a>
								</div>
							</div>
						</div>
						<?php
					}

					if ($count === 0) {
						echo '<div class="col-span-12 pb-8"> <div class="bold text-lg pb-8 w-full">Попробуйте другие варианты фильтра. По заданным вами параметрам мы не нашли экскурсии. </div><button type="button" class="close-filter-btn button-cancel h-10 w-full max-w-[160px] flex items-center justify-center bg-[#52A6B2] text-white rounded-[6px] hover:bg-[#44909B]" id="cancelBtnFilter">Сбросить фильтры</button></div>';
					}
					?>
				</div>
			</div>
		</div>
	<?php else : ?>
		<p>Нет записей для выбранной категории.</p>
	<?php endif; wp_reset_postdata();

}
?>
