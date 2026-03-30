<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Accordion extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_accordion',
            'title'      => __( 'MV Accordion', 'mindverse' ),
            'icon'       => 'eicon-accordion',
            'script'     => ['mindverse-accordion'],
            'keywords'   => [ 'mv', 'mindverse', 'accordion', 'faqs' ],
        ];
    }

    /**
     * Register Controls
     */
    protected function register_controls() {
        // Content
        $this->register_style_layout_controls();
        $this->register_content_controls();
        $this->register_interactions_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_header_style_controls();
        $this->register_title_style_controls();
        $this->register_index_style_controls();
        $this->register_icon_style_controls();
        $this->register_content_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**  
     * Register Layout Controls
    */
    protected function register_style_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_style_layout_style', 
            'label' => __('Layout', 'mindverse'),
        ]);
        $this->visual_choice([
            'name' => 'layout_style',
            'label' => __('Layout Style', 'mindverse'),
            'columns' => '1',
            'options' => [
                '0' => [
                    'title' => esc_attr__( 'Layout Style Default', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/accordion_1.webp'),
                ],
                '1' => [
                    'title' => esc_attr__( 'Layout Style 1', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/accordion_2.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Layout Style 2', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/accordion_2.webp'),
                ],
            ],
            'default' => '0',
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Content Controls
    */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse')
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => '',
        ]);
        $this->switcher([
            'name' => 'show_index',
            'separator' => 'before',
            'label' => __('Show Index', 'mindverse'),
            'default' => '',
        ]);
        $this->text([
            'name' => 'index_prefix',
            'label' => __('Index Prefix', 'mindverse'),
            'label_block' => false,
            'condition' => [
                'show_index' => 'yes'
            ],
        ]);
        $this->text([
            'name' => 'index_suffix',
            'label' => __('Index Suffix', 'mindverse'),
            'label_block' => false,
            'condition' => [
                'show_index' => 'yes'
            ],
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Accordion', 'mindverse'),
            'title_field' => '{{{ title }}}',
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __('Title', 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 3,
                    'default' => __('Your Title', 'mindverse'),
                ],
                [
                    'name' => 'content',
                    'label' => __('Content', 'mindverse'),
                    'type' => 'wysiwyg',
                    'default' => __('Accordion content. Click the edit button to change this text.', 'mindverse')
                ],
            ],
            'default' => [
                [
                    'title' => __('Title #1', 'mindverse'),
                    'content' => __('Accordion content. Click the edit button to change this text.', 'mindverse')
                ],
                [
                    'title' => __('Title #2', 'mindverse'),
                    'content' => __('Accordion content. Click the edit button to change this text.', 'mindverse')
                ],
                [
                    'title' => __('Title #3', 'mindverse'),
                    'content' => __('Accordion content. Click the edit button to change this text.', 'mindverse')
                ],
            ]
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Interactions Content Controls
    */
    protected function register_interactions_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_interactions_content', 
            'label' => __('Interactions', 'mindverse')
        ]);
        $this->number([
            'name' => 'default_active',
            'label' => __('Default Active', 'mindverse'),
            'min'  => -1,
            'default' => 1,
            'description' => __('No default item is activated if left blank.', 'mindverse'),
        ]);
        $this->select([
            'name' => 'mode',
            'label' => __('Mode', 'mindverse'),
            'default'  => 'one',
            'options' => [
                'one'      => __('One Item Active', 'mindverse'),
                'multiple' => __('Multiple Items Active', 'mindverse')
            ],
        ]);
        $this->select([
            'name' => 'hide_icon_item_actived',
            'label' => __('Hide Icon Item Actived', 'mindverse'),
            'default'  => 'no',
            'options' => [
                'no'    => __('No', 'mindverse'),
                'yes'   => __('Yes', 'mindverse')
            ],
            'selectors_dictionary' => [
                'no' => '',
                'yes' => '0',
            ],
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-item.is-active .accordion-icon' => 'scale: {{VALUE}};'
            ]
        ]);
        // $this->switcher([
        //     'name' => 'use_default_icon',
        //     'label' => __('Use Default Icon', 'mindverse'),
        //     'default' => 'yes',
        // ]);
        // $this->icons([
        //     'name' => 'close_icon',
        //     'label' => __('Close Icon', 'mindverse'),
        //     'condition' => [
        //         'use_default_icon!' => 'yes'
        //     ]
        // ]);
        // $this->icons([
        //     'name' => 'open_icon',
        //     'label' => __('Open Icon', 'mindverse'),
        //     'condition' => [
        //         'use_default_icon!' => 'yes'
        //     ]
        // ]);
        $this->end_controls_section();
    }

    /**  
     * Register Layout Style Controls
    */
    protected function register_layout_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_layout_style', 
            'label' => __('Layout', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'desc_max_w',
            'label' => __('Description Max Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-content p' => 'max-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'item_spacing',
            'label' => __('Item Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-item + .accordion-item' => 'margin-top: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->dimensions([
            'name' => 'index_margin',
            'label' => __( 'Index Margin', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-index' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->group_background([
            'name' => 'box_gradient_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .accordion .box-border-gradient',
            'fields_options' => [			
				'color' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .box-border-gradient' => '--mv-background-color: {{VALUE}};',
					],
				],
                'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .box-border-gradient' => '--mv-background-color-b: {{VALUE}};',
					],
				],
			],
            'condition' => [
                'layout_style' => ['2']
            ]
		]);
        $this->color([
            'name' => 'gradient_color_1',
            'label' => __('Gradient Color 1', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_2',
            'label' => __('Gradient Color 2', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-2: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_3',
            'label' => __('Gradient Color 3', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-3: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_4',
            'label' => __('Gradient Color 4', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-4: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_5',
            'label' => __('Gradient Color 5', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-5: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_6',
            'label' => __('Gradient Color 6', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-6: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
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
            'selector' => '{{WRAPPER}} .accordion .accordion-item',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .accordion .accordion-item, {{WRAPPER}} .accordion[data-layout_style="2"] .accordion-item .box-border-gradient',
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
            'selector' => '{{WRAPPER}} .accordion .accordion-item:not(.box-gradient):hover, 
                            {{WRAPPER}} .accordion .accordion-item.is-active:not(.box-gradient),
                            {{WRAPPER}} .accordion .box-gradient:before, 
                            {{WRAPPER}} .accordion .is-active.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .accordion .accordion-item:hover, {{WRAPPER}} .accordion .accordion-item.is-active, 
            {{WRAPPER}} .accordion[data-layout_style="2"] .accordion-item:hover .box-border-gradient, {{WRAPPER}} .accordion[data-layout_style="2"] .accordion-item.is-active .box-border-gradient',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-item, {{WRAPPER}} .accordion .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**  
     * Register Header Style Controls
    */
    protected function register_header_style_controls() {
        $this->start_style_section([ 
            'name' => 'style_header_section', 
            'label' => __('Header', 'mindverse'),
        ]);

        $this->start_controls_tabs( 'header_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'header_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'header_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-header',
		]);
        $this->group_style([
            'name' => 'header_',
            'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-header',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'header_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'header_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .accordion .accordion-item:hover .accordion-header:not(.box-gradient), 
                            {{WRAPPER}} .accordion .accordion-item.is-active .accordion-header:not(.box-gradient),
                            {{WRAPPER}} .accordion .accordion-item:hover .accordion-header.box-gradient:before,
                            {{WRAPPER}} .accordion .accordion-item.is-active .accordion-header.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'header_hover_',
            'selector' => '{{WRAPPER}} .accordion .accordion-item:hover .accordion-header, {{WRAPPER}} .accordion .accordion-item.is-active .accordion-header',
        ]);
        $this->duration([
            'name' => 'header_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-header, {{WRAPPER}} .accordion .accordion-header.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
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
            'selector' => '{{WRAPPER}} .accordion .accordion-title',
        ]);
        $this->group_text_shadow([
            'name' => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .accordion .accordion-title',
        ]);
        $this->start_controls_tabs( 'title_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'title_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
			'name' => 'title_fill',
			'selector' => '{{WRAPPER}} .accordion .accordion-title .title-text:before',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-title' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-title .title-text:before' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-title .title-text:before' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_text_stroke([
            'name' => 'title_text_stroke',
            'selector' => '{{WRAPPER}} .accordion .accordion-title',
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'title_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->group_background([
			'name' => 'title_hover_fill',
			'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-title [data-text]:after',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item:hover .accordion-title .title-text:not([data-text]), 
                        {{WRAPPER}} .accordion .accordion-item.is-active .accordion-title .title-text:not([data-text])' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item .accordion-title [data-text]:after' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item .accordion-title [data-text]:after' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_text_stroke([
            'name' => 'title_hover_text_stroke',
            'selector' => '{{WRAPPER}} .accordion .accordion-item:hover .accordion-title, {{WRAPPER}} .accordion .accordion-item.is-active .accordion-title',
        ]);
        $this->duration([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-item .accordion-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**  
     * Register Index Style Controls
    */
    protected function register_index_style_controls() {
        $this->start_style_section([
            'name' => 'section_index_style',
            'label' => __('Index', 'mindverse'),
            'condition' => [
                'show_index' => 'yes'
            ],
        ]);
        $this->group_typography([
            'name' => 'index_typography',
            'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-index',
        ]);
        $this->group_text_shadow([
            'name' => 'index_text_shadow',
            'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-index',
        ]);
        $this->start_controls_tabs( 'index_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'index_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
			'name' => 'index_fill',
			'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-index:before',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item .accordion-index:not([data-text])' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item .accordion-index:before' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item .accordion-index:before' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_text_stroke([
            'name' => 'index_text_stroke',
            'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-index',
        ]);

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'index_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->group_background([
			'name' => 'index_hover_fill',
			'selector' => '{{WRAPPER}} .accordion .accordion-item .accordion-index[data-text]:after',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item:hover .accordion-index:not([data-text]), 
                        {{WRAPPER}} .accordion .accordion-item.is-active .accordion-index:not([data-text])' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item .accordion-index[data-text]:after' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .accordion .accordion-item .accordion-index[data-text]:after' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_text_stroke([
            'name' => 'index_hover_text_stroke',
            'selector' => '{{WRAPPER}} .accordion .accordion-item:hover .accordion-index, {{WRAPPER}} .accordion .accordion-item.is-active .accordion-index',
        ]);
        $this->duration([
            'name' => 'index_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-item .accordion-index' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
            'size_units' => ['px', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .accordion .icon-plus:after, {{WRAPPER}} .accordion .icon-plus:before' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'icon_weight',
            'label' => __('Icon Weight', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .accordion .icon-plus:after, {{WRAPPER}} .accordion .icon-plus:before' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size_width',
            'separator' => 'before',
            'label' => __('Box width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-icon' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size_height',
            'label' => __('Box Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-icon' => 'height: {{SIZE}}{{UNIT}};'
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
                '{{WRAPPER}} .accordion .accordion-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .accordion .accordion-icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .accordion .accordion-icon',
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
                '{{WRAPPER}} .accordion .accordion-item:hover .accordion-icon, 
                {{WRAPPER}} .accordion .accordion-item.is-active .accordion-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .accordion .accordion-item:hover .accordion-icon:not(.box-gradient), 
            {{WRAPPER}} .accordion .accordion-item.is-active .accordion-icon:not(.box-gradient),
            {{WRAPPER}} .accordion .accordion-item .accordion-icon.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .accordion .accordion-item:hover .accordion-icon, {{WRAPPER}} .accordion .accordion-item.is-active .accordion-icon',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-item .accordion-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**  
     * Register Content Style Controls
    */
    protected function register_content_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_content_style', 
            'label' => __('Content', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'content_typography',
            'selector' => '{{WRAPPER}} .accordion .accordion-content p',
        ]);
        $this->color([
            'name' => 'content_text_color',
            'label' => __('Text Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-content p' => 'color: {{VALUE}};'
            ],
        ]);
        $this->color([
            'name' => 'content_link_color',
            'label' => __('Link Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .accordion .accordion-content a' => 'color: {{VALUE}};'
            ],
        ]);
        $this->group_background([
            'name' => 'content_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .accordion .accordion-content p',
		]);
        $this->group_style([
            'name' => 'content_',
            'selector' => '{{WRAPPER}} .accordion .accordion-content p'
        ]);
        $this->end_controls_section();
    }
}