<?php
/**
 * Template part for displaying front page recent news.
 *
 * @package Moral
 */

// Get default  mods value.
$latest = get_theme_mod( 'blog_lover_recent_posts', 'custom' );

if ( 'disable' === $latest ) {
    return;
}

$default = blog_lover_get_default_mods();

$latest_num = 3;

$col_class = '';
if ( $latest_num > 4 ) {
    if ( $latest_num % 3 === 0 ) {
        $col_class = 3;
    } else {
        $col_class = 4;
    }
} else {
    $col_class = $latest_num;
}

$img_postion = get_theme_mod( 'blog_lover_recent_posts_image_position', 'left' );
$img_class = ( 'right' === $img_postion ) ? 'image-right' : '';
?>
<div id="recent-posts" class="page-section relative">
    <div class="wrapper">
        <div class="section-content <?php echo ( is_active_sidebar( 'homepage-sidebar' ) ) ? '' : 'no-sidebar'; ?>">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <div class="posts-wrapper <?php echo esc_attr( $img_class ); ?>">
                        <?php
                        if (  in_array( $latest, array( 'post', 'page', 'cat' ) ) ) {

                            if ( 'cat' === $latest ) {
                                $cat_id = get_theme_mod( 'blog_lover_recent_posts_cat' );
                                $args = array(
                                    'cat' => $cat_id,   
                                    'posts_per_page' =>  absint( $latest_num ),
                                );
                            } else {
                                $id = array();
                                for ( $i=1; $i <= $latest_num; $i++ ) { 
                                    $id[] = get_theme_mod( "blog_lover_recent_posts_{$latest}_" . $i );
                                }
                                $args = array(
                                    'post_type' => $latest,
                                    'post__in' => (array)$id,   
                                    'orderby'   => 'post__in',
                                    'posts_per_page' => absint( $latest_num ),
                                    'ignore_sticky_posts' => true,
                                );
                            }

                            $query = new WP_Query( $args );

                            $i = 1;
                            if ( $query->have_posts() ) :
                                while ( $query->have_posts() ) :
                                    $query->the_post();
                                    
                                    $read_more   = get_theme_mod( 'blog_lover_recent_posts_more_' . $i, $default['blog_lover_recent_posts_more'] );
                                    ?>
                                    
                                    <article class="full-width hentry <?php echo ( has_post_thumbnail() ) ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                                        <?php 
                                            if ( has_post_thumbnail() ) : 
                                                echo '<div class="featured-image" style="background-image: url('.get_the_post_thumbnail_url( get_the_ID(), 'large' ).'">
                                                    <a href="' . esc_url( get_permalink() ) . '" ></a>
                                                </div><!-- .featured-image -->';
                                            endif;
                                        ?>

                                        <div class="entry-container">
                                            <div class="entry-meta">
                                                <?php blog_lover_cats(); ?>
                                                
                                                <?php blog_lover_posted_on(); ?>
                                            </div><!-- .entry-meta -->
                                            <header class="entry-header">
                                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                            </header>
                                            <div class="entry-content">
                                                <p><?php the_excerpt(); ?></p>
                                            </div><!-- .entry-content -->
                                            <a href="<?php the_permalink(); ?>" class="btn btn-default">
                                                <?php echo esc_html( $read_more ); ?>
                                                <?php echo blog_lover_get_icon_svg( 'read_more' ); ?>
                                            </a>
                                        </div>
                                    </article>
                                <?php 
                                $i++;
                                endwhile;
                                wp_reset_postdata();
                            endif; 
                        } ?>
                    </div>
                 </main>
            </div><!-- #primary -->
            <?php if ( is_active_sidebar( 'homepage-sidebar' ) ) : ?>
                <aside id="secondary" class="widget-area" role="complementary">
                    <?php dynamic_sidebar( 'homepage-sidebar' ); ?>
                </aside>
            <?php endif; ?>
        </div><!-- .section-content -->
    </div><!-- .wrapper -->
</div><!-- #recent-posts -->
