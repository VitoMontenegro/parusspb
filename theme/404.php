<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _tw
 */

get_header();
?>

	<section class="primary content--reviews">
		<main id="main">
			<div class="mt-2 sm:mt-4"></div>

			<div class="container mb-[100px] mb-8">
				<div class="flex justify-center items-center flex-col mb-3">
					<h1 class="page-title mt-8 mb-4">Ошибка 404</h1>

					<p>Вы ищете страницу, которой не существует.</p>
				</div>
				<a class="text-[#52A6B2]" href="/">← Перейти на главную страницу сайта</a>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
