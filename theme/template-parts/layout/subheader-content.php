<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _bukvica
 */

?>

<?php
$menu_items = wp_get_nav_menu_items('main_menu');
$menu_tree = [];

// Проверяем, получили ли мы элементы меню
if ($menu_items) {
	foreach ($menu_items as $item) {
		if ($item->menu_item_parent == 0) {
			$menu_tree[$item->ID] = ['item' => $item, 'children' => []];
		} else {
			if (!isset($menu_tree[$item->menu_item_parent])) {
				$menu_tree[$item->menu_item_parent] = ['item' => null, 'children' => []];
			}
			$menu_tree[$item->menu_item_parent]['children'][] = $item;
		}
	}
}
?>


