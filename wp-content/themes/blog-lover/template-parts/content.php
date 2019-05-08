<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	$archive_img_enable = get_theme_mod( 'blog_lover_enable_archive_featured_img', true );

	$img_url = '';
	if ( has_post_thumbnail() && $archive_img_enable ) : 
		$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	endif;
	?>
	<?php if ( ! empty( $img_url ) ) : ?>
		<div class="featured-image">
		    	<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $img_url ); ?>"></a>
		</div><!-- .featured-image -->
	<?php endif; ?>

	<div class="entry-container">
		<?php
		$enable_archive_author = get_theme_mod( 'blog_lover_enable_archive_author', true );
		$archive_date_enable = get_theme_mod( 'blog_lover_enable_archive_date', true );
		?>

	    <div class="entry-meta">
	        <?php blog_lover_cats(); ?>
	    </div>
		    	
	    <header class="entry-header">
	        <?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif; ?>
	    </header>

	    <div class="entry-meta">
			<?php if ( $enable_archive_author || $archive_date_enable ) :
		        if ( $enable_archive_author ) {
					blog_lover_post_author(); 
				}

				if ( $archive_date_enable ) {
					blog_lover_posted_on(); 
				}
			endif; ?>
		</div>
		
	    <div class="entry-content">
	        <?php
				$archive_content_type = get_theme_mod( 'blog_lover_enable_archive_content_type', 'excerpt' );
				if ( 'excerpt' === $archive_content_type ) {
					the_excerpt();
					?>
			        <div class="read-more-link">
					    <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_theme_mod( 'blog_lover_archive_excerpt', esc_html__( 'View the post', 'blog-lover' ) ) ); ?></a>
					</div><!-- .read-more -->
				<?php
				} else {
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
				}
			?>
	    	
	    	<?php blog_lover_tags(); ?>

	    </div><!-- .entry-content -->
    </div><!-- .entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->
