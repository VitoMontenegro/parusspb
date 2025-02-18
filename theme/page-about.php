<?php
/**
 * Template Name: Страница О нас
 */

get_header();
?>

	<section class="primary">
		<main id="main">
		<?php get_template_part( 'template-parts/layout/breadcrumbs', 'content' ); ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'about' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
