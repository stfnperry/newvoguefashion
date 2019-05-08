<?php
/**
 * The template for displaying Link post formats.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php kubera_article_schema( 'CreativeWork' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * kubera_before_content hook.
		 *
		 *
		 * @hooked kubera_featured_page_header_inside_single - 10
		 */
		do_action( 'kubera_before_content' );
		?>

		<header class="entry-header">
			<?php
			/**
			 * kubera_before_entry_title hook.
			 *
			 */
			do_action( 'kubera_before_entry_title' );

			the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( kubera_get_link_url() ) ), '</a></h2>' );

			/**
			 * kubera_after_entry_title hook.
			 *
			 *
			 * @hooked kubera_post_meta - 10
			 */
			do_action( 'kubera_after_entry_title' );
			?>
		</header><!-- .entry-header -->

		<?php
		/**
		 * kubera_after_entry_header hook.
		 *
		 *
		 * @hooked kubera_post_image - 10
		 */
		do_action( 'kubera_after_entry_header' );

		if ( kubera_show_excerpt() ) : ?>

			<div class="entry-summary" itemprop="text">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php else : ?>

			<div class="entry-content" itemprop="text">
				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'kubera' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->

		<?php endif;

		/**
		 * kubera_after_entry_content hook.
		 *
		 *
		 * @hooked kubera_footer_meta - 10
		 */
		do_action( 'kubera_after_entry_content' );

		/**
		 * kubera_after_content hook.
		 *
		 */
		do_action( 'kubera_after_content' );
		?>
	</div><!-- .inside-article -->
</article><!-- #post-## -->
