<?php
/**
 * Страница с кастомным шаблоном (page-custom.php)
 * @package WordPress
 * Template Name: Гиды
 */


$options = get_fields( 'option');
$fields = get_fields();
get_header();
?>
<section class="primary content--reviews">
	<main id="main">
		<?php get_template_part( 'template-parts/layout/breadcrumbs', 'content' ); ?>



		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="container">
                <div class="overflow-x-hidden">
                    <div class="entry-content">
                        <h1 class="mt-0 text-2xl sm:text-[32px] font-bold tracking-tight mb-[22px] sm:mb-6"><?php the_title() ; ?></h1>
                        <?php

                            $excurs_arr = []; // массив экскурсий [id]=>title

                            $args = ['post_type' => 'gid',
                                    'posts_per_page' => -1
                            ];
                            $query = new WP_Query( $args );
                        ?>
                        <?php if ($query->have_posts()) : ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-[62px]">
                                <?php while ($query->have_posts()) : $query->the_post(); $fields = get_fields(); ?>
                                    <div class="p-6 rounded-[14px] shadows_custom flex gap-6 flex-col">
                                        <div class="flex flex-col sm:flex-row gap-6">
                                            <div class="grow shrink basis-0">
                                                <img src="<?php echo $fields['img'] ?>" alt="<?php the_title() ?>" class="rounded-[6px] h-full object-cover">
                                            </div>
                                            <div class="grow shrink basis-0">
                                                <div class="mb-1.5 font-semibold leading-[20px]"><?php the_title() ?></div>
                                                <div class="mb-[16px] text-[14px] text-[#6B7280]">Опыт работы: <?php echo $fields['experience'] ?></div>
                                                <div class="p-[10px] rounded-[14px] text-[#6B7280] text-[14px] bg-[#EFEDE7]"><?php echo $fields['accreditation'] ?></div>
                                            </div>
                                        </div>
                                        <div class="text-[14px]"><?php echo $fields['Info'] ?></div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; wp_reset_postdata(); ?>
                    </div>
                </div>
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->






	</main>
</section>

<?php get_footer(); ?>
