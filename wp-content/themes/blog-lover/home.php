<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

get_header(); 
	
	$img = '';
	if( blog_lover_is_frontpage_blog() ) {
		$page_for_posts = get_option( 'page_for_posts' );
        $img = get_the_post_thumbnail_url( $page_for_posts, 'large' );
	}
	?>
	<div id="banner-image" style="background-image: url('<?php echo esc_url( $img ); ?>');">
	    <div class="overlay"></div>
	    <div class="page-site-header">
	        <div class="wrapper">
	            <header class="page-header">
	                <h2 class="page-title">
		                <?php 
		            	if ( blog_lover_is_latest_posts() ) {
		            		echo esc_html( get_theme_mod( 'blog_lover_your_latest_posts_title', esc_html__( 'Blogs', 'blog-lover' ) ) ); 
		            	} elseif( blog_lover_is_frontpage_blog() ) {
		            		single_post_title();
		            	} 
		            	?>
	                </h2>
	            </header><!-- .page-header -->

	            <?php  
		        $breadcrumb_enable = get_theme_mod( 'blog_lover_breadcrumb_enable', true );
		        if ( $breadcrumb_enable ) : 
		            ?>
		            <div id="breadcrumb-list" class="animated animatedFadeInUp">
		                <div class="wrapper">
		                    <?php echo blog_lover_breadcrumb( array( 'show_on_front'   => false, 'show_browse' => false ) ); ?>
		                </div><!-- .wrapper -->
		            </div><!-- #breadcrumb-list -->
		        <?php endif; ?>
	        </div><!-- .wrapper -->
	    </div><!-- #page-site-header -->
	</div><!-- #banner-image -->

    <div id="inner-content-wrapper" class="wrapper page-section">
			<div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
		        	<?php 
		        	$sticky_posts = get_option( 'sticky_posts' );  
		        	if ( ! empty( $sticky_posts ) ) :
		        	?>
                        <div class="sticky-post-wrapper posts-wrapper">
        	        		<?php  
        						$sticky_query = new WP_Query( array(
        							'post__in'  => $sticky_posts,
        						) );

        						if ( $sticky_query->have_posts() ) :
        							/* Start the Loop */
        							while ( $sticky_query->have_posts() ) : $sticky_query->the_post(); ?>
        								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        									<?php 
        									$archive_img_enable = get_theme_mod( 'blog_lover_enable_archive_featured_img', true );

        									$img_url = '';
        									if ( has_post_thumbnail() && $archive_img_enable ) : 
        										$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        									endif;
        									?>
        									<div class="featured-image">
        										<?php 
        										if ( ! empty( $img_url ) ) : ?>
        									    	<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $img_url ); ?>"></a>
        										<?php endif; ?>
        									</div><!-- .featured-image -->

        									<div class="entry-container">
        										<?php
        										$enable_archive_author = get_theme_mod( 'blog_lover_enable_archive_author', true );
        										$archive_date_enable = get_theme_mod( 'blog_lover_enable_archive_date', true );

        										if ( $enable_archive_author || $archive_date_enable ) : ?>
        										    <div class="entry-meta">
        										        <?php
        									    		blog_lover_cats(); 
        										        
        										        if ( $enable_archive_author ) {
        													blog_lover_post_author(); 
        												}

        												if ( $archive_date_enable ) {
        													blog_lover_posted_on(); 
        												}
        												?>

        										    </div><!-- .entry-meta -->
        										<?php endif; ?>

        									    <header class="entry-header">
        									        <?php
        											if ( is_singular() ) :
        												the_title( '<h1 class="entry-title">', '</h1>' );
        											else :
        												the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        											endif; ?>
        									    </header>

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
        							<?php
        							endwhile;
        							wp_reset_postdata();
        						endif;
        	        		?>
                        </div><!-- .blog-posts-wrapper/.sticky-post-wrapper -->
		        	<?php endif; ?>
                    
                    <div  id="blog-lover-infinite-scroll" class="archive-blog-wrapper posts-wrapper clear col-2">
						<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_format() );

							endwhile;

							wp_reset_postdata();

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>
					</div><!-- .blog-posts-wrapper -->
					<?php blog_lover_posts_pagination();?>
				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar();?>
	</div>
<?php get_footer();
