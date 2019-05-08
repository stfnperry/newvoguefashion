<?php
/**
 * Moral Theme Customizer
 *
 * @package Moral
 */

/**
 * Get all the default values of the theme mods.
 */
function blog_lover_get_default_mods() {
	$blog_lover_default_mods = array(
		// Sliders
		'blog_lover_slider_custom_btn' => esc_html__( 'Know More', 'blog-lover' ),

		// Featured
		'blog_lover_featured_first_read_more' => esc_html__( 'Discover More', 'blog-lover' ),

		// Recent posts
		'blog_lover_recent_posts_more' => esc_html__( 'Discover More', 'blog-lover' ),

		// Hero sliders
		'blog_lover_hero_slider_custom_btn' => esc_html__( 'Discover More', 'blog-lover' ),
	);

	return apply_filters( 'blog_lover_default_mods', $blog_lover_default_mods );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blog_lover_customize_register( $wp_customize ) {
	/**
	 * Separator custom control
	 *
	 * @version 1.0.0
	 * @since  1.0.0
	 */
	class Blog_Lover_Separator_Custom_Control extends WP_Customize_Control {
		/**
		 * Control type
		 *
		 * @var string
		 */
		public $type = 'blog-lover-separator';
		/**
		 * Control method
		 *
		 * @since 1.0.0
		 */
		public function render_content() {
			?>
			<p><hr style="border-color: #222; opacity: 0.2;"></p>
			<?php
		}
	}

	/**
	 * The radio image customize control extends the WP_Customize_Control class.  This class allows
	 * developers to create a list of image radio inputs.
	 *
	 * Note, the `$choices` array is slightly different than normal and should be in the form of
	 * `array(
		 *	$value => array( 'color' => $color_value ),
		 *	$value => array( 'color' => $color_value ),
	 * )`
	 *
	 */

	/**
	 * Radio color customize control.
	 *
	 * @since  3.0.0
	 * @access public
	 */
	class Blog_Lover_Customize_Control_Radio_Color extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered.
		 *
		 * @since  3.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'radio-color';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  3.0.0
		 * @access public
		 * @return void
		 */
		public function to_json() {
			parent::to_json();

			// We need to make sure we have the correct color URL.
			foreach ( $this->choices as $value => $args )
				$this->choices[ $value ]['color'] = esc_attr( $args['color'] );

			$this->json['choices'] = $this->choices;
			$this->json['link']    = $this->get_link();
			$this->json['value']   = $this->value();
			$this->json['id']      = $this->id;
		}

		/**
		 * Don't render the content via PHP.  This control is handled with a JS template.
		 *
		 * @since  4.0.0
		 * @access public
		 * @return bool
		 */
		protected function render_content() {}

		/**
		 * Underscore JS template to handle the control's output.
		 *
		 * @since  3.0.0
		 * @access public
		 * @return void
		 */
		public function content_template() { ?>

			<# if ( ! data.choices ) {
				return;
			} #>

			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<# _.each( data.choices, function( args, choice ) { #>
				<label>
					<input type="radio" value="{{ choice }}" name="_customize-{{ data.type }}-{{ data.id }}" {{{ data.link }}} <# if ( choice === data.value ) { #> checked="checked" <# } #> />

					<span class="screen-reader-text">{{ args.label }}</span>
					
					<# if ( 'custom' != choice ) { #>
						<span class="color-value" style="background-color: {{ args.color }}"></span>
					<# } else { #>
						<span class="color-value custom-color-value"></span>
					<# } #>
				</label>
			<# } ) #>
		<?php }
	}

	$wp_customize->register_control_type( 'Blog_Lover_Customize_Control_Radio_Color'       );

	$default = blog_lover_get_default_mods();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'blog_lover_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'blog_lover_customize_partial_blogdescription',
		) );
	}

	/**
	 *
	 * 
	 * Header panel
	 *
	 * 
	 */
	// Header panel
	$wp_customize->add_panel(
		'blog_lover_header_panel',
		array(
			'title' => esc_html__( 'Header', 'blog-lover' ),
			'priority' => 100
		)
	);

	$wp_customize->get_section( 'title_tagline' )->panel         = 'blog_lover_header_panel';

	// Header text display setting
	$wp_customize->add_setting(	
		'blog_lover_header_text_display',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'blog_lover_header_text_display',
		array(
			'section'		=> 'title_tagline',
			'type'			=> 'checkbox',
			'label'			=> esc_html__( 'Display Site Title and Tagline', 'blog-lover' ),
		)
	);

	// Header section
	$wp_customize->add_section(
		'blog_lover_header_section',
		array(
			'title' => esc_html__( 'Header', 'blog-lover' ),
			'panel' => 'blog_lover_header_panel',
		)
	);

	// Header search form settings
	$wp_customize->add_setting(
		'blog_lover_show_search',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true
		)
	);

	$wp_customize->add_control(
		'blog_lover_show_search',
		array(
			'section'		=> 'blog_lover_header_section',
			'label'			=> esc_html__( 'Show search.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 *
	 * 
	 * Home sections panel
	 *
	 * 
	 */
	// Home sections panel
	$wp_customize->add_panel(
		'blog_lover_home_panel',
		array(
			'title' => esc_html__( 'Homepage', 'blog-lover' ),
			'priority' => 105
		)
	);

	$wp_customize->get_section( 'static_front_page' )->panel         = 'blog_lover_home_panel';

	// Your latest posts title setting
	$wp_customize->add_setting(	
		'blog_lover_your_latest_posts_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'Blogs', 'blog-lover' ),
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'blog_lover_your_latest_posts_title',
		array(
			'section'		=> 'static_front_page',
			'label'			=> esc_html__( 'Title:', 'blog-lover' ),
			'active_callback' => 'blog_lover_is_latest_posts'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'blog_lover_your_latest_posts_title', 
		array(
	        'selector'            => '.home.blog #page-header .page-title',
			'render_callback'     => 'blog_lover_your_latest_posts_partial_title',
    	) 
    );

	/**
	 * Slider section
	 */
	// Slider section
	$wp_customize->add_section(
		'blog_lover_slider',
		array(
			'title' => esc_html__( 'Banner Slider', 'blog-lover' ),
			'panel' => 'blog_lover_home_panel',
		)
	);

	// Slider enable settings
	$wp_customize->add_setting(
		'blog_lover_slider',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'blog_lover_slider',
		array(
			'section'		=> 'blog_lover_slider',
			'label'			=> esc_html__( 'Content type:', 'blog-lover' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'blog-lover' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'blog-lover' ),
					'post' => esc_html__( 'Post', 'blog-lover' ),
					'page' => esc_html__( 'Page', 'blog-lover' ),
			 	)
		)
	);

	$slider_num = 3;
	for ( $i=1; $i <= $slider_num; $i++ ) { 
		// Slider custom name setting
		$wp_customize->add_setting(
			'blog_lover_slider_custom_btn_' . $i,
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default' => $default['blog_lover_slider_custom_btn'],
			)
		);

		$wp_customize->add_control(
			'blog_lover_slider_custom_btn_' . $i,
			array(
				'section'		=> 'blog_lover_slider',
				'label'			=> esc_html__( 'Button text ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_slider_not_disabled'
			)
		);

		// Slider post setting
		$wp_customize->add_setting(
			'blog_lover_slider_post_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'blog_lover_slider_post_' . $i,
			array(
				'section'		=> 'blog_lover_slider',
				'label'			=> esc_html__( 'Post ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_slider_post',
				'type'			=> 'select',
				'choices'		=> blog_lover_get_post_choices(),
			)
		);
		
		// Slider page setting
		$wp_customize->add_setting(
			'blog_lover_slider_page_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'blog_lover_slider_page_' . $i,
			array(
				'section'		=> 'blog_lover_slider',
				'label'			=> esc_html__( 'Page ', 'blog-lover' ) . $i,
				'type'			=> 'dropdown-pages',
				'active_callback' => 'blog_lover_if_slider_page'
			)
		);
		
		// Slider custom separator setting
		$wp_customize->add_setting(
			'blog_lover_slider_custom_separator_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new Blog_Lover_Separator_Custom_Control( 
			$wp_customize,
			'blog_lover_slider_custom_separator_' . $i,
				array(
					'section'		=> 'blog_lover_slider',
					'active_callback' => 'blog_lover_if_slider_not_disabled',
					'type'			=> 'blog-lover-separator',
				)
			)
		);
	}

	/**
	 * Latest news section
	 */
	// Latest news section
	$wp_customize->add_section(
		'blog_lover_latest',
		array(
			'title' => esc_html__( 'Latest news', 'blog-lover' ),
			'panel' => 'blog_lover_home_panel',
		)
	);

	// Latest news enable settings
	$wp_customize->add_setting(
		'blog_lover_latest',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'blog_lover_latest',
		array(
			'section'		=> 'blog_lover_latest',
			'label'			=> esc_html__( 'Content type:', 'blog-lover' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'blog-lover' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'blog-lover' ),
					'post' => esc_html__( 'Post', 'blog-lover' ),
					'page' => esc_html__( 'Page', 'blog-lover' ),
			 	)
		)
	);

	$latest_num = 3;
	for ( $i=1; $i <= $latest_num; $i++ ) { 
		// Latest news post setting
		$wp_customize->add_setting(
			'blog_lover_latest_post_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'blog_lover_latest_post_' . $i,
			array(
				'section'		=> 'blog_lover_latest',
				'label'			=> esc_html__( 'Post ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_latest_post',
				'type'			=> 'select',
				'choices'		=> blog_lover_get_post_choices(),
			)
		);

		// Latest news page setting
		$wp_customize->add_setting(
			'blog_lover_latest_page_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'blog_lover_latest_page_' . $i,
			array(
				'section'		=> 'blog_lover_latest',
				'label'			=> esc_html__( 'Page ', 'blog-lover' ) . $i,
				'type'			=> 'dropdown-pages',
				'active_callback' => 'blog_lover_if_latest_page'
			)
		);

		// Latest news separator setting
		$wp_customize->add_setting(
			'blog_lover_latest_separator_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new Blog_Lover_Separator_Custom_Control( 
			$wp_customize,
			'blog_lover_latest_separator_' . $i,
				array(
					'section'		=> 'blog_lover_latest',
					'active_callback' => 'blog_lover_if_latest_not_disabled',
					'type'			=> 'blog-lover-separator',
				)
			)
		);
	}

	/**
	 * Featured section
	 */
	// Featured section
	$wp_customize->add_section(
		'blog_lover_featured',
		array(
			'title' => esc_html__( 'Featured', 'blog-lover' ),
			'panel' => 'blog_lover_home_panel',
		)
	);

	// Featured enable settings
	$wp_customize->add_setting(
		'blog_lover_featured',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'blog_lover_featured',
		array(
			'section'		=> 'blog_lover_featured',
			'label'			=> esc_html__( 'Content type:', 'blog-lover' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'blog-lover' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'blog-lover' ),
					'post' => esc_html__( 'Post', 'blog-lover' ),
					'page' => esc_html__( 'Page', 'blog-lover' ),
			 	)
		)
	);

	$featured_num = 7;
	for ( $i=1; $i <= $featured_num; $i++ ) { 
		if ( 1 === $i ) {
			// Featured custom sub title setting
			$wp_customize->add_setting(
				'blog_lover_featured_first_read_more_' . $i,
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default' => $default['blog_lover_featured_first_read_more'],
				)
			);

			$wp_customize->add_control(
				'blog_lover_featured_first_read_more_' . $i,
				array(
					'section'		=> 'blog_lover_featured',
					'label'			=> esc_html__( 'Read more ', 'blog-lover' ),
					'active_callback' => 'blog_lover_if_featured_not_disabled'
				)
			);
		}

		// Featured post setting
		$wp_customize->add_setting(
			'blog_lover_featured_post_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'blog_lover_featured_post_' . $i,
			array(
				'section'		=> 'blog_lover_featured',
				'label'			=> esc_html__( 'Post ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_featured_post',
				'type'			=> 'select',
				'choices'		=> blog_lover_get_post_choices(),
			)
		);

		// Featured page setting
		$wp_customize->add_setting(
			'blog_lover_featured_page_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'blog_lover_featured_page_' . $i,
			array(
				'section'		=> 'blog_lover_featured',
				'label'			=> esc_html__( 'Page ', 'blog-lover' ) . $i,
				'type'			=> 'dropdown-pages',
				'active_callback' => 'blog_lover_if_featured_page'
			)
		);

		// Featured separator setting
		$wp_customize->add_setting(
			'blog_lover_featured_separator_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new Blog_Lover_Separator_Custom_Control( 
			$wp_customize,
			'blog_lover_featured_separator_' . $i,
				array(
					'section'		=> 'blog_lover_featured',
					'active_callback' => 'blog_lover_if_featured_not_disabled',
					'type'			=> 'blog-lover-separator',
				)
			)
		);
	}

	/**
	 * Video section
	 */
	// Video section
	$wp_customize->add_section(
		'blog_lover_video',
		array(
			'title' => esc_html__( 'Video', 'blog-lover' ),
			'panel' => 'blog_lover_home_panel',
		)
	);

	// Video enable settings
	$wp_customize->add_setting(
		'blog_lover_video',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'blog_lover_video',
		array(
			'section'		=> 'blog_lover_video',
			'label'			=> esc_html__( 'Content type:', 'blog-lover' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'blog-lover' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'blog-lover' ),
					'post' => esc_html__( 'Post', 'blog-lover' ),
			 	)
		)
	);

	// Video post setting
	$wp_customize->add_setting(
		'blog_lover_video_post',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'blog_lover_video_post',
		array(
			'section'		=> 'blog_lover_video',
			'label'			=> esc_html__( 'Post:', 'blog-lover' ),
			'active_callback' => 'blog_lover_if_video_post',
			'type'			=> 'select',
			'choices'		=> blog_lover_get_post_choices(),
		)
	);

	// Video link setting
	$wp_customize->add_setting(
		'blog_lover_video_link',
		array(
			'sanitize_callback' => 'esc_url_raw',
			'default' => '#',
		)
	);

	$wp_customize->add_control(
		'blog_lover_video_link',
		array(
			'section'		=> 'blog_lover_video',
			'label'			=> esc_html__( 'Video Link:', 'blog-lover' ),
			'type'			=> 'url',
			'active_callback' => 'blog_lover_if_video_enabled'
		)
	);

	/**
	 * Recent posts section
	 */
	// Recent posts section
	$wp_customize->add_section(
		'blog_lover_recent_posts',
		array(
			'title' => esc_html__( 'Recent posts', 'blog-lover' ),
			'description' => sprintf( __( '%1$sUse case:%2$s This section uses the %3$sHomepage: Recent News Section Sidebar%4$s for sidebar.', 'blog-lover' ), '<strong>', '</strong>', '<a href="" data-open="blog-lover-recent-posts">', '</a>' ),
			'panel' => 'blog_lover_home_panel',
		)
	);

	// Recent posts enable settings
	$wp_customize->add_setting(
		'blog_lover_recent_posts',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'post'
		)
	);

	$wp_customize->add_control(
		'blog_lover_recent_posts',
		array(
			'section'		=> 'blog_lover_recent_posts',
			'label'			=> esc_html__( 'Content type:', 'blog-lover' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'blog-lover' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'blog-lover' ),
					'post' => esc_html__( 'Post', 'blog-lover' ),
					'page' => esc_html__( 'Page', 'blog-lover' ),
					'cat' => esc_html__( 'Category', 'blog-lover' ),
			 	)
		)
	);

	// Recent posts image position option.
	$wp_customize->add_setting(	
		'blog_lover_recent_posts_image_position',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'left',
		)
	);

	$wp_customize->add_control(
		'blog_lover_recent_posts_image_position',
		array(
			'section'		=> 'blog_lover_recent_posts',
			'type'			=> 'radio',
			'active_callback' => 'blog_lover_if_recent_posts_not_disabled',
			'label'			=> esc_html__( 'Image position', 'blog-lover' ),
			'choices'		=> array( 
									'left' => esc_html__( 'Left', 'blog-lover' ), 
									'right' => esc_html__( 'Right', 'blog-lover' ), 
								),
		)
	);

	// Recent posts category setting
	$wp_customize->add_setting(
		'blog_lover_recent_posts_cat',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'blog_lover_recent_posts_cat',
		array(
			'section'		=> 'blog_lover_recent_posts',
			'label'			=> esc_html__( 'Category:', 'blog-lover' ),
			'active_callback' => 'blog_lover_if_recent_posts_cat',
			'type'			=> 'select',
			'choices'		=> blog_lover_get_post_cat_choices(),
		)
	);

	$recent_posts_num = 3;
	for ( $i=1; $i <= $recent_posts_num; $i++ ) { 

		// Recent posts post setting
		$wp_customize->add_setting(
			'blog_lover_recent_posts_post_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'blog_lover_recent_posts_post_' . $i,
			array(
				'section'		=> 'blog_lover_recent_posts',
				'label'			=> esc_html__( 'Post ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_recent_posts_post',
				'type'			=> 'select',
				'choices'		=> blog_lover_get_post_choices(),
			)
		);

		// Recent posts page setting
		$wp_customize->add_setting(
			'blog_lover_recent_posts_page_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'blog_lover_recent_posts_page_' . $i,
			array(
				'section'		=> 'blog_lover_recent_posts',
				'label'			=> esc_html__( 'Page ', 'blog-lover' ) . $i,
				'type'			=> 'dropdown-pages',
				'active_callback' => 'blog_lover_if_recent_posts_page'
			)
		);

		// Recent posts custom link setting
		$wp_customize->add_setting(
			'blog_lover_recent_posts_more_' . $i,
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'		=> $default['blog_lover_recent_posts_more'],
			)
		);

		$wp_customize->add_control(
			'blog_lover_recent_posts_more_' . $i,
			array(
				'section'		=> 'blog_lover_recent_posts',
				'label'			=> esc_html__( 'Read more text ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_recent_posts_not_disabled',
			)
		);

		// Recent posts separator setting
		$wp_customize->add_setting(
			'blog_lover_recent_posts_separator_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new Blog_Lover_Separator_Custom_Control( 
			$wp_customize,
			'blog_lover_recent_posts_separator_' . $i,
				array(
					'section'		=> 'blog_lover_recent_posts',
					'active_callback' => 'blog_lover_if_recent_posts_not_disabled',
					'type'			=> 'blog-lover-separator',
				)
			)
		);
	}
	/**
	 *Hero slider section
	 */
	//Hero slider section
	$wp_customize->add_section(
		'blog_lover_hero_slider',
		array(
			'title' => esc_html__( 'Hero slider', 'blog-lover' ),
			'panel' => 'blog_lover_home_panel',
		)
	);

	//Hero slider enable settings
	$wp_customize->add_setting(
		'blog_lover_hero_slider',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'blog_lover_hero_slider',
		array(
			'section'		=> 'blog_lover_hero_slider',
			'label'			=> esc_html__( 'Content type:', 'blog-lover' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'blog-lover' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'blog-lover' ),
					'post' => esc_html__( 'Post', 'blog-lover' ),
					'page' => esc_html__( 'Page', 'blog-lover' ),
			 	)
		)
	);

	$hero_slider_num = 3;
	for ( $i=1; $i <= $hero_slider_num; $i++ ) { 
		//Hero slider custom name setting
		$wp_customize->add_setting(
			'blog_lover_hero_slider_custom_btn_' . $i,
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default' => $default['blog_lover_hero_slider_custom_btn'],
			)
		);

		$wp_customize->add_control(
			'blog_lover_hero_slider_custom_btn_' . $i,
			array(
				'section'		=> 'blog_lover_hero_slider',
				'label'			=> esc_html__( 'Button text ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_hero_slider_not_disabled'
			)
		);

		//Hero slider post setting
		$wp_customize->add_setting(
			'blog_lover_hero_slider_post_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'blog_lover_hero_slider_post_' . $i,
			array(
				'section'		=> 'blog_lover_hero_slider',
				'label'			=> esc_html__( 'Post ', 'blog-lover' ) . $i,
				'active_callback' => 'blog_lover_if_hero_slider_post',
				'type'			=> 'select',
				'choices'		=> blog_lover_get_post_choices(),
			)
		);
		
		//Hero slider page setting
		$wp_customize->add_setting(
			'blog_lover_hero_slider_page_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_dropdown_pages',
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'blog_lover_hero_slider_page_' . $i,
			array(
				'section'		=> 'blog_lover_hero_slider',
				'label'			=> esc_html__( 'Page ', 'blog-lover' ) . $i,
				'type'			=> 'dropdown-pages',
				'active_callback' => 'blog_lover_if_hero_slider_page'
			)
		);
		
		//Hero slider custom separator setting
		$wp_customize->add_setting(
			'blog_lover_hero_slider_custom_separator_' . $i,
			array(
				'sanitize_callback' => 'blog_lover_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new Blog_Lover_Separator_Custom_Control( 
			$wp_customize,
			'blog_lover_hero_slider_custom_separator_' . $i,
				array(
					'section'		=> 'blog_lover_hero_slider',
					'active_callback' => 'blog_lover_if_hero_slider_not_disabled',
					'type'			=> 'blog-lover-separator',
				)
			)
		);
	}

	/**
	 *
	 * General settings panel
	 * 
	 */
	// General settings panel
	$wp_customize->add_panel(
		'blog_lover_general_panel',
		array(
			'title' => esc_html__( 'Advanced Settings', 'blog-lover' ),
			'priority' => 107
		)
	);

	$wp_customize->get_section( 'colors' )->panel         = 'blog_lover_general_panel';
	
	// Header title color setting
	$wp_customize->add_setting(	
		'blog_lover_header_title_color',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_hex_color',
			'default' => '#cf3140',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'blog_lover_header_title_color',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site title Color:', 'blog-lover' ),
			)
		)
	);

	// Header tagline color setting
	$wp_customize->add_setting(	
		'blog_lover_header_tagline',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_hex_color',
			'default' => '#929292',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'blog_lover_header_tagline',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site tagline Color:', 'blog-lover' ),
			)
		)
	);

	$wp_customize->get_section( 'background_image' )->panel         = 'blog_lover_general_panel';
	$wp_customize->get_section( 'custom_css' )->panel         = 'blog_lover_general_panel';

	/**
	 * General settings
	 */
	// General settings
	$wp_customize->add_section(
		'blog_lover_general_section',
		array(
			'title' => esc_html__( 'General', 'blog-lover' ),
			'panel' => 'blog_lover_general_panel',
		)
	);

	// Breadcrumb enable setting
	$wp_customize->add_setting(
		'blog_lover_breadcrumb_enable',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_breadcrumb_enable',
		array(
			'section'		=> 'blog_lover_general_section',
			'label'			=> esc_html__( 'Enable breadcrumb.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Backtop enable setting
	$wp_customize->add_setting(
		'blog_lover_back_to_top_enable',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_back_to_top_enable',
		array(
			'section'		=> 'blog_lover_general_section',
			'label'			=> esc_html__( 'Enable Scroll up.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Blog/Archive section 
	 */
	// Blog/Archive section 
	$wp_customize->add_section(
		'blog_lover_archive_settings',
		array(
			'title' => esc_html__( 'Archive/Blog', 'blog-lover' ),
			'description' => esc_html__( 'Settings for archive pages including blog page too.', 'blog-lover' ),
			'panel' => 'blog_lover_general_panel',
		)
	);

	// Archive excerpt setting
	$wp_customize->add_setting(
		'blog_lover_archive_excerpt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'View the post', 'blog-lover' ),
		)
	);

	$wp_customize->add_control(
		'blog_lover_archive_excerpt',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Excerpt more text:', 'blog-lover' ),
		)
	);

	// Archive excerpt length setting
	$wp_customize->add_setting(
		'blog_lover_archive_excerpt_length',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_number_range',
			'default' => 60,
		)
	);

	$wp_customize->add_control(
		'blog_lover_archive_excerpt_length',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Excerpt more length:', 'blog-lover' ),
			'type'			=> 'number',
			'input_attrs'   => array( 'min' => 5 ),
		)
	);

	// Date enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_archive_date',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_archive_date',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Enable date.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Category enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_archive_cat',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_archive_cat',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Enable category.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Tag enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_archive_tag',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_archive_tag',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Enable tags.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Comment enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_archive_comment',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_archive_comment',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Enable comment count.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);


	// Author enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_archive_author',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_archive_author',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Enable author.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Featured image enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_archive_featured_img',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_archive_featured_img',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Enable featured image.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Content type setting
	$wp_customize->add_setting(
		'blog_lover_enable_archive_content_type',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'excerpt',
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_archive_content_type',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Content type:', 'blog-lover' ),
			'choices'		=> array(
				'full-content' => esc_html__( 'Full content', 'blog-lover' ), 
				'excerpt' => esc_html__( 'Excerpt', 'blog-lover' ), 
			),
			'type'			=> 'radio',
		)
	);

	// Pagination type setting
	$wp_customize->add_setting(
		'blog_lover_archive_pagination_type',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_select',
			'default' => 'numeric',
		)
	);

	$archive_pagination_description = '';
	$archive_pagination_choices = array( 
				'disable' => esc_html__( '--Disable--', 'blog-lover' ),
				'numeric' => esc_html__( 'Numeric', 'blog-lover' ),
				'older_newer' => esc_html__( 'Older / Newer', 'blog-lover' ),
			);
	if ( ! class_exists( 'JetPack' ) ) {
		$archive_pagination_description = sprintf( esc_html__( 'We recommend to install %1$sJetpack%2$s and enable %3$sInfinite Scroll%4$s feature for automatic loading of posts.', 'blog-lover' ), '<a target="_blank" href="http://wordpress.org/plugins/jetpack">', '</a>', '<b>', '</b>' );
	} else {
		$archive_pagination_choices['infinite_scroll'] = esc_html__( 'Infinite Load', 'blog-lover' );
	}
	$wp_customize->add_control(
		'blog_lover_archive_pagination_type',
		array(
			'section'		=> 'blog_lover_archive_settings',
			'label'			=> esc_html__( 'Pagination type:', 'blog-lover' ),
			'description'			=>  $archive_pagination_description,
			'type'			=> 'select',
			'choices'		=> $archive_pagination_choices,
		)
	);

	/**
	 * Single setting section 
	 */
	// Single setting section 
	$wp_customize->add_section(
		'blog_lover_single_settings',
		array(
			'title' => esc_html__( 'Single Posts', 'blog-lover' ),
			'description' => esc_html__( 'Settings for all single posts.', 'blog-lover' ),
			'panel' => 'blog_lover_general_panel',
		)
	);

	// Date enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_date',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_date',
		array(
			'section'		=> 'blog_lover_single_settings',
			'label'			=> esc_html__( 'Enable date.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Category enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_cat',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_cat',
		array(
			'section'		=> 'blog_lover_single_settings',
			'label'			=> esc_html__( 'Enable category.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Tag enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_tag',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_tag',
		array(
			'section'		=> 'blog_lover_single_settings',
			'label'			=> esc_html__( 'Enable tags.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Comment enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_comment',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_comment',
		array(
			'section'		=> 'blog_lover_single_settings',
			'label'			=> esc_html__( 'Enable comment.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);


	// Author enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_author',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_author',
		array(
			'section'		=> 'blog_lover_single_settings',
			'label'			=> esc_html__( 'Enable author.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Featured image enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_featured_img',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_featured_img',
		array(
			'section'		=> 'blog_lover_single_settings',
			'label'			=> esc_html__( 'Enable featured image.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Pagination enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_pagination',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_pagination',
		array(
			'section'		=> 'blog_lover_single_settings',
			'label'			=> esc_html__( 'Enable pagination.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Single pages setting section 
	 */
	// Single pages setting section 
	$wp_customize->add_section(
		'blog_lover_single_page_settings',
		array(
			'title' => esc_html__( 'Single Pages', 'blog-lover' ),
			'description' => esc_html__( 'Settings for all single pages.', 'blog-lover' ),
			'panel' => 'blog_lover_general_panel',
		)
	);

	// Author enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_page_author',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_page_author',
		array(
			'section'		=> 'blog_lover_single_page_settings',
			'label'			=> esc_html__( 'Enable author.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Featured image enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_page_featured_img',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_page_featured_img',
		array(
			'section'		=> 'blog_lover_single_page_settings',
			'label'			=> esc_html__( 'Enable featured image.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	// Pagination enable setting
	$wp_customize->add_setting(
		'blog_lover_enable_single_page_pagination',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'blog_lover_enable_single_page_pagination',
		array(
			'section'		=> 'blog_lover_single_page_settings',
			'label'			=> esc_html__( 'Enable pagination.', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Reset all settings
	 */
	// Reset settings section
	$wp_customize->add_section(
		'blog_lover_reset_sections',
		array(
			'title' => esc_html__( 'Reset all', 'blog-lover' ),
			'description' => esc_html__( 'Reset all settings to default.', 'blog-lover' ),
			'panel' => 'blog_lover_general_panel',
		)
	);

	// Reset reset setting
	$wp_customize->add_setting(
		'blog_lover_reset_settings',
		array(
			'sanitize_callback' => 'blog_lover_sanitize_checkbox',
			'default' => false,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'blog_lover_reset_settings',
		array(
			'section'		=> 'blog_lover_reset_sections',
			'label'			=> esc_html__( 'Reset all settings?', 'blog-lover' ),
			'type'			=> 'checkbox',
		)
	);
}
add_action( 'customize_register', 'blog_lover_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blog_lover_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blog_lover_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blog_lover_customize_preview_js() {
	wp_enqueue_script( 'blog-lover-customizer', get_theme_file_uri( '/assets/js/customizer.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'blog_lover_customize_preview_js' );

/**
 * Binds JS handlers for Customizer controls.
 */
function blog_lover_customize_control_js() {


	wp_enqueue_style( 'blog-lover-customize-style', get_theme_file_uri( '/assets/css/customize-controls.css' ), array(), '20151215' );

	wp_enqueue_script( 'blog-lover-customize-control', get_theme_file_uri( '/assets/js/customize-control.js' ), array( 'jquery', 'customize-controls' ), '20151215', true );
	$localized_data = array( 
		'refresh_msg' => esc_html__( 'Refresh the page after Save and Publish.', 'blog-lover' ),
		'reset_msg' => esc_html__( 'Warning!!! This will reset all the settings. Refresh the page after Save and Publish to reset all.', 'blog-lover' ),
	);

	wp_localize_script( 'blog-lover-customize-control', 'localized_data', $localized_data );
}
add_action( 'customize_controls_enqueue_scripts', 'blog_lover_customize_control_js' );

/**
 *
 * Sanitization callbacks.
 * 
 */

/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function blog_lover_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}


/**
 * HEX Color sanitization callback example.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 *
 */
function blog_lover_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Image sanitization callback example.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 */
function blog_lover_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon',
        'svg'          => 'image/svg+xml'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 */
function blog_lover_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Drop-down Pages sanitization callback example.
 *
 * - Sanitization: dropdown-pages
 * - Control: dropdown-pages
 * 
 */
function blog_lover_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/**
 * Number Range sanitization callback example.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 * 
 */
function blog_lover_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 * HTML sanitization callback example.
 *
 * - Sanitization: html
 * - Control: text, textarea
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
function blog_lover_sanitize_html( $html ) {
	return wp_filter_post_kses( $html );
}

/**
 *
 * Active callbacks.
 * 
 */

/**
 * Check if the featured is not disabled
 */
function blog_lover_if_featured_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'blog_lover_featured' )->value();
}

/**
 * Check if the featured is page
 */
function blog_lover_if_featured_page( $control ) {
	return 'page' === $control->manager->get_setting( 'blog_lover_featured' )->value();
}

/**
 * Check if the featured is post
 */
function blog_lover_if_featured_post( $control ) {
	return 'post' === $control->manager->get_setting( 'blog_lover_featured' )->value();
}

/**
 * Check if the video is enabled
 */
function blog_lover_if_video_enabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'blog_lover_video' )->value();
}

/**
 * Check if the video is post
 */
function blog_lover_if_video_post( $control ) {
	return 'post' === $control->manager->get_setting( 'blog_lover_video' )->value();
}

/**
 * Check if the recent news is not disabled
 */
function blog_lover_if_recent_posts_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'blog_lover_recent_posts' )->value();
}

/**
 * Check if the recent news is page
 */
function blog_lover_if_recent_posts_page( $control ) {
	return 'page' === $control->manager->get_setting( 'blog_lover_recent_posts' )->value();
}

/**
 * Check if the recent news is post
 */
function blog_lover_if_recent_posts_post( $control ) {
	return 'post' === $control->manager->get_setting( 'blog_lover_recent_posts' )->value();
}

/**
 * Check if the recent news is cat
 */
function blog_lover_if_recent_posts_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'blog_lover_recent_posts' )->value();
}

/**
 * Check if the recent news is not disabled or category.
 */
function blog_lover_if_recent_posts_not_cat_disabled( $control ) {
	return ( ! blog_lover_if_recent_posts_cat( $control ) && blog_lover_if_recent_posts_not_disabled( $control ) );
}

/**
 * Check if instagram is enabled
 */
function blog_lover_is_insta_enable( $control ) {
	return $control->manager->get_setting( 'blog_lover_instagram_enable' )->value();
}

/**
 * Check if the latest is not disabled
 */
function blog_lover_if_latest_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'blog_lover_latest' )->value();
}

/**
 * Check if the latest is page
 */
function blog_lover_if_latest_page( $control ) {
	return 'page' === $control->manager->get_setting( 'blog_lover_latest' )->value();
}

/**
 * Check if the latest is post
 */
function blog_lover_if_latest_post( $control ) {
	return 'post' === $control->manager->get_setting( 'blog_lover_latest' )->value();
}

/**
 * Check if the slider is not disabled
 */
function blog_lover_if_slider_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'blog_lover_slider' )->value();
}

/**
 * Check if the slider is page
 */
function blog_lover_if_slider_page( $control ) {
	return 'page' === $control->manager->get_setting( 'blog_lover_slider' )->value();
}

/**
 * Check if the slider is post
 */
function blog_lover_if_slider_post( $control ) {
	return 'post' === $control->manager->get_setting( 'blog_lover_slider' )->value();
}

/**
 * Check if the hero slider is not disabled
 */
function blog_lover_if_hero_slider_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'blog_lover_hero_slider' )->value();
}

/**
 * Check if the hero slider is page
 */
function blog_lover_if_hero_slider_page( $control ) {
	return 'page' === $control->manager->get_setting( 'blog_lover_hero_slider' )->value();
}

/**
 * Check if the hero slider is post
 */
function blog_lover_if_hero_slider_post( $control ) {
	return 'post' === $control->manager->get_setting( 'blog_lover_hero_slider' )->value();
}

/**
 * Selective refresh.
 */

/**
 * Selective refresh for insta title.
 */
function blog_lover_insta_partial_title() {
	return esc_html( get_theme_mod( 'blog_lover_insta_title' ) );
}

/**
 * Selective refresh for your latest posts title.
 */
function blog_lover_your_latest_posts_partial_title() {
	return esc_html( get_theme_mod( 'blog_lover_your_latest_posts_title' ) );
}