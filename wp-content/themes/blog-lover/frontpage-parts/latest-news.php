<?php
/**
 * Template part for displaying front page latest news.
 *
 * @package Moral
 */

// Get default  mods value.
$latest = get_theme_mod( 'blog_lover_latest', 'post' );

if ( 'disable' === $latest ) {
    return;
}

$default = blog_lover_get_default_mods();

$latest_num = 3;

$col_class = $latest_num;

$img_postion = 'left';
$img_class = ( 'right' === $img_postion ) ? 'image-right' : '';

?>
<div id="latest-news" class="col-<?php echo esc_attr( $col_class ); ?>">
    <div class="wrapper">
        <div class="latest-wrapper clear">
                <?php

                if (  in_array( $latest, array( 'post', 'page' ) ) ) {

                    $id = array();
                    for ( $i=1; $i <= $latest_num; $i++ ) { 
                        $id[] = get_theme_mod( "blog_lover_latest_{$latest}_" . $i );
                    }
                    $args = array(
                        'post_type' => $latest,
                        'post__in' => (array)$id,   
                        'orderby'   => 'post__in',
                        'posts_per_page' => absint( $latest_num ),
                        'ignore_sticky_posts' => true,
                    );

                    $query = new WP_Query( $args );

                    $i = 1;
                    if ( $query->have_posts() ) :
                        while ( $query->have_posts() ) :
                            $query->the_post();
                            ?>
                            
                            <article class="hentry animated animatedFadeInUp">
                                <?php 
                                    if ( has_post_thumbnail() ) : 
                                        echo '<div class="featured-image '. esc_attr( $img_class ) .'">
                                            <a href="' . esc_url( get_permalink() ) . '" class="featured-image-link">' . get_the_post_thumbnail( get_the_ID(), 'blog-lover-home-latest-news' ) . '</a>
                                        </div><!-- .featured-image -->';
                                    endif;
                                ?>

                                <div class="entry-container">
                                    <?php blog_lover_cats(); ?>
                                    
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    </header>
                                    
                                    <?php blog_lover_posted_on(); ?>
                                </div>
                            </article>

                        <?php 
                        $i++;
                        endwhile;
                        wp_reset_postdata();
                    endif; 
                }
                ?>
        </div><!-- .latest-items-wrapper -->
    </div><!-- .wrapper -->
</div><!-- #latest-news -->
