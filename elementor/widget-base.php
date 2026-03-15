<?php
namespace Mindverse\Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;


use Elementor\Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Traits\Controls_Trait;
use Mindverse\Inc\Integrations\Elementor\Traits\Group_Controls_Trait;
use Mindverse\Inc\Integrations\Elementor\Traits\Css_Trait;

use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;


abstract class Mindverse_Widget_Base extends Widget_Base {

    use Controls_Trait, Group_Controls_Trait, Css_Trait;

    protected $config = [];

    abstract protected function widget_info();

    public function __construct( $data = [], $args = null ) {
        $widget_args = $this->widget_info();

        $this->setup_widget_info( $widget_args );
        
        parent::__construct( $data, $args );
    }

    private function setup_widget_info( $args ) {
        $defaults = [
            'name'       => '',
            'title'      => '',
            'icon'       => 'eicon-code',
            'categories' => [ 'mindverse-theme' ],
            'keywords'   => [],
            'style'      => [],
            'script'     => [],
        ];
        $this->config = wp_parse_args( $args, $defaults );
    }

    public function get_name() {
        return $this->config['name'];
    }

    public function get_title() {
        return $this->config['title'];
    }
    public function get_icon() { return $this->config['icon']; }
    public function get_categories() { return $this->config['categories']; }
    public function get_keywords() { return $this->config['keywords']; }
    public function get_style_depends() { return $this->config['style']; }
    public function get_script_depends() { return $this->config['script']; }

    /**
     * Not render elementor-widget-container
     */
    public function has_widget_inner_wrapper(): bool {
        return false;
    }

     /**
     * Get the path to the render template for this widget
     */
    protected function get_template_path( $layout = '1' ) {
        $name = str_replace( 'mindverse_', '', $this->get_name() );
        $name = str_replace( '_', '-', $name ); // ensure folder name consistency
        $template_name = "layout-{$layout}.php";
        return get_template_directory() . "/elementor/render/{$name}/{$template_name}";
    }

    /**
     * Default render logic shared by all child widgets
     */
    protected function render() {
        $widget = $this;
        $settings = $widget->get_settings_for_display();
        $layout = $settings['layout'] ?? 1;
        $template = $this->get_template_path( $layout );
        $_wrapper_attrs = [];
        $gsap_settings = [];

        if( isset($settings['is_sticky']) && $settings['is_sticky'] === 'on' ) {
            $_wrapper_attrs['class'] = 'is-sticky';
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
            $_wrapper_attrs['data-sticky-settings'] = json_encode($sticky_attrs);
        }

        if( isset($settings['scrolling_effects']) && $settings['scrolling_effects'] === 'yes' ) {
            $gsap_settings = Elementor_Helpers::get_gsap_settings( $settings );
            $_wrapper_attrs['data-scrolling-effects'] = json_encode($gsap_settings);
        }

        if( isset($settings['entrance_animation_lib']) && $settings['entrance_animation_lib'] === 'gsap' && isset($settings['gsap_animation']) && !empty( $settings['gsap_animation'] ) ) {
            $gsap_settings = Elementor_Helpers::get_gsap_settings( $settings );
            $gsap_settings['animation'] = $settings['gsap_animation'];
            $_wrapper_attrs['data-gsap-animation'] = json_encode($gsap_settings);
        }

        if( !empty( $_wrapper_attrs ) ) {
            $this->add_render_attribute('_wrapper', $_wrapper_attrs);
        }

        if ( file_exists( $template ) ) {
            include $template;
        } else {
            printf(
                '<div style="color:red;">Template not found: <code>%s</code></div>',
                esc_html( str_replace( get_template_directory(), '', $template ) )
            );
        }
    }


    /**
     * Register the Container's motion effects controls 
     */
    protected function register_motion_effects_settings_controls() {
        $this->start_controls_section(
            '_section_motion_effects', 
            [ 
                'label' => __('Motion Effects', 'mindverse'), 
                'tab'  => 'content',
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
                'size_units' => ['ms', 's'],
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
                'size_units' => ['ms', 's'],
                'default' => [
                    'size' => 0, 
                    'unit' => 'ms'
                ],
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
        // Responsive
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
        $this->add_control(
            'scroll_transform_origin',
            [
                'label' => esc_html__( 'Transform Origin', 'mindverse' ),
                'type' => 'select',
                'default' => 'center center',
                'options' => [
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
                'selectors' => [
                    '{{WRAPPER}}' => 'transform-origin: {{VALUE}};',
                ],
                'condition' => [
                    'scrolling_effects' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Register the Widget's carousel animation controls 
     */
    protected function register_items_animation_controls() {
        $this->start_controls_section(
            '_section_animation', 
            [ 
                'label' => __('Animation', 'mindverse'), 
                'tab'  => 'content',
            ]
        );
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
            ]
        );
        $this->add_control(
            'entrance_animation', 
            [
                'label' => __( 'Entrance Animation', 'mindverse' ),
                'type' => 'select',
                'groups' => Elementor_Helpers::entrance_animation_options(),  
                'default' => '',
                'render_type' => 'template',
                'condition' => [
                    'entrance_animation_lib' => '',
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
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}}.wow' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'entrance_animation!' => '',
                    'entrance_animation_lib' => '',
                ]
            ]
        );
        $this->add_responsive_control(
            'entrance_animation_delay', 
            [
                'label' => __('Animation Delay(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'default' => [
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}}.wow' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'entrance_animation!' => '',
                    'entrance_animation_lib' => '',
                ]
            ]
        );
        // Gsap Animation
        $this->add_control(
            'gsap_animation',
            [
                'label' => __('Animation', 'mindverse'),
                'type' => 'select',
                'groups' => Elementor_Helpers::entrance_animation_gsap_options(),  
                'default' => '',
                'render_type' => 'template',
                'condition' => [
                    'entrance_animation_lib' => 'gsap',
                ]
            ]
        );
        $this->add_control(
			'scroll_translate_settings',
			[
				'label' => esc_html__( 'Translate(px)', 'mindverse' ),
				'type' => 'popover_toggle',
				'return_value' => 'yes',
				'default' => '',
                'condition' => [
                    'gsap_animation' => 'custom',
                    'entrance_animation_lib' => 'gsap'
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
                'condition' => [
                    'gsap_animation' => 'custom',
                    'entrance_animation_lib' => 'gsap'
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
                'condition' => [
                    'gsap_animation' => 'custom',
                    'entrance_animation_lib' => 'gsap'
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
                'condition' => [
                    'gsap_animation' => 'custom',
                    'entrance_animation_lib' => 'gsap'
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
                'condition' => [
                    'gsap_animation' => 'custom',
                    'entrance_animation_lib' => 'gsap'
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
                'condition' => [
                    'gsap_animation' => 'custom',
                    'entrance_animation_lib' => 'gsap'
                ],
            ]
        );
        $this->add_control(
            'scroll_stagger', 
            [
                'label' => __('Stagger(s)', 'mindverse'),
                'type' => 'number',
                'min' => 0,
                'max' => 50,
                'default' => 0.25,
                'step' => 0.05,
                'condition' => [
                    'entrance_animation_lib' => 'gsap'
                ],
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Register the Widget's custom options
     */
    protected function register_custom_options_settings_controls() {
        $this->start_controls_section(
            'section_custom_options', 
            [
                'label' => __( 'Custom Options', 'mindverse' ),
                'tab' => 'settings',
            ]
        );
        // Width
        $this->add_responsive_control(
            '_width', 
            [
                'label' => __( 'Width', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
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
                    '{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}} !important;',
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
            '_min_height', 
            [
                'label' => __( 'Min Height', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [ 'px', '%', 'custom'],
                'range' => [
                    'px' => [ 'min' => 0 ],
                    '%'  => [ 'min' => 0 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Overflow
        $this->add_responsive_control(
            '_opacity', 
            [
                'label' => __( 'Opacity', 'mindverse' ),
                'type' => 'slider',
                'size_units' => [''],
                'range' => [
                    '' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_backdrop_filter', 
            [
                'label' => __( 'Backdrop Filter', 'mindverse' ),
                'type' => 'slider',
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}}' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->add_responsive_control(
            '_overflow',
            [
                'label'  => __('Overflow', 'mindverse'),
                'type'  => 'select',
                'separator' => 'before',
                'default' => '',
                'options' => [
                    ''         => __('Default', 'mindverse'),
                    'hidden' => __('Hidden', 'mindverse'),
                    'visible'    => __('Visible', 'mindverse'),
                    'auto' => __('Auto', 'mindverse'),
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'overflow: {{VALUE}} !important;',
                ],
            ]
        );
        // Position
        $this->add_responsive_control(
            '_custom_position',
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
                    'sticky'   => __('Sticky', 'mindverse')
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
                    '_custom_position' => ['absolute', 'fixed', 'sticky']
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
                    '_custom_position' => ['absolute', 'fixed', 'sticky'],
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
                    '_custom_position' => ['absolute', 'fixed', 'sticky'],
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
                    '_custom_position' => ['absolute', 'fixed', 'sticky']
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
                    '_custom_position' => ['absolute', 'fixed', 'sticky'],
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
                    '_custom_position' => ['absolute', 'fixed', 'sticky'],
                    '_orientation_vertical' => 'bottom'
                ]
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Get Text Animation Settings
     */
    protected function get_text_animation_settings() {
        $settings = $this->get_settings_for_display();
        $animation = $settings['text_animation'] ?? null;
        $gsap_settings = [
            'splitType' => $settings['split_type'] ?? 'chars',
            'staggerFrom' => $settings['animation_from'] ?? 'start',
            'scrub' => (bool) $settings['sync_scroll'],
            'staggerEach' => $settings['stagger_each'] ?: 0.015,
        ];
        if( $settings['sync_scroll'] === '0' ) {
            $gsap_settings['toggleActions'] = $settings['toggle_actions'] ?? 'none';
        }
        if ( $animation === 'custom' ) {
            $gsap_settings = array_merge( Elementor_Helpers::get_gsap_settings( $settings ), $gsap_settings );
        }else if( $animation === 'flyFlipX' ) {
            $gsap_settings['splitType'] = 'lines';
            $gsap_settings['staggerFrom'] = 'start';
            $gsap_settings['staggerEach'] = 0;
        }
        $gsap_settings['animation'] = $animation;
        return json_encode($gsap_settings); 
    }
}