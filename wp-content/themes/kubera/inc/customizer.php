<?php
/**
 * Builds our Customizer controls.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'customize_register', 'kubera_set_customizer_helpers', 1 );
/**
 * Set up helpers early so they're always available.
 * Other modules might need access to them at some point.
 *
 */
function kubera_set_customizer_helpers( $wp_customize ) {
	// Load helpers
	require_once trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-helpers.php';
}

if ( ! function_exists( 'kubera_customize_register' ) ) {
	add_action( 'customize_register', 'kubera_customize_register' );
	/**
	 * Add our base options to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function kubera_customize_register( $wp_customize ) {
		// Get our default values
		$defaults = kubera_get_defaults();

		// Load helpers
		require_once trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-helpers.php';

		if ( $wp_customize->get_control( 'blogdescription' ) ) {
			$wp_customize->get_control('blogdescription')->priority = 3;
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'blogname' ) ) {
			$wp_customize->get_control('blogname')->priority = 1;
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'custom_logo' ) ) {
			$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
		}

		// Add control types so controls can be built using JS
		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Kubera_Customize_Misc_Control' );
			$wp_customize->register_control_type( 'Kubera_Range_Slider_Control' );
		}

		// Add upsell section type
		if ( method_exists( $wp_customize, 'register_section_type' ) ) {
			$wp_customize->register_section_type( 'Kubera_Upsell_Section' );
		}

		// Add selective refresh to site title and description
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector' => '.main-title a',
				'render_callback' => 'kubera_customize_partial_blogname',
			) );

			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector' => '.site-description',
				'render_callback' => 'kubera_customize_partial_blogdescription',
			) );
		}

		// Remove title
		$wp_customize->add_setting(
			'kubera_settings[hide_title]',
			array(
				'default' => $defaults['hide_title'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'kubera_settings[hide_title]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Hide site title', 'kubera' ),
				'section' => 'title_tagline',
				'priority' => 2
			)
		);

		// Remove tagline
		$wp_customize->add_setting(
			'kubera_settings[hide_tagline]',
			array(
				'default' => $defaults['hide_tagline'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'kubera_settings[hide_tagline]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Hide site tagline', 'kubera' ),
				'section' => 'title_tagline',
				'priority' => 4
			)
		);

		$wp_customize->add_setting(
			'kubera_settings[retina_logo]',
			array(
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'kubera_settings[retina_logo]',
				array(
					'label' => __( 'Retina Logo', 'kubera' ),
					'section' => 'title_tagline',
					'settings' => 'kubera_settings[retina_logo]',
					'active_callback' => 'kubera_has_custom_logo_callback'
				)
			)
		);

		$wp_customize->add_setting(
			'kubera_settings[side_inside_color]', array(
				'default' => $defaults['side_inside_color'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'kubera_settings[side_inside_color]',
				array(
					'label' => __( 'Inside padding', 'kubera' ),
					'section' => 'colors',
					'settings' => 'kubera_settings[side_inside_color]',
					'active_callback' => 'kubera_is_side_padding_active',
				)
			)
		);

		$wp_customize->add_setting(
			'kubera_settings[text_color]', array(
				'default' => $defaults['text_color'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'kubera_settings[text_color]',
				array(
					'label' => __( 'Text Color', 'kubera' ),
					'section' => 'colors',
					'settings' => 'kubera_settings[text_color]'
				)
			)
		);

		$wp_customize->add_setting(
			'kubera_settings[link_color]', array(
				'default' => $defaults['link_color'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'kubera_settings[link_color]',
				array(
					'label' => __( 'Link Color', 'kubera' ),
					'section' => 'colors',
					'settings' => 'kubera_settings[link_color]'
				)
			)
		);

		$wp_customize->add_setting(
			'kubera_settings[link_color_hover]', array(
				'default' => $defaults['link_color_hover'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'kubera_settings[link_color_hover]',
				array(
					'label' => __( 'Link Color Hover', 'kubera' ),
					'section' => 'colors',
					'settings' => 'kubera_settings[link_color_hover]'
				)
			)
		);

		$wp_customize->add_setting(
			'kubera_settings[link_color_visited]', array(
				'default' => $defaults['link_color_visited'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_hex_color',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'kubera_settings[link_color_visited]',
				array(
					'label' => __( 'Link Color Visited', 'kubera' ),
					'section' => 'colors',
					'settings' => 'kubera_settings[link_color_visited]'
				)
			)
		);

		if ( ! function_exists( 'kubera_colors_customize_register' ) && ! defined( 'KUBERA_PREMIUM_VERSION' ) ) {
			$wp_customize->add_control(
				new Kubera_Customize_Misc_Control(
					$wp_customize,
					'colors_get_addon_desc',
					array(
						'section' => 'colors',
						'type' => 'addon',
						'label' => __( 'More info', 'kubera' ),
						'description' => __( 'More colors are available in Kubera premium version. Visit wpkoi.com for more info.', 'kubera' ),
						'url' => esc_url( KUBERA_THEME_URL ),
						'priority' => 30,
						'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname'
					)
				)
			);
		}

		if ( class_exists( 'WP_Customize_Panel' ) ) {
			if ( ! $wp_customize->get_panel( 'kubera_layout_panel' ) ) {
				$wp_customize->add_panel( 'kubera_layout_panel', array(
					'priority' => 25,
					'title' => __( 'Layout', 'kubera' ),
				) );
			}
		}

		// Add Layout section
		$wp_customize->add_section(
			'kubera_layout_container',
			array(
				'title' => __( 'Container', 'kubera' ),
				'priority' => 10,
				'panel' => 'kubera_layout_panel'
			)
		);

		// Container width
		$wp_customize->add_setting(
			'kubera_settings[container_width]',
			array(
				'default' => $defaults['container_width'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_integer',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			new Kubera_Range_Slider_Control(
				$wp_customize,
				'kubera_settings[container_width]',
				array(
					'type' => 'kubera-range-slider',
					'label' => __( 'Container Width', 'kubera' ),
					'section' => 'kubera_layout_container',
					'settings' => array(
						'desktop' => 'kubera_settings[container_width]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 700,
							'max' => 2000,
							'step' => 5,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'priority' => 0,
				)
			)
		);

		// Add Top Bar section
		$wp_customize->add_section(
			'kubera_top_bar',
			array(
				'title' => __( 'Top Bar', 'kubera' ),
				'priority' => 15,
				'panel' => 'kubera_layout_panel',
			)
		);

		// Add Top Bar width
		$wp_customize->add_setting(
			'kubera_settings[top_bar_width]',
			array(
				'default' => $defaults['top_bar_width'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Top Bar width control
		$wp_customize->add_control(
			'kubera_settings[top_bar_width]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Width', 'kubera' ),
				'section' => 'kubera_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'kubera' ),
					'contained' => __( 'Contained', 'kubera' )
				),
				'settings' => 'kubera_settings[top_bar_width]',
				'priority' => 5,
				'active_callback' => 'kubera_is_top_bar_active',
			)
		);

		// Add Top Bar inner width
		$wp_customize->add_setting(
			'kubera_settings[top_bar_inner_width]',
			array(
				'default' => $defaults['top_bar_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Top Bar width control
		$wp_customize->add_control(
			'kubera_settings[top_bar_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Inner Width', 'kubera' ),
				'section' => 'kubera_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'kubera' ),
					'contained' => __( 'Contained', 'kubera' )
				),
				'settings' => 'kubera_settings[top_bar_inner_width]',
				'priority' => 10,
				'active_callback' => 'kubera_is_top_bar_active',
			)
		);

		// Add top bar alignment
		$wp_customize->add_setting(
			'kubera_settings[top_bar_alignment]',
			array(
				'default' => $defaults['top_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[top_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Alignment', 'kubera' ),
				'section' => 'kubera_top_bar',
				'choices' => array(
					'left' => __( 'Left', 'kubera' ),
					'center' => __( 'Center', 'kubera' ),
					'right' => __( 'Right', 'kubera' )
				),
				'settings' => 'kubera_settings[top_bar_alignment]',
				'priority' => 15,
				'active_callback' => 'kubera_is_top_bar_active',
			)
		);

		// Add Header section
		$wp_customize->add_section(
			'kubera_layout_header',
			array(
				'title' => __( 'Header', 'kubera' ),
				'priority' => 20,
				'panel' => 'kubera_layout_panel'
			)
		);

		// Add Header Layout setting
		$wp_customize->add_setting(
			'kubera_settings[header_layout_setting]',
			array(
				'default' => $defaults['header_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Header Layout control
		$wp_customize->add_control(
			'kubera_settings[header_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Header Width', 'kubera' ),
				'section' => 'kubera_layout_header',
				'choices' => array(
					'fluid-header' => __( 'Full', 'kubera' ),
					'contained-header' => __( 'Contained', 'kubera' )
				),
				'settings' => 'kubera_settings[header_layout_setting]',
				'priority' => 5
			)
		);

		// Add Inside Header Layout setting
		$wp_customize->add_setting(
			'kubera_settings[header_inner_width]',
			array(
				'default' => $defaults['header_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Header Layout control
		$wp_customize->add_control(
			'kubera_settings[header_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Header Width', 'kubera' ),
				'section' => 'kubera_layout_header',
				'choices' => array(
					'contained' => __( 'Contained', 'kubera' ),
					'full-width' => __( 'Full', 'kubera' )
				),
				'settings' => 'kubera_settings[header_inner_width]',
				'priority' => 6
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[header_alignment_setting]',
			array(
				'default' => $defaults['header_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[header_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Header Alignment', 'kubera' ),
				'section' => 'kubera_layout_header',
				'choices' => array(
					'left' => __( 'Left', 'kubera' ),
					'center' => __( 'Center', 'kubera' ),
					'right' => __( 'Right', 'kubera' )
				),
				'settings' => 'kubera_settings[header_alignment_setting]',
				'priority' => 10
			)
		);

		$wp_customize->add_section(
			'kubera_layout_navigation',
			array(
				'title' => __( 'Primary Navigation', 'kubera' ),
				'priority' => 30,
				'panel' => 'kubera_layout_panel'
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[nav_layout_setting]',
			array(
				'default' => $defaults['nav_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[nav_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Width', 'kubera' ),
				'section' => 'kubera_layout_navigation',
				'choices' => array(
					'fluid-nav' => __( 'Full', 'kubera' ),
					'contained-nav' => __( 'Contained', 'kubera' )
				),
				'settings' => 'kubera_settings[nav_layout_setting]',
				'priority' => 15
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[nav_inner_width]',
			array(
				'default' => $defaults['nav_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[nav_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Navigation Width', 'kubera' ),
				'section' => 'kubera_layout_navigation',
				'choices' => array(
					'contained' => __( 'Contained', 'kubera' ),
					'full-width' => __( 'Full', 'kubera' )
				),
				'settings' => 'kubera_settings[nav_inner_width]',
				'priority' => 16
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[nav_alignment_setting]',
			array(
				'default' => $defaults['nav_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[nav_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Alignment', 'kubera' ),
				'section' => 'kubera_layout_navigation',
				'choices' => array(
					'left' => __( 'Left', 'kubera' ),
					'center' => __( 'Center', 'kubera' ),
					'right' => __( 'Right', 'kubera' )
				),
				'settings' => 'kubera_settings[nav_alignment_setting]',
				'priority' => 20
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[nav_position_setting]',
			array(
				'default' => $defaults['nav_position_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => ( '' !== kubera_get_setting( 'nav_position_setting' ) ) ? 'postMessage' : 'refresh'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[nav_position_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Location', 'kubera' ),
				'section' => 'kubera_layout_navigation',
				'choices' => array(
					'nav-below-header' => __( 'Below Header', 'kubera' ),
					'nav-above-header' => __( 'Above Header', 'kubera' ),
					'nav-float-right' => __( 'Float Right', 'kubera' ),
					'nav-float-left' => __( 'Float Left', 'kubera' ),
					'nav-left-sidebar' => __( 'Left Sidebar', 'kubera' ),
					'nav-right-sidebar' => __( 'Right Sidebar', 'kubera' ),
					'' => __( 'No Navigation', 'kubera' )
				),
				'settings' => 'kubera_settings[nav_position_setting]',
				'priority' => 22
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[nav_dropdown_type]',
			array(
				'default' => $defaults['nav_dropdown_type'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[nav_dropdown_type]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Dropdown', 'kubera' ),
				'section' => 'kubera_layout_navigation',
				'choices' => array(
					'hover' => __( 'Hover', 'kubera' ),
					'click' => __( 'Click - Menu Item', 'kubera' ),
					'click-arrow' => __( 'Click - Arrow', 'kubera' )
				),
				'settings' => 'kubera_settings[nav_dropdown_type]',
				'priority' => 22
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[nav_search]',
			array(
				'default' => $defaults['nav_search'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[nav_search]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Search', 'kubera' ),
				'section' => 'kubera_layout_navigation',
				'choices' => array(
					'enable' => __( 'Enable', 'kubera' ),
					'disable' => __( 'Disable', 'kubera' )
				),
				'settings' => 'kubera_settings[nav_search]',
				'priority' => 23
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'kubera_settings[nav_effect]',
			array(
				'default' => $defaults['nav_effect'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'kubera_settings[nav_effect]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Effects', 'kubera' ),
				'section' => 'kubera_layout_navigation',
				'choices' => array(
					'none' => __( 'None', 'kubera' ),
					'stylea' => __( 'Brackets', 'kubera' ),
					'styleb' => __( 'Borders', 'kubera' ),
					'stylec' => __( 'Switch', 'kubera' ),
					'styled' => __( 'Fall down', 'kubera' )
				),
				'settings' => 'kubera_settings[nav_effect]',
				'priority' => 24
			)
		);

		// Add content setting
		$wp_customize->add_setting(
			'kubera_settings[content_layout_setting]',
			array(
				'default' => $defaults['content_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add content control
		$wp_customize->add_control(
			'kubera_settings[content_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Content Layout', 'kubera' ),
				'section' => 'kubera_layout_container',
				'choices' => array(
					'separate-containers' => __( 'Separate Containers', 'kubera' ),
					'one-container' => __( 'One Container', 'kubera' )
				),
				'settings' => 'kubera_settings[content_layout_setting]',
				'priority' => 25
			)
		);

		$wp_customize->add_section(
			'kubera_layout_sidecontent',
			array(
				'title' => __( 'Fixed Side Content', 'kubera' ),
				'priority' => 39,
				'panel' => 'kubera_layout_panel'
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[fixed_side_content]',
			array(
				'default' => $defaults['fixed_side_content'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[fixed_side_content]',
			array(
				'type' 		 => 'textarea',
				'label'      => __( 'Fixed Side Content', 'kubera' ),
				'description'=> __( 'Content that You want to display fixed on the left.', 'kubera' ),
				'section'    => 'kubera_layout_sidecontent',
				'settings'   => 'kubera_settings[fixed_side_content]',
			)
		);

		$wp_customize->add_section(
			'kubera_layout_sidebars',
			array(
				'title' => __( 'Sidebars', 'kubera' ),
				'priority' => 40,
				'panel' => 'kubera_layout_panel'
			)
		);

		// Add Layout setting
		$wp_customize->add_setting(
			'kubera_settings[layout_setting]',
			array(
				'default' => $defaults['layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices'
			)
		);

		// Add Layout control
		$wp_customize->add_control(
			'kubera_settings[layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Sidebar Layout', 'kubera' ),
				'section' => 'kubera_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'kubera' ),
					'right-sidebar' => __( 'Content / Sidebar', 'kubera' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'kubera' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'kubera' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'kubera' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'kubera' )
				),
				'settings' => 'kubera_settings[layout_setting]',
				'priority' => 30
			)
		);

		// Add Layout setting
		$wp_customize->add_setting(
			'kubera_settings[blog_layout_setting]',
			array(
				'default' => $defaults['blog_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices'
			)
		);

		// Add Layout control
		$wp_customize->add_control(
			'kubera_settings[blog_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Blog Sidebar Layout', 'kubera' ),
				'section' => 'kubera_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'kubera' ),
					'right-sidebar' => __( 'Content / Sidebar', 'kubera' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'kubera' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'kubera' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'kubera' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'kubera' )
				),
				'settings' => 'kubera_settings[blog_layout_setting]',
				'priority' => 35
			)
		);

		// Add Layout setting
		$wp_customize->add_setting(
			'kubera_settings[single_layout_setting]',
			array(
				'default' => $defaults['single_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices'
			)
		);

		// Add Layout control
		$wp_customize->add_control(
			'kubera_settings[single_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Single Post Sidebar Layout', 'kubera' ),
				'section' => 'kubera_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'kubera' ),
					'right-sidebar' => __( 'Content / Sidebar', 'kubera' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'kubera' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'kubera' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'kubera' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'kubera' )
				),
				'settings' => 'kubera_settings[single_layout_setting]',
				'priority' => 36
			)
		);

		$wp_customize->add_section(
			'kubera_layout_footer',
			array(
				'title' => __( 'Footer', 'kubera' ),
				'priority' => 50,
				'panel' => 'kubera_layout_panel'
			)
		);

		// Add footer setting
		$wp_customize->add_setting(
			'kubera_settings[footer_layout_setting]',
			array(
				'default' => $defaults['footer_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add content control
		$wp_customize->add_control(
			'kubera_settings[footer_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Width', 'kubera' ),
				'section' => 'kubera_layout_footer',
				'choices' => array(
					'fluid-footer' => __( 'Full', 'kubera' ),
					'contained-footer' => __( 'Contained', 'kubera' )
				),
				'settings' => 'kubera_settings[footer_layout_setting]',
				'priority' => 40
			)
		);

		// Add footer setting
		$wp_customize->add_setting(
			'kubera_settings[footer_widgets_inner_width]',
			array(
				'default' => $defaults['footer_widgets_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
			)
		);

		// Add content control
		$wp_customize->add_control(
			'kubera_settings[footer_widgets_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Footer Widgets Width', 'kubera' ),
				'section' => 'kubera_layout_footer',
				'choices' => array(
					'contained' => __( 'Contained', 'kubera' ),
					'full-width' => __( 'Full', 'kubera' )
				),
				'settings' => 'kubera_settings[footer_widgets_inner_width]',
				'priority' => 41
			)
		);

		// Add footer setting
		$wp_customize->add_setting(
			'kubera_settings[footer_inner_width]',
			array(
				'default' => $defaults['footer_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add content control
		$wp_customize->add_control(
			'kubera_settings[footer_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Footer Width', 'kubera' ),
				'section' => 'kubera_layout_footer',
				'choices' => array(
					'contained' => __( 'Contained', 'kubera' ),
					'full-width' => __( 'Full', 'kubera' )
				),
				'settings' => 'kubera_settings[footer_inner_width]',
				'priority' => 41
			)
		);

		// Add footer widget setting
		$wp_customize->add_setting(
			'kubera_settings[footer_widget_setting]',
			array(
				'default' => $defaults['footer_widget_setting'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add footer widget control
		$wp_customize->add_control(
			'kubera_settings[footer_widget_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Widgets', 'kubera' ),
				'section' => 'kubera_layout_footer',
				'choices' => array(
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5'
				),
				'settings' => 'kubera_settings[footer_widget_setting]',
				'priority' => 45
			)
		);

		// Add footer widget setting
		$wp_customize->add_setting(
			'kubera_settings[footer_bar_alignment]',
			array(
				'default' => $defaults['footer_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add footer widget control
		$wp_customize->add_control(
			'kubera_settings[footer_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Bar Alignment', 'kubera' ),
				'section' => 'kubera_layout_footer',
				'choices' => array(
					'left' => __( 'Left','kubera' ),
					'center' => __( 'Center','kubera' ),
					'right' => __( 'Right','kubera' )
				),
				'settings' => 'kubera_settings[footer_bar_alignment]',
				'priority' => 47,
				'active_callback' => 'kubera_is_footer_bar_active'
			)
		);

		// Add back to top setting
		$wp_customize->add_setting(
			'kubera_settings[back_to_top]',
			array(
				'default' => $defaults['back_to_top'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_choices'
			)
		);

		// Add content control
		$wp_customize->add_control(
			'kubera_settings[back_to_top]',
			array(
				'type' => 'select',
				'label' => __( 'Back to Top Button', 'kubera' ),
				'section' => 'kubera_layout_footer',
				'choices' => array(
					'enable' => __( 'Enable', 'kubera' ),
					'' => __( 'Disable', 'kubera' )
				),
				'settings' => 'kubera_settings[back_to_top]',
				'priority' => 50
			)
		);

		// Add Layout section
		$wp_customize->add_section(
			'kubera_blog_section',
			array(
				'title' => __( 'Blog', 'kubera' ),
				'priority' => 55,
				'panel' => 'kubera_layout_panel'
			)
		);

		$wp_customize->add_setting(
			'kubera_settings[blog_header_image]',
			array(
				'default' => $defaults['blog_header_image'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'kubera_settings[blog_header_image]',
				array(
					'label' => __( 'Blog Header image', 'kubera' ),
					'section' => 'kubera_blog_section',
					'settings' => 'kubera_settings[blog_header_image]',
					'description' => __( 'Recommended size: 1920*930px', 'kubera' )
				)
			)
		);

		// Blog header texts
		$wp_customize->add_setting(
			'kubera_settings[blog_header_title]',
			array(
				'default' => $defaults['blog_header_title'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[blog_header_title]',
			array(
				'type' 		 => 'textarea',
				'label'      => __( 'Blog Header title', 'kubera' ),
				'section'    => 'kubera_blog_section',
				'settings'   => 'kubera_settings[blog_header_title]',
				'description' => __( 'HTML allowed.', 'kubera' )
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[blog_header_text]',
			array(
				'default' => $defaults['blog_header_text'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[blog_header_text]',
			array(
				'type' 		 => 'textarea',
				'label'      => __( 'Blog Header text', 'kubera' ),
				'section'    => 'kubera_blog_section',
				'settings'   => 'kubera_settings[blog_header_text]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[blog_header_button_text]',
			array(
				'default' => $defaults['blog_header_button_text'],
				'type' => 'option',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[blog_header_button_text]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Blog Header button text', 'kubera' ),
				'section'    => 'kubera_blog_section',
				'settings'   => 'kubera_settings[blog_header_button_text]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[blog_header_button_url]',
			array(
				'default' => $defaults['blog_header_button_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[blog_header_button_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Blog Header button url', 'kubera' ),
				'section'    => 'kubera_blog_section',
				'settings'   => 'kubera_settings[blog_header_button_url]',
			)
		);

		// Add Layout setting
		$wp_customize->add_setting(
			'kubera_settings[post_content]',
			array(
				'default' => $defaults['post_content'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_blog_excerpt'
			)
		);

		// Add Layout control
		$wp_customize->add_control(
			'blog_content_control',
			array(
				'type' => 'select',
				'label' => __( 'Content Type', 'kubera' ),
				'section' => 'kubera_blog_section',
				'choices' => array(
					'full' => __( 'Full', 'kubera' ),
					'excerpt' => __( 'Excerpt', 'kubera' )
				),
				'settings' => 'kubera_settings[post_content]',
				'priority' => 10
			)
		);

		if ( ! function_exists( 'kubera_blog_customize_register' ) && ! defined( 'KUBERA_PREMIUM_VERSION' ) ) {
			$wp_customize->add_control(
				new Kubera_Customize_Misc_Control(
					$wp_customize,
					'blog_get_addon_desc',
					array(
						'section' => 'kubera_blog_section',
						'type' => 'addon',
						'label' => __( 'Learn more', 'kubera' ),
						'description' => __( 'More options are available for this section in our premium version.', 'kubera' ),
						'url' => esc_url( KUBERA_THEME_URL ),
						'priority' => 30,
						'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname'
					)
				)
			);
		}

		// Add Performance section
		$wp_customize->add_section(
			'kubera_general_section',
			array(
				'title' => __( 'General', 'kubera' ),
				'priority' => 99
			)
		);

		if ( ! apply_filters( 'kubera_fontawesome_essentials', false ) ) {
			$wp_customize->add_setting(
				'kubera_settings[font_awesome_essentials]',
				array(
					'default' => $defaults['font_awesome_essentials'],
					'type' => 'option',
					'sanitize_callback' => 'kubera_sanitize_checkbox'
				)
			);

			$wp_customize->add_control(
				'kubera_settings[font_awesome_essentials]',
				array(
					'type' => 'checkbox',
					'label' => __( 'Load essential icons only', 'kubera' ),
					'description' => __( 'Load essential Font Awesome icons instead of the full library.', 'kubera' ),
					'section' => 'kubera_general_section',
					'settings' => 'kubera_settings[font_awesome_essentials]',
				)
			);
		}

		// Add Socials section
		$wp_customize->add_section(
			'kubera_socials_section',
			array(
				'title' => __( 'Socials', 'kubera' ),
				'priority' => 99
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_display_side]',
			array(
				'default' => $defaults['socials_display_side'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_display_side]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Display on fixed side', 'kubera' ),
				'section' => 'kubera_socials_section'
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_display_top]',
			array(
				'default' => $defaults['socials_display_top'],
				'type' => 'option',
				'sanitize_callback' => 'kubera_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_display_top]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Display on top bar', 'kubera' ),
				'section' => 'kubera_socials_section'
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_facebook_url]',
			array(
				'default' => $defaults['socials_facebook_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_facebook_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Facebook url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_facebook_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_twitter_url]',
			array(
				'default' => $defaults['socials_twitter_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_twitter_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Twitter url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_twitter_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_google_url]',
			array(
				'default' => $defaults['socials_google_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_google_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Google url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_google_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_tumblr_url]',
			array(
				'default' => $defaults['socials_tumblr_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_tumblr_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Tumblr url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_tumblr_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_pinterest_url]',
			array(
				'default' => $defaults['socials_pinterest_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_pinterest_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Pinterest url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_pinterest_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_youtube_url]',
			array(
				'default' => $defaults['socials_youtube_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_youtube_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Youtube url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_youtube_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_linkedin_url]',
			array(
				'default' => $defaults['socials_linkedin_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_linkedin_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Linkedin url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_linkedin_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_linkedin_url]',
			array(
				'default' => $defaults['socials_linkedin_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_linkedin_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Linkedin url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_linkedin_url]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_custom_icon_1]',
			array(
				'default' => $defaults['socials_custom_icon_1'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_custom_icon_1]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 1', 'kubera' ),
				'description'=> sprintf( 
					'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
					esc_html__( 'You can add icon code for Your button.', 'kubera' ),
					esc_html__( 'Example: ', 'kubera' ),
					esc_html__( 'Use the codes from ', 'kubera' ),
					esc_url( KUBERA_FONT_AWESOME_LINK ),
					esc_html__( 'Font Awesome', 'kubera' )
				),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_custom_icon_1]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_custom_icon_url_1]',
			array(
				'default' => $defaults['socials_custom_icon_url_1'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_custom_icon_url_1]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 1 url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_custom_icon_url_1]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_custom_icon_2]',
			array(
				'default' => $defaults['socials_custom_icon_2'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_custom_icon_2]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 2', 'kubera' ),
				'description'=> sprintf( 
					'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
					esc_html__( 'You can add icon code for Your button.', 'kubera' ),
					esc_html__( 'Example: ', 'kubera' ),
					esc_html__( 'Use the codes from ', 'kubera' ),
					esc_url( KUBERA_FONT_AWESOME_LINK ),
					esc_html__( 'Font Awesome', 'kubera' )
				),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_custom_icon_2]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_custom_icon_url_2]',
			array(
				'default' => $defaults['socials_custom_icon_url_2'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_custom_icon_url_2]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 2 url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_custom_icon_url_2]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_custom_icon_3]',
			array(
				'default' => $defaults['socials_custom_icon_3'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_custom_icon_3]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 3', 'kubera' ),
				'description'=> sprintf( 
					'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
					esc_html__( 'You can add icon code for Your button.', 'kubera' ),
					esc_html__( 'Example: ', 'kubera' ),
					esc_html__( 'Use the codes from ', 'kubera' ),
					esc_url( KUBERA_FONT_AWESOME_LINK ),
					esc_html__( 'Font Awesome', 'kubera' )
				),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_custom_icon_3]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_custom_icon_url_3]',
			array(
				'default' => $defaults['socials_custom_icon_url_3'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_custom_icon_url_3]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 3 url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_custom_icon_url_3]',
			)
		);
		
		$wp_customize->add_setting(
			'kubera_settings[socials_mail_url]',
			array(
				'default' => $defaults['socials_mail_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_control(
			'kubera_settings[socials_mail_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'E-mail url', 'kubera' ),
				'section'    => 'kubera_socials_section',
				'settings'   => 'kubera_settings[socials_mail_url]',
			)
		);

		// Add Kubera Premium section
		if ( ! defined( 'KUBERA_PREMIUM_VERSION' ) ) {
			$wp_customize->add_section(
				new Kubera_Upsell_Section( $wp_customize, 'kubera_upsell_section',
					array(
						'pro_text' => __( 'Get Premium for more!', 'kubera' ),
						'pro_url' => esc_url( KUBERA_THEME_URL ),
						'capability' => 'edit_theme_options',
						'priority' => 555,
						'type' => 'kubera-upsell-section',
					)
				)
			);
		}
	}
}

if ( ! function_exists( 'kubera_customizer_live_preview' ) ) {
	add_action( 'customize_preview_init', 'kubera_customizer_live_preview', 100 );
	/**
	 * Add our live preview scripts
	 *
	 */
	function kubera_customizer_live_preview() {
		wp_enqueue_script( 'kubera-themecustomizer', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/controls/js/customizer-live-preview.js', array( 'customize-preview' ), KUBERA_VERSION, true );
	}
}
