<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Icon_Box_Marquee extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_icon_box_marquee',
            'title'      => __( 'MV Icon Box Marquee', 'mindverse' ),
            'icon'       => 'eicon-carousel',
            'script'     => ['marquee'],
            'keywords'   => [ 'mv', 'mindverse', 'img', 'image', 'marquee','slider', 'ma', 'quee' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Layout 
        $this->register_layout_controls();
        // Content
        $this->register_icon_box_content_controls();
        $this->register_interactions_content_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_icon_style_controls();
        $this->register_image_style_controls();
        $this->register_title_style_controls();
        $this->register_desc_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

        /**  
     * Register Layout Controls
    */
    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_layout', 
            'label' => __('Layout', 'mindverse')
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Icon Box Marquee 1', 'mindverse' ),
                    'image' => content_url('default-assets/layout/icon-box-marquee-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Icon Box Marquee 2', 'mindverse' ),
                    'image' => content_url('default-assets/layout/icon-box-marquee-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Box Content Controls
     */
    protected function register_icon_box_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_icon_box_content', 
            'label' => __('Content', 'mindverse'),
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => '',
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'mindverse'),
            'fields' => [
                [
                    'name' => 'is_icon_img',
                    'label' => __('Is Icon Image', 'mindverse'),
                    'type' => 'switcher',
                    'default' => '',
                ],
                [
                    'name' => 'icon',
                    'type' => 'icons',
                    'label' => __('Icon', 'mindverse'),
                    'condition' => [
                        'is_icon_img!' => 'yes',
                    ],
                ],
                [
                    'name' => 'img',
                    'label' => __('Image', 'mindverse'),
                    'type' => 'media',
                    'default' => [
                        'id' => 0,
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'is_icon_img' => 'yes',
                    ],
                ],
                [
                    'name'  => 'img_size',
                    'label' => esc_html__( 'Image Size', 'mindverse' ),
                    'type' => 'image_dimensions',
                    'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Only apply this item)', 'mindverse' ),
                    'condition' => [
                        'is_icon_img!' => 'yes',
                    ],
                ],
                [
                    'name' => 'title',
                    'label' => __('Title', 'mindverse'),
                    'type' => 'textarea',
                    'label_block' => true,
                    'separator' => 'before',
                    'row' => 3
                ],
                [
                    'name' => 'desc',
                    'label' => __('Description', 'mindverse'),
                    'type' => 'textarea',
                    'separator' => 'before',
                    'rows' => 5,
                ],
                [
                    'name' => 'desc_after',
                    'label' => __('Description After', 'mindverse'),
                    'type' => 'text',
                ],
                [
                    'name' => 'link',
                    'label' => __("Link", 'mindverse'),
                    'type' => 'url',
                    'separator' => 'before',
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Interactions Content Controls
     */
    protected function register_interactions_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_interactions_content', 
            'label' => __('Interactions', 'mindverse'), 
        ]);
        $this->select([
            'name' => 'direction',
            'label' => __('Direction', 'mindverse'),
            'separator' => 'before',
            'default' => 'rtl',
            'options' => [
                'rtl' => __('Right to Left', 'mindverse'),
                'ltr' => __('Left to Right', 'mindverse'),
            ]
        ]);
        $this->switcher([
            'name' => 'pause_on_hover',
            'label' => __('Pause On Hover', 'mindverse'),
            'default' => '',
        ]);
        $this->number([
            'name' => 'marquee_anim_duration',
            'label' => __('Animation Duration(s)', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-inner' => '--mv-animation-duration: {{VALUE}}s;',
            ]
        ]);
        $this->slider([
            'name' => 'spacing',
            'label' => __('Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-inner' => '--mv-spacing-inline: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Layout Style Controls
     */
    protected function register_layout_style_controls() {
        $this->start_style_section([
            'name' => 'style_layout_section', 
            'label' => __('Layout', 'mindverse'),
        ]);
        $this->flex_direction([
            'name' => 'icon_box',
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name'      => 'icon_box',
            'condition' => [
                'icon_box_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'icon_box',
            'condition' => [
                'icon_box_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->align_items_horizontal([
            'name' => 'icon_box',
            'condition' => [
                'icon_box_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'icon_box',
            'condition' => [
                'icon_box_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->gap([
            'name' => 'icon_box',
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->dimensions([
            'name' => 'box_margin',
            'label' => __('Box Margin', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
        ]);
        $this->choose([
            'name' => 'title_position',
            'label' => __('Title Position', 'mindverse'),
            'separator' => 'before',
            'toggle' => true,
            'options' => [
                'column' => [
                    'title' => __('Above', 'mindverse'),
                    'icon' => 'eicon-v-align-top',
                ],
                'column-reverse' => [
                    'title' => __('Below', 'mindverse'),
                    'icon' => 'eicon-v-align-bottom',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-content' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->text_alignment([
            'name' => 'content_',
            'label' => __('Content Text Align', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-content' => 'text-align: {{VALUE}};'
            ]
        ]);
        $this->gap([
            'name' => 'content',
            'label' => __('Content Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-content' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Box Style Controls
     */
    protected function register_box_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_style', 
            'label' => __('Box', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'box_width',
            'label' => __('Box Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .icon-box' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'box_height',
            'label' => __('Box Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .icon-box' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs( 'box_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'box_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .marquee .icon-box',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .marquee .icon-box',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'box_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .marquee .icon-box:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .marquee .icon-box:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .marquee .icon-box, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __('Icon', 'mindverse'),
            'condition' => [
                'is_icon_img!' => 'yes'
            ]
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .icon-box .icon-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
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
                '{{WRAPPER}} .icon-box .icon-box-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon-box .icon-box-icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .icon-box .icon-box-icon',
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
                '{{WRAPPER}} .icon-box:hover .icon-box-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon-box:hover .icon-box-icon',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .icon-box:hover .icon-box-icon',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Register Image Style Controls
     */
    protected function register_image_style_controls() {
        $this->start_style_section([
            'name' => 'section_image_style',
            'label' => __('Image', 'mindverse'),
            'condition' => [
                'is_icon_img' => 'yes'
            ]
        ]);
        $this->slider([
            'name' => 'img_width',
            'label' => __('Image Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon img' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name' => 'img_height',
            'label' => __('Image Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon img' => 'height: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name' => 'img_box_size',
            'label' => __('Box Size', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->start_controls_tabs( 'img_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'img_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_style_image([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .icon-box .icon-box-icon img',
        ]);
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'img_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->group_style_image([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .icon-box .icon-box-icon img',
        ]);
        $this->duration([
            'name' => 'img_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon img' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Title Style Controls
     */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style', 
            'label' => __('Title', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .icon-box .icon-box-title',
        ]);
        $this->group_text_shadow([
            'name' => 'btntext_shadow',
            'selector' => '{{WRAPPER}} .icon-box .icon-box-title',
        ]);
        $this->start_controls_tabs( 'title_text_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'title_text_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
		$this->group_background([
			'name' => 'title_text_fill',
			'selector' => '{{WRAPPER}} .icon-box .icon-box-title',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .icon-box .icon-box-title' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .icon-box .icon-box-title' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .icon-box .icon-box-title' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->end_controls_tab();
        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'title_text_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        // Text Color 
		$this->group_background([
			'name' => 'title_text_fill_hover',
			'selector' => '{{WRAPPER}} .icon-box .icon-box-title:after',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .icon-box .icon-box-title:hover, 
						{{WRAPPER}} .icon-box .icon-box-title:after' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .icon-box .icon-box-title:after' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .icon-box .icon-box-title:after' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->duration([
            'name' => 'text_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Register Description Style Controls
     */
    protected function register_desc_style_controls() {
        $this->start_style_section([
            'name' => 'section_desc_style',
            'label' => __('Description', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .icon-box .icon-box-description',
        ]);
        $this->start_controls_tabs( 'desc_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'desc_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'desc_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->color([
            'name' => 'desc_after_color',
            'label' => __('After Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-description .description-after' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'desc_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'desc_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box:hover .icon-box-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->color([
            'name' => 'desc_after_hover_color',
            'label' => __('After Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box:hover .icon-box-description .description-after' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'desc_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-description' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
