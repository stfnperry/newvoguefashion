<?php
/**
 * Moral functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Moral
 */

if ( ! function_exists( 'blog_lover_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function blog_lover_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Moral, use a find and replace
		 * to change 'blog-lover' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'blog-lover' );

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
			'top' => esc_html__( 'Top', 'blog-lover' ),
			'primary' => esc_html__( 'Primary', 'blog-lover' ),
			'social' => esc_html__( 'Social', 'blog-lover' ),
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
		add_theme_support( 'custom-background', apply_filters( 'blog_lover_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		// add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	    
    	/*
    	 * This theme styles the visual editor to resemble the theme style,
    	 * specifically font, colors, and column width.
     	 */
    	add_editor_style( array( 'assets/css/editor-style.css', blog_lover_fonts_url() ) );

    	// Gutenberg support
		add_theme_support( 'editor-color-palette', array(
	       	array(
				'name' => esc_html__( 'Blue', 'blog-lover' ),
				'slug' => 'blue',
				'color' => '#2c7dfa',
	       	),
	       	array(
	           	'name' => esc_html__( 'Green', 'blog-lover' ),
	           	'slug' => 'green',
	           	'color' => '#07d79c',
	       	),
	       	array(
	           	'name' => esc_html__( 'Orange', 'blog-lover' ),
	           	'slug' => 'orange',
	           	'color' => '#ff8737',
	       	),
	       	array(
	           	'name' => esc_html__( 'Black', 'blog-lover' ),
	           	'slug' => 'black',
	           	'color' => '#2f3633',
	       	),
	       	array(
	           	'name' => esc_html__( 'Grey', 'blog-lover' ),
	           	'slug' => 'grey',
	           	'color' => '#82868b',
	       	),
	   	));

		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-font-sizes', array(
		   	array(
		       	'name' => esc_html__( 'small', 'blog-lover' ),
		       	'shortName' => esc_html__( 'S', 'blog-lover' ),
		       	'size' => 12,
		       	'slug' => 'small'
		   	),
		   	array(
		       	'name' => esc_html__( 'regular', 'blog-lover' ),
		       	'shortName' => esc_html__( 'M', 'blog-lover' ),
		       	'size' => 16,
		       	'slug' => 'regular'
		   	),
		   	array(
		       	'name' => esc_html__( 'larger', 'blog-lover' ),
		       	'shortName' => esc_html__( 'L', 'blog-lover' ),
		       	'size' => 36,
		       	'slug' => 'larger'
		   	),
		   	array(
		       	'name' => esc_html__( 'huge', 'blog-lover' ),
		       	'shortName' => esc_html__( 'XL', 'blog-lover' ),
		       	'size' => 48,
		       	'slug' => 'huge'
		   	)
		));
		add_theme_support('editor-styles');
		add_theme_support( 'wp-block-styles' );
	}
endif;
add_action( 'after_setup_theme', 'blog_lover_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blog_lover_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'blog_lover_content_width', 900 );
}
add_action( 'after_setup_theme', 'blog_lover_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blog_lover_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'blog-lover' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'blog-lover' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s animated animatedFadeInUp">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage: Recent News Section Sidebar', 'blog-lover' ),
		'id'            => 'homepage-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'blog-lover' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s animated animatedFadeInUp">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $i=1; $i <= 4; $i++ ) { 
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widget Area ', 'blog-lover' )  . $i,
			'id'            => 'footer-' . $i,
			'description'   => esc_html__( 'Add widgets here.', 'blog-lover' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s animated animatedFadeInUp">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'blog_lover_widgets_init' );

/**
 * Register custom fonts.
 */
function blog_lover_fonts_url() {
	$fonts_url = '';

	$font_families = array();
	
	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Khand, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$montserrat = _x( 'on', 'Khand font: on or off', 'blog-lover' );

	if ( 'off' !== $montserrat ) {
		$font_families[] = 'Khand:400,600';
	}

	$playfair_display = _x( 'on', 'Playfair Display font: on or off', 'blog-lover' );

	if ( 'off' !== $playfair_display ) {
		$font_families[] = 'Playfair Display:400,700';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function blog_lover_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'blog-lover-fonts', blog_lover_fonts_url(), array(), null );

	wp_enqueue_style( 'slick', get_theme_file_uri() . '/assets/css/slick.css', '', '1.8.0' );

	wp_enqueue_style( 'slick-theme', get_theme_file_uri() . '/assets/css/slick-theme.css', '', '1.8.0' );

	// blocks
	wp_enqueue_style( 'blog-lover-blocks', get_template_directory_uri() . '/assets/css/blocks.css' );

	wp_enqueue_style( 'blog-lover-style', get_stylesheet_uri() );

	wp_enqueue_script( 'slick-jquery', get_theme_file_uri( '/assets/js/slick.js' ), array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'blog-lover-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '20151215', true );

	wp_enqueue_script( 'blog-lover-skip-link-focus-fix', get_theme_file_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'blog-lover-custom', get_theme_file_uri( '/assets/js/custom.js' ), array( 'jquery' ), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'blog_lover_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 *
 * @since Blog Lover 1.0.0
 */
function blog_lover_pro_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'blog-lover-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.css' ) );
	// Add custom fonts.
	wp_enqueue_style( 'blog-lover-fonts', blog_lover_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'blog_lover_pro_block_editor_styles' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_parent_theme_file_path() . '/inc/jetpack.php';
}

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Breadcrumb trail class.
 */
require get_parent_theme_file_path( '/inc/class-breadcrumb-trail.php' );

/**
 * Metabox
 */
require get_parent_theme_file_path( '/inc/metabox.php' );

/**
 * Admin welcome page
 */
require get_parent_theme_file_path( '/inc/welcome.php' );

/**
 * TGMPA call
 */
require get_parent_theme_file_path( '/inc/tgmpa/call.php' );

/**
 * OCDI compatibility.
 */
if ( class_exists( 'OCDI_Plugin' ) ) {
	require get_parent_theme_file_path( '/inc/ocdi.php' );
}

/**
 * Blocks call
 */
// require get_parent_theme_file_path( '/inc/blocks/blocks.php' );

/**
* Redirect page to About Blog Lover page on theme activation
*/
global $pagenow;

if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
	wp_redirect( admin_url( 'themes.php?page=blog-lover-welcome' ) ); 	
} 

/**
 * Enqueue admin css.
 * @return [type] [description]
 */
function blog_lover_load_custom_wp_admin_style( $hook ) {
	if ( 'appearance_page_blog-lover-welcome' != $hook ) {
        return;
    }
    wp_register_style( 'blog-lover-admin', get_theme_file_uri( 'assets/css/blog-lover-admin.css' ), false, '1.0.0' );
    wp_enqueue_style( 'blog-lover-admin' );
}
add_action( 'admin_enqueue_scripts', 'blog_lover_load_custom_wp_admin_style' );

/**
 * Styles the header image and text displayed on the blog.
 *
 * @see blog_lover_custom_header_setup().
 */
function blog_lover_header_text_style() {
	// If we get this far, we have custom styles. Let's do this.
	$header_text_display = get_theme_mod( 'blog_lover_header_text_display', true );
	?>
	<style type="text/css">
	<?php if ( ! $header_text_display ) : ?>
		#site-identity {
			display: none;
		}
	<?php endif; ?>

	.site-title a{
		color: <?php echo esc_attr( get_theme_mod( 'blog_lover_header_title_color', '#cf3140' ) ); ?>;
	}
	.site-description {
		color: <?php echo esc_attr( get_theme_mod( 'blog_lover_header_tagline', '#2e2e2e' ) ); ?>;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'blog_lover_header_text_style' );

/**
 *
 * Reset all setting to default.
 *
 */
function blog_lover_reset_settings() {
    $reset_settings = get_theme_mod( 'blog_lover_reset_settings', false );
    if ( $reset_settings ) {
        remove_theme_mods();
    }
}
add_action( 'customize_save_after', 'blog_lover_reset_settings' );


if ( ! function_exists( 'blog_lover_exclude_sticky_posts' ) ) {
    function blog_lover_exclude_sticky_posts( $query ) {
        if ( ! is_admin() && $query->is_main_query() && $query->is_home() ) {
            $sticky_posts = get_option( 'sticky_posts' );  
            if ( ! empty( $sticky_posts ) ) {
            	$query->set('post__not_in', $sticky_posts );
            }
            $query->set('ignore_sticky_posts', true );
        }
    }
}
add_action( 'pre_get_posts', 'blog_lover_exclude_sticky_posts' );