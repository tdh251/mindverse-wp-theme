<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Traits\Swiper_Trait;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Icon_Box_Carousel extends Mindverse_Widget_Base {

    use Swiper_Trait;

    protected function widget_info() {
        return [
            'name'       => 'mindverse_icon_box_carousel',
            'title'      => __( 'MV Icon Box Carousel', 'mindverse' ),
            'script'     => ['mindverse-carousel'],
            'style'      => ['swiper'],
            'icon'       => 'eicon-slider-push',
            'keywords'   => [ 'mv', 'mindverse', 'step', 'carousel', 'swiper', 'icon-box' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Layout
        $this->register_layout_controls();
        // Content
        $this->register_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_icon_style_controls();
        $this->register_image_style_controls();
        $this->register_title_style_controls();
        $this->register_description_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_carousel_settings_controls();
    }

    /** 
     * Register Layout Controls
     */
    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'layout_section', 
            'label' => 'Layout' 
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Custom', 'mindverse' ),
                ],
                '2' => [
                    'title' => esc_attr__( 'Icon Box 2', 'mindverse' ),
                    'image' => content_url('default-assets/layout/icon-box-2.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Icon Box 3', 'mindverse' ),
                    'image' => content_url('default-assets/layout/icon-box-3.webp'),
                ]
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Layout Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'mindverse'),
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'mindverse'),
            'fields' => [
                [
                    'name' => 'is_icon_img',
                    'label' => __('Icon Image', 'mindverse'),
                    'type' => 'switcher',
                    'default' => '',
                ],
                [
                    'name'  => 'img',
                    'label' => __( 'Choose Image', 'mindverse' ),
                    'type' => 'media',
                    'default' => [
                        'id' => 0,
                    ],
                    'condition' => [
                        'is_icon_img' => 'yes'
                    ]
                ],
                [
                    'name' => 'icon',
                    'label' => __("Icon", 'mindverse'),
                    'type' => 'icons',
                    'condition' => [
                        'is_icon_img!' => 'yes'
                    ]
                ],
                [
                    'name' => 'title',
                    'label' => __("Title", 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 3,
                ],
                [
                    'name' => 'desc',
                    'label' => __("Description", 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 10,
                ],
                [
                    'name' => 'link',
                    'label' => __("Link", 'mindverse'),
                    'type' => 'url',
                ],
            ],
            'default' => [
                [
                    'is_icon_img' => '',
                    'icon'  => [
                        'value' => 'fas fa-circle',
					    'library' => 'fa-solid',
                    ],
                    'img' => [
                        'id' => 0,
                    ], 
                    'title' => __( 'Title #1', 'mindverse' ),
                    'desc'  => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'is_icon_img' => '',
                    'icon'  => [
                        'value' => 'fas fa-circle',
					    'library' => 'fa-solid',
                    ],
                    'img' => [
                        'id' => 0,
                    ], 
                    'title' => __( 'Title #2', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'is_icon_img' => '',
                    'icon'  => [
                        'value' => 'fas fa-circle',
					    'library' => 'fa-solid',
                    ],
                    'img' => [
                        'id' => 0,
                    ], 
                    'title' => __( 'Title #3', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'is_icon_img' => '',
                    'icon'  => [
                        'value' => 'fas fa-circle',
					    'library' => 'fa-solid',
                    ],
                    'img' => [
                        'id' => 0,
                    ], 
                    'title' => __( 'Title #4', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'is_icon_img' => '',
                    'icon'  => [
                        'value' => 'fas fa-circle',
					    'library' => 'fa-solid',
                    ],
                    'img' => [
                        'id' => 0,
                    ], 
                    'title' => __( 'Title #5', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
            ],
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => 'div',
            'separator' => 'before',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Layout Style Controls
     */
    protected function register_layout_style_controls() {
        $this->start_style_section([
            'name' => 'section_layout-Style', 
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

        $this->choose([
            'name' => 'title_position',
            'label' => __('Title Position', 'mindverse'),
            'separator' => 'before',
            'options' => [
                'above' => [
                    'title' => __('Above', 'mindverse'),
                    'icon' => 'eicon-v-align-top',
                ],
                'below' => [
                    'title' => __('Below', 'mindverse'),
                    'icon' => 'eicon-v-align-bottom',
                ],
            ],
        ]);
        $this->text_alignment([
            'name' => 'content_',
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-content' => 'text-align: {{VALUE}};'
            ]
        ]);
        $this->gap([
            'name' => 'content',
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-content' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name' => 'desc_max_width',
            'label' => __('Description Max Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-description' => 'max-width: {{SIZE}}{{UNIT}};'
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
            'name' => 'box_min_height',
            'label' => __('Min Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'min-height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs( 'box_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'box_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        // Background 
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon-box',
            'exclude' => ['image']
        ]);
        // Group Style
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .icon-box'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'box_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        // Background 
        $this->group_background([
			'name' => 'box_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .icon-box:not(.box-gradient):hover, {{WRAPPER}} .icon-box.box-gradient:before',
		]);
        // Border Color 
        $this->color([
			'name' => 'box_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .icon-box:hover' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'box_hover',
            'selector' => '{{WRAPPER}} .icon-box:hover'
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-box' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
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
        $this->color([
            'name' => 'icon_copy_color',
            'label' => __('Icon Big Color', 'mindverse'),
            'condition' => [
                'layout' => '2',
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-box .icon-box-icon .icon-copy' => 'color: {{VALUE}};',
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
        $this->color([
            'name' => 'icon_copy_hover_color',
            'label' => __('Icon Big Color', 'mindverse'),
            'condition' => [
                'layout' => '2',
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-box:hover .icon-box-icon .icon-copy' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon-box:hover .icon-box-icon:not(.box-gradient), {{WRAPPER}} .icon-box .icon-box-icon.box-gradient:before',
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
            'name' => 'section_umage_style',
            'label' => __('Image', 'mindverse'),
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
						'{{WRAPPER}} .icon-box:hover .icon-box-title, 
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
    protected function register_description_style_controls() {
        $this->start_style_section([
            'name' => 'section_description_style',
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