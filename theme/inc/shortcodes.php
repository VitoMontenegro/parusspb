<?php




//Шорткод %%duration%% - вывода минимальной цены категории в метатегах
function get_duration() {
	if (is_tax('excursion') || is_home() || is_front_page()) {

		if (is_front_page()) {
			$t = 'ekskursii-peterburg';
		} else {
			$t = get_queried_object()->slug;
		}
		$items = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'tours',
				'tax_query' => array(
					array(
						'taxonomy' => 'excursion',
						'field' => 'slug',
						'terms' => $t
					)
				)
			)
		);

		$items_prices = [];

		foreach ($items as $item) {
			$m = 0;
			$fields = get_fields($item->ID);

			if (!empty($fields['duration'])) {
				if (preg_match('/\d+([.,]\d+)?/', $fields['duration'], $matches)) {
					$m =  str_replace(',', '.', $matches[0]); // Заменяем запятую на точку
				}
			}

			$items_duration[] = $m;
		}

		$min_duration = !empty($items_duration) ? min($items_duration) : 'уточняйте';
		wp_reset_postdata();
		return $min_duration;


	} elseif(is_single()) {
		$post_type = get_post_type();
		if ($post_type === 'tours') {
			$fields = get_fields();

			if (!empty($fields['duration'])) {
				if (preg_match('/\d+([.,]\d+)?/', $fields['duration'], $matches)) {
					return str_replace(',', '.', $matches[0]); // Заменяем запятую на точку
				}
			}

			return 'уточняйте';
		}
	}

	return 'уточняйте';
}

//Шорткод %%maxduration%% - вывода минимальной цены категории в метатегах
function get_max_duration() {
	if (is_tax('excursion') || is_home() || is_front_page()) {

		if (is_front_page()) {
			$t = 'ekskursii-peterburg';
		} else {
			$t = get_queried_object()->slug;
		}
		$items = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'tours',
				'tax_query' => array(
					array(
						'taxonomy' => 'excursion',
						'field' => 'slug',
						'terms' => $t
					)
				)
			)
		);

		$items_duration = [];

		foreach ($items as $item) {
			$m = 0;
			$fields = get_fields($item->ID);

			if (!empty($fields['duration'])) {
				if (preg_match('/\d+([.,]\d+)?/', $fields['duration'], $matches)) {
					$m =  str_replace(',', '.', $matches[0]); // Заменяем запятую на точку
				}
			}

			$items_duration[] = $m;
		}

		$min_duration = !empty($items_duration) ? max($items_duration) : 'уточняйте';
		wp_reset_postdata();
		return $min_duration;


	} elseif(is_single()) {
		$post_type = get_post_type();
		if ($post_type === 'tours') {
			$fields = get_fields();

			if (!empty($fields['duration'])) {
				if (preg_match('/\d+([.,]\d+)?/', $fields['duration'], $matches)) {
					return str_replace(',', '.', $matches[0]); // Заменяем запятую на точку
				}
			}

			return 'уточняйте';
		}
	}

	return 'уточняйте';
}

//Шорткод %%price%% - вывода минимальной цены категории в метатегах
function min_price() {

	if (is_tax('excursion') || is_home() || is_front_page()) {

		if (is_front_page()) {
			$t = 'ekskursii-peterburg';
		} else {
			$t = get_queried_object()->slug;
		}
		$items = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'tours',
				'tax_query' => array(
					array(
						'taxonomy' => 'excursion',
						'field' => 'slug',
						'terms' => $t
					)
				)
			)
		);

		$items_prices = [];

		foreach ($items as $item) {
			$m = 0;
			$fields = get_fields($item->ID);

			$priority = [
				'p_deti_inostrancy', 'p_deti_inostrancy_sale',
				'p_studenty_inostrancy', 'p_studenty_inostrancy_sale',
				'p_vzroslie_inostrancy', 'p_vzroslie_inostrancy_sale',
				'p_pensionery', 'p_pensionery_sale',
				'p_vzroslie', 'p_vzroslie_sale',
				'p_studenty', 'p_studenty_sale',
				'p_shkolniki', 'p_shkolniki_sale',
				'p_doshkolniki', 'p_doshkolniki_sale'
			];

			foreach ($priority as $key) {
				if (!empty($fields[$key])) {
					$m =  $fields[$key]; // Нашли первое (самое старшее), сразу возвращаем
				}
			}
			$items_prices[] = $m;
		}

		$min_price = !empty($items_prices) ? min($items_prices) : 'по запросу';
		wp_reset_postdata();
		return $min_price;


	} elseif(is_single()) {
		$post_type = get_post_type();
		if ($post_type === 'tours') {
			$fields = get_fields();
			$priority = [
				'p_doshkolniki_sale', 'p_doshkolniki',
				'p_shkolniki_sale', 'p_shkolniki',
				'p_studenty_sale', 'p_studenty',
				'p_vzroslie_sale', 'p_vzroslie',
				'p_pensionery_sale', 'p_pensionery',
				'p_vzroslie_inostrancy_sale', 'p_vzroslie_inostrancy',
				'p_studenty_inostrancy_sale', 'p_studenty_inostrancy',
				'p_deti_inostrancy_sale', 'p_deti_inostrancy'
			];

			foreach ($priority as $key) {
				if (!empty($fields[$key])) {
					return $fields[$key]; // Нашли первое (самое старшее), сразу возвращаем
				}
			}

			return 'по запросу'; // Если ничего не найдено
		}
	}
	return 'по запросу';
}

//Шорткод %%year%% - вывода минимальной цены категории в метатегах
function get_year() {
	return date("Y");
}

// define the action for register yoast_variable replacments
function register_custom_yoast_variables() {
	wpseo_register_var_replacement( '%%duration%%', 'get_duration', 'advanced', ' ' );
	wpseo_register_var_replacement( '%%maxduration%%', 'get_max_duration', 'advanced', ' ' );
	wpseo_register_var_replacement( '%%price%%', 'min_price', 'advanced', ' ' );
	wpseo_register_var_replacement( '%%year%%', 'get_year', 'advanced', ' ' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables');
