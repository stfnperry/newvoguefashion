<?php
/**
 * Template part for displaying front page slider.
 *
 * @package Moral
 */

// Get default  mods value.
$slider = get_theme_mod( 'blog_lover_hero_slider', 'custom' );

if ( 'disable' === $slider ) {
    return;
}

$default = blog_lover_get_default_mods();

$slider_num = 3;

?>
<div id="hero-slider" class="page-section">
    <div class="regular" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":false, "autoplay": true, "draggable": true, "fade": true }'>
    	<?php

    	if (  in_array( $slider, array( 'post', 'page' ) ) ) {
	        $id = array();
	        for ( $i=1; $i <= $slider_num; $i++ ) { 
	            $id[] = get_theme_mod( "blog_lover_hero_slider_{$slider}_" . $i );
	        }
	        $args = array(
	            'post_type' => $slider,
	            'post__in' => (array)$id,   
                'orderby'   => 'post__in',
	            'posts_per_page' => $slider_num,
	            'ignore_sticky_posts' => true,
	        );

    	    $query = new WP_Query( $args );

    	    $i = 1;
    	    if ( $query->have_posts() ) :
    	        while ( $query->have_posts() ) :
    	            $query->the_post();
    	            ?>
    	        	<article class="hentry has-post-thumbnail">
    	        	    <div class="wrapper">
    	        	        <div class="hero-wrapper">
    	        	            <div class="entry-container">
    	        	                <div class="entry-meta">
			                			<?php 
				                			blog_lover_cats(); 
				                			blog_lover_posted_on(); 
			                			?>
    	        	                </div><!-- .entry-meta -->

    	        	                <header class="entry-header">
    	        	                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
    	        	                </header>

    	        	                <div class="entry-content">
    	        	                    <p><?php the_excerpt(); ?></p>
    	        	                </div><!-- .entry-content -->

            	                    <?php 
            	                    	$read_more = get_theme_mod( 'blog_lover_hero_slider_custom_btn_' . $i, $default['blog_lover_hero_slider_custom_btn'] ); 
            	                    ?>
                                	<?php if ( ! empty( $read_more ) ) : ?>
	    	        	                <a href="<?php the_permalink(); ?>" class="btn btn-default">
	    	        	                	<?php echo esc_html( $read_more ); ?>
	    	        	                    <?php echo blog_lover_get_icon_svg( 'read_more' ); ?>
	    	        	                </a>
				                	<?php endif; ?>
    	        	            </div><!-- .entry-container -->

    	        	            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'large' ); ?>');">
    	        	                <a href="<?php the_permalink(); ?>"></a>
    	        	            </div><!-- .featured-image -->
    	        	        </div><!-- .hero-wrapper -->
    	        	    </div><!-- .wrapper -->
    	        	</article><!-- .hentry -->
    	        <?php 
    	        $i++;
    	    	endwhile;
    	        wp_reset_postdata();
    	    endif; 
    	}
    	?>
    </div>
</div><!-- #featured-slider -->