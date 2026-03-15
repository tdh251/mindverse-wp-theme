<?php
namespace Mindverse\Inc\Integrations\Elementor\Traits;

use \Elementor\Controls_Manager;
use \Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


trait Group_Controls_Trait {
    /**
     * Quick Group Size Controls
     */
    protected function group_size($args = []) {
        $label         = $args['label'] ?? esc_html__('Size', 'mindverse');
        $prefix   = $args['name'] ?? '';
        $base_selector = $args['selector'] ?? '';
        $field_options = $args['fields_options'] ?? [];

        $get_selector = function($property) use ($base_selector) {
            if (empty($base_selector)) {
                return [];
            }
            return [
                $base_selector => "{$property}: {{SIZE}}{{UNIT}};"
            ];
        };
        $defaults = [
            'width' => [
                'name' => $prefix.'width',
                'label' => __( 'Width', 'mindverse' ),
                'selectors' => $get_selector('width')
            ],
            'max_width' => [
                'name' => $prefix.'max_width',
                'label' => __( 'Max Width', 'mindverse' ),
                'selectors' => $get_selector('max-width')
            ],
            'min_width' => [
                'name' => $prefix.'min_width',
                'label' => __( 'Min Width', 'mindverse' ),
                'selectors' => $get_selector('min-width')
            ],
            'height' => [
                'name' => $prefix.'height',
                'label' => __( 'Height', 'mindverse' ),
                'selectors' => $get_selector('height')
            ],
            'max_height' => [
                'name' => $prefix.'max_height',
                'label' => __( 'Max Height', 'mindverse' ),
                'selectors' => $get_selector('max-height')
            ],
            'min_height' => [
                'name' => $prefix.'min_height',
                'label' => __( 'Min Height', 'mindverse' ),
                'selectors' => $get_selector('min-height')
            ],
        ];
        $controls = array_replace_recursive($defaults, $field_options);
        $this->popover_toggle([
            'name' => $prefix.'size_popover_toggle',
            'label' => esc_html( $label ),
        ]);
        $this->start_popover();
        $this->slider($controls['width']);
        $this->slider($controls['max_width']);
        $this->slider($controls['min_width']);
        $this->divider([
            'name' => $prefix.'size_divider',
        ]);
        $this->slider($controls['height']);
        $this->slider($controls['max_height']);
        $this->slider($controls['min_height']);
        $this->end_popover();
    }

    /**
     * Quick group position
     */
    protected function style_position( $args = [] ) {
        $selector = $args['selector'] ?? '';
        $prefix = $args['name'] ?? '';
        $this->select([
            'name' => $prefix.'position',
            'label' => __('Position', 'mindverse'),
            'options' => [
                ''         => __('Default', 'mindverse'),
                'relative' => __('Relative', 'mindverse'),
                'absolute' => __('Absolute', 'mindverse'),
            ],
            'render_type' => '',
            'selectors' => [
                $selector => 'position: {{VALUE}};'
            ]
        ]);
        $this->popover_toggle([
            'name' => $prefix.'position_offset_popover_toggle',
            'label' => esc_html__( 'Offset', 'mindverse' ),
            'condition' => [
                $prefix.'position' => 'absolute',
            ]
        ]);
        $this->start_popover();

        $this->slider([
            'name' => $prefix.'offset_top',
            'label' => __('Top', 'mindverse'),
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                $selector => 'top: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $prefix.'position_offset_popover_toggle' => 'yes'
            ]
        ]);

        $this->slider([
            'name' => $prefix.'offset_right',
            'label' => __('Right', 'mindverse'),
            'selectors' => [
                $selector => 'right: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $prefix.'position_offset_popover_toggle' => 'yes'
            ]
        ]);

        $this->slider([
            'name' => $prefix.'offset_bottom',
            'label' => __('Bottom', 'mindverse'),
            'selectors' => [
                $selector => 'bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $prefix.'position_offset_popover_toggle' => 'yes'
            ]
        ]);

        $this->slider([
            'name' => $prefix.'offset_left',
            'label' => __('Left', 'mindverse'),
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                $selector => 'left: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $prefix.'position_offset_popover_toggle' => 'yes'
            ]
        ]);
        

        $this->end_popover();

        $this->style_transform([
            'name' => $prefix.'transform',
            'selector' => $selector,
            'separator' => 'before',
        ]);
    }

    /**
     * Quick transform style
     */
    protected function style_transform($args = []) {
        $prefix = $args['name'] ?? '';
        $selector = $args['selector'] ?? '';
        $separator = $args['separator'] ?? '';
        $this->popover_toggle([
            'name' => $prefix.'transform_popover_toggle',
            'label' => esc_html__( 'Transform', 'mindverse' ),
            'separator' => $separator,
        ]);
        $this->start_popover();
        $this->slider([
            'name' => $prefix.'rotate',
            'label' => __('Rotate', 'mindverse'),
            'size_units' => ['deg'],
            'default' => [
                'unit' => 'deg',
            ],
            'selectors' => [
                $selector => '--mv-rotate: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->divider([
            'name' => $prefix.'transform_divider',
        ]);
        $this->slider([
            'name' => $prefix.'translate_x',
            'label' => __('Translate X', 'mindverse'),
            'default' => [
                'unit' => '%',
            ],
            'selectors' => [
                $selector => '--mv-translate-x: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name' => $prefix.'translate_y',
            'label' => __('Translate Y', 'mindverse'),
            'default' => [
                'unit' => '%',
            ],
            'selectors' => [
                $selector => '--mv-translate-y: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_popover();
    }

    /**
     * Quick group typography control
     */ 
    protected function group_typography($args = []) {
        $args['type'] = \Elementor\Group_Control_Typography::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group text shadow control
     */ 
    protected function group_text_shadow($args = []) {
        $args['type'] = \Elementor\Group_Control_Text_Shadow::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group text stroke control
     */ 
    protected function group_text_stroke($args = []) {
        $args['type'] = \Elementor\Group_Control_Text_Stroke::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick text group style basic
     */
    protected function text_style($args = [] ) {
        $this->color([
            'name' => $args['name'].'_color',
            'selectors' => [
                $args['selector'] => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => $args['name'].'_typography',
            'selector' => $args['selector'],
        ]);
        $this->group_text_shadow([
            'name' => $args['name'].'_text_shadow',
            'selector' => $args['selector'],
        ]);
        $this->group_text_stroke([
            'name' => $args['name'].'_text_stroke',
            'selector' => $args['selector'],
        ]);
    }
    
    /**
     * Quick group Image Size control
     */ 
    protected function group_image_size( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Image_Size::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_css_filter( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Css_Filter::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_border( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Border::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_box_shadow( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Box_Shadow::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_background( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Background::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }
    /**
     * Group Style Image
     */
    protected function group_style_image( $args = [] ) {
        $prefix = $args['name'] ?? 'img_';
        $selector = $args['selector'] ?? '';

        $this->slider([
                'name' => $prefix.'opacity',
                'label' => __( 'Opacity', 'mindverse' ),
                'size_units' => [ '' ],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => '',
                ],
                'selectors' => [
                    $selector => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => $prefix.'css_filter',
            'selector' => $selector
        ]);
        $this->group_border([
            'name' => $prefix.'border',
            'selector' => $selector,
            'separator' => 'before',
        ]);
        $this->group_box_shadow([
            'name' => $prefix.'box_shadow',
            'selector' => $selector,
        ]);
        $this->dimensions([
            'name' => $prefix.'border_radius',
            'label' => __('Border Radius', 'mindverse'),
            'selectors' => [
                $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name' => $prefix.'padding',
            'label' => __('Padding', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
    }


    /**
     * Group Box Style 
     */
    protected function group_style( $args = [] ) {
        $prefix = $args['name'] ?? 'box_';
        $selector = $args['selector'] ?? '';
        // Border
        $this->group_border([
            'name' => $prefix.'border',
            'selector' => $selector,
            'separator' => 'before',
        ]);
        // Box Shadow
        $this->group_box_shadow([
            'name' => $prefix.'box_shadow',
            'selector' => $selector,
            'separator' => 'before',
        ]);
        $this->number([
            'name' => $prefix.'backdrop_filter',
            'label' => __('Backdrop Filter', 'mindverse'),
            'selectors' => [
                $selector => 'backdrop-filter: blur({{VALUE}}px);'
            ]
        ]);
        // Border Radius
        $this->dimensions([
            'name' => $prefix.'border_radius',
            'label' => __( 'Border Radius', 'mindverse' ),
            'selectors' => [
                $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding 
        $this->dimensions ([
            'name' => $prefix.'padding',
            'label' => __( 'Padding', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
    }

    /** Highlight Content */
    protected function highlight_content() {
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'hl_content_heading',
            [
                'label' => __('CONTENT', 'mindverse'),
                'type' => 'heading',
                'description' => __('Each [highlight] corresponds to 1 item.', 'mindverse'),
            ]
        );
        $repeater->add_control(
            'hl_type',
            [
                'label' => __('Highlight Type', 'mindverse'),
                'type' => 'select',
                'default' => 'text',
                'options' => [
                    'text' => __('Text', 'mindverse'),
                    'img'  => __('Image', 'mindverse'),
                    'icon' => __('Icon', 'mindverse'),
                ]
            ]
        );
        $repeater->add_control(
            'hl_text',
            [
                'label' => __('Highlight Text', 'mindverse'),
                'type' => 'textarea',
                'rows'  => 5,
                'default' => __('Highlight Text Here', 'mindverse'),
                'condition' => [
                    'hl_type' => 'text',
                ]
            ]
        );
        $repeater->add_control(
            'hl_img',
            [
                'label' => __('Highlight Image', 'mindverse'),
                'type' => 'media',
                'default' => [
                    'id' => 0,
                ],
                'condition' => [
                    'hl_type' => 'img',
                ]
            ]
        );
        $repeater->add_control(
			'hl_img_size',
			[
				'label' => esc_html__( 'Image Dimension', 'mindverse' ),
				'type' => 'image_dimensions',
                'condition' => [
                    'hl_img[id]!' => 0,
                ]
            ],
		);
        $repeater->add_control(
            'hl_icon',
            [
                'label' => esc_html__( 'Highlight Icon', 'mindverse' ),
                'type' => 'icons',
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'hl_type' => 'icon',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'hl_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'mindverse' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'width: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'hl_type' => 'icon',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'hl_box_width',
            [
                'label' => esc_html__( 'Box Width', 'mindverse' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
                'separator' => 'before',
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $repeater->add_responsive_control(
            'hl_box_height',
            [
                'label' => esc_html__( 'Box Height', 'mindverse' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'height: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $repeater->add_responsive_control(
            'hl_vertical_align',
            [
                'label' => __('Vertical Align', 'mindverse'),
                'type' => 'choose',
                'options' => [
                    'top' => [
                        'label' => __('Top', 'mindverse'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'sub' => [
                        'label' => __('Middle', 'mindverse'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'label' => __('Bottom', 'mindverse'),
                        'icon'  => 'eicon-v-align-bottom'
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'vertical-align: {{VALUE}};'
                ]
            ]
        );
        $repeater->add_control(
            'hl_style_heading',
            [
                'label' => __('STYLE', 'mindverse'),
                'type' => 'heading',
                'separator' => 'before',
            ]
        );
        $repeater->add_group_control (
            \Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'hl_typography',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'condition' => [
                    'hl_type' => 'text'
                ]
			]
		);
        $repeater->add_group_control (
            \Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'hl_stroke',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'condition' => [
                    'hl_type' => 'text'
                ]
			]
		);
        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'hl_text_fill',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'separator' => 'before',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Text Fill', 'mindverse' ),
                    ],				
                    'color' => [
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-image: url("{{URL}}"); -webkit-background-clip: text !important; background-clip: text; color: transparent;',
                        ],
                    ],
                    'color_b' => [
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => '-webkit-background-clip: text !important; background-clip: text; color: transparent;',
                        ],
                    ],
                ],
                'condition' => [
                    'hl_type' => 'text'
                ]
            ]
        );
        $repeater->add_control(
			'hl_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'mindverse' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
                'condition' => [
                    'hl_type' => 'icon'
                ]
			]
		);
        $repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'hl_background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
			]
		);
        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'hl_border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'separator' => 'before',
            ]
        );
        $repeater->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'hl_box_shadow',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'separator' => 'before',
            ]
        );
        $repeater->add_responsive_control(
            'hl_border_radius',
            [
                'label' => __( 'Border Radius', 'mindverse' ),
                'type' => 'dimensions',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'hl_padding',
            [
                'label' => __( 'Padding', 'mindverse' ),
                'type' => 'dimensions',
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'hl_margin',
            [
                'label' => __( 'Margin', 'mindverse' ),
                'type' => 'dimensions',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'hl_position_heading',
            [
                'label' => __('POSITION', 'mindverse'),
                'type' => 'heading',
                'separator' => 'before',
            ]
        );
        $repeater->add_responsive_control(
            'hl_position',
            [
                'label' => __('Position', 'mindverse'),
                'type' => 'select',
                'default' => '',
                'options' => [
                    '' => __('Default', 'mindverse'),
                    'relative' => __('Relative', 'mindverse'),
                    'absolute' => __('Absolute', 'mindverse'),
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'position: {{VALUE}}'
                ]
            ]
        );
        $repeater->add_responsive_control(
            'hl_offset_top',
            [
                'label' => __('Top', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_position' => 'absolute',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'hl_offset_right',
            [
                'label' => __('Right', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_position' => 'absolute',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'hl_offset_bottom',
            [
                'label' => __('Bottom', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_position' => 'absolute',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'hl_offset_left',
            [
                'label' => __('Left', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_position' => 'absolute',
                ]
            ]
        );
        $repeater->add_control(
            'hl_animation_heading',
            [
                'label' => __('ANIMATION', 'mindverse'),
                'type' => 'heading',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'hl_entrance_animation',
            [
                'label' => __( 'Entrance Animation', 'mindverse' ),
                'type' => 'select',
                'groups' => Elementor_Helpers::entrance_animation_options(),  
                'default' => '',
            ]
        );
        $repeater->add_responsive_control(
            'hl_entrance_animation_duration',
            [
                'label' => __('Animation Duration(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'range' => [
                    'ms' => [
                        'min' => 0,
                        'max' => 100000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_entrance_animation!' => '',
                ]
            
            ]
        );
        $repeater->add_responsive_control(
            'hl_entrance_animation_delay',
            [
                'label' => __('Animation Delay(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'range' => [
                    'ms' => [
                        'min' => 0,
                        'max' => 100000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_entrance_animation!' => '',
                ]
            ]
        );
        $repeater->add_control(
            'hl_loop_animation',
            [
                'label' => __( 'Loop Animation', 'mindverse' ),
                'type' => 'select',
                'separator' => 'before',
                'options' => [
                    '' => __('None', 'mindverse'),
                    'pulse-shake' => __('Pulse Shake', 'mindverse'),
                ],  
                'default' => '',
            ]
        );
        $repeater->add_responsive_control(
            'hl_loop_animation_duration',
            [
                'label' => __('Animation Duration(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'range' => [
                    'ms' => [
                        'min' => 0,
                        'max' => 100000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_type' => 'img',
                    'hl_loop_animation!' => '' 
                ]
            
            ]
        );
        $repeater->add_responsive_control(
            'hl_loop_animation_delay',
            [
                'label' => __('Animation Delay(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'range' => [
                    'ms' => [
                        'min' => 0,
                        'max' => 100000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'hl_type' => 'img',
                    'hl_loop_animation!' => '' 
                ]
            ]
        );
        $this->repeater([
            'name' => 'hl_items',
            'label' => __('Highlight Items', 'mindverse'),
            'separator' => 'before',
            'title_field' => '{{{ hl_type }}}',
            'fields' => $repeater->get_controls(),
        ]);
    }

    /** Group Highlight Content */
    protected function group_highlight() {
        $repeater = new \Elementor\Repeater();
        $repeater->add_responsive_control(
            'group_hl_align_items',
            [
                'label' => __('Align Items', 'mindverse'),
                'options' => [
                    'start' => [ 'title' => __( 'Start', 'mindverse' ), 'icon' => 'eicon-align-start-v', ],
                    'center' => [ 'title' => __( 'Center', 'mindverse' ), 'icon' => 'eicon-align-center-v', ],
                    'end' => [ 'title' => __( 'End', 'mindverse' ), 'icon' => 'eicon-align-end-v', ],
                    'stretch' => [ 'title' => __( 'Stretch', 'mindverse' ), 'icon' => 'eicon-align-stretch-v', ],
                ],
                'type' => 'choose',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_gap',
            [
                'label' => esc_html__( 'Gap', 'mindverse' ),
				'type' => 'slider',
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'gap: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'group_hl_background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
			]
		);
        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'group_hl_border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'separator' => 'before',
            ]
        );
        $repeater->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'group_hl_box_shadow',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'separator' => 'before',
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_border_radius',
            [
                'label' => __( 'Border Radius', 'mindverse' ),
                'type' => 'dimensions',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_padding',
            [
                'label' => __( 'Padding', 'mindverse' ),
                'type' => 'dimensions',
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'group_hl_position_heading',
            [
                'label' => __('POSITION', 'mindverse'),
                'type' => 'heading',
                'separator' => 'before',
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_position',
            [
                'label' => __('Position', 'mindverse'),
                'type' => 'select',
                'default' => '',
                'options' => [
                    '' => __('Default', 'mindverse'),
                    'relative' => __('Relative', 'mindverse'),
                    'absolute' => __('Absolute', 'mindverse'),
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'position: {{VALUE}}'
                ]
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_offset_top',
            [
                'label' => __('Top', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'group_hl_position' => 'absolute',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_offset_right',
            [
                'label' => __('Right', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'group_hl_position' => 'absolute',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_offset_bottom',
            [
                'label' => __('Bottom', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'group_hl_position' => 'absolute',
                ]
            ]
        );
        $repeater->add_responsive_control(
            'group_hl_offset_left',
            [
                'label' => __('Left', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['px', '%', 'custom'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'group_hl_position' => 'absolute',
                ]
            ]
        );
        $this->repeater([
            'name' => 'group_hl_items',
            'separator' => 'before',
            'label' => __('Group Highlight Style', 'mindverse'),
            'fields' => $repeater->get_controls(),
        ]);
    }
}