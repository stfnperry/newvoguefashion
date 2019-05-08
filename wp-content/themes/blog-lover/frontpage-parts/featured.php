<?php
/**
 * Template part for displaying front page featured.
 *
 * @package Moral
 */

// Get default  mods value.
$featured = get_theme_mod( 'blog_lover_featured', 'custom' );

if ( 'disable' === $featured ) {
    return;
}

$default = blog_lover_get_default_mods();

$featured_num = 7;

$col_class = '';
if ( $featured_num > 5 ) {
    if ( $featured_num % 3 === 1 ) {
        $col_class = 3;
    } else {
        $col_class = 4;
    }
} else {
    $col_class = $featured_num - 1;
}

$img_postion = 'before-title';

?>
<div id="latest-featured" class="col-<?php echo esc_attr( $col_class ); ?>">
    <div class="wrapper">
        <div class="posts-wrapper">
                <?php

                if (  in_array( $featured, array( 'post', 'page' ) ) ) {
                    $id = array();
                    for ( $i=1; $i <= $featured_num; $i++ ) { 
                        $id[] = get_theme_mod( "blog_lover_featured_{$featured}_" . $i );
                    }
                    $args = array(
                        'post_type' => $featured,
                        'post__in' => (array)$id,   
                        'orderby'   => 'post__in',
                        'posts_per_page' => absint( $featured_num ),
                        'ignore_sticky_posts' => true,
                    );

                    $query = new WP_Query( $args );

                    $i = 1;
                    if ( $query->have_posts() ) :
                        while ( $query->have_posts() ) :
                            $query->the_post();
                            
                            $img_html = '';
                            if ( has_post_thumbnail() ) : 
                                $img_html =
                                '<div class="featured-image" style="background-image: url(' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ) . ');">
                                    <a href="' . esc_url( get_permalink() ) . '"></a>
                                </div><!-- .featured-image -->';
                            endif;

                            ?>
                            
                            <article class="animated animatedFadeInUp <?php echo ( 1 === $i ) ? 'full-width' : '' ; ?> hentry has-post-thumbnail">

                                <?php 
                                if ( 'before-title' === $img_postion ) {
                                    echo $img_html; 
                                }
                                ?>

                                <div class="entry-container">
                                    <div class="entry-meta">
                                        <?php 
                                            blog_lover_cats();
                                            blog_lover_posted_on(); 
                                        ?>
                                    </div><!-- .entry-meta -->

                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    </header>

                                    <?php if ( 1 === $i ) { ?>
                                        <div class="entry-content">
                                            <?php the_excerpt(); ?>
                                        </div><!-- .entry-content -->

                                        <?php 
                                        $btn_txt = get_theme_mod( 'blog_lover_featured_first_read_more_' . $i, $default['blog_lover_featured_first_read_more'] );
                                        if ( $btn_txt ) : ?>
                                            <a href="<?php the_permalink(); ?>" class="btn btn-default"><?php echo esc_html( $btn_txt ); ?>
                                                <?php echo blog_lover_get_icon_svg( 'read_more' ); ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php } ?>
                                </div><!-- .entry-container -->

                                <?php 
                                if ( 'after-title' === $img_postion ) {
                                    echo $img_html; 
                                }
                                ?>

                            </article>

                        <?php 
                        $i++;
                        endwhile;
                        wp_reset_postdata();
                    endif; 
                }
                ?>
        </div><!-- .featured-items-wrapper -->
    </div><!-- .wrapper -->
</div><!-- #featured-section -->