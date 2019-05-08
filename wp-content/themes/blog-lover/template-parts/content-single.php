<?php
/**
 * Template part for displaying content  in post.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry' ); ?>>
	<div class="entry-meta">
	    <?php 
	    
	    $single_author_enable = get_theme_mod( 'blog_lover_enable_single_author', true );
	    if ( $single_author_enable ) {
	    	blog_lover_post_author(); 
	    }
	    $single_date_enable = get_theme_mod( 'blog_lover_enable_single_date', true );
		if ( $single_date_enable ) {
    		blog_lover_posted_on();
    	}

	    ?>
	</div><!-- .entry-meta -->


	<div class="entry-container">
	    <div class="entry-content">
	        <?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'blog-lover' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blog-lover' ),
				'after'  => '</div>',
			) );
			?>
	    </div><!-- .entry-content -->

	    <?php 
	    blog_lover_cats(); 
	    blog_lover_tags(); ?>
	</div><!-- .entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->
