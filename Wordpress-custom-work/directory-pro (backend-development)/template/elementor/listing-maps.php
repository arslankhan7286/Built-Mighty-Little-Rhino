<?php
	
namespace Elementor;

/**
 * Listing google maps widget.
 *
 * Elementor widget that displays an embedded google map.
 *
 * @since 1.0.0
 */

	class Widget_listing_Google_Maps extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve google maps widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Widget_listingGoogleMaps';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve google maps widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Listing Google Map', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve google maps widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the google maps widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['directory-pro'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'google', 'map', 'embed', 'location' ];
	}

	/**
	 * Register google maps widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'Liting_section_map',
			[
				'label' => esc_html__( 'Map', 'ivdirectories' ),
			]
		);
				
		$this->add_control(
			'zoom',
			[
				'label' => esc_html__( 'Zoom', 'ivdirectories' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'ivdirectories' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 1440,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_map_style',
			[
				'label' => esc_html__( 'Map', 'ivdirectories' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'map_filter' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'ivdirectories' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} iframe',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'ivdirectories' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover iframe',
			]
		);

		$this->add_control(
			'hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'ivdirectories' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} iframe' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render google maps widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();
		global $post;
		$address=get_post_meta($post->ID,'address',true).'+'.get_post_meta($post->ID,'city',true).'+'.get_post_meta($post->ID,'postcode',true).'+'.get_post_meta($post->ID,'country',true);
		
		if ( empty( $address ) ) {
			return;
		}

		if ( 0 === absint( $settings['zoom']['size'] ) ) {
			$settings['zoom']['size'] = 10;
		}


		?>
		<div class="elementor-custom-embed">
				<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo esc_html($address); ?>&amp;ie=UTF8&amp;&amp;output=embed"></iframe>
				
		</div>
		
		
		<?php
	}

	/**
	 * Render google maps widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_listing_Google_Maps );