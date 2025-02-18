<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the `#content` element and all content thereafter.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _tw
 */

?>

	<?php get_template_part( 'template-parts/layout/footer', 'content' ); ?>
	<button id="scrollToTop" class="fixed bottom-[23px] sm:bottom-16 right-[16px] sm:right-12 hidden p-2 transition-opacity duration-300 opacity-0 hover:opacity-100">
	<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
		<circle cx="20" cy="20" r="20" fill="#D6BD7F"/>
		<path d="M12.416 17.8333L19.9993 10.25M19.9993 10.25L27.5827 17.8333M19.9993 10.25V29.75" stroke="white" stroke-width="2.67" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>

    </button>

<?php wp_footer(); ?>

</body>
</html>
