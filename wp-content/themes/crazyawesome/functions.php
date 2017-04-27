<?php
/**
 * CrazyAwesome functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CrazyAwesome
 */

if ( ! function_exists( 'crazyawesome_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function crazyawesome_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on CrazyAwesome, use a find and replace
	 * to change 'crazyawesome' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'crazyawesome', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Header', 'crazyawesome' ),
            	'menu-2' => esc_html__( 'Footer', 'crazyawesome' ), //possible secondary menu

	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'crazyawesome_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
        
        //add theme supportfor custom logo
        add_theme_support( 'custom-logo', array( 'width' => 90, 'height' => 90,  'flex-width' => true, ) );
        

	// Add theme su pport for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'crazyawesome_setup' );

function crazyawesome_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Roboto and Palanquin Dark, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto = _x( 'on', 'Roboto font: on or off', 'crazyawesome' );
        
        $palanquin_dark = _x( 'on', 'Palanquin Dark font: on or off', 'crazyawesome' );

	$font_families = array();
        
        
        if ( 'off' !== $roboto ) {
        $font_families[] = 'Roboto:400,400i,700,700i,900';
        }
        
        if ( 'off' !== $palanquin_dark ) {
	$font_families[] = 'Palanquin Dark:400,500,700';
        }

		
                    if ( in_array('on', array($roboto, $palanquin_dark))) {
        
        

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function crazyawesome_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'crazyawesome-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
    add_filter( 'wp_resource_hints', 'crazyawesome_resource_hints', 10,2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function crazyawesome_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'crazyawesome_content_width', 640 );
}
add_action( 'after_setup_theme', 'crazyawesome_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function crazyawesome_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'crazyawesome' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'crazyawesome' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'crazyawesome_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function crazyawesome_scripts() {
    //enque google fonts, roberto and souce sans
    
        wp_enqueue_style('crazyawesome-fonts', crazyawesome_fonts_url() );
           
	wp_enqueue_style( 'crazyawesome-style', get_stylesheet_uri() );

	wp_enqueue_script( 'crazyawesome-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );
        
        wp_enqueue_script( 'crazyawesome-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20170426', true );
        
        wp_localize_script('crazyawesome-navigation', 'crazyawesomeScreenReaderText', 
                array(
                'expand'=> __( 'Expand child menu', 'crazyawesome' ),
                'collapse'=> __( 'Collapse child menu', 'crazyawesome' ),
                ));

	wp_enqueue_script( 'crazyawesome-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'crazyawesome_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
