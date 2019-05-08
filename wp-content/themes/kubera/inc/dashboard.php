<?php
/**
 * Builds our admin page.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'kubera_create_menu' ) ) {
	add_action( 'admin_menu', 'kubera_create_menu' );
	/**
	 * Adds our "Kubera" dashboard menu item
	 *
	 */
	function kubera_create_menu() {
		$kubera_page = add_theme_page( 'Kubera', 'Kubera', apply_filters( 'kubera_dashboard_page_capability', 'edit_theme_options' ), 'kubera-options', 'kubera_settings_page' );
		add_action( "admin_print_styles-$kubera_page", 'kubera_options_styles' );
	}
}

if ( ! function_exists( 'kubera_options_styles' ) ) {
	/**
	 * Adds any necessary scripts to the Kubera dashboard page
	 *
	 */
	function kubera_options_styles() {
		wp_enqueue_style( 'kubera-options', get_template_directory_uri() . '/css/admin/admin-style.css', array(), KUBERA_VERSION );
	}
}

if ( ! function_exists( 'kubera_settings_page' ) ) {
	/**
	 * Builds the content of our Kubera dashboard page
	 *
	 */
	function kubera_settings_page() {
		?>
		<div class="wrap">
			<div class="metabox-holder">
				<div class="kubera-masthead clearfix">
					<div class="kubera-container">
						<div class="kubera-title">
							<a href="<?php echo esc_url(KUBERA_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'Kubera', 'kubera' ); ?></a> <span class="kubera-version"><?php echo esc_html( KUBERA_VERSION ); ?></span>
						</div>
						<div class="kubera-masthead-links">
							<?php if ( ! defined( 'KUBERA_PREMIUM_VERSION' ) ) : ?>
								<a class="kubera-masthead-links-bold" href="<?php echo esc_url(KUBERA_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'Premium', 'kubera' );?></a>
							<?php endif; ?>
							<a href="<?php echo esc_url(KUBERA_WPKOI_AUTHOR_URL); ?>" target="_blank"><?php esc_html_e( 'WPKoi', 'kubera' ); ?></a>
                            <a href="<?php echo esc_url(KUBERA_DOCUMENTATION); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'kubera' ); ?></a>
						</div>
					</div>
				</div>

				<?php
				/**
				 * kubera_dashboard_after_header hook.
				 *
				 */
				 do_action( 'kubera_dashboard_after_header' );
				 ?>

				<div class="kubera-container">
					<div class="postbox-container clearfix" style="float: none;">
						<div class="grid-container grid-parent">

							<?php
							/**
							 * kubera_dashboard_inside_container hook.
							 *
							 */
							 do_action( 'kubera_dashboard_inside_container' );
							 ?>

							<div class="form-metabox grid-70" style="padding-left: 0;">
								<h2 style="height:0;margin:0;"><!-- admin notices below this element --></h2>
								<form method="post" action="options.php">
									<?php settings_fields( 'kubera-settings-group' ); ?>
									<?php do_settings_sections( 'kubera-settings-group' ); ?>
									<div class="customize-button hide-on-desktop">
										<?php
										printf( '<a id="kubera_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
											esc_url( admin_url( 'customize.php' ) ),
											esc_html__( 'Customize', 'kubera' )
										);
										?>
									</div>

									<?php
									/**
									 * kubera_inside_options_form hook.
									 *
									 */
									 do_action( 'kubera_inside_options_form' );
									 ?>
								</form>

								<?php
								$modules = array(
									'Backgrounds' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Blog' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Colors' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Copyright' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Disable Elements' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Demo Import' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Hooks' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Import / Export' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Menu Plus' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Page Header' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Secondary Nav' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Spacing' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Typography' => array(
											'url' => KUBERA_THEME_URL,
									),
									'Elementor Addon' => array(
											'url' => KUBERA_THEME_URL,
									)
								);

								if ( ! defined( 'KUBERA_PREMIUM_VERSION' ) ) : ?>
									<div class="postbox kubera-metabox">
										<h3 class="hndle"><?php esc_html_e( 'Premium Modules', 'kubera' ); ?></h3>
										<div class="inside" style="margin:0;padding:0;">
											<div class="premium-addons">
												<?php foreach( $modules as $module => $info ) { ?>
												<div class="add-on activated kubera-clear addon-container grid-parent">
													<div class="addon-name column-addon-name" style="">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php echo esc_html( $module ); ?></a>
													</div>
													<div class="addon-action addon-addon-action" style="text-align:right;">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php esc_html_e( 'More info', 'kubera' ); ?></a>
													</div>
												</div>
												<div class="kubera-clear"></div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php
								endif;

								/**
								 * kubera_options_items hook.
								 *
								 */
								do_action( 'kubera_options_items' );
								?>
							</div>

							<div class="kubera-right-sidebar grid-30" style="padding-right: 0;">
								<div class="customize-button hide-on-mobile">
									<?php
									printf( '<a id="kubera_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
										esc_url( admin_url( 'customize.php' ) ),
										esc_html__( 'Customize', 'kubera' )
									);
									?>
								</div>

								<?php
								/**
								 * kubera_admin_right_panel hook.
								 *
								 */
								 do_action( 'kubera_admin_right_panel' );

								  ?>
                                
                                <div class="wpkoi-doc">
                                	<h3><?php esc_html_e( 'Kubera documentation', 'kubera' ); ?></h3>
                                	<p><?php esc_html_e( 'If You`ve stuck, the documentation may help on WPKoi.com', 'kubera' ); ?></p>
                                    <a href="<?php echo esc_url(KUBERA_DOCUMENTATION); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Kubera documentation', 'kubera' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-social">
                                	<h3><?php esc_html_e( 'WPKoi on Facebook', 'kubera' ); ?></h3>
                                	<p><?php esc_html_e( 'If You want to get useful info about WordPress and the theme, follow WPKoi on Facebook.', 'kubera' ); ?></p>
                                    <a href="<?php echo esc_url(KUBERA_WPKOI_SOCIAL_URL); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Go to Facebook', 'kubera' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-review">
                                	<h3><?php esc_html_e( 'Help with You review', 'kubera' ); ?></h3>
                                	<p><?php esc_html_e( 'If You like Kubera theme, show it to the world with Your review. Your feedback helps a lot.', 'kubera' ); ?></p>
                                    <a href="<?php echo esc_url(KUBERA_WORDPRESS_REVIEW); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Add my review', 'kubera' ); ?></a>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'kubera_admin_errors' ) ) {
	add_action( 'admin_notices', 'kubera_admin_errors' );
	/**
	 * Add our admin notices
	 *
	 */
	function kubera_admin_errors() {
		$screen = get_current_screen();

		if ( 'appearance_page_kubera-options' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
			 add_settings_error( 'kubera-notices', 'true', esc_html__( 'Settings saved.', 'kubera' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'imported' == $_GET['status'] ) {
			 add_settings_error( 'kubera-notices', 'imported', esc_html__( 'Import successful.', 'kubera' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'reset' == $_GET['status'] ) {
			 add_settings_error( 'kubera-notices', 'reset', esc_html__( 'Settings removed.', 'kubera' ), 'updated' );
		}

		settings_errors( 'kubera-notices' );
	}
}
