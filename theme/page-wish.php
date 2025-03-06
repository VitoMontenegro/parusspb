<?php
/**
 * Template Name: Страница Избранное
 */

$productCookie = $_COOKIE["product"];
$productCookie = stripslashes($productCookie);
$decodedProducts = json_decode($productCookie, true);

$sub = array(".01." => " января ", ".02." => " февраля ",
		".03." => " марта ", ".04." => " апреля ", ".05." => " мая ", ".06." => " июня ",
		".07." => " июля ", ".08." => " августа ", ".09." => " сентября ",
		".10." => " октября ", ".11." => " ноября ", ".12." => " декабря ", "2022" => '2022', '2023' => '2023', '2024'=>'2024', '2025'=>'2025','2026'=>'2026','00:00'=>'');

$search_query = get_search_query();
$current_category = get_term_by('slug', 'ekskursii-peterburg','excursion');
$category_id = $current_category->term_id;
set_query_var('sidebar_term', $current_category);
get_header();
?>

<section class="primary content--reviews">
	<main id="main">
		<div class="mt-2 sm:mt-4"></div>
		<div class="container">
			<div class="flex-col justify-start items-start gap-[18px] inline-flex">
				<h1 class="sm:text-[38px] font-bold"><?php the_title();?></h1>
			</div>
		</div>

		<div class="container mt-8 pb-8 border-b-[2px] border-[#D6BD7F]">

			<div class="flex gap-8">


				<section class="product-cards w-full" id="card_link">

					<div class="flex flex-col">
						<div class="flex flex-col relative">
							<?php
							my_custom_template($decodedProducts, 'template-parts/content/wish-loop-excursion');
							?>
						</div>
					</div>
				</section>
			</div>
		</div>

		<div class="bg-white pb-10 lg:pb-14">

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
									<div class="swiper-slide rounded-[6px] shadows_custom p-6 text-[14px] sm:text-[16px]" itemprop="review" itemscope itemtype="https://schema.org/Review">
										<div class="text-[14px]"><?php the_title() ?>, </div>
										<div class="text-[14px] text-[#6B7280] mb-3" itemprop="datePublished">
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
<?php get_footer(); // подключаем footer.php ?>

