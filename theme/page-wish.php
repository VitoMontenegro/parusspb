<?php
/**
 * Template Name: Страница Избранное
 */

get_header();
?>

<section class="content content--bus content--wishlist">
	<div class="container mx-auto">
		<h1><?php the_title();?></h1>


			<?php if($_COOKIE["product"]) : ?>
				<?php
				$productCookie = $_COOKIE["product"];
				$productCookie = stripslashes($productCookie);
				$decodedProducts = json_decode($productCookie, true);
				?>

				<?php if (!empty($decodedProducts)) : ?>
					<?php
					$query = new WP_Query([
							'post_type' => 'tours', // Замените на ваш тип записей, если это не стандартный
							'posts_per_page' => -1, // Показывать все посты (или укажите ограничение)
							'post__in' => $decodedProducts,
					]);

					// Проверяем, есть ли посты
					if ($query->have_posts()) : ?>
						<div class="filter">
							<!-- Форма с полем для выбора даты -->
							<form id="filter-form" class="flex gap-8 mb-8">
								<input type="hidden" id="category_id" value="<?php echo $category_id; ?>" />
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
							<div id="response" class="mb-8">
								<div class="content__tours grid gap-6 ms:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="tours">
									<?php while ($query->have_posts()) :
										$query->the_post();
										$fields = get_fields();
										$cost = $fields['neva_fullprice_custom'] ?? '';
										if (!empty($fields['duration'])) {
											$duration_no_let = preg_replace("/[^,.:0-9]/", '', correctTime($fields['duration']));
											$duration_clear = str_replace(',','.',$duration_no_let);
										}

										$cost = null;
										$cost_sale = null;

										if (isset($fields['p_doshkolniki']) && $fields['p_doshkolniki']) {
											$cost = $fields['p_doshkolniki'];
										}

										if (isset($fields['p_doshkolnik_sale']) && $fields['p_doshkolnik_sale']) {
											$cost_sale = $fields['p_doshkolnik_sale'];
										}

										if (isset($fields['p_shkolniki']) && $fields['p_shkolniki']) {
											$cost = $fields['p_shkolniki'];
										}

										if (isset($fields['p_shkolniki_sale']) && $fields['p_shkolniki_sale']) {
											$cost_sale = $fields['p_shkolniki_sale'];
										}

										if (isset($fields['p_vzroslie']) && $fields['p_vzroslie']) {
											$cost = $fields['p_vzroslie'];
										}

										if (isset($fields['p_vzroslie_sale']) && $fields['p_vzroslie_sale']) {
											$cost_sale = $fields['p_vzroslie_sale'];
										}

										?>
										<!-- Фильтруемый контент -->
										<div class="card item basis-0 grow" data-duration="<?php echo $duration_clear; ?>" data-cost="<?php echo $cost_sale ?? $cost; ?>" data-popular="<?php echo ++$count;?>">
											<div class="shadow-[4px_4px_20px_#0000001a] group overflow-hidden rounded-[10px] bg-white">
												<div class="overflow-hidden mb-5 min-h-[300px]">
													<div class="relative">
														<a href="<?php echo get_permalink(); ?>">
															<?php if ( has_post_thumbnail() ) : ?>
																<img class="w-full h-[240px] object-cover rounded-lg" src="<?php  the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
															<?php else : ?>
																<img class="w-full h-[240px] object-cover rounded-lg bg-gray-300" src="<?php echo get_stylesheet_directory_uri(); ?>/img/woocommerce-placeholder.webp" alt="No image available">
															<?php endif; ?>

														</a>
														<button class="wish-btn absolute top-4 left-4 w-[35px] h-[35px] flex justify-center items-center rounded-full bg-white group" data-wp-id="<?php echo $post->ID; ?>">
															<div class="icon">
																<svg class="w-6 h-6 fill-current text-[#A5A5A5] group-[.active]:text-red-600">
																	<path class="icon-path" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
																</svg>
															</div>
														</button>
														<?php if (isset($fields['video_after_gates']) && !empty($fields['video_after_gates'])): ?>
															<span class="absolute bottom-1 left-0 w-[76px] h-[60px] p-[20px] flex justify-center" data-ll-status="observed">
												<svg height="100%" version="1.1" viewBox="0 0 68 48" width="35" ><path class="" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path>
												</svg>
											</span>
														<?php endif ?>
													</div>
													<div class="p-4">
														<a href="<?php echo get_permalink(); ?>">
															<h2 class="text-xl font-semibold text-gray-800 mb-2 text-center filter"><?php echo get_the_title();	?></h2>
														</a>
														<div class="h-[60px] text-[14px] leading-[20px] relative overflow-hidden custom-blur mb-4">
															<?php echo wp_trim_words(get_the_content(), 20) ?>
														</div>

														<div class="flex flex-col gap-1 mb-4  h-[125px]">
															<?php if (isset($fields['periodicity']) && $fields['periodicity']) : ?>
																<span class="flex items-center gap-2">
													<svg xmlns="http://www.w3.org/2000/svg" class="min-w-[18px]" width="18" height="18" viewBox="0 0 18 18" fill="none">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M13.8857 2.05714H9.77143V0.771429C9.77143 0.34538 9.42605 0 9 0C8.57395 0 8.22857 0.34538 8.22857 0.771429V2.05714H4.11429V0.771429C4.11429 0.34538 3.76891 0 3.34286 0C2.91681 0 2.57143 0.34538 2.57143 0.771429V2.06867C1.12976 2.19859 0 3.41022 0 4.88571V6.68571V8.22857V15.1714C0 16.7336 1.26639 18 2.82857 18H15.1714C16.7336 18 18 16.7336 18 15.1714V8.22857V6.68571V4.88571C18 3.41022 16.8702 2.19859 15.4286 2.06867V0.771429C15.4286 0.34538 15.0832 0 14.6571 0C14.2311 0 13.8857 0.34538 13.8857 0.771429V2.05714ZM3.34286 3.6L2.82857 3.6C2.11849 3.6 1.54286 4.17563 1.54286 4.88571V6.68571H16.4571V4.88571C16.4571 4.17563 15.8815 3.6 15.1714 3.6L14.6571 3.6H9H3.34286ZM1.54286 15.1714V8.22857H16.4571V15.1714C16.4571 15.8815 15.8815 16.4571 15.1714 16.4571H2.82857C2.11849 16.4571 1.54286 15.8815 1.54286 15.1714Z" fill="#2C84D1"/>
													</svg>
													<?php echo $fields['periodicity']; ?>
												</span>
															<?php endif ?>

															<?php if (isset($fields['start_time']) && $fields['start_time']) : ?>
																<span class="flex items-center gap-2">
													<svg xmlns="http://www.w3.org/2000/svg" class="min-w-[18px]" width="18" height="18" viewBox="0 0 18 18" fill="none">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M9 18C13.9706 18 18 13.9706 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18ZM9 16.6154C4.79414 16.6154 1.38462 13.2059 1.38462 9C1.38462 4.79414 4.79414 1.38462 9 1.38462C13.2059 1.38462 16.6154 4.79414 16.6154 9C16.6154 13.2059 13.2059 16.6154 9 16.6154ZM9 4.43143C9.38235 4.43143 9.69231 4.74139 9.69231 5.12374V9.63631L11.9407 11.8847C12.2111 12.1551 12.2111 12.5934 11.9407 12.8638C11.6703 13.1341 11.232 13.1341 10.9616 12.8638L8.51046 10.4126C8.38063 10.2828 8.30769 10.1067 8.30769 9.92308V5.12374C8.30769 4.74139 8.61765 4.43143 9 4.43143Z" fill="#2C84D1"/>
													</svg>
													<?php echo $fields['start_time']; ?>
												</span>
															<?php endif ?>

															<?php if (isset($fields['duration']) && $fields['duration']) : ?>
																<span class="flex items-center gap-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M9.3041 17C14.1067 17 18 13.1944 18 8.5C18 3.80558 14.1067 0 9.3041 0C4.5015 0 0.608227 3.80558 0.608227 8.5C0.608227 10.5534 1.35819 12.4881 2.67467 14.0016H0.668914C0.299483 14.0016 1.1134e-08 14.2944 0 14.6555C-1.11359e-08 15.0166 0.299483 15.3093 0.668913 15.3093L4.45286 15.3093C4.82229 15.3093 5.12177 15.0166 5.12177 14.6555V10.9567C5.12177 10.5956 4.82229 10.3029 4.45286 10.3029C4.08343 10.3029 3.78395 10.5956 3.78395 10.9567V13.2562C2.61413 11.9609 1.94605 10.2842 1.94605 8.5C1.94605 4.5278 5.24037 1.30769 9.3041 1.30769C13.3678 1.30769 16.6622 4.5278 16.6622 8.5C16.6622 12.4722 13.3678 15.6923 9.3041 15.6923C8.93467 15.6923 8.63519 15.985 8.63519 16.3462C8.63519 16.7073 8.93467 17 9.3041 17ZM9.30415 4.18521C9.67358 4.18521 9.97306 4.47794 9.97306 4.83905V9.10093L12.1455 11.2244C12.4067 11.4797 12.4067 11.8937 12.1455 12.1491C11.8842 12.4044 11.4607 12.4044 11.1995 12.1491L8.83115 9.8341C8.70571 9.71148 8.63523 9.54517 8.63523 9.37176V4.83905C8.63523 4.47794 8.93472 4.18521 9.30415 4.18521Z" fill="#2C84D1"/>
													</svg>
													<?php echo $fields['duration']; ?>  часов
												</span>
															<?php endif ?>
															<?php if (isset($fields['departure_address']) && $fields['departure_address']) : ?>
																<span class="flex items-center gap-2">
													<svg xmlns="http://www.w3.org/2000/svg" class="min-w-[18px]" width="14" height="18" viewBox="0 0 14 18" fill="none">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M7.00001 1.51868C3.99313 1.51868 1.55557 3.89539 1.55557 6.83401C1.55557 8.98292 2.53635 11.0711 3.75124 12.81C4.93113 14.5109 6.28446 15.8169 7.00001 16.4548C7.71557 15.8169 9.0689 14.5109 10.2488 12.81C11.4637 11.0711 12.4445 8.98292 12.4445 6.83401C12.4445 3.89539 10.0069 1.51868 7.00001 1.51868ZM0 6.834C0 3.06011 3.13367 0 7 0C10.8663 0 14 3.06011 14 6.834C14 9.41574 12.8326 11.8 11.536 13.668C10.2324 15.536 8.74689 16.9559 7.99556 17.6241C7.427 18.1253 6.573 18.1253 6.00445 17.6241C5.25311 16.9559 3.76756 15.536 2.464 13.668C1.16744 11.8 0 9.41574 0 6.834ZM6.99999 5.31531C6.14132 5.31531 5.44443 5.99871 5.44443 6.83397C5.44443 7.66924 6.14132 8.35264 6.99999 8.35264C7.85865 8.35264 8.55554 7.66924 8.55554 6.83397C8.55554 5.99871 7.85865 5.31531 6.99999 5.31531ZM3.88886 6.83403C3.88886 5.1559 5.28186 3.79669 6.99997 3.79669C8.71808 3.79669 10.1111 5.1559 10.1111 6.83403C10.1111 8.51215 8.71808 9.87136 6.99997 9.87136C5.28186 9.87136 3.88886 8.51215 3.88886 6.83403Z" fill="#2C84D1"/>
													</svg>
													<?php echo $fields['departure_address']; ?></span>
															<?php endif ?>
														</div>

														<div class="tour__cost">
															Стоимость:
															<span>
												<span class="font-semibold text-[#08c] text-[21px]">от</span>
												<span id="min_cost">
													<span class="text-[#f24941] font-semibold text-[21px] mr-[5px] line-through"><?php echo  $cost; ?></span>
													<span class="text-[#08c] text-[21px]"><?php echo $cost_sale; ?></span>  руб/чел</span>
											</span>
														</div>

													</div>
												</div>
											</div>



										</div>
									<?php endwhile; ?>
								</div>
							</div>
						</div>
					<?php else : ?>
						<p>no wishes</p>
					<?php endif; wp_reset_postdata(); ?>

				<?php endif; ?>
			<?php endif; ?>

	</div>
</section>
<?php get_footer(); // подключаем footer.php ?>

