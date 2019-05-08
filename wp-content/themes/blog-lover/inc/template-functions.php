<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Moral
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blog_lover_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = 'right-sidebar';
    }
	
	return $classes;
}
add_filter( 'body_class', 'blog_lover_body_classes' );

function blog_lover_post_classes( $classes ) {
	if ( blog_lover_is_page_displays_posts() ) {
		// Search 'has-post-thumbnail' returned by default and remove it.
		$key = array_search( 'has-post-thumbnail', $classes );
		unset( $classes[ $key ] );
		
		$archive_img_enable = get_theme_mod( 'blog_lover_enable_archive_featured_img', true );

		if( has_post_thumbnail() && $archive_img_enable ) {
			$classes[] = 'has-post-thumbnail';
		} else {
			$classes[] = 'no-post-thumbnail';
		}
	}

  $classes[] = 'animated animatedFadeInUp';
  
	return $classes;
}
add_filter( 'post_class', 'blog_lover_post_classes' );

/**
 * Excerpt length
 * 
 * @since Moral 1.0.0
 * @return Excerpt length
 */
function blog_lover_excerpt_length( $length ){
	if ( is_admin() ) {
		return $length;
	}

	$length = get_theme_mod( 'blog_lover_archive_excerpt_length', 60 );
	return $length;
}
add_filter( 'excerpt_length', 'blog_lover_excerpt_length', 999 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function blog_lover_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'blog_lover_pingback_header' );

/**
 * Get an array of post id and title.
 * 
 */
function blog_lover_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'blog-lover' ) );
	$args = array( 'numberposts' => -1, );
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$id = $post->ID;
		$title = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Get an array of cat id and title.
 * 
 */
function blog_lover_get_post_cat_choices() {
  $choices = array( '' => esc_html__( '--Select--', 'blog-lover' ) );
	$cats = get_categories();

	foreach ( $cats as $cat ) {
		$id = $cat->term_id;
		$title = $cat->name;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function blog_lover_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function blog_lover_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Posts page".
 */
function blog_lover_is_frontpage_blog() {
	return ( is_home() && ! is_front_page() );
}

/**
 * Checks to see if the current page displays any kind of post listing.
 */
function blog_lover_is_page_displays_posts() {
	return ( blog_lover_is_frontpage_blog() || is_search() || is_archive() || blog_lover_is_latest_posts() );
}

/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  1.0.0
 * @access public
 * @param  array $args Arguments to pass to Breadcrumb_Trail.
 * @return void
 */
function blog_lover_breadcrumb( $args = array() ) {
	$breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

	if ( ! is_object( $breadcrumb ) )
		$breadcrumb = new Breadcrumb_Trail( $args );

	return $breadcrumb->trail();
}

/**
 * Pagination in archive/blog/search pages.
 */
function blog_lover_posts_pagination() { 
	$archive_pagination = get_theme_mod( 'blog_lover_archive_pagination_type', 'numeric' );
	if ( 'disable' === $archive_pagination ) {
		return;
	}
	if ( 'numeric' === $archive_pagination ) {
		the_posts_pagination( array(
            'prev_text'          => blog_lover_get_icon_svg( 'menu_icon_up' ),
            'next_text'          => blog_lover_get_icon_svg( 'menu_icon_up' ),
        ) );
	} elseif ( 'older_newer' === $archive_pagination ) {
        the_posts_navigation( array(
            'prev_text'          => blog_lover_get_icon_svg( 'menu_icon_up' ) . '<span>'. esc_html__( 'Older', 'blog-lover' ) .'</span>',
            'next_text'          => '<span>'. esc_html__( 'Newer', 'blog-lover' ) .'</span>' . blog_lover_get_icon_svg( 'menu_icon_up' ),
        )  );
	}
}

// Add auto p to the palces where get_the_excerpt is being called.
add_filter( 'get_the_excerpt', 'wpautop' );