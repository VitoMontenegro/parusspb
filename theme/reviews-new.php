<?php
/**
 * Страница с кастомным шаблоном (page-custom.php)
 * @package WordPress
 * Template Name: Отзывы
 */



get_header();
$excurs_arr = []; // массив экскурсий [id]=>title

$args = ['post_type' => 'tours',
		'posts_per_page' => -1
];
$query = new WP_Query( $args );

foreach($query->posts as $post){
	$excurs_arr[$post->ID] = get_the_title();
}
wp_reset_postdata();

$gid = []; // массив экскурсий [id]=>title

$args = ['post_type' => 'gid',
		'posts_per_page' => -1
];
$query = new WP_Query( $args );

foreach($query->posts as $post){
	$gid[$post->ID] = get_the_title();
}
wp_reset_postdata();
?>
<section class="primary content--reviews">
	<main id="main">
		<?php get_template_part( 'template-parts/layout/breadcrumbs', 'content' ); ?>



		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="container">
				<div class="entry-content">
                        <h1 class="mt-0 text-2xl sm:text-[32px] font-bold tracking-tight mb-[22px] sm:mb-12"><?php the_title() ; ?></h1>

                        <div class="flex flex-col sm:flex-row sm:items-start gap-6 w-full px-1 mb-[62px]">
                            <div class="content w-full">
                                <?php the_content(); ?>
                                <?php
                                    $args = ['post_type' => 'reviews',	'posts_per_page' => -1];
                                    $query = new WP_Query( $args );
                                    $months = [
                                        'января'   => '01', 'февраля' => '02', 'марта'    => '03', 'апреля'   => '04',
                                        'мая'      => '05', 'июня'    => '06', 'июля'     => '07', 'августа'  => '08',
                                        'сентября' => '09', 'октября' => '10', 'ноября'   => '11', 'декабря'  => '12'
                                    ];

                                    // Получаем и сортируем записи
                                    $posts = [];
                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                            $acf_date = get_field('date');

                                            if ($acf_date) {
                                                $date_parts = explode(' ', $acf_date);
                                                if (count($date_parts) === 3) {
                                                    $day   = str_pad($date_parts[0], 2, '0', STR_PAD_LEFT);
                                                    $month = $months[$date_parts[1]] ?? '01';
                                                    $year  = $date_parts[2];
                                                    $formatted_date = "$year-$month-$day";
                                                } else {
                                                    $formatted_date = '0000-00-00';
                                                }
                                            } else {
                                                $formatted_date = '0000-00-00';
                                            }

                                            $posts[] = [
                                                'id'    => get_the_ID(),
                                                'date'  => $acf_date,
                                                'sort_date' => $formatted_date
                                            ];
                                        }
                                    }

                                    // Сортируем по убыванию даты
                                    usort($posts, function($a, $b) {
                                        return strcmp($b['sort_date'], $a['sort_date']);
                                    });

                                    // Разбиваем по 10 записей
                                    $posts_per_page = 100;
                                    $total_posts = count($posts);
                                    $total_pages = ceil($total_posts / $posts_per_page);
                                    $posts_paginated = array_slice($posts, 0, $posts_per_page);
                                ?>

                                <?php if (!empty($posts_paginated)) : ?>
                                    <div id="rev-container" class="rev-container flex flex-col gap-[18px] sm:gap-6">
                                        <?php foreach ($posts_paginated as $post) : ?>
                                            <?php
                                                $post_obj = get_post($post['id']);
                                                setup_postdata($post_obj);
                                                get_template_part('template-parts/content/content', 'reviews');
                                            ?>
                                        <?php endforeach; ?>
                                        <?php if ($total_posts > $posts_per_page) : ?>
                                            <button id="load-more_rev" class="col-span-2 pt-1 load-more-excursion" data-page="2">
                                                <span class="inline-block font-bold text-[#FF7A45] py-2 px-4 sm:px-8 border-2 border-[#FF7A45] rounded-[6px] hover:text-white hover:bg-[#FF7A45]">
                                                    Загрузить ещё
                                                </span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; wp_reset_postdata(); ?>
                            </div>
                            <div class="aside w-full sm:max-w-[404px]">
                                <div class="sm:px-8 py-[30px] sm-shadows_custom">
                                    <form id="reviews_form" class="reviews_form">
                                        <div class="head mb-[18px]">
                                            <div class="title text-[24px] font-bold mb-1">Что вы можете сказать <br>
                                            об экскурсии?</div>
                                        </div>
                                        <div class="flex flex-col gap-[18px] items-center justify-center">
                                            <div class="flex flex-col w-full">

                                                <label class="placeholder relative mb-[18px] name_field">
                                                    <input
                                                            class="bg-[#F2F1FA]  rounded-[6px] w-full h-10 px-4 focus:outline-none placeholder-transparent"
                                                            name="name"
                                                            type="text"
                                                            placeholder="Как вас зовут?*">
                                                    <span class="absolute left-4 top-1/2 -translate-y-1/2  transition-opacity pointer-events-none">
                                                    Как вас зовут?<span class="text-[#52A6B2]">*</span>
                                                    </span>
                                                </label>
                                                <label class="placeholder relative mb-[18px]">
                                                    <input
                                                            class="bg-[#F2F1FA]   rounded-[6px] w-full h-10 px-4 focus:outline-none placeholder-transparent"
                                                            name="email"
                                                            type="text"
                                                            placeholder="E-mail для обратной связи*">
                                                    <span class="absolute left-4 top-1/2 -translate-y-1/2  transition-opacity pointer-events-none">
                                                    E-mail для обратной связи<span class="text-[#52A6B2]">*</span>
                                                    </span>
                                                </label>


                                                <label class="placeholder list-input relative mb-[18px] relative cursor-pointer">
                                                    <svg class="absolute right-[20px] top-[14px]"  width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="12" height="1" rx="0.5" fill="#D6BD7F"/>
                                                        <rect y="4" width="12" height="1" rx="0.5" fill="#D6BD7F"/>
                                                        <rect y="8" width="12" height="1" rx="0.5" fill="#D6BD7F"/>
                                                    </svg>
                                                    <input
                                                        class="bg-[#F2F1FA]   rounded-[6px] w-full h-10 ps-4 pe-11 focus:outline-none placeholder-[#373F41] cursor-pointer"
                                                        type="text"
                                                        name="excursObj"
                                                        id="inputField1"
                                                        autocomplete="off"
                                                        placeholder="Посещенная экскурсия"
                                                        >
                                                    <ul id="suggestions" class="absolute top-full left-0 w-full bg-white sm-shadows_custom rounded shadow max-h-52 overflow-y-auto hidden z-10 styles-scrollbar">
                                                        <?php foreach ($excurs_arr as $key => $value): ?>
                                                            <li class="data-item px-4 py-2 hover:bg-gray-100 cursor-pointer" data-name="<?php echo $key ?>"><?php echo $value ?></li>
                                                        <?php endforeach ?>
                                                    </ul>
													<input type="hidden" name="excurs">
                                                </label>

                                                <label class="placeholder list-input relative mb-[18px]">
                                                    <svg class="absolute right-[20px] top-[14px]"  width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="12" height="1" rx="0.5" fill="#D6BD7F"/>
                                                        <rect y="4" width="12" height="1" rx="0.5" fill="#D6BD7F"/>
                                                        <rect y="8" width="12" height="1" rx="0.5" fill="#D6BD7F"/>
                                                    </svg>
                                                    <input
                                                        class="bg-[#F2F1FA]  rounded-[6px] w-full h-10 ps-4 pe-11 focus:outline-none placeholder-[#373F41] cursor-pointer"
                                                        type="text"
                                                        name="gid"
                                                        id="inputField2"
                                                        autocomplete="off"
                                                        placeholder="Экскурсовод" >
                                                    <ul id="gids" class="absolute top-full left-0 w-full bg-white sm-shadows_custom rounded shadow max-h-52 overflow-y-auto hidden z-10 styles-scrollbar">
                                                        <?php foreach ($gid as $key => $value): ?>
                                                            <li class="data-item px-4 py-2 hover:bg-gray-100 cursor-pointer" data-name="<?php echo $value ?>"><?php echo $value ?></li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </label>


                                                <textarea class="bg-[#F2F1FA] rounded-[12px] w-full px-4 py-[11px] focus:outline-none h-[220px] mb-[18px]" name="message" id="" placeholder="Напишите всё, что думаете об экскурсии"></textarea>


                                                <div id="rev_upload" class="rounded-xl border border-dashed border-[#D6BD7F] px-[11px] py-[14px] bg-[#F2F1FA] cursor-pointer">
                                                    <label class="relative justify-center items-center flex flex-col cursor-pointer">
                                                        <svg class="pointer-events-none" xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 8.375C4.45507 8.375 3 9.83008 3 11.625V24.625C3 26.4199 4.45507 27.875 6.25 27.875H25.75C27.5449 27.875 29 26.4199 29 24.625V11.625C29 9.83007 27.5449 8.375 25.75 8.375H23.1731C22.7421 8.375 22.3288 8.2038 22.024 7.89905L20.2019 6.0769C19.5924 5.46741 18.7658 5.125 17.9038 5.125H14.0962C13.2342 5.125 12.4076 5.46741 11.7981 6.0769L9.97595 7.89905C9.6712 8.2038 9.25788 8.375 8.8269 8.375H6.25ZM16 23C18.6924 23 20.875 20.8174 20.875 18.125C20.875 15.4326 18.6924 13.25 16 13.25C13.3076 13.25 11.125 15.4326 11.125 18.125C11.125 20.8174 13.3076 23 16 23Z" fill="#D6BD7F"/>
                                                        </svg>
                                                        <span id="popup-input-file" class="popup-input-content popup-input-file-content">
                                                            <input type="file" id="photo-input"  multiple="multiple"  class="popup-input-file opacity-0 photo absolute top-0 bottom-0 left-0 right-0 cursor-pointer" name="file[]" accept="image/*">
                                                            <span class="popup-input-file-btn text-[11px] text-center flex items-center justify-center">Перетащите или загрузите фото <br>формат:  jpg, jpeg, png, webp</span>
                                                        </span>
                                                    </label>
                                                </div>

                                                <div id="preview-container" class="flex flex-wrap gap-x-1.5"></div>
                                            </div>
                                        </div>

                                        <button class="send-btn relative inline-flex h-11 items-center justify-center font-bold   px-7 sm:px-10 rounded-md bg-[#52A6B2] text-white text-[12px] lg:text-sm mb-[18px] mt-[18px] w-full sm:w-[205px]">
                                            <span class="btn-text text-center text-white text-[12px] lg:text-sm font-bold leading-tight">Отправить отзыв</span>
											<span class="loader hidden absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
												<svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
													<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
												</svg>
											</span>
                                        </button>
                                        <label class=cursor-pointer">
                                                        <span class="flex gap-2 items-center">
                                                        <input type="checkbox" class="checkbox-input hidden" checked />
                                                        <span class="checkbox-box w-[16px] h-[16px]  border border-[#52A6B2] rounded-sm flex items-center justify-center bg-transparent"">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                                                <path d="M4.37891 9.31366L6.44772 11.3825L11.6197 6.21045" stroke="#52A6B2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </span>
                                            <span class="text-[9px] leading-[12px]">Отправляя форму, соглашаюсь с <a target="_blank" class="underline" href="/privacy-policy">Политикой конфиденциальности</a></span>
                                        </label>
                                    </form>
                                </div>
                                <div class="w-full mt-6">
                                    <iframe src="https://yandex.ru/sprav/widget/rating-badge/92802349227?type=rating" width="150" height="50" frameborder="0"></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
			</div>


		</article><!-- #post-<?php the_ID(); ?> -->






	</main>
</section>

<?php get_footer(); ?>
