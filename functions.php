<?php
/**
 * FWD Starter Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FWD_Starter_Theme
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.2.4');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fwd_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on FWD Starter Theme, use a find and replace
	 * to change 'fwd' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('fwd', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// Portrait Blog Size - 200px width, 250px height, hard crop
	add_image_size('portrait-blog', 200, 250, true);

	add_image_size('latest-blog-teaser', 400, 200, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header' => esc_html__('Header Menu Location', 'fwd'),
			'footer-left' => esc_html__('Footer - Left Side', 'fwd'),
			'footer-right' => esc_html__('Footer - Right Side', 'fwd'),
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
			'navigation-widgets',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'fwd_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
			// 'unlink-homepage-logo' 	=> true,
		)
	);

	/**
	 * Add support for Block Editor features.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/
	 */
	add_theme_support('wp-block-styles');
	add_theme_support('responsive-embeds');
	// add_theme_support( 'align-wide' );
}
add_action('after_setup_theme', 'fwd_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fwd_content_width()
{
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('fwd_content_width', 960);
}
add_action('after_setup_theme', 'fwd_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fwd_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'fwd'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'fwd'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar-2', 'fwd'),
			'id' => 'sidebar-2',
			'description' => esc_html__('Add widgets here.', 'fwd'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'fwd_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function fwd_scripts()
{
	wp_enqueue_style(
		'fwd-googlefonts', // handle ( unique name)
		'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Poppins:wght@400;700&display=swap',
		array(), // dependencies
		null // version (use null for google fonts)
	);
	wp_enqueue_style('fwd-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('fwd-style', 'rtl', 'replace');

	wp_enqueue_script('fwd-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (is_front_page()) {
		// name, file path, /point/to/concateneted/theme/folder/file.name, empty aray, version #, media (bull is default to it) 
		wp_enqueue_style('swiper-styles', get_template_directory_uri() . '/css/swiper-bundle.css', array(), '7.4.1');
		// 'defer' has scripts load at the bottom of the page but smartly
		// '_S_VERSION' is hte version of the theme chosen and used.
		wp_enqueue_script('swiper-scripts', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), '7.4.1', array('strategy' => 'defer'));
		wp_enqueue_script('swiper-settings', get_template_directory_uri() . '/js/swiper-settings.js', array('swiper-scripts'), _S_VERSION, array('strategy' => 'defer'));
	}
	
}
add_action('wp_enqueue_scripts', 'fwd_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Post Types & Taxonomies
 */
require get_template_directory() . '/inc/cpt-taxonomy.php';


/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}



// _________________________



// Add Theme Color Meta Tag
function fwd_theme_color()
{
	echo "<meta name='theme-color' content='#fff200'>";
}
add_action('wp_head', 'fwd_theme_color');

// Change exerpt length to 20 words
function fwd_exerpt_length($length)
{
	return 35;
}
add_filter('excerpt_length', 'fwd_exerpt_length', 999);

// Change excerpt more text for posts
function fwd_exerpt_more($more)
{
	return '... <a class="read-more" href="' . esc_url(get_permalink()) . '">Continue Reading</a>';
}
add_filter('excerpt_more', 'fwd_exerpt_more', 999);

// Add Block Templates to Pages
function fwd_block_editor_templates()
{
	// Replace '14' with the Page ID
	if (isset($_GET['post']) && '151' == $_GET['post']) {
		$post_type_object = get_post_type_object('page');
		$post_type_object->template = array(
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Add your introduction here...'
				)
			),
			array(
				'core/heading',
				array(
					'placeholder' => 'Add your heading here...',
					'level' => 2
				)
			),
			array(
				'core/image',
				array(
					'align' => 'left',
					'sizeSlug' => 'medium'
				)
			),
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Add text here...'
				)
			),
		);
		$post_type_object->template_lock = 'all';
	}
}
add_action('init', 'fwd_block_editor_templates');


// remove 
function fwd_post_filter($use_block_editor, $post)
{
	// Change 112 to your Page ID
	$page_ids = array(177, 19);
	if (in_array($post->ID, $page_ids)) {
		return false;
	} else {
		return $use_block_editor;
	}
}
add_filter('use_block_editor_for_post', 'fwd_post_filter', 10, 2);

