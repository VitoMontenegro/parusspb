<?php
/**
 * _tw functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _tw
 */
if ( ! defined( 'TW_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'TW_VERSION', '0.1.33' );
}

if ( ! defined( 'TW_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `tw_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'TW_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'tw_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tw_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _tw, use a find and replace
		 * to change 'tw' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tw', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'tw' ),
				'menu-2' => __( 'Footer Menu', 'tw' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );
		add_editor_style( 'style-editor-extra.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'tw_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tw_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'tw' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'tw' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'tw_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tw_scripts() {
	wp_enqueue_style('tw-swiper-style', get_template_directory_uri() . '/css/swiper-bundle.min.css');
	wp_enqueue_script('tw-swiper-init', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), TW_VERSION, true);
	wp_enqueue_script('tw-localize', get_template_directory_uri() . '/js/localize.js', array(), TW_VERSION, true);
	wp_enqueue_script( 'tw-fancybox', get_template_directory_uri() . '/js/fancybox.umd.js', array(), TW_VERSION, true );



	wp_enqueue_style( 'tw-style', get_stylesheet_uri(), array(), TW_VERSION );
	wp_enqueue_script( 'tw-script', get_template_directory_uri() . '/js/script.min.js', array(), TW_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tw_scripts' );

/**
 * Enqueue the block editor script.
 */
function tw_enqueue_block_editor_script() {
	if ( is_admin() ) {
		wp_enqueue_script(
			'tw-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			TW_VERSION,
			true
		);
		wp_add_inline_script( 'tw-editor', "tailwindTypographyClasses = '" . esc_attr( TW_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'tw_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function tw_tinymce_add_class( $settings ) {
	$settings['body_class'] = TW_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'tw_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/api-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Customizer gutenberg.
 */
require get_theme_file_path() . '/inc/gutenberg.php';

function varf($param) {
	echo '<pre>';
	var_dump($param);
	echo '</pre>';
}
function remove_private_prefix($title, $post_id) {
    $post = get_post($post_id);

    // Проверяем, если запись имеет статус 'private'
    if ($post->post_status === 'private') {
        $title = str_replace('Личное: ', '', $title);
    }

    return $title;
}
add_filter('the_title', 'remove_private_prefix', 10, 2);

/*
function get_all_rest_routes() {
    $routes = rest_get_server()->get_routes();
    echo '<pre>';
    print_r($routes);
    echo '</pre>';
}

add_action('init', 'get_all_rest_routes');*/


function remove_wp_block_styles() {
	wp_dequeue_style( 'wp-block-library' );  // Стили для блоков
	wp_dequeue_style( 'wp-block-library-theme' );  // Стили для тем блоков
}
add_action( 'wp_enqueue_scripts', 'remove_wp_block_styles', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
