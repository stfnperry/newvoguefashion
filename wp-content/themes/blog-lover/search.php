<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Moral
 */

get_header(); ?>
		<div id="banner-image" style="background-image: url('');">
		    <div class="overlay"></div>
		    <div class="page-site-header">
		        <div class="wrapper">
		            <header class="page-header">
		               <h1 class="page-title"><?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'blog-lover' ), '<span>' . get_search_query() . '</span>' );
						?></h1>
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
                    <div class="blog-posts-wrapper col-2">
                    	<div id="blog-lover-infinite-scroll" class="blog-archive-wrapper">

						<?php
						/* Start the Loop */
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_format() );

							endwhile;

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>
						</div>
					</div><!-- .posts-wrapper -->
					<?php blog_lover_posts_pagination();?>
				</main><!-- #main -->
			</div><!-- #primary -->
			
			<?php get_sidebar(); ?>
				
		</div>

<?php
get_footer();
