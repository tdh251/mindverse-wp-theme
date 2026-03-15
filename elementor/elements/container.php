<?php
namespace Elementor\Includes\Elements;

use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mindverse_Container extends Container {

	/**
	 * Render the element JS template.
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
        <# 
        if ( settings.background_parallax_image.url !== '' || settings.background_parallax_color_b !== '' ) { #>
            <div class="mindverse-e-background"></div>
        <# } #>

		<# if ( 'boxed' === settings.content_width ) { #>
			<div class="e-con-inner">
		<#
		}
		if ( settings.background_video_link ) {
			let videoAttributes = 'autoplay muted playsinline';

			if ( ! settings.background_play_once ) {
				videoAttributes += ' loop';
			}

			view.addRenderAttribute(
				'background-video-container',
				{
					'class': 'elementor-background-video-container',
					'aria-hidden': 'true',
				}
			);

			if ( ! settings.background_play_on_mobile ) {
				view.addRenderAttribute( 'background-video-container', 'class', 'elementor-hidden-mobile' );
			}
			#>
			<div {{{ view.getRenderAttributeString( 'background-video-container' ) }}}>
				<div class="elementor-background-video-embed"></div>
				<video class="elementor-background-video-hosted" {{ videoAttributes }}></video>
			</div>
		<# } #>
		<div class="elementor-shape elementor-shape-top" aria-hidden="true"></div>
		<div class="elementor-shape elementor-shape-bottom" aria-hidden="true"></div>
		<# if ( 'boxed' === settings.content_width ) { #>
			</div>
		<# } #>
		<?php
	}
	
	/**
	 * Before rendering the container content. (Print the opening tag, etc.)
	 *
	 * @return void
	 */
	public function before_render() {
		$settings = $this->get_settings_for_display();
        
		$link = $settings['link'];

		if ( ! empty( $link['url'] ) ) {
			$this->add_link_attributes( '_wrapper', $link );
		}

        $wrapper_attrs = [];
        $gsap_settings = [];

        if( $settings['is_sticky'] === 'on' ) {
            $wrapper_attrs['class'] = 'is-sticky';
            $sticky_attrs = [
                'position' => $settings['sticky_position'],
                'offset' => $settings['sticky_offset'] ?: 0,
                'spacing' => $settings['sticky_spacing'] === 'yes' ? true : false,
            ];
            if( !empty( $settings['sticky_trigger'] ) ) {
                $sticky_attrs['trigger'] = $settings['sticky_trigger'];
            }
            if( !empty( $settings['sticky_responsive'] ) ) {
                $sticky_attrs['breakOn'] = $settings['sticky_responsive'];
                if( $settings['sticky_responsive'] === 'custom' ) {
                    $sticky_attrs['breakOn'] = $settings['sticky_responsive_screen_w'] ?: 0;
                }
            }
            $wrapper_attrs['data-sticky-settings'] = json_encode($sticky_attrs);
        }

        if( $settings['scrolling_effects'] === 'yes' ) {
            $gsap_settings = Elementor_Helpers::get_gsap_settings( $settings );
            $wrapper_attrs['data-scrolling-effects'] = json_encode($gsap_settings);
        }

        if( $settings['entrance_animation_lib'] === 'gsap' && !empty( $settings['gsap_animation'] ) ) {
            // if( $settings['gsap_animation'] !== 'custom' ) {
            //     }else {
            $gsap_settings = Elementor_Helpers::get_gsap_settings( $settings );
            $gsap_settings['animation'] = $settings['gsap_animation'];
            $wrapper_attrs['data-gsap-animation'] = json_encode($gsap_settings);
            // }
        }

        if( !empty( $wrapper_attrs ) ) {
            $this->add_render_attribute('_wrapper', $wrapper_attrs);
        }

		?><<?php $this->print_html_tag(); ?> <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
		<?php

        $this->render_background_parallax();

		if ( $this->is_boxed_container( $settings ) ) { ?>
			<div class="e-con-inner">
		<?php }

		$this->render_video_background();

		if ( ! empty( $settings['shape_divider_top'] ) ) {
			$this->render_shape_divider( 'top' );
		}

		if ( ! empty( $settings['shape_divider_bottom'] ) ) {
			$this->render_shape_divider( 'bottom' );
		}
	}

	/**
	 * After rendering the Container content. (Print the closing tag, etc.)
	 *
	 * @return void
	 */
	public function after_render() {
		$settings = $this->get_settings_for_display();
		if ( $this->is_boxed_container( $settings ) ) { ?>
			</div>
		<?php } ?>
		</<?php $this->print_html_tag(); ?>>
		<?php
	}

    /**
	 * Register the Container's layout tab.
	 *
	 * @return void
	 */
    protected function register_layout_tab() {
        parent::register_layout_tab();
        $this->register_custom_options_controls();
        $this->resgister_background_parallax_controls();
        $this->register_border_gradient_controls();
        $this->_register_motion_effects_controls();
    }

    /**
	 * Register the Container's background parallax controls.
	 *
	 * @return void
	 */
    protected function resgister_background_parallax_controls() {
        $this->start_controls_section(
            'section_background_parallax', 
            [
                'label' => __( 'Background Parallax', 'mindverse' ),
                'tab' => 'layout',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background_parallax',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} > .mindverse-e-background',
                'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
            ]
        );
        $this->add_control(
            'background_parallax_opacity', 
            [
                'label' => __( 'Opacity', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ '' ],
                'separator' => 'before',
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mindverse-e-background' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'background_parallax_z_index', 
            [
                'label' => __('Z Index', 'mindverse'),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => -9999,
                        'max' => 9999,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mindverse-e-background' => 'z-index: {{SIZE}};',
                ],
            ]
        );
        // Background Parallax Settings
        $this->add_control(
            'background_parallax_settings',
            [
                'type' => 'popover_toggle',
                'label' => esc_html__( 'Parallax Settings', 'mindverse' ),
                'separator' => 'before',
                'label_off' => esc_html__( 'Default', 'mindverse' ),
                'label_on' => esc_html__( 'Custom', 'mindverse' ),
                'return_value' => 'yes',
            ]
        );
        $this->start_popover();
        $this->add_control(
            'background_parallax_x',
            [
                'label' => esc_html__( 'Translate X', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );
        $this->add_control(
            'background_parallax_y',
            [
                'label' => esc_html__( 'Translate Y', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );
        $this->add_control(
            'background_parallax_scale',
            [
                'label' => esc_html__( 'Scale', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ '' ],
                'range' => [
                    '' => [
                        'min' => -10,
                        'max' => 10,
                        'step' => 0.05,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 1,
                ],
            ]
        );
        $this->add_control(
            'background_parallax_rotate',
            [
                'label' => esc_html__( 'Rotate', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ '' ],
                'range' => [
                    '' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0,
                ],
            ]
        );
        $this->add_control(
            'background_parallax_origin',
            [
                'label' => esc_html__( 'Transform Origin', 'mindverse' ),
                'type' => 'select',
                'separator' => 'before',
                'options' => [
                    ''              => __('Default', 'mindverse'),
                    'center center' => esc_html__( 'Center', 'mindverse' ),
                    'left top' => esc_html__( 'Left Top', 'mindverse' ),
                    'left center' => esc_html__( 'Left Center', 'mindverse' ),
                    'left bottom' => esc_html__( 'Left Bottom', 'mindverse' ),
                    'center top' => esc_html__( 'Center Top', 'mindverse' ),
                    'center bottom' => esc_html__( 'Center Bottom', 'mindverse' ),
                    'right top' => esc_html__( 'Right Top', 'mindverse' ),
                    'right center' => esc_html__( 'Right Center', 'mindverse' ),
                    'right bottom' => esc_html__( 'Right Bottom', 'mindverse' ),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mindverse-e-background' => 'transform-origin: {{VALUE}};'
                ]
            ],
        );
        $this->end_popover();
        $this->end_controls_section();
    }

    /**
	 * Register the Container's controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
        parent::register_controls();
	}

    /**
     * Render the background parallax
     */
    protected function render_background_parallax() {
		$settings = $this->get_settings_for_display();
        if( !empty( $settings['background_parallax_image']['url'] ) || !empty( $settings['background_parallax_color_b'] ) ) : 
            $background_html_attrs = [
                'class' => 'mindverse-e-background'
            ];
            if( $settings['background_parallax_settings'] === 'yes' ) {
                $background_html_attrs['class'] .= ' background-parallax';
                $background_html_attrs['data-custom-settings'] = json_encode([
                    'x' => ( $settings['background_parallax_x']['size'] ?: 0 ),
                    'y' => ( $settings['background_parallax_y']['size'] ?: 0 ),
                    'scale' => ( $settings['background_parallax_scale']['size'] ?: 1 ),
                    'rotate' => ( $settings['background_parallax_rotate']['size'] ?: 0 ),
                ]);
            }
            $this->add_render_attribute( '_background_parallax', $background_html_attrs);
        ?>
            <div <?php pxl_print_html( $this->get_render_attribute_string('_background_parallax') ); ?>></div>
        <?php endif;
    }

    /**
     * Regiser the Container's border gradient controls 
     */
    protected function register_border_gradient_controls() {
        $this->start_controls_section('section_border_gradient', [
            'label' => __( 'Border Gradient', 'mindverse' ),
            'tab' => 'layout',
        ]);
        $this->add_control(
            'border_gradient_type', 
            [
                'label' => __('Border Gradient', 'mindverse'),
                'type' => 'select',
                'default' => '',
                'options' => [
                    '' => __('None', 'mindverse'),
                    'box-border-gradient' => __('Gradient 2 Color', 'mindverse'),
                    'box-border-gradient three-colors' => __('Gradient 3 Color', 'mindverse'),
                    'box-border-gradient four-colors'  => __('Gradient 4 Color', 'mindverse'),
                    'box-border-gradient five-colors'  => __('Gradient 5 Color', 'mindverse'),
                    'box-border-gradient six-colors'   => __('Gradient 6 Color', 'mindverse'),
                ],
                'prefix_class' => ''
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'border_gradient_background',
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}}',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Background', 'mindverse' ),
                    ],				
                    'color' => [
                        'label' => __( 'Color', 'mindverse' ),
                        'selectors' => [
                            '{{WRAPPER}}' => '--mv-background-color: {{VALUE}};',
                        ],
                    ],
                    'color_b' => [
                        'selectors' => [
                            '{{WRAPPER}}' => '--mv-background-color-b: {{VALUE}};',
                        ],
                    ],
                ],
                'condition' => [
                    'border_gradient_type!' => '',
                ]
            ]
        );
        $this->add_control(
            'border_gradient_width', 
            [
                'label' => __('Border Width', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 50, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--mv-border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'border_gradient_type!' => '',
                ]
            ]
        );
        $this->add_control(
            'border_gradient_color_1', 
            [
                'label' => __('Color 1', 'mindverse'),
                'type' => 'color',
                'selectors' => [
                    '{{WRAPPER}}' => '--gradient-color: {{VALUE}}',
                ],
                'condition' => [
                    'border_gradient_type!' => '',
                ]
            ]
        );
        $this->add_control(
            'border_gradient_color_2', 
            [
                'label' => __('Color 2', 'mindverse'),
                'type' => 'color',
                'selectors' => [
                    '{{WRAPPER}}' => '--gradient-color-2: {{VALUE}}',
                ],
                'condition' => [
                    'border_gradient_type!' => '',
                ]
            ]
        );
        $this->add_control(
            'border_gradient_color_3', 
            [
                'label' => __('Color 3', 'mindverse'),
                'type' => 'color',
                'selectors' => [
                    '{{WRAPPER}}' => '--gradient-color-3: {{VALUE}}',
                ],
                'condition' => [
                    'border_gradient_type' => ['box-border-gradient three-colors', 'box-border-gradient four-colors', 'box-border-gradient five-colors', 'box-border-gradient six-colors'],
                ]
            ]
        );
        $this->add_control(
            'border_gradient_color_4', 
            [
                'label' => __('Color 4', 'mindverse'),
                'type' => 'color',
                'selectors' => [
                    '{{WRAPPER}}' => '--gradient-color-4: {{VALUE}}',
                ],
                'condition' => [
                    'border_gradient_type' => ['box-border-gradient four-colors', 'box-border-gradient five-colors', 'box-border-gradient six-colors'],
                ]
            ]
        );
        $this->add_control(
            'border_gradient_color_5', 
            [
                'label' => __('Color 5', 'mindverse'),
                'type' => 'color',
                'selectors' => [
                    '{{WRAPPER}}' => '--gradient-color-5: {{VALUE}}',
                ],
                'condition' => [
                    'border_gradient_type' => ['box-border-gradient five-colors', 'box-border-gradient six-colors'],
                ]
            ]
        );
        $this->add_control(
            'border_gradient_color_6', 
            [
                'label' => __('Color 6', 'mindverse'),
                'type' => 'color',
                'selectors' => [
                    '{{WRAPPER}}' => '--gradient-color-6: {{VALUE}}',
                ],
                'condition' => [
                    'border_gradient_type' => ['box-border-gradient six-colors'],
                ]
            ]
        );
        $this->add_control(
            'border_gradient_angle', 
            [
                'label' => __('Angle', 'mindverse'),
                'type' => 'number',
                'min' => -360,
                'max' => 360,
                'selectors' => [
                    '{{WRAPPER}}' => '--mv-angle: {{VALUE}}deg;',
                ],
                'condition' => [
                    'border_gradient_type!' => '',
                ]
            ]
        );
        $this->add_control(
            'border_gradient_animation',
            [
                'label' => __('Animation', 'mindverse'),
                'default' => '',
                'type' => 'select',
                'options' => [
                    ''     => __('On', 'mindverse'),
                    'none' => __('Off', 'mindverse'),
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'animation: {{VALUE}};'
                ],
                'condition' => [
                    'border_gradient_type!' => '',
                ]
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Register the Container's motion effects controls 
     */
    protected function _register_motion_effects_controls() {
        $this->start_controls_section(
            '_section_motion_effects', 
            [ 
                'label' => __('Motion Effects', 'mindverse'), 
                'tab'  => 'layout',
            ]
        );
        
        // Sticky   
        $this->add_control(
            'is_sticky',
            [
                'label' => esc_html__( 'Is Sticky', 'mindverse' ),
                'type'  => 'select',
                'frontend_available' => true,
                'render_type' => 'template',
                'options'      => array(
                    'on'  => esc_html__( 'On', 'mindverse' ),           
                    'off' => esc_html__( 'Off', 'mindverse' )
                ),
                'default'      => 'off',
            ]
        );
        $this->add_control(
            'sticky_position',
            [
                'label' => esc_html__( 'Position', 'mindverse' ),
                'type'  => 'select',
                'hide_in_inner' => false,      
                'frontend_available' => true,
                'render_type' => 'none',
                'options'      => array(
                    'top'         => esc_html__( 'Top', 'mindverse' ),           
                    'bottom'      => esc_html__( 'Bottom', 'mindverse' )
                ),
                'default'      => 'top',
                'condition' => [
                    'is_sticky' => 'on',
                ]
            ]
        );
        $this->add_control(
            'sticky_offset',
            [
                'label' => esc_html__( 'Offset(px)', 'mindverse' ),
                'type' => 'number',
                'default' => 0,
                'min' => 0,
                'max' => 500,
                'condition' => [
                    'is_sticky' => 'on',
                ],
            ]
        ); 
        $this->add_control(
            'sticky_spacing',
            [
                'label' => __('Spacing', 'mindverse'),
                'type' => 'switcher',
                'default' => '',
                'condition' => [
                    'is_sticky' => 'on',
                ],
            ]
        );
        $this->add_control(
            'sticky_trigger',
            [
                'label' => esc_html__( 'Trigger', 'mindverse' ),
                'type' => 'text',
                'placeholder' => esc_html__( 'e.g: .my-class', 'mindverse' ),
                'description' => __('This is a number(px) or .class, #id.', 'mindverse'),
                'condition' => [
                    'is_sticky' => 'on',
                ],
            ]
        );  
        $this->add_control(
            'sticky_responsive',
            [
                'label' => esc_html__( 'Break On', 'mindverse' ),
                'type' => 'select',
                'default' => '',
                'options' => Elementor_Helpers::get_elementor_divice(),
                'render_type' => 'none',
                'frontend_available' => true,
                'condition' => [
                    'is_sticky' => 'on',
                ],
            ]
        );   
        $this->add_control(
            'sticky_responsive_screen_w',
            [
                'label' => __('Screen Width', 'mindverse'),
                'type' => 'number',
                'min' => 0,
                'default' => 767,
                'max' => 2400,
                'condition' => [
                    'sticky_responsive' => 'custom',
                ]
            ]
        );
        
        // Entrance Animation
        $this->add_control(
            'entrance_animation_lib',
            [
                'label' => __('Animation Liblary', 'mindverse'),
                'separator' => 'before',
                'type' => 'select',
                'default' => '',
                'render_type' => 'none',
                'options' => [
                    '' => __('Default', 'mindverse'),
                    'gsap' => __('Gsap', 'mindverse')
                ],
                'condition' => [
                    'scrolling_effects!' => 'yes'
                ]
            ]
        );
        // Gsap Animation
        $this->add_control(
            'gsap_animation',
            [
                'label' => __('Gsap Animation', 'mindverse'),
                'type' => 'select',
                'groups' => Elementor_Helpers::entrance_animation_gsap_options(),  
                'default' => '',
                'render_type' => 'template',
                'condition' => [
                    'entrance_animation_lib' => 'gsap',
                    'scrolling_effects!' => 'yes'
                ]
            ]
        );
        $this->add_control(
			'handle_gsap_animation_asset_loading',
			[
				'type' => 'hidden',
				'assets' => [
					'scripts' => [
						[
							'name' => 'mindverse-animation',
							'conditions' => [
								'terms' => [
									[
										'name' => 'entrance_animation_lib',
										'operator' => '===',
										'value' => 'gsap',
									],
                                    [
										'name' => 'gsap_animation',
										'operator' => '!==',
										'value' => '',
									],
								],
							],
						],
					],
				],
			]
		);
        // Wow Animation
        $this->add_control(
            'entrance_animation', 
            [
                'label' => __( 'Entrance Animation', 'mindverse' ),
                'type' => 'select',
                'groups' => Elementor_Helpers::entrance_animation_options(),  
                'default' => '',
                'prefix_class' => '',
                'condition' => [
                    'entrance_animation_lib' => '',
                    'scrolling_effects!' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'entrance_animation_duration', 
            [
                'label' => __('Animation Duration(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'default' => [
                    'size' => 1000, 
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}}.wow' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'entrance_animation!' => '',
                    'entrance_animation_lib' => '',
                    'scrolling_effects!' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'entrance_animation_delay', 
            [
                'label' => __('Animation Delay(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'default' => ['size' => 0, 'unit' => 'ms'],
                'selectors' => [
                    '{{WRAPPER}}.wow' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'entrance_animation!' => '',
                    'entrance_animation_lib' => '',
                    'scrolling_effects!' => 'yes'
                ]
            ]
        );

        // Scrolling Effects
        $this->add_control(
            'scrolling_effects', 
            [
                'label' => __('Scrolling Effects', 'mindverse'),
                'type' => 'switcher',
                'separator' => 'before',
                'default' => '',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'entrance_animation',
                                    'operator' => '===',
                                    'value' => ''
                                ],
                            ]
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => ''
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        );
        $this->add_control(
            'scroll_name',
            [
				'label' => esc_html__( 'Scroll Name', 'mindverse' ),
                'type'  => 'select',
                'default' => '',
                'options' => [
                    ''            => __('None', 'mindverse'),
                    'moveToLeft'  => __('Move To Left', 'mindverse'),
                    'moveToRight' => __('Move To Right', 'mindverse'),
                    'custom'      => __('Custom', 'mindverse')
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        );
        // Translate 
        $this->add_control(
			'scroll_translate_settings',
			[
				'label' => esc_html__( 'Translate(px)', 'mindverse' ),
				'type' => 'popover_toggle',
				'return_value' => 'yes',
				'default' => '',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
			]
		);
		$this->start_popover();
        $this->add_control(
            'scroll_x', 
            [
                'label' => __('X', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ] 
                ],
                'default' => [
                    'size' => 0, 
                    'unit' => 'px'
                ],
            ]
        );
        $this->add_control(
            'scroll_y', 
            [
                'label' => __('Y', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ] 
                ],
                'default' => [
                    'size' => 0, 
                    'unit' => 'px'
                ],
            ]
        );
        $this->add_control(
            'scroll_z', 
            [
                'label' => __('Z', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ] 
                ],
                'default' => [
                    'size' => 0, 
                    'unit' => 'px'
                ],
            ]
        );
        $this->end_popover();

        // Rotate
        $this->add_control(
			'scroll_rotate_settings',
			[
				'label' => esc_html__( 'Rotate(deg)', 'mindverse' ),
				'type' => 'popover_toggle',
				'return_value' => 'yes',
				'default' => '',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
			]
		);
		$this->start_popover();
        $this->add_control(
            'scroll_rotate_keep_proportions',
            [
                'label' => __( 'Keep Proportions', 'mindverse' ),
                'type' => 'switcher',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'scroll_rotate',
            [
                'label' => __('Rotate', 'mindverse'),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => -720,
                        'max' => 720
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => ''
                ],
                'condition' => [
                    'scroll_rotate_keep_proportions' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'scroll_rotate_x',
            [
                'label' => __('Rotate X', 'mindverse'),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => -720,
                        'max' => 720
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => ''
                ],
                'condition' => [
                    'scroll_rotate_keep_proportions!' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'scroll_rotate_y',
            [
                'label' => __('Rotate Y', 'mindverse'),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => -720,
                        'max' => 720
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => ''
                ],
                'condition' => [
                    'scroll_rotate_keep_proportions!' => 'yes'
                ]
            ]
        );
        $this->end_popover();

        // Scale
        $this->add_control(
			'scroll_scale_settings',
			[
				'label' => esc_html__( 'Scale', 'mindverse' ),
				'type' => 'popover_toggle',
				'return_value' => 'yes',
				'default' => '',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
			]
		);
		$this->start_popover();
        $this->add_control(
            'scroll_scale_keep_proportions',
            [
                'label' => __( 'Keep Proportions', 'mindverse' ),
                'type' => 'switcher',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'scroll_scale',
            [
                'label' => __('Scale', 'mindverse'),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 0.05,
                    ]
                ],
                'default' => [
                    'size' => 1,
                    'unit' => ''
                ],
                'condition' => [
                    'scroll_scale_keep_proportions' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'scroll_scale_x',
            [
                'label' => __('Scale X', 'mindverse'),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 0.05,
                    ]
                ],
                'default' => [
                    'size' => 1,
                    'unit' => ''
                ],
                'condition' => [
                    'scroll_scale_keep_proportions!' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'scroll_scale_y',
            [
                'label' => __('Scale Y', 'mindverse'),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 0.05,
                    ]
                ],
                'default' => [
                    'size' => 1,
                    'unit' => ''
                ],
                'condition' => [
                    'scroll_scale_keep_proportions!' => 'yes'
                ]
            ]
        );
		$this->end_popover();
        $this->add_control(
            'scroll_opacity', 
            [
                'label' => __('Opacity', 'mindverse'),
                'type' => 'number',
                'min' => 0,
                'max' => 1,
                'step' => 0.01,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        );
        $this->add_control(
            'scroll_blur', 
            [
                'label' => __('Blur(px)', 'mindverse'),
                'type' => 'number',
                'min' => 0,
                'max' => 500,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        );
        $this->add_control(
            'scroll_perspective', 
            [
                'label' => __('Perspective', 'mindverse'),
                'type' => 'number',
                'min' => 0,
                'max' => 2000,
                'default' => 0,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        );
        $this->add_control(
			'scroll_trigger_settings',
			[
				'label' => esc_html__( 'Trigger', 'mindverse' ),
				'type' => 'popover_toggle',
				'return_value' => 'yes',
				'default' => '',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'scrolling_effects',
                            'operator' => '===',
                            'value' => 'yes'
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'entrance_animation_lib',
                                    'operator' => '===',
                                    'value' => 'gsap'
                                ],
                                [
                                    'name' => 'gsap_animation',
                                    'operator' => '===',
                                    'value' => 'custom'
                                ],
                            ]
                        ]
                    ]
                ],
			]
		);
		$this->start_popover();
        $this->add_control(
            'trigger_type',
            [
                'label' => __('Type', 'mindverse'),
                'default' => 'from',
                'type' => 'select',
                'options' => [
                    'from' => __('From', 'mindverse'),
                    'to'   => __('To', 'mindverse'),
                ],
            ]
        );
        $this->add_control(
            'scroll_trigger_settings_divider',
            [
                'type' => 'divider'
            ]
        );
        $this->add_control(
            'scroll_trigger_el_start', 
            [
                'label' => __('Element Start', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['%', 'px'],
                'default' => [
                    'size' => 30,
                    'unit' => 'px'
                ],
            ]
        );
        $this->add_control(
            'scroll_trigger_el_end', 
            [
                'label' => __('Element End', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['%', 'px'],
                'default' => [
                    'size' => 100,
                    'unit' => '%'
                ],
            ]
        );
        $this->add_control(
            'scroll_trigger_settings_divider_2',
            [
                'type' => 'divider'
            ]
        );
        $this->add_control(
            'scroll_trigger_vw_start', 
            [
                'label' => __('Viewport Start', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['%', 'px'],
                'default' => [
                    'size' => 100,
                    'unit' => '%'
                ],
            ]
        );
        $this->add_control(
            'scroll_trigger_vw_end', 
            [
                'label' => __('Viewport End', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['%', 'px'],
                'default' => [
                    'size' => 100,
                    'unit' => '%'
                ],
            ]
        );
        $this->add_control(
			'custom_panel_alert',
			[
				'type' => 'alert',
				'alert_type' => 'info',
				'content' => esc_html__( 'I will help you understand this option.', 'mindverse' ) . ' <a href="">' . esc_html__( 'Let s go', 'mindverse' ) . '</a>',
			]
		);
		$this->end_popover();
        $this->add_control(
            'scroll_responsive',
            [
                'label' => esc_html__( 'Break On', 'mindverse' ),
                'type' => 'select',
                'default' => '',
                'options' => Elementor_Helpers::get_elementor_divice(),
                'render_type' => 'none',
                'frontend_available' => true,
                'condition' => [
                    'scrolling_effects' => 'yes',
                ],
            ]
        );   
        $this->add_control(
            'scroll_responsive_screen_w',
            [
                'label' => __('Screen Width', 'mindverse'),
                'type' => 'number',
                'min' => 0,
                'default' => 767,
                'max' => 2400,
                'condition' => [
                    'scrolling_effects' => 'yes',
                    'scroll_responsive' => 'custom'
                ]
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Register the Container's custom options
     */
    protected function register_custom_options_controls() {
        $this->start_controls_section(
            'section_custom_options', 
            [
                'label' => __( 'Custom Options', 'mindverse' ),
                'tab' => 'layout',
            ]
        );
        // Width
        $this->add_responsive_control(
            '_max_width', 
            [
                'label' => __( 'Max Width', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_min_width', 
            [
                'label' => __( 'Min Width', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Height
        $this->add_responsive_control(
            '_height', 
            [
                'label' => __( 'Height', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_max_height', 
            [
                'label' => __( 'Max Height', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_backdrop_filter', 
            [
                'label' => __( 'Backdrop Filter', 'mindverse' ),
                'type' => 'slider',
                'separator' => 'before',
                'size_units' => [ 'px', '%', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        // Position
        $this->add_responsive_control(
            '_position',
            [
                'label'  => __('Position', 'mindverse'),
                'type'  => 'select',
                'separator' => 'before',
                'default' => '',
                'options' => [
                    ''         => __('Default', 'mindverse'),
                    'absolute' => __('Absolute', 'mindverse'),
                    'fixed'    => __('Fixed', 'mindverse'),
                    'relative' => __('Relative', 'mindverse'),
                    'static'   => __('Static', 'mindverse'),
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'position: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            '_orientation_horizontal',
            [
                'label' => __('Horizontal Orientation', 'mindverse'),
                'type' => 'choose',
                'default' => 'left',
                'toggle' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'mindverse'),
                        'icon'  => 'eicon-arrow-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'mindverse'),
                        'icon'  => 'eicon-arrow-right',
                    ]
                ],
                'condition' => [
                    '_position' => ['absolute', 'fixed']
                ]
            ]
        );
        $this->add_responsive_control(
            'offset_left',
            [
                'label' => __('Offset Left', 'mindverse'),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ],
                'condition' => [
                    '_position' => ['absolute', 'fixed'],
                    '_orientation_horizontal' => 'left'
                ]
            ]
        );
        $this->add_responsive_control(
            'offset_right',
            [
                'label' => __('Offset Right', 'mindverse'),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ],
                'condition' => [
                    '_position' => ['absolute', 'fixed'],
                    '_orientation_horizontal' => 'right'
                ]
            ]
        );
        $this->add_responsive_control(
            '_orientation_vertical',
            [
                'label' => __('Vertical Orientation', 'mindverse'),
                'type' => 'choose',
                'default' => 'top',
                'toggle' => false,
                'options' => [
                    'top' => [
                        'title' => __('Top', 'mindverse'),
                        'icon'  => 'eicon-arrow-up',
                    ],
                    'bottom' => [
                        'title' => __('Bottom', 'mindverse'),
                        'icon'  => 'eicon-arrow-down',
                    ]
                ],
                'condition' => [
                    '_position' => ['absolute', 'fixed']
                ]
            ]
        );
        $this->add_responsive_control(
            'offset_top',
            [
                'label' => __('Offset Top', 'mindverse'),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}}; bottom:auto;',
                ],
                'condition' => [
                    '_position' => ['absolute', 'fixed'],
                    '_orientation_vertical' => 'top'
                ]
            ]
        );
        $this->add_responsive_control(
            'offset_bottom',
            [
                'label' => __('Offset Bottom', 'mindverse'),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                ],
                'condition' => [
                    '_position' => ['absolute', 'fixed'],
                    '_orientation_vertical' => 'bottom'
                ]
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Get render gsap scroll settings
     */
    // protected function get_gsap_settings() {
	// 	$settings = $this->get_settings_for_display();
    //     $gsap_settings = [];
    //     if( $settings['scroll_translate_settings'] === 'yes' ) {
    //         $gsap_settings['x'] = $settings['scroll_x']['size'] ?: 0;
    //         $gsap_settings['y'] = $settings['scroll_y']['size'] ?: 0;
    //         $gsap_settings['z'] = $settings['scroll_z']['size'] ?: 0;
    //     }
    //     if( $settings['scroll_rotate_settings'] === 'yes' ) {
    //         if( $settings['scroll_rotate_keep_proportions'] !== 'yes' ) {
    //             $gsap_settings['rotateX'] = $settings['scroll_rotate_x']['size'] ?: 0;
    //             $gsap_settings['rotateY'] = $settings['scroll_rotate_y']['size'] ?: 0;
    //         }else {
    //             $gsap_settings['rotate'] = $settings['scroll_rotate']['size'] ?: 0;
    //         }
    //     }
    //     if( $settings['scroll_scale_settings'] === 'yes' ) {
    //         if( $settings['scroll_scale_keep_proportions'] !== 'yes' ) {
    //             $gsap_settings['scaleX'] = $settings['scroll_scale_x']['size'] ?: 1;
    //             $gsap_settings['scaleY'] = $settings['scroll_scale_y']['size'] ?: 1;
    //         }else {
    //             $gsap_settings['scale'] = $settings['scroll_scale']['size'] ?: 0;
    //         }
    //     }
    //     $gsap_settings['opacity'] = 0.1;
    //     $gsap_settings['cmsdksdcsd'] = 'asdashdjaskjdashjgd';
    //     if( !empty( $settings['scroll_opacity'] ) ) {
    //     }
    //     if( !empty( $settings['scroll_blur'] ) ) {
    //         $gsap_settings['filter'] = 'blur('.$settings['scroll_blur'].'px)';
    //     }
    //     if( $settings['scroll_perspective'] > 0 ) {
    //         $gsap_settings['perspective'] = $settings['scroll_perspective'];
    //     }
    //     return $gsap_settings;
    // }
}
