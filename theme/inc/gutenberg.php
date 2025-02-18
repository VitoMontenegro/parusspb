<?php

// Добавляем свой раздел блоков
add_filter( 'block_categories_all', 'custom_block_category', 10, 2 );
function custom_block_category( $default_categories, $post ) {
    $res =  array_merge(
        $default_categories,
        [
            [
                'slug'  => 'bdt-category',     // Слаг категории который будем использовать при регистрации блока
                'title' => __( 'bdt Blocks', 'my-plugin' ),      // Отображаемое название категории
                'icon'  => 'wordpress'      // Иконка для категории, можно передать null если иконка не нужна
            ],
        ]
    );

    return array_reverse ($res);
}


add_action('acf/init', 'review_block_init');
function review_block_init() {

    // check function exists
    if( function_exists('acf_register_block_type') ) {
        acf_register_block_type(array(
            'name'      => 'about',
            'title'     => 'Блок о нас',
            'description'       => 'Блок о нас',
            'render_callback'   => 'my_acf_block_render_callback',
            'category'      => 'bdt-category',
            'icon' => array(
                // Specifying a background color to appear with the icon e.g.: in the inserter.
                'background' => '#eccb13',
                // Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
                'foreground' => '#fff',
                // Specifying a dashicon for the block
                'src' => 'lpb',
            ),
            'example'           => [],
        ));
        acf_register_block_type(array(
            'name'      => 'reviews',
            'title'     => 'Блок отзывы',
            'description'       => 'Блок отзывы',
            'render_callback'   => 'my_acf_block_render_callback',
            'category'      => 'bdt-category',
            'icon' => array(
                // Specifying a background color to appear with the icon e.g.: in the inserter.
                'background' => '#eccb13',
                // Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
                'foreground' => '#fff',
                // Specifying a dashicon for the block
                'src' => 'lpb',
            ),
            'example'           => [],
        ));
        acf_register_block_type(array(
            'name'      => 'details',
            'title'     => 'Блок реквизиты',
            'description'       => 'Блок реквизиты',
            'render_callback'   => 'my_acf_block_render_callback',
            'category'      => 'bdt-category',
            'icon' => array(
                // Specifying a background color to appear with the icon e.g.: in the inserter.
                'background' => '#eccb13',
                // Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
                'foreground' => '#fff',
                // Specifying a dashicon for the block
                'src' => 'lpb',
            ),
            'example'           => [],
        ));
    }
}

function my_acf_block_render_callback( $block ) {

    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "template-parts/block" folder
    if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
            include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
    }
}


