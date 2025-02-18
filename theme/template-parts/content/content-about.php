<?php
/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */
$options = get_fields( 'option');
$fields = get_fields();
$sub = array(".01." => " января ", ".02." => " февраля ",
		".03." => " марта ", ".04." => " апреля ", ".05." => " мая ", ".06." => " июня ",
		".07." => " июля ", ".08." => " августа ", ".09." => " сентября ",
		".10." => " октября ", ".11." => " ноября ", ".12." => " декабря ", "2022" => '2022', '2023' => '2023', '2024'=>'2024', '2025'=>'2025','2026'=>'2026','00:00'=>'');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<div class="overflow-x-hidden">
			<div class="entry-content">
				<h1 class="text-[20px] sm:text-[32px]"><?php the_title() ; ?></h1>
				<div class="content w-full">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
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
		<div class="pt-3 pb-[30px] sm:pb-[64px]">
			<div class="container">
				<h2 class="mb-6 mt-0">Нам доверяют</h2>
				<div class="buttons relative flex justify-end gap-2 items-center">
					<div class="rev-button-prev w-[61px] h-[61px] p-0"></div>
					<div class="rev-button-next w-[61px] h-[61px] p-0"></div>
				</div>
				<div class="swiper_rev overflow-hidden px-[2px] pt-[2px] mb-8">
					<div class="swiper-wrapper flex h-auto py-[10px]">
						<?php while ( $query->have_posts() ) : $query->the_post(); $fieldsRev = get_fields(get_the_ID());?>

							<div class="swiper-slide rounded-[6px] bg-neutral-50  shadows_custom p-6 text-[14px] sm:text-[16px]">
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
											<span><?php echo get_the_title($fieldsRev['excursion_obj']);  ?></span>
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
	<div class="container">
		<div class="self-stretch justify-start items-start gap-8 inline-flex mb-12">
			<div class="grow shrink basis-0 text-gray-500 text-base font-normal font-['Inter']">Реквизиты:<br/><?php echo $options['info'];  ?></div>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->


