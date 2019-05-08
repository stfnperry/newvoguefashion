<?php
/**
 * Footer elements.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'kubera_construct_footer' ) ) {
	add_action( 'kubera_footer', 'kubera_construct_footer' );
	/**
	 * Build our footer.
	 *
	 */
	function kubera_construct_footer() {
		?>
		<footer class="site-info" itemtype="https://schema.org/WPFooter" itemscope="itemscope">
			<div class="inside-site-info <?php if ( 'full-width' !== kubera_get_setting( 'footer_inner_width' ) ) : ?>grid-container grid-parent<?php endif; ?>">
				<?php
				/**
				 * kubera_before_copyright hook.
				 *
				 *
				 * @hooked kubera_footer_bar - 15
				 */
				do_action( 'kubera_before_copyright' );
				?>
				<div class="copyright-bar">
					<?php
					/**
					 * kubera_credits hook.
					 *
					 *
					 * @hooked kubera_add_footer_info - 10
					 */
					do_action( 'kubera_credits' );
					?>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'kubera_footer_bar' ) ) {
	add_action( 'kubera_before_copyright', 'kubera_footer_bar', 15 );
	/**
	 * Build our footer bar
	 *
	 */
	function kubera_footer_bar() {
		if ( ! is_active_sidebar( 'footer-bar' ) ) {
			return;
		}
		?>
		<div class="footer-bar">
			<?php dynamic_sidebar( 'footer-bar' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'kubera_add_footer_info' ) ) {
	add_action( 'kubera_credits', 'kubera_add_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 */
	function kubera_add_footer_info() {
		$copyright = sprintf( '<span class="copyright">&copy; %1$s %2$s</span> &bull; %4$s <a href="%3$s" itemprop="url">%5$s</a>',
			date( 'Y' ),
			get_bloginfo( 'name' ),
			esc_url( KUBERA_THEME_URL ),
			_x( 'Powered by', 'WPKoi', 'kubera' ),
			__( 'WPKoi', 'kubera' )
		);

		echo apply_filters( 'kubera_copyright', $copyright ); // WPCS: XSS ok.
	}
}

/**
 * Build our individual footer widgets.
 * Displays a sample widget if no widget is found in the area.
 *
 *
 * @param int $widget_width The width class of our widget.
 * @param int $widget The ID of our widget.
 */
function kubera_do_footer_widget( $widget_width, $widget ) {
	$widget_width = apply_filters( "kubera_footer_widget_{$widget}_width", $widget_width );
	$tablet_widget_width = apply_filters( "kubera_footer_widget_{$widget}_tablet_width", '50' );
	?>
	<div class="footer-widget-<?php echo absint( $widget ); ?> grid-parent grid-<?php echo absint( $widget_width ); ?> tablet-grid-<?php echo absint( $tablet_widget_width ); ?> mobile-grid-100">
		<?php if ( ! dynamic_sidebar( 'footer-' . absint( $widget ) ) ) :
	        $current_user = wp_get_current_user();
	        if (user_can( $current_user, 'administrator' )) { ?>
			<aside class="widget inner-padding widget_text">
				<h4 class="widget-title"><?php esc_html_e( 'Footer Widget', 'kubera' );?></h4>
				<div class="textwidget">
					<p>
						<?php
						printf( // WPCS: XSS ok.
							/* translators: 1: admin URL */
							__( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into this widget area.', 'kubera' ),
							esc_url( admin_url( 'widgets.php' ) )
						);
						?>
					</p>
					<p>
						<?php
						printf( // WPCS: XSS ok.
							/* translators: 1: admin URL */
							__( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.', 'kubera' ),
							esc_url( admin_url( 'customize.php' ) )
						);
						?>
					</p>
				</div>
			</aside>
		<?php } endif; ?>
	</div>
	<?php
}

if ( ! function_exists( 'kubera_construct_footer_widgets' ) ) {
	add_action( 'kubera_footer', 'kubera_construct_footer_widgets', 5 );
	/**
	 * Build our footer widgets.
	 *
	 */
	function kubera_construct_footer_widgets() {
		// Get how many widgets to show.
		$widgets = kubera_get_footer_widgets();

		if ( ! empty( $widgets ) && 0 !== $widgets ) :

			// Set up the widget width.
			$widget_width = '';
			if ( $widgets == 1 ) {
				$widget_width = '100';
			}

			if ( $widgets == 2 ) {
				$widget_width = '50';
			}

			if ( $widgets == 3 ) {
				$widget_width = '33';
			}

			if ( $widgets == 4 ) {
				$widget_width = '25';
			}

			if ( $widgets == 5 ) {
				$widget_width = '20';
			}
			?>
			<div id="footer-widgets" class="site footer-widgets">
				<div <?php kubera_inside_footer_class(); ?>>
					<div class="inside-footer-widgets">
						<?php
						if ( $widgets >= 1 ) {
							kubera_do_footer_widget( $widget_width, 1 );
						}

						if ( $widgets >= 2 ) {
							kubera_do_footer_widget( $widget_width, 2 );
						}

						if ( $widgets >= 3 ) {
							kubera_do_footer_widget( $widget_width, 3 );
						}

						if ( $widgets >= 4 ) {
							kubera_do_footer_widget( $widget_width, 4 );
						}

						if ( $widgets >= 5 ) {
							kubera_do_footer_widget( $widget_width, 5 );
						}
						?>
					</div>
				</div>
			</div>
		<?php
		endif;

		/**
		 * kubera_after_footer_widgets hook.
		 *
		 */
		do_action( 'kubera_after_footer_widgets' );
	}
}

if ( ! function_exists( 'kubera_back_to_top' ) ) {
	add_action( 'kubera_after_footer', 'kubera_back_to_top', 2 );
	/**
	 * Build the back to top button
	 *
	 */
	function kubera_back_to_top() {
		$kubera_settings = wp_parse_args(
			get_option( 'kubera_settings', array() ),
			kubera_get_defaults()
		);

		if ( 'enable' !== $kubera_settings[ 'back_to_top' ] ) {
			return;
		}

		echo apply_filters( 'kubera_back_to_top_output', sprintf( // WPCS: XSS ok.
			'<a title="%1$s" rel="nofollow" href="#" class="kubera-back-to-top" style="opacity:0;visibility:hidden;" data-scroll-speed="%2$s" data-start-scroll="%3$s">
				<span class="screen-reader-text">%5$s</span>
			</a>',
			esc_attr__( 'Scroll back to top', 'kubera' ),
			absint( apply_filters( 'kubera_back_to_top_scroll_speed', 400 ) ),
			absint( apply_filters( 'kubera_back_to_top_start_scroll', 300 ) ),
			esc_attr( apply_filters( 'kubera_back_to_top_icon', 'fa-angle-up' ) ),
			esc_html__( 'Scroll back to top', 'kubera' )
		) );
	}
}

add_action( 'kubera_after_footer', 'kubera_side_padding_footer', 5 );
/**
 * Add holder div if sidebar padding is enabled
 *
 */
function kubera_side_padding_footer() { 
	$kubera_settings = wp_parse_args(
		get_option( 'kubera_spacing_settings', array() ),
		kubera_spacing_get_defaults()
	);
	
	$fixed_side_content   =  kubera_get_setting( 'fixed_side_content' ); 
	$socials_display_side =  kubera_get_setting( 'socials_display_side' ); 
	
	if ( ( $kubera_settings[ 'side_top' ] != 0 ) || ( $kubera_settings[ 'side_right' ] != 0 ) || ( $kubera_settings[ 'side_bottom' ] != 0 ) || ( $kubera_settings[ 'side_left' ] != 0 ) ) { ?>
    	<div class="kubera-side-left-cover"></div>
    	<div class="kubera-side-right-cover"></div>
	</div>
	<?php } 
	if ( ( $fixed_side_content != '' ) || ( $socials_display_side == true ) ) { ?>
    <div class="kubera-side-left-content">
        <?php if ( $socials_display_side == true ) { ?>
        <div class="kubera-side-left-socials">
        <?php do_action( 'kubera_social_bar_action' ); ?>
        </div>
        <?php } ?>
        <?php if ( $fixed_side_content != '' ) { ?>
    	<div class="kubera-side-left-text">
        <?php echo wp_kses_post( $fixed_side_content ); ?>
        </div>
        <?php } ?>
    </div>
    <?php
	}
}
