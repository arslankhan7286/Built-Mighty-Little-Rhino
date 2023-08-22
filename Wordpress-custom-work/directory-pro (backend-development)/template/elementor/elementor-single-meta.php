<?php
	namespace Elementor;	
	use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
	use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

	class ListingProSingleMeta extends \Elementor\Widget_Base {
		public function __construct( $data=[], $args=null ){
            parent::__construct( $data, $args );            
			wp_register_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
            /*
			wp_register_script( 'demo-elementor-widget-js',  plugin_dir_url( __FILE__ ) . '/assets/js/demo-elementor-widget.js', ['elementor-frontend'],'1.0.0', true );
            */
        }
		
		public function get_name()
		{
			return "directory_pro_single_meta";
		}
		public function get_title()
		{
			return "Listing Fields";
		}
		public function get_icon()
		{
			return 'eicon-text';
		}
		public function get_categories()
		{
			return ['directory-pro'];
		}
		

		public function get_style_depends() {
				return [ 'iv-bootstrap-4' ];
		}
		/******************** CONTENT PROCESSING ***********************/
		protected function register_controls() {
			//Top Section Right Side Image
			$this->start_controls_section(
			'directory_pro_meta_data',
			[
			'label' => __( 'Listing Fields', 'ivdirectories' ),
			'tab' => Controls_Manager::TAB_CONTENT,
			]
			);
			
			$default_fields = array();
			$field_set=get_option('iv_directories_fields' );			
			if($field_set!=""){
				$default_fields=get_option('iv_directories_fields' );
				}else{
				$default_fields['business_type']='Business Type';
				$default_fields['main_products']='Main Products';
				$default_fields['number_of_employees']='Number Of Employees';
				$default_fields['main_markets']='Main Markets';
				$default_fields['total_annual_sales_volume']='Total Annual Sales Volume';	
			}
			$default_fields['title']= esc_html__( 'Title', 'ivdirectories' );
			$default_fields['listing_content']=  esc_html__( 'content', 'ivdirectories' );
			$default_fields['_opening_time']=esc_html__( 'Opening Time', 'ivdirectories' );
			$default_fields['address']= esc_html__( 'Address', 'ivdirectories' );
			$default_fields['city']=  esc_html__( 'City', 'ivdirectories' );
			$default_fields['state']= esc_html__( 'State', 'ivdirectories' );
			$default_fields['country']= esc_html__( 'Country', 'ivdirectories' );
			$default_fields['postcode']= esc_html__( 'Post Code', 'ivdirectories' );
			$default_fields['zipcode']= esc_html__( 'Zip Code', 'ivdirectories' );
			$default_fields['phone']=  esc_html__( 'Conatct Phone #', 'ivdirectories' );
			$default_fields['contact_name']= esc_html__('Contact Name', 'ivdirectories');
			$default_fields['contact-email']= esc_html__( 'Contact Email', 'ivdirectories' );
			$default_fields['contact_web']= esc_html__( 'Contact Web Address', 'ivdirectories' );
			$default_fields['vimeo']= esc_html__('Vimeo video', 'ivdirectories');
			$default_fields['youtube']= esc_html__('Youtube video', 'ivdirectories');	
			
			
			
			$this->add_control(
			'directory_pro_meta',
				[
				'label' => esc_html__( 'Select Field', 'ivdirectories' ),
				'type' => Controls_Manager::SELECT,
				'block' => true,
				'default' => 'title',
				'options' => $default_fields,
			]
			);
			
			
			$this->add_control(
			'size',
				[
				'label' => __( 'Size', 'ivdirectories' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
				'default' => __( 'Default', 'ivdirectories' ),
				'small' => __( 'Small', 'ivdirectories' ),
				'medium' => __( 'Medium', 'ivdirectories' ),
				'large' => __( 'Large', 'ivdirectories' ),
				'xl' => __( 'XL', 'ivdirectories' ),
				'xxl' => __( 'XXL', 'ivdirectories' ),
				],
				]
			);
			$this->add_control(
			'header_size',
				[
				'label' => __( 'HTML Tag', 'ivdirectories' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
				'h1' => __( 'H1', 'ivdirectories' ),
				'h2' => __( 'H2', 'ivdirectories' ),
				'h3' => __( 'H3', 'ivdirectories' ),
				'h4' => __( 'H4', 'ivdirectories' ),
				'h5' => __( 'H5', 'ivdirectories' ),
				'h6' => __( 'H6', 'ivdirectories' ),
				'div' => __( 'div', 'ivdirectories' ),
				'span' => __( 'span', 'ivdirectories' ),
				'p' => __( 'p', 'ivdirectories' ),
				],
				'default' => 'h2',
				]
			);
			$this->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', 'elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'elementor' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
					]
				);
			$this->add_control(
			'view',
			[
			'label' => __( 'View', 'elementor' ),
			'type' => Controls_Manager::HIDDEN,
			'default' => 'traditional',
			]
			);
			$this->end_controls_section();
			$this->start_controls_section(
			'section_title_style',
			[
			'label' => __( 'Title', 'elementor' ),
			'tab' => Controls_Manager::TAB_STYLE,
			]
			);
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Text Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
					],
				]
			);

						
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .elementor-heading-title',
				]
				);

				$this->add_group_control(
					Group_Control_Text_Stroke::get_type(),
					[
						'name' => 'text_stroke',
						'selector' => '{{WRAPPER}} .elementor-heading-title',
					]
				);

				$this->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name' => 'text_shadow',
						'selector' => '{{WRAPPER}} .elementor-heading-title',
					]
				);
				$this->add_control(
					'blend_mode',
					[
						'label' => esc_html__( 'Blend Mode', 'elementor' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'' => esc_html__( 'Normal', 'elementor' ),
							'multiply' => 'Multiply',
							'screen' => 'Screen',
							'overlay' => 'Overlay',
							'darken' => 'Darken',
							'lighten' => 'Lighten',
							'color-dodge' => 'Color Dodge',
							'saturation' => 'Saturation',
							'color' => 'Color',
							'difference' => 'Difference',
							'exclusion' => 'Exclusion',
							'hue' => 'Hue',
							'luminosity' => 'Luminosity',
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
						],
						'separator' => 'none',
					]
				);
			$this->end_controls_section();
		}
		/**
			* Render heading widget output on the frontend.
			*
			* Written in PHP and used to generate the final HTML.
			*
			* @since 1.0.0
			* @access protected
		*/
		protected function render() {
			$settings = $this->get_settings_for_display();
			global $post;
			if ( empty( $settings['directory_pro_meta'] ) ) {
				return;
			}
		

			if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'title', 'class', 'elementor-size-' . $settings['size'] );
			}

			$this->add_inline_editing_attributes( 'title' );
			$title = $settings['directory_pro_meta'];
						
			$this->add_render_attribute( 'directory_pro_meta', 'class', 'elementor-heading-title' );
			if ( ! empty( $settings['size'] ) ) {
				$this->add_render_attribute( 'directory_pro_meta', 'class', 'elementor-size-' . $settings['size'] );
			}
			$this->add_inline_editing_attributes( 'directory_pro_meta' );
			$title = get_post_meta($post->ID,$settings['directory_pro_meta'],true) ;
							
			if( $settings['directory_pro_meta']=='_opening_time'){	
				?>
					<div class="row col">
						<?php					
						foreach($title as $key => $item){
							$day_time = explode("|", $item);
							echo sprintf( '<div class="col-md-6"><p> <%1$s %2$s>%3$s %4$s %5$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'directory_pro_meta' ), $key," : ",$day_time[0].' - '.$day_time[1].'</p></div>');
						}
						?>
					</div>
				<?php	
			}elseif( $settings['directory_pro_meta']=='vimeo'){	
				$video_vimeo_id= get_post_meta($post->ID,'vimeo',true);
				if($video_vimeo_id!=""){ $v=$v+1; ?>
					<iframe src="https://player.vimeo.com/video/<?php echo esc_html($video_vimeo_id); ?>" width="100%" height="100%" class="w-100 m-0 p-0" frameborder="0"></iframe>					
					<?php
					}
			}elseif( $settings['directory_pro_meta']=='youtube'){					
					$video_youtube_id=get_post_meta($post->ID,'youtube',true);
					if($video_youtube_id!=""){						
					?>
					<iframe width="100%" height="415px" src="https://www.youtube.com/embed/<?php echo esc_html($video_youtube_id); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-100"></iframe>
					<?php
					}
						
			}elseif( $settings['directory_pro_meta']=='listing_content'){			
				
				$content_post = get_post($post->ID);
				$listing_data = $content_post->post_content;				

				echo sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $listing_data );
				
				
			}elseif( $settings['directory_pro_meta']=='title'){	
					$title=get_the_title($post->ID);					
					echo  sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $title );
					
					
			}else{
			
				echo  sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $title );
				
			}
			
			
		}
		/**
			* Render heading widget output in the editor.
			*
			* Written as a Backbone JavaScript template and used to generate the live preview.
			*
			* @since 1.0.0
			* @access protected
		*/
		protected function content_template() {
		?>
		
		<#
		var title_template = settings.directory_pro_meta;
		view.addRenderAttribute( 'directory_pro_meta', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );
		view.addInlineEditingAttributes( 'directory_pro_meta' );		
		
		var headerSizeTag = elementor.helpers.validateHTMLTag( settings.header_size ),
			title_html = '<' + headerSizeTag  + ' ' + view.getRenderAttributeString( 'directory_pro_meta' ) + '>' + title_template + '</' + headerSizeTag + '>';
		
			print( title_html );
		#>
		
        <?php
		}
	}
	Plugin::instance()->widgets_manager->register_widget_type( new ListingProSingleMeta );
