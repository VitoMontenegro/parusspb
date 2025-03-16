<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once( ABSPATH . 'wp-admin/includes/file.php' );

define('TELEGRAM_BOT_TOKEN', '7674258017:AAH1wb9S4ARTuNc3w9TqpOzHfXFoyXmaUBc'); // Замените на свой токен
define('TELEGRAM_CHAT_ID', '300193513'); // Замените на свой chat_id

function custom_rest_filter_posts() {
	register_rest_route('my_namespace/v1', '/filter-posts/', [
		'methods' => 'GET',
		'callback' => 'handle_filter_posts_request',
		'permission_callback' => '__return_true',
	]);
	register_rest_route('custom/v1', '/reviews-form', [
			'methods' => 'POST',
			'callback' => 'handle_reviews_form',
			'permission_callback' => '__return_true',
	]);
	register_rest_route('custom/v1', '/tour_tickets', [
			'methods' => 'POST',
			'callback' => 'handle_tour_tickets',
			'permission_callback' => '__return_true',
	]);
	register_rest_route( 'custom/v1', '/search-excursions/', [
			'methods'  => 'GET',
			'callback' => 'custom_search_excursions',
			'permission_callback' => '__return_true',
	]);
}
add_action('rest_api_init', 'custom_rest_filter_posts');


function custom_search_excursions( $request ) {
	global $wpdb;

	$query_params = $request->get_params();
	$search_query = isset( $query_params['search'] ) ? sanitize_text_field( $query_params['search'] ) : '';

	if ( empty( $search_query ) ) {
		return new WP_REST_Response( [], 200 );
	}
	$search_str = [];

	$_s = explode(' ', $search_query);
	foreach($_s as $item){
		if (mb_strlen($item) > 4) {
			if(mb_substr($item,-1) == 'ь' || mb_strtolower($item) == 'валаам')
				$item = mb_substr($item,0,-1);
			else
				$item = mb_substr($item,0,-2);

		}
		$search_str[] = $item;
	}
	$s = implode(' ', $search_str);

	add_filter( 'posts_where', function( $where ) use ( $s, $wpdb ) {
		$where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like( $s ) . '%' );
		return $where;
	});

	$args = [
			'post_type'      => 'tours',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
	];

	$query = new WP_Query( $args );

	$results = [];
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$results[] = [
					'id'    => get_the_ID(),
					'title' => get_the_title(),
					'link'  => get_permalink(),
			];
		}
		wp_reset_postdata();
	}

	remove_filter( 'posts_where', 'custom_search_where' );

	return new WP_REST_Response( $results, 200 );
}


function handle_tour_tickets(WP_REST_Request $request){
	$id = $request->get_param('id');

	/*realtime tickets*/
	$real_tickets = $tour_id = [];
	$url = get_option( 'option_name', '' )['api_url'].'/trips?tour='.$id;
	$resp = unserialize(trim(file_get_contents ($url)));
	$sopr = check_sopr($id);

	if($sopr){
		$url2 = get_option( 'option_name', '' )['api_url'].'/trips?tour='.$sopr;
		$resp2 = unserialize(trim(file_get_contents ($url2)));
		$resp = array_merge($resp, $resp2);

	}

	foreach($resp as $k=>$item){
		$real_tickets[$item->id] = (int)$item->tickets-(int)$item->sold;
		$tour_id[$item->id] = $item->tour;
	}

	$posts = get_posts( array(
		'meta_key' => 'id_crm',
		'meta_value' => $id,
		'post_type' => 'tours',
		'suppress_filters' => true,
		'post_status' => 'any',
	) )[0];

	if(get_post_meta($posts->ID, 'on_address', 1) && get_post_meta($posts->ID, 'mins', 1)){
		$fix_times_for_addresses = [];
		$i = 1;
		$times_crm = get_post_meta($posts->ID, 'times_crm', 1);
		$mins = get_post_meta($posts->ID, 'mins', 1);

		/*foreach(explode(',',$times_crm) as $item){
			if($mins){
				$sign = get_post_meta($posts->ID, 'sign', 1);
				$a1_time = explode(':', get_post_meta($posts->ID, 'adress_1_'.$i, 1));

				if($sign == 'plus')
					$a2_time_utc = mktime($a1_time[0], $a1_time[1]+$mins, 0, 1, 1, 2000);
				else
					$a2_time_utc = mktime($a1_time[0], $a1_time[1]-$mins, 0, 1, 1, 2000);

				$fix_times_for_addresses[$item] = [
					'a1' => get_post_meta($posts->ID, 'adress_1_'.$i, 1),
					'a2' => date('H:i', $a2_time_utc)
				];
			} else {
				$fix_times_for_addresses[$item] = [
					'a1' => get_post_meta($posts->ID, 'adress_1_'.$i, 1),
					'a2' => get_post_meta($posts->ID, 'adress_2_'.$i, 1)
				];
			}
			$i++;
		}*/
	}
	$tickets = json_decode(get_post_meta($posts->ID, 'tickets', 1));
	if($sopr){
		$sopr_post = get_posts([
			'post_type' => 'tours',
			'numberposts' => -1,
			'meta_key' => 'id_crm',
			'meta_value' => $sopr,
			'post_status' => 'any'
		]);
		if($sopr_post && count($sopr_post)){
			if(!$tickets) $tickets = [];
			$tickets2 = json_decode(get_post_meta($sopr_post[0]->ID, 'tickets', 1));

			if(!$tickets2) $tickets2 = [];

			$tickets = array_merge($tickets, $tickets2);
		}
	}


	foreach($tickets as $k=>$item){
		if($real_tickets[$item->id]){
			$tickets[$k]->tickets = $real_tickets[$item->id];
			$tickets[$k]->tour_id = $tour_id[$item->id];
		} else {
			unset($tickets[$k]);
		}
	}


	foreach($tickets as $k=>$item){
		if (isset($item->added)) continue;
		$tmp_tickets = [];

		$tickets[$k]->date = strtotime($item->date);
		$dates[] = $tickets[$k]->date;
		$tickets[$k]->date = date('Y-m-d', $item->date);

		if(get_post_meta($posts->ID, 'on_address', 1) && get_post_meta($posts->ID, 'mins', 1)){
			$a1_time = explode(':', $item->time);
			$sign = get_post_meta($posts->ID, 'sign', 1);
			if($sign == 'plus')
				$a2_time_utc = mktime($a1_time[0], $a1_time[1]+$mins, 0, 1, 1, 2000);
			else
				$a2_time_utc = mktime($a1_time[0], $a1_time[1]-$mins, 0, 1, 1, 2000);

			$tickets[$k]->a1 = $item->time;
			$tickets[$k]->a2 = date('H:i', $a2_time_utc);
		}
	}

	$return = [
		'min_date' => date('Y-m-d', min($dates)),
		'max_date' => date('Y-m-d', max($dates)),
		'dates' => array_values($tickets)
	];

	echo json_encode($return);
	//var_dump($return);
	die();
}


function isDateInRange($datesArr, $datesFromTo) {
	// Нормализуем начало и конец диапазона из $datesFromTo
	$startDate = isset($datesFromTo[0]) ? trim($datesFromTo[0]) : null;
	$endDate = isset($datesFromTo[1]) ? trim($datesFromTo[1]) : null;

	// Если есть только одна дата, рассматриваем её как единственную границу
	if ($startDate && !$endDate) {
		$endDate = $startDate;
	} elseif (!$startDate && $endDate) {
		$startDate = $endDate;
	}

	// Преобразуем в объекты DateTime
	$startDate = new DateTime($startDate);
	$endDate = new DateTime($endDate);

	// Проверяем даты
	foreach ($datesArr as $date) {
		$currentDate = new DateTime(trim($date));

		// Если текущая дата в диапазоне, возвращаем true
		if ($currentDate >= $startDate && $currentDate <= $endDate) {
			return true;
		}
	}

	// Если ничего не найдено, возвращаем false
	return false;
}


function handle_filter_posts_request(WP_REST_Request $request) {

	$duration = $request->get_param('duration');
	$price_ranges = $request->get_param('price');
	//$grade = $request->get_param('grade');
	$grade_sorts = $request->get_param('grade_sort');
	$dateForm = $request->get_param('dateForm');
	$grade_sort = json_decode($grade_sorts);
	if($grade_sort) {
		if (is_array($grade_sort) && count($grade_sort) > 0) {
			$grade_sort = $grade_sort[0];
		}
	} else {
		$grade_sort = 'pops';
	}
	$category_id = $request->get_param('category_id');

	// Получаем дочерние категории
	$child_categories = get_terms([
			'taxonomy'    => 'excursion',
			'child_of'    => $category_id,
			'fields'      => 'ids',
			'hide_empty'  => true,
	]);
	$categories = array_merge([$category_id], $child_categories);
	// Инициализация основного массива для WP_Query
	$query_args = [
			'post_type'      => 'tours',
			'posts_per_page' => -1,
			'tax_query'      => [
					[
							'taxonomy'         => 'excursion',
							'field'            => 'term_id',
							'terms'            => $categories,
					],
			]
	];

	$query = new WP_Query($query_args);

	$posts = [];
	ob_start();
	if ($query->have_posts()) {
		$count = 0;
		while ($query->have_posts()) {
			$query->the_post();
			$fields = get_fields(get_the_ID());
			$returnDuration = true;
			$returnPrice = true;
			$returnGrade = true;

			$json_decode = json_decode(get_post_meta(get_the_ID(), 'tickets', 1));


			$sopr = isset($fields['id_crm_eks']) ?? null;
			if(!$json_decode && $sopr){
				$sopr_post = get_posts([
						'post_type' => 'tours',
						'post_status' => 'any',
						'meta_query' => [
								[
										'key' => 'id_crm',
										'value' => $sopr
								]
						]
				])[0];
				$json_decode = json_decode(get_post_meta($sopr_post->ID, 'tickets', 1));
			}
			$m = [
					'января',
					'февраля',
					'марта',
					'апреля',
					'мая',
					'июня',
					'июля',
					'августа',
					'сентября',
					'октября',
					'ноября',
					'декабря'
			];
			$uniqueArray = [];
			$datesArray = [];

			if(is_array($json_decode)) {
				foreach ($json_decode as $item) {
					$json_decode_start_date = explode('.', $item->date);
					$start_dates =  $json_decode_start_date[0]. ' ' .$m[(int)$json_decode_start_date[1] -1];
					$startDates =  $json_decode_start_date[2]. '-' .$json_decode_start_date[1] . '-' . $json_decode_start_date[0];
					if (!in_array($start_dates, $uniqueArray)) {
						$uniqueArray[] = $start_dates;
					}
					$datesArray[] = $startDates;
				}
			}

			// Обработка фильтра по duration
			if (!empty($duration)) {
				$duration_values = json_decode($duration);
				if(!empty($duration_values)) {
					$durationRange = convertTime($fields['duration']) ?? 0 ;
					$returnDuration = false;
					foreach ($duration_values as $duration_range) {
						if ($duration_range) {
							$explode = explode('-', $duration_range);
							if (($durationRange >= (int)$explode[0]) && ($durationRange <= (int)$explode[1])) {
								$returnDuration = true;
							}
						}
					}
				}
			}


			$returnDateForm =  true;
			if ($dateForm) {
				$dateForm_values = explode('—', $dateForm);
				$returnDateForm = ($datesArray) ? isDateInRange($datesArray, $dateForm_values) : true;
			}

			// Обработка фильтра по price_range
			if (!empty($price_ranges)) {
				$price_values = json_decode($price_ranges);
				if (!empty($price_values)) {
					$priceRange = get_cost($fields)['cost_sale'] ? get_cost($fields)['cost_sale'] : get_cost($fields)['cost'];
					$returnPrice = false;
					foreach ($price_values as $price_range) {
						if ($price_range) {
							list($min_price, $max_price) = explode('-', $price_range);
							$min_price = floatval($min_price);
							$max_price = floatval($max_price);
							if ((int)$priceRange >= (int)$min_price && (int)$priceRange <=  (int)$max_price) {
								$returnPrice = true;
							}
						}
					}
				}
			}

			//запрос
			if (!$returnPrice || !$returnDuration || !$returnGrade || !$returnDateForm) {
				continue;
			}


			// Обработка фильтра по price_range
			if (!empty($grade_sort)) {
				$gradeSort = get_cost($fields)['cost_sale'] ? get_cost($fields)['cost_sale'] : get_cost($fields)['cost'];
				$posts[] = [
						'post' => get_post(),
						'fields' => $fields,
						'datesArray' => $datesArray,
						'uniqueArray' => $uniqueArray,
						'gradeSort' => $gradeSort,
						'date' => get_the_date('Y-m-d H:i:s'), // Добавляем дату в формате строки
				];
			} else {
				$posts[] = [
						'post' => get_post(),
						'fields' => $fields,
						'datesArray' => $datesArray,
						'uniqueArray' => $uniqueArray,
						'gradeSort' => '',
						'date' => get_the_date('Y-m-d H:i:s'), // Добавляем дату в формате строки
				];
			}
		}
		if ($grade_sort === 'expensive') {
			usort($posts, function ($a, $b) {
				return $a['gradeSort'] >= $b['gradeSort'];
			});
		} elseif($grade_sort === 'chip') {
			usort($posts, function ($a, $b) {
				return $a['gradeSort'] <= $b['gradeSort'];
			});
		} else {
			usort($posts, function ($a, $b) {
				return strtotime($b['date']) <=> strtotime($a['date']);
			});
		}


		foreach ($posts as $postData) {
			$post = $postData['post'];
			$fields = $postData['fields'];
			$datesArray = $postData['datesArray'];
			$uniqueArray = $postData['uniqueArray'];
			setup_postdata($post);

			$link = get_permalink($post->ID);

			if(isset($fields['id_crm_eks']) && !empty($fields['id_crm_eks'])) {
				$sopr = $fields['id_crm_eks'];
				if($sopr){
					$df = $fields['date_from_dup'];
					$dt = $fields['date_till_dup'];


					if($df && $dt){
						$df = strtotime($df);
						$dt = strtotime($dt)+3600*24;
						$cur_time = time();

						if($cur_time>=$df && $cur_time<=$dt){
							$args = array(
								'post_type' => 'tours',
								'numberposts' => -1,
								'meta_key' => 'id_crm',
								'meta_value' => $sopr,
								'post_status' => array('publish', 'private') // Получаем и опубликованные, и личные записи
							);
							$posts = get_posts($args);

							if($posts && count($posts)){
								$post = $posts[0]; // перепишем глоб. `$post`
								setup_postdata($posts[0]);
							}
						}
					}
				}
				$fields = get_fields($post->ID);
			}

			?>
			<div class="card flex flex-col col-span-12 md:col-span-6 bg-white rounded-2xl shadows_custom pb-6 relative" data-cost="<?php echo get_cost($fields)['cost_sale'] ?? get_cost($fields)['cost']; ?>" data-popular="<?php echo ++$count;?>">
				<div class="relative mb-5">
					<a href="<?php echo $link ?>">
						<?php if(isset($fields["galery"]) && !empty($fields["galery"])): ?>
							<?php $image = $fields["galery"][0]["url"]; ?>
							<img class="w-full h-[235px] object-cover rounded-t-2xl" src="<?php echo $image; ?>" alt="<?php echo get_the_title($post->ID); ?>" loading="lazy">
						<?php else : ?>
							<img class="w-full h-[240px] object-cover rounded-lg bg-gray-300" src="<?php echo get_stylesheet_directory_uri(); ?>/img/woocommerce-placeholder.webp" alt="No image available">
						<?php endif; ?>
					</a>
					<?php if (isset($fields['duration']) && $fields['duration']) : ?>
						<div class="absolute left-4 sm:left-6 bottom-[18px] flex gap-1 items-center bg-[#FFFFFF] rounded-[6px] h-[28px] px-2">
							<span class="w-6 h-6 rounded-full bg-white flex items-center justify-center">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/clock.svg" alt="" class="object-cover">
							</span>
							<div class="text-[#6B7280] leading-0"><?php echo $fields['duration']; ?></div>
						</div>
					<?php endif ?>
					<?php if (isset($fields['sticker']) && $fields['sticker']) : ?>
						<?php
						$bg_stick = (isset($fields['sticker_background']) &&!empty($fields['sticker_background']) ) ? $fields['sticker_background'] : "#D45E5E";
						$bg_color = (isset($fields['sticker_text']) &&!empty($fields['sticker_text']) ) ? $fields['sticker_text'] : "#FFF";
						?>
						<div class="absolute left-4 sm:left-6 top-[18px] flex items-center rounded-[6px] h-[34px] px-4 text-white" style="background: <?php echo $bg_stick;?>;color:<?php echo $bg_color;?>">
							<div class="leading-0"><?php echo $fields['sticker'];?></div>
						</div>
					<?php endif ?>
					<button class="absolute right-4 sm:right-[18px] top-[10px] sm:top-[18px] wish-btn w-12 h-12 flex items-center justify-center group" data-wp-id="<?php echo $post->ID; ?>" aria-label="Добавить в избранное">
						<span class="w-9 h-9 rounded-full bg-white flex items-center justify-center">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart.svg" alt="" class="object-cover block group-[:hover]:hidden group-[.active]:hidden">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart-hover.svg" alt="" class="object-cover hidden group-[:hover]:block group-[.active]:hidden">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart-active.svg" alt="" class="object-cover hidden group-[.active]:block">
						</span>
					</button>
					<?php if (isset($fields['video_after_gates']) && !empty($fields['video_after_gates'])): ?>
						<button class="absolute right-[65px]  top-[10px] sm:top-[18px]  w-12 h-12 flex items-center justify-center group" aria-label="Смотреть видео">
							<span class="w-6 h-6 rounded-full bg-white flex items-center justify-center">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/play.svg" alt="" class="object-cover">
							</span>
						</button>
					<?php endif ?>
				</div>
				<div class="px-4 sm:px-6 flex flex-col gap-5 h-full">
					<div class="flex flex-col gap-1 flex-grow min-h-[96px]">
						<a href="<?php echo $link; ?>" class="card-title text-[18px] lg:text-[20px] font-bold leading-[1.2] three-lines"><?php echo get_the_title($post->ID); ?></a>
						<div class="date flex items-center gap-2 text-[14px] sm:text-[16px]">
							<?php if(count($uniqueArray)) : ?>
								<div class="flex items-center gap-[5px] text-[#6B7280]">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/calendar.svg" alt="" class="object-cover">
									<div class="">
										<span><?php echo $uniqueArray[0]; ?></span>
										<?php if(count($uniqueArray)>1) : ?>
											|
											<span><?php echo $uniqueArray[1]; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<?php if(count($uniqueArray)>2) : ?>
									<button aria-expanded="true" data-close-on-click="false" class="dropdown-button text-[#52A6B2]">Другие даты</button>
									<div class="dropdown-menu absolute right-0 z-10 mt-2  w-[310px] origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none hidden left-0 mx-auto">

										<div class="">
											<div class="p-4 calendar-wrapper" data-dates='<?php echo json_encode($datesArray) ;?>'>
												<div class="flex justify-end relative -t-[2px]">
													<button class="close-menu ">
														<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
															<path d="M12 20L16 16M16 16L19.6667 12.3333M16 16L12 12M16 16L20 20M29 16C29 23.1797 23.1797 29 16 29C8.8203 29 3 23.1797 3 16C3 8.8203 8.8203 3 16 3C23.1797 3 29 8.8203 29 16Z" stroke="#9CA3AF" stroke-width="2.67" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
													</button>
												</div>
												<div class="calendar pointer-events-none"></div>
												<a href="<?php echo $link;?>" class="px-2 h-11 text-[14px] rounded-md bg-[#D6BD7F] flex sm:hidden items-center justify-center text-white">
													Перейти в экскурсию
												</a>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="flex items-center justify-between">
						<div class="price flex flex-col gap-1">
							<?php if (get_cost($fields)['cost_sale']) : ?>
								<div class="old_price line-through">
									от <span><?php echo get_cost($fields)['cost']; ?></span> ₽/чел.
								</div>
								<div class="price text-[20px] font-bold">
									от <span><?php echo get_cost($fields)['cost_sale']; ?></span> ₽/чел.
								</div>
							<?php else: ?>
								<div class="price text-[20px] font-bold">
									от <span><?php echo get_cost($fields)['cost']; ?></span> ₽/чел.
								</div>
							<?php endif ?>
						</div>
						<a href="<?php echo $link; ?>" class="inline-flex h-11 items-center justify-center font-medium px-7 sm:px-10 rounded-md bg-[#52A6B2] hover:bg-[#44909B] text-white text-[14px] lg:text-[16px]">Подробнее</a>
					</div>
				</div>
			</div>
			<?php
		}


		if ($count === 0) {
			echo '<div class="col-span-12 pb-8"> <div class="bold text-lg pb-8 w-full">Попробуйте другие варианты фильтра. По заданным вами параметрам мы не нашли экскурсии. </div><button type="button" class="close-filter-btn button-cancel h-10 w-full max-w-[160px] flex items-center justify-center bg-[#52A6B2] text-white rounded-[6px] hover:bg-[#44909B]" id="cancelBtnFilter">Сбросить фильтры</button></div>';
		}
	} else {
		echo '<div class="col-span-12 pb-8"> <div class="bold text-lg pb-8 w-full">Попробуйте другие варианты фильтра. По заданным вами параметрам мы не нашли экскурсии. </div><button type="button" class="close-filter-btn button-cancel h-10 w-full max-w-[160px] flex items-center justify-center bg-[#52A6B2] text-white rounded-[6px] hover:bg-[#44909B]" id="cancelBtnFilter">Сбросить фильтры</button></div>';
	}
	$output = ob_get_clean();

	// Верните данные через REST API
	wp_send_json_success(['html' => $output]);
}
function enable_webp_uploads($mime_types) {
    $mime_types['webp'] = 'image/webp'; // Добавление WebP
    return $mime_types;
}
add_filter('upload_mimes', 'enable_webp_uploads');



function wp_telegram($text) {
	$url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage";
	$telegram_data = [
			'chat_id' => TELEGRAM_CHAT_ID,
			'text' => $text,
			'parse_mode' => 'HTML',
	];
	$options = [
			'http' => [
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query($telegram_data), // Передаем корректный массив
			],
	];
	$context = stream_context_create($options);
	return file_get_contents($url, false, $context);
}



function handle_reviews_form(WP_REST_Request $request) {
	$params = $request->get_params();
	$files = $_FILES['file'] ?? null;


	$recepient = 'testdev@kometatek.ru';
	$sitename = "groupspb.ru";
	$name = sanitize_text_field($params["name"]);
	$email = sanitize_email($params["email"]);
	$text = sanitize_textarea_field($params["message"]);
	$excurs = isset($params["excursObj"]) ? $params["excursObj"] : 0;
	$excursId = isset($params["excurs"]) ? $params["excurs"] : 0;
	$gid = isset($params["gid"]) ? sanitize_text_field($params["gid"]) : '';


/*	$message = "Дата: " . date('d/m/Y') . "<br/><br/>\r\n";
	$message .= "Имя: " .  $name . "<br/><br/>\r\n";
	$message .= "Экскурсия: " .  $excurs . "<br/><br/>";
	$message .= "Гид: " .  $gid . "<br/><br/>";
	$message .= "Email: " .  $email . "<br/><br/>";
	$message .= "Сообщение: " .  $text . "<br/><br/>";*/


	// Создание сообщения
	$message = "<b>Новый отзыв на сайте</b>". "\r\n";
	$message .= "<b>Дата:</b> " . esc_html(date('d/m/Y')) . "\r\n";
	$message .= "<b>Имя:</b> " . esc_html($name) . "\r\n";
	$message .= "<b>email:</b> " . esc_html($email) . "\r\n";
	$message .= "<b>Экскурсия:</b> " . esc_html($excurs) . "\r\n";
	$message .= "<b>Гид:</b> " . esc_html($gid) . "\r\n";
	$message .= "<b>Сообщение:</b> " . esc_html($text) . "\r\n";





	$pagetitle = "Новый отзыв с сайта \"$sitename\"";

	// Создание записи "Отзыв"
	$post_data = [
		'post_title'   => $name,
		'post_content' => $text,
		'post_status'  => 'pending',
		'post_author'  => 1,
		'post_type'    => 'reviews',
	];
	$post_id = wp_insert_post($post_data);

	// Обработка файлов
	if ($files) {
		$allowed_types = ['image/jpeg', 'image/png', 'image/webp']; // Разрешенные MIME-типы
		$allowed_ext = ['jpg', 'jpeg', 'png', 'webp']; // Разрешенные расширения
		$uploaded_files = array_map('RemapFilesArray',
			$files['name'],
			$files['type'],
			$files['tmp_name'],
			$files['error'],
			$files['size']
		);

		$gallery = [];

		foreach ($uploaded_files as $file) {
			if ($file["name"] && $file["type"] && $file["tmp_name"]) {
				$ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION)); // Получаем расширение файла

				// Проверяем MIME-типы и расширения
				if (in_array($file["type"], $allowed_types) && in_array($ext, $allowed_ext)) {
					$attachment = my_update_attachment($file, $post_id);
					if (isset($attachment['attach_id'])) {
						$gallery[] = $attachment['attach_id'];
					}
				}
			}
		}

		/* foreach ($uploaded_files as $file) {
			if($file["name"] && $file["type"] && $file["tmp_name"]) {
				$attachment = my_update_attachment($file, $post_id);
				if (isset($attachment['attach_id'])) {
					$gallery[] = $attachment['attach_id'];
				}
			}
		} */
		// Сохранение дополнительных полей (ACF или meta)
		update_field('field_5fad894783054', $gallery, $post_id); // Поле для галереи
	}

	// Сохранение дополнительных данных
	update_field('field_644b06e279cc3', $excursId, $post_id);
	update_field('field_5fad896583056', $gid, $post_id);
	update_field('field_612cc6d2ad914', $email, $post_id);
	update_field('field_5ea7e567e12c6',  date('Y-m-d'), $post_id);

	// Добавление ссылки на запись в сообщение
	$message .= "Ссылка на отзыв: ".site_url()."/wp-admin/post.php?post=$post_id&action=edit". "\r\n";


	wp_telegram($message);

	$content = "<b>Новый отзыв на сайте</b>". "<br/>";
	$content .= "<b>Дата:</b> " . esc_html(date('d/m/Y')) . "<br/>";
	$content .= "<b>Имя:</b> " . esc_html($name) . "<br/>";
	$content .= "<b>email:</b> " . esc_html($email) ."<br/>";
	$content .= "<b>Сообщение:</b> " . esc_html($text) ."<br/>";
	$content .= "<b>Экскурсия:</b> " . esc_html($excurs) ."<br/>";
	$content .= "<b>Гид:</b> " . esc_html($gid)."<br/>";
	$content .= "<b>Ссылка на отзыв:</b> ".site_url()."/wp-admin/post.php?post=$post_id&action=edit";


	wp_mail( 'vitaliy060282@gmail.com, testdev@kometatek.ru,world.julia1@gmail.com', $pagetitle, $content, "Content-type: text/html; charset=\"utf-8\"\r\n From: mail@groupspb.ru\r\n".'X-Mailer: PHP/' . phpversion()  );
	wp_mail( 'info@groupspb.ru', $pagetitle, $content , "Content-type: text/html; charset=\"utf-8\"\r\n From: mail@groupspb.ru\r\n".'X-Mailer: PHP/' . phpversion());
	/*wp_mail( 'Info@groupspb.ru', $pagetitle, $content, "Content-type: text/html; charset=\"utf-8\"\r\n From: mail@groupspb.ru\r\n".'X-Mailer: PHP/' . phpversion()  );
	*/



	// Возвращаем ответ REST API
	return rest_ensure_response([
			'success' => true,
			'message' => 'Отзыв успешно отправлен!',
			'post_id' => $post_id,
	]);
}

// Вспомогательная функция для обработки массива файлов
function RemapFilesArray($name, $type, $tmp_name, $error, $size) {
    return array(
        'name' => $name,
        'type' => $type,
        'tmp_name' => $tmp_name,
        'error' => $error,
        'size' => $size,
    );
}

// Вспомогательная функция для загрузки вложений

function my_update_attachment($f,$pid,$t='',$c='') {
  wp_update_attachment_metadata( $pid, $f );
  if( !empty( $f['name'] )) {

    $override['test_form'] = false;
    $file = wp_handle_upload( $f, $override );

    if ( isset( $file['error'] )) {
      return new WP_Error( 'upload_error', $file['error'] );
    }

    $file_type = wp_check_filetype($f['name'], array(
      'jpg|jpeg' => 'image/jpeg',
      'gif' => 'image/gif',
      'png' => 'image/png',
      'webp' => 'image/webp',
    ));
    if ($file_type['type']) {
      $name_parts = pathinfo( $file['file'] );
      $name = $f['name'];
      $type = $file['type'];
      $title = $t ? $t : $name;
      $content = $c;

      $attachment = array(
        'post_title' => $title,
        'post_type' => 'attachment',
        'post_content' => $content,
        'post_parent' => $pid,
        'post_mime_type' => $type,
        'guid' => $file['url'],
      );


      foreach( get_intermediate_image_sizes() as $s ) {
        $sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => true );
        $sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
        $sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
        $sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
      }

      $sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

      foreach( $sizes as $size => $size_data ) {
        $resized = image_make_intermediate_size( $file['file'], $size_data['width'], $size_data['height'], $size_data['crop'] );
        if ( $resized )
          $metadata['sizes'][$size] = $resized;
      }

      $attach_id = wp_insert_attachment( $attachment, $file['file'] /*, $pid - for post_thumbnails*/);

      if ( !is_wp_error( $attach_id )) {
        $attach_meta = wp_generate_attachment_metadata( $attach_id, $file['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_meta );
      }

   return array(
  'pid' =>$pid,
  'url' =>$file['url'],
  'file'=>$file,
  'attach_id'=>$attach_id
   );
    }
  }
}

