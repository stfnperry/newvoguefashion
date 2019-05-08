<?php
/**
 * Template part for displaying front page slider.
 *
 * @package Moral
 */

// Get default  mods value.
$slider = get_theme_mod( 'blog_lover_slider', 'post' );

if ( 'disable' === $slider ) {
    return;
}

$default = blog_lover_get_default_mods();

$slider_num = 3;

?>
<div id="featured-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":false, "autoplay": true, "draggable": true, "fade": true }'>
	        	<?php

	        	if (  in_array( $slider, array( 'post', 'page' ) ) ) {
        	        $id = array();
        	        for ( $i=1; $i <= $slider_num; $i++ ) { 
        	            $id[] = get_theme_mod( "blog_lover_slider_{$slider}_" . $i );
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
	        	        
	        	            <article style="background-image: url('<?php the_post_thumbnail_url( 'large' ); ?>');">
	            				<div class="overlay"></div>
					            <div class="wrapper">
					                <div class="featured-content-wrapper">

					                	<?php blog_lover_cats(); ?>

					                    <header class="entry-header animated animatedFadeInUp">
					                        <h2 class="entry-title"><?php the_title();?></h2>
					                    </header>

					                    <?php blog_lover_posted_on(); ?>

					                    <?php 
					                    	$read_more = get_theme_mod( 'blog_lover_slider_custom_btn_' . $i, $default['blog_lover_slider_custom_btn'] ); 
					                    ?>
				                    	<?php if ( ! empty( $read_more ) ) : ?>

						                    <a href="<?php the_permalink(); ?>" class="btn btn-fill"><?php echo esc_html( $read_more ); ?>
						                    	<span class="more-icon">
						                    		<?php echo blog_lover_get_icon_svg( 'read_more' ); ?>
	                                			</span><!-- .more-icon -->
						                    </a>
						                <?php endif; ?>
					                </div><!-- .featured-content-wrapper -->
					            </div><!-- .wrapper -->
		        	        </article>
	        	        <?php 
	        	        $i++;
	        	    	endwhile;
	        	        wp_reset_postdata();
	        	    endif; 
	        	}
	        	?>
</div><!-- #featured-slider -->