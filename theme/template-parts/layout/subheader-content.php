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



<section>
	<div class="container mx-auto">
		<div class="flex justify-between items-center">
			<ul class="flex items-center gap-6  hidden md:flex tracking-[.2px]">
				<?php foreach ($menu_tree as $menu): ?>
					<?php if (!isset($menu['item']) || !$menu['item']) continue;
						$hasChildren = !empty($menu['children']);
					?>
					<li class="group relative pt-[14px] pb-[12px] md:items-start lg:items-center flex items-center lg:gap-2">
						<?php $munuUrl = (strpos($menu['item']->url, '/ekskursii-peterburg') !== false) ? esc_url( home_url()) : esc_url($menu['item']->url); ?>

						<a href="<?php echo $munuUrl; ?>" class="font-medium items-center max-w-none sm:max-v-[165px] lg:max-w-none  leading-[16px] sm:max-w-[145px] lg:max-w-none">
						<?php echo esc_html($menu['item']->title); ?>
						</a>
						<?php if ($hasChildren) : ?>

							<svg class="mt-0 sm:mt-[2px] min-w-[12px] " xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
								<g clip-path="url(#clip0_135_6833)">
									<path d="M1.5 3.75L6 8.25L10.5 3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
								</g>
								<defs>
									<clipPath>
										<rect width="12" height="12" fill="white" transform="translate(12) rotate(90)"></rect>
									</clipPath>
								</defs>
							</svg>
							<ul class="submenu absolute top-10 bg-[#FFFFFF] w-full px-2 py-4 z-10  flex-col gap-1 border hidden group-hover:flex rounded-md min-w-[125px] z-20 min-w-[150px]">

								<?php foreach($menu['children'] as $child): ?>
									<li>
										<a href="<?php echo esc_url($child->url); ?>" class="font-semibold py-1.5 rounded-md hover:bg-[#52A6b2]  hover:text-white block w-full px-2"><?php echo esc_html($child->title); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>

				<?php endforeach; ?>


			</ul>
		</div>
	</div>

</section>
