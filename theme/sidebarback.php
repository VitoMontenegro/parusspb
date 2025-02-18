<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootscore
 *
 * @version 5.2.0.0-beta1
 */


/*$current_category = get_queried_object();
if ($current_category && $current_category->taxonomy === 'excursion_category') {
	$parent_id = $current_category->term_id;

	// Получаем дочерние категории
	$child_categories = get_child_categories($parent_id, 'excursion_category');

	// Пример обработки полученных дочерних категорий
	foreach ($child_categories as $child) {
		echo '<a href="' . esc_url($child['link']) . '">' . esc_html($child['name']) . '</a><br>';
	}
}

display_nested_categories('excursion_category');*/
/*******************************************************/

$current_category = get_queried_object(); // Текущая категория
if ($current_category && isset($current_category->term_id)) {
	// Получаем самого верхнего родителя
	$top_parent = get_top_parent_category($current_category->term_id, 'excursion_category');
	if ($top_parent) {
		// Получаем все категории, у которых родительский ID равен ID верхнего родителя
		/*
			$sibling_categories = get_sibling_categories($top_parent->term_id, 'excursion_category');

			if (!empty($sibling_categories)) : ?>
				<ul class="categories">
					<?php foreach ($sibling_categories as $category) : ?>
						<li>
							<a href="<?php echo esc_url($category['link']); ?>">
								<?php echo esc_html($category['name']); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif;
		*/
		$categories_tree = get_nested_categories_by_parent($top_parent->term_id, 'excursion_category');
		if (!empty($categories_tree)) : ?>
			<ul>
				<?php foreach ($categories_tree as $category) : ?>
					<li>
						<a href="<?php echo esc_url($category['link']); ?>">
							<?php echo esc_html($category['name']); ?>
						</a>
						<?php if (!empty($category['children'])) : ?>
							<?php echo render_nested_categories($category['children']); ?>
						<?php endif; ?>
					</li>

				<?php endforeach; ?>
			</ul>
		<?php endif;


	}
}

