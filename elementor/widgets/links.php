<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Links extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_links',
            'title'      => __( 'MV Links', 'mindverse' ),
            'icon'       => 'eicon-editor-link',
            'keywords'   => [ 'mv', 'mindverse', 'links', 'list' ],
        ];
    }

    /**  
     * Register Controls 
    */
    protected function register_controls() {
        // Content
        $this->register_links_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->regiser_layout_style_controls();
        $this->register_link_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**  
     * Register Layout Style Controls 
    */
    protected function register_links_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_links_content', 
            'label' => __('Content', 'mindverse')
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __("Items", 'mindverse'),
            'title_field' => '{{{ text }}}',
            'fields' => [
                [
                    'name' => 'text',
                    'label' => __('Text', 'mindverse'),
                    'type' => 'textarea',
                    'default' => '',
                ],
                [
                    'name' => 'link',
                    'label' => __('Link', 'mindverse'),
                    'type' => 'url',
                    'default' => [
                        'url' => '#',
                    ]
                ]
            ],
            'default' => [
                [
                    'text' => __("Link #1", 'mindverse')
                ],
                [
                    'text' => __("Link #2", 'mindverse')
                ],
                [
                    'text' => __("Link #3", 'mindverse')
                ]
            ]
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Layout Style Controls 
    */
    protected function regiser_layout_style_controls() {
        $this->start_style_section([
            'name' => 'section_layout_style', 
            'label' => __('Layout', 'mindverse'),
        ]);
        $this->flex_direction([
            'name' => 'link',
            'selectors' => [
                '{{WRAPPER}} .links' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name' => 'link',
            'condition' => [
                'link_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .links' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'link',
            'condition' => [
                'link_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .links' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->align_items_horizontal([
            'name' => 'link',
            'condition' => [
                'link_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .links' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'link',
            'condition' => [
                'link_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .links' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->gap([
            'name' => 'link',
            'selectors' => [
                '{{WRAPPER}} .links' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        // $this->slider([
        //     'name' => 'item_spacing_h',
        //     'separator' => 'before',
        //     'label' => __('Item Spacing', 'mindverse'),
        //     'selectors' => [
        //         '{{WRAPPER}} .links' => '--mv-spacing-inline: {{SIZE}}{{UNIT}};'
        //     ],
        //     'condition' => [
        //         'link_flex_direction!' => ['row', 'row-reverse', ''],
        //     ],
        // ]);
        // $this->slider([
        //     'name' => 'item_spacing_v',            
        //     'separator' => 'before',
        //     'label' => __('Item Spacing', 'mindverse'),
        //     'selectors' => [
        //         '{{WRAPPER}} .links' => '--mv-spacing-block: {{SIZE}}{{UNIT}};'
        //     ],
        //     'condition' => [
        //         'link_flex_direction!' => ['column', 'column-reverse'],
        //     ],
        // ]);
        $this->end_controls_section();
    }

    /**  
     * Register Link Style Controls 
    */
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name' => 'section_link_style',
            'label' => __('Link', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .links .link-item',
        ]);
        $this->group_text_shadow([
            'name' => 'text_shadow',
            'selector' => '{{WRAPPER}} .links .link-item',
        ]);
        $this->start_controls_tabs('text_style_tabs');
        // Normal
        $this->_start_controls_tab([
            'name' => 'text_tab_normal',
            'label' => __("Normal", 'mindverse'),
        ]);
        $this->color([
            'name' =>  'text_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .links .link-item' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'text_stroke',
            'selector' => '{{WRAPPER}} .links .link-item',
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'text_tab_hover',
            'label' => __("Hover", 'mindverse'),
        ]);
        $this->color([
            'name' =>  'text_color_hover',
            'selectors' => [
                '{{WRAPPER}} .links .link-item:hover:not([data-hover="text-flip-3d"])' => 'color: {{VALUE}};',
                '{{WRAPPER}} .links .link-item[data-hover="text-flip-3d"]:after' => 'color: {{VALUE}};'
            ],
            'condition' => [
                'link_hover_style!' => 'text-flip-3d',
            ],
        ]);
        // Text Color 
        $this->group_background([
			'name' => 'text_hover_fill',
			'selector' => '{{WRAPPER}} .links .link-item:after',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .links .link-item:hover:not([data-text]), 
                        {{WRAPPER}} .links .link-item:after' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .links .link-item:after' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .links .link-item:after' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
            ],
            'condition' => [
                'link_hover_style' => 'text-flip-3d',
            ],
		]);
        $this->group_text_stroke([
            'name' => 'text_stroke_hover',
            'selector' => '{{WRAPPER}} .links .link-item:hover',
        ]);
        $this->select([
            'name' => 'link_hover_style',
            'label' => __('Hover Style', 'mindverse'),
            'separator' => 'before',
            'type' => 'select',
            'default' => '',
            'options' => [
                '' => __('None', 'mindverse'),
                'text-underline' => __('Underline', 'mindverse'),
                'text-underline-slide' => __('Underline Slide', 'mindverse'),
                'text-flip-3d' => __('Flip 3D', 'mindverse'),
            ],
        ]);
        $this->slider([
            'name' => 'underline_thickness',
            'label' => __('Underline Thickness', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'default' => ['unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .links .link-item' => '--mv-line-thickness: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'link_hover_style' => ['text-underline', 'text-underline-slide'],
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}