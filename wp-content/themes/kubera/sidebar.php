<?php
/**
 * The Sidebar containing the main widget areas.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If the navigation is set in the sidebar, set variable to true.
$navigation_active = ( 'nav-right-sidebar' == kubera_get_navigation_location() ) ? true : false;

// If the secondary navigation is set in the sidebar, set variable to true.
if ( function_exists( 'kubera_secondary_nav_get_defaults' ) ) {
	$secondary_nav = wp_parse_args(
		get_option( 'kubera_secondary_nav_settings', array() ),
		kubera_secondary_nav_get_defaults()
	);

	if ( 'secondary-nav-right-sidebar' == $secondary_nav['secondary_nav_position_setting'] ) {
		$navigation_active = true;
	}
}
?>
<div id="right-sidebar" itemtype="https://schema.org/WPSideBar" itemscope="itemscope" <?php kubera_right_sidebar_class(); ?>>
	<div class="inside-right-sidebar">
		<?php
		/**
		 * kubera_before_right_sidebar_content hook.
		 *
		 */
		do_action( 'kubera_before_right_sidebar_content' );

		if ( ! dynamic_sidebar( 'sidebar-1' ) ) :

			if ( false == $navigation_active ) : ?>

				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>

				<aside id="archives" class="widget">
					<h2 class="widget-title"><?php esc_html_e( 'Archives', 'kubera' ); ?></h2>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>

			<?php endif;

		endif;

		/**
		 * kubera_after_right_sidebar_content hook.
		 *
		 */
		do_action( 'kubera_after_right_sidebar_content' );
		?>
	</div><!-- .inside-right-sidebar -->
</div><!-- #secondary -->
