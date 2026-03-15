<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Button extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_button',
            'title'      => __( 'MV Button', 'mindverse' ),
            'icon'       => 'eicon-button',
            'script'     => ['mindverse-interactions'],
            'keywords'   => [ 'button', 'btn', 'mv', 'mindverse' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_button_content_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_button_style_controls();
        $this->register_button_text_style_controls();
        $this->register_button_icon_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /** Register Button Content Controls */
    protected function register_button_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_button_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->visual_choice([
            'name' => 'btn_style',
            'label' => __('Style', 'mindverse'),
            'options' => [
                'primary' => [
                    'title' => esc_attr__( 'Primary', 'mindverse' ),
                ],
                'secondary' => [
                    'title' => esc_attr__( 'Gradient', 'mindverse' ),
                ],
                'third' => [
                    'title' => esc_attr__( 'Gradient', 'mindverse' ),
                ],
                'cta' => [
                    'title' => esc_attr__( 'CTA', 'mindverse' ),
                ],
                'gradient-3-color' => [
                    'title' => esc_attr__( 'Gradient Three Colors', 'mindverse' ),
                ],
                'box-border-gradient six-colors' => [
                    'title' => esc_attr__( 'Border Gradient Six Colors', 'mindverse' ),
                ],
                'highlight' => [
                    'title' => esc_attr__( 'Highlight - Border Gradient', 'mindverse' ),
                ],
                'highlight-2' => [
                    'title' => esc_attr__( 'Highlight 2', 'mindverse' ),
                ],
                'style-1' => [
                    'title' => esc_attr__( 'Style 1', 'mindverse' ),
                ],
                'style-2' => [
                    'title' => esc_attr__( 'Style 2', 'mindverse' ),
                ],
                '' => [
                    'title' => esc_attr__( 'Custom', 'mindverse' ),
                ],
            ],
            'default' => 'primary',
        ]);
        $this->select([
            'name' => 'btn_type',
            'label' => __('Type', 'mindverse'),
            'default' => '',
            'options' => [
                ''        => __('Link', 'mindverse'),
                'toggle'  => __('Toggle', 'mindverse'),
                'submit'  => __('Submit', 'mindverse'),
                'play'    => __('Play', 'mindverse'),
                'login'   => __('Login', 'mindverse'),
                'sign-up' => __('Sign Up', 'mindverse'),
                'anchor' => __('Anchor', 'mindverse'),
            ]
        ]);
        $this->select([
            'name'  => 'cf_id',
            'label' => __('Submit To Form', 'mindverse'),
            'default' => '0',
            'options' => Elementor_Helpers::get_contact_form_options(),
            'condition' => [
                'btn_type' => ['submit'],
            ]
        ]);
        $this->text([
            'name' => 'target',
            'label' => __('Target ID( Class )', 'mindverse'),
            'placeholder' => __('Ex: #id-name', 'mindverse'),
            'condition' => [
                'btn_type' => ['toggle', 'login', 'sign-up', 'anchor'],
            ]
        ]);
        $this->number([
            'name' => 'offset',
            'label' => __('Offset(px)', 'mindverse'),
            'default' => 0,
            'min' => 0,
            'condition' => [
                'btn_type' => ['anchor'],
            ]
        ]);
        $this->text([
            'name' => 'text',
            'default' => __('Click here', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->icons([
            'name' => 'icon',
            'default' => [],
            'condition' => [
                'btn_style!' => ['highlight']
            ]
        ]);
        $this->choose([
            'name' => 'icon_position',
            'label' => __( 'Icon Position', 'mindverse' ),
            'options' => [
                'row-reverse' => [ 
                    'title' => __( 'Left', 'mindverse' ), 
                    'icon' => 'eicon-arrow-left'
                ],
                'row' => [ 
                    'title' => __( 'Right', 'mindverse' ), 
                    'icon' => 'eicon-arrow-right', 
                ],
            ],
            'condition' => [
                'icon[value]!' => '',
                'btn_style!' => ['highlight']
            ],
            'selectors' => [
                '{{WRAPPER}} .button' => 'flex-direction: {{VALUE}};'
            ]
        ]);
        $this->text([
            'name' => 'btn_text_highlight',
            'label' => __('Highlight Text', 'mindverse'),
            'default' => __('Highlight', 'mindverse'),
            'condition' => [
                'btn_style' => ['highlight', 'highlight-2']
            ]
        ]);
        $this->url([
            'name' => 'link',
            'label' => __('Link URL', 'mindverse'),
            'separator' => 'before',
            'default' => [
                'url' => '#',
            ],
            'condition' => [
                'btn_type' => ['', 'play'],
            ]
        ]);
        $this->end_controls_section();
    }

    /** Register Layout Style Controls */
    protected function register_layout_style_controls() {
        $this->start_style_section([
            'name' => 'section_layout_style',
            'label' => __('Layout', 'mindverse'),
        ]); 

        $this->slider([
            'name' => 'btn_gap',
            'label' => __('Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'btn_width',
            'label' => __('Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'btn_height',
            'label' => __('Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** Register Button Style Controls */
    protected function register_button_style_controls() {
        $this->start_style_section([
            'name' => 'section_button_style', 
            'label' => __('Button', 'mindverse'),
        ]);

        $this->start_controls_tabs( 'btn_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'btn_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        $this->group_background([
            'name' => 'box_gradient_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .button.box-border-gradient',
            'fields_options' => [			
				'color' => [
					'selectors' => [
						'{{WRAPPER}} .button.box-border-gradient' => '--mv-background-color: {{VALUE}};',
					],
				],
                'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .button.box-border-gradient' => '--mv-background-color-b: {{VALUE}};',
					],
				],
			],
            'condition' => [
                'btn_style' => ['highlight']
            ]
		]);
        // Background 
        $this->group_background([
            'name' => 'btn_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .button, {{WRAPPER}} .box-border-gradient:before',
            'condition' => [
                'btn_style!' => ['highlight', 'gradient-3-color'],
            ]
        ]);
        $this->number([
            'name' => 'btn_color_gradient_angle',
            'label' => __('Gradient Angle', 'mindverse'),
            'min' => -360,
            'max' => 360,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .button' => '--mv-angle: {{VALUE}}deg;'
            ],
            'condition' => [
                'btn_style' => 'gradient-3-color',
            ]
        ]);
        $this->color([
            'name' => 'btn_color_gradient',
            'label' => __('Color 1', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button' => '--gradient-color: {{VALUE}};'
            ],
            'condition' => [
                'btn_style' => 'gradient-3-color',
            ]
        ]);
        $this->color([
            'name' => 'btn_color2_gradient',
            'label' => __('Color 2', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button' => '--gradient-color-2: {{VALUE}};'
            ],
            'condition' => [
                'btn_style' => 'gradient-3-color',
            ]
        ]);
        $this->color([
            'name' => 'btn_color3_gradient',
            'label' => __('Color 3', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button' => '--gradient-color-3: {{VALUE}};'
            ],
            'condition' => [
                'btn_style' => 'gradient-3-color',
            ]
        ]);
        // Group Style
        $this->group_style([
            'name' => 'btn_',
            'selector' => '{{WRAPPER}} .button'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'btn_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);

        // Background 
        $this->group_background([
            'name' => 'btn_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} [data-hover]:not([data-hover="iconReversePosition"]):before, {{WRAPPER}} .button-gradient:before, 
                        {{WRAPPER}} .button:not([data-hover]):not(.button-gradient):not([data-hover="spotlightFill"]):hover, 
                        {{WRAPPER}} .button[data-hover="spotlightFill"] .spotlight-item, 
                        {{WRAPPER}} .button[data-hover*="icon"]:hover',
                        
            'fields_options' => [			
				// 'color' => [
				// 	'selectors' => [
				// 		'{{WRAPPER}} .button:not([data-hover]):not(.button-gradient):hover, 
                //         {{WRAPPER}} [data-hover]:before, {{WRAPPER}} .button-gradient:before' => 'background-color: {{VALUE}};',
				// 	],
				// ],
			],
		]);
        // Border Color 
        $this->color([
			'name' => 'btn_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .button:hover' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'btn_hover',
            'selector' => '{{WRAPPER}} .button:hover'
        ]);
        $this->duration([
            'name' => 'btn_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->select([
			'name' => 'btn_hover_style',
			'label' => __( 'Hover Style', 'mindverse' ),
			'default' => '',
			'options' => [
				''               => __('None', 'mindverse'),
                'fillFromLeft'   => __('Fill From Left', 'mindverse'),
                'fillFromRight'  => __('Fill From Right', 'mindverse'),
                'fillFromTop'    => __('Fill From Top', 'mindverse'),
                'fillFromBottom' => __('Fill From Bottom', 'mindverse'),
                'fillCircle'     => __('Fill In Circle', 'mindverse'),
                'fillHorizontal' => __('Fill In Horizontal', 'mindverse'),
                'fillVertical'   => __('Fill In Vertical', 'mindverse'),
				'spotlightFill'  => __('Fill Spotlight', 'mindverse'),
                'overlayShine'   => __('Overlay Shine', 'mindverse'),
                'parallax'       => __('Parallax', 'mindverse'),
                'iconSlideUp'    => __('Icon Slide Up', 'mindverse'),
                'iconSlideRight' => __('Icon Slide Right', 'mindverse'),
                'iconSlideDown'  => __('Icon Slide Down', 'mindverse'),
                'iconSlideLeft'  => __('Icon Slide Left', 'mindverse'),
                'iconReversePosition'   => __('Icon Reverse Position', 'mindverse'),
			],
		]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Register Button Text Style Controls */
    protected function register_button_text_style_controls() {
        $this->start_style_section([
            'name' => 'section_button_text_style', 
            'label' => __('Button Text', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'btn_typography',
            'selector' => '{{WRAPPER}} .button',
        ]);
        $this->group_text_shadow([
            'name' => 'btntext_shadow',
            'selector' => '{{WRAPPER}} .button',
        ]);
        $this->start_controls_tabs( 'btn_text_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'btn_text_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
		$this->group_background([
			'name' => 'btn_text_fill',
			'selector' => '{{WRAPPER}} .button .button-text, {{WRAPPER}} .button .button-icon',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .button' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .button .button-text, {{WRAPPER}} .button .button-icon' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .button .button-text, {{WRAPPER}} .button .button-icon' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->color([
            'name' =>  'btn_text_hl_color',
            'label' => __('Text Highlight Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button .button-text--highlight' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'btn_style' => ['highlight', 'highlight-2']
            ]
        ]);
        $this->end_controls_tab();
        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'btn_text_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        // Text Color 
		$this->group_background([
			'name' => 'btn_text_fill_hover',
			'selector' => '{{WRAPPER}} .button:hover .button-text',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .button:hover, 
						{{WRAPPER}} .button:hover .button-text' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .button:hover .button-text' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .button:hover .button-text' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->color([
            'name' =>  'btn_text_hover_hl_color',
            'label' => __('Text Highlight Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button:hover .button-text--highlight' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'btn_style' => ['highlight', 'highlight-2']
            ]
        ]);
        $this->duration([
            'name' => 'text_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button .button-text' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Register Button Icon Style Controls */
    protected function register_button_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_button_icon_style',
            'label' => __('Button Icon', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button .button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .button .button-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button .button-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs( 'icon_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'icon_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button .button-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .button .button-icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .button .button-icon',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'icon_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_hover_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button:hover .button-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .button:hover .button-icon',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .button:hover .button-icon',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button .button-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
} 