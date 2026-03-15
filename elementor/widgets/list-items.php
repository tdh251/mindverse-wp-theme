<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class List_Items extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_list_items',
            'title'      => __( 'MV List', 'mindverse' ),
            'icon'       => 'eicon-editor-list-ul',
            'keywords'   => [ 'mv', 'mindverse', 'list', 'ul', 'ol' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_list_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_icon_style_controls();
        $this->register_text_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register List Content Controls
     */
    protected function register_list_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_list_content_controls', 
            'label' => __('Content', 'mindverse')
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => __('Common Icon', 'mindverse'),
            'description' => __('This icon applies to all items.', 'mindverse'),
        ]);
        $this->switcher([
            'name' => 'divider',
            'separator' => 'before',
            'label' => __('Divider', 'mindverse'),
            'default' => '',
        ]);
        $this->color([
            'name' => 'divider_color',
            'label' => __('Divider Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .list.has-divider .item + .item' => 'border-color: {{VALUE}};'
            ]
        ]);
        $this->repeater([
            'name' => 'items',
            'separator' => 'before',
            'label' => __("Items", 'mindverse'),
            'title_field' => '{{{ text }}}',
            'fields' => [
                [
                    'name' => 'text',
                    'type' => 'textarea',
                    'label' => __('Text', 'mindverse'),
                    'default' => '',
                ],
                [
                    'name' => 'item_icon',
                    'type' => 'icons',
                    'label' => __('Own Icon', 'mindverse'),
                    'default' => [],
                ],
            ],
            'default' => [
                [
                    'text' => __("List Item 1", 'mindverse')
                ],
                [
                    'text' => __("List Item 2", 'mindverse')
                ],
                [
                    'text' => __("List Item 3", 'mindverse')
                ]
            ]
        ]);
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
        $this->flex_direction([
            'name' => 'list',
            'selectors' => [
                '{{WRAPPER}} .list' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .list' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .list' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->align_items_horizontal([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .list' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .list' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->choose([
            'name' => 'list_wrap',
            'label' => __("Flex Wrap", 'mindverse'),
            'options' => [
                'nowrap' => [
                    'title' => __('Nowrap', 'mindverse'),
                    'icon' => 'eicon-nowrap'
                ],
                'wrap' => [
                    'title' => __('Wrap', 'mindverse'),
                    'icon' => 'eicon-wrap'
                ]
            ],
            'selectors' => [
                '{{WRAPPER}} .list' => 'flex-wrap: {{VALUE}};',
            ],
            'condition' => [
                'list_flex_direction' => ['row', 'row-reverse', ''],
            ],
        ]);
        $this->gap([
            'name' => 'list',
            'selectors' => [
                '{{WRAPPER}} .list' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);

        $this->align_items_horizontal([
            'name' => 'list_item',
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .list .item' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->slider([
            'name' => 'item_spacing_h',
            'label' => __('Item Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .list' => '--mv-spacing-inline: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'list_flex_direction!' => ['row', 'row-reverse', ''],
            ],
        ]);
        $this->slider([
            'name' => 'item_spacing_v',            
            'separator' => 'before',
            'label' => __('Item Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .list' => '--mv-spacing-block: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'list_flex_direction!' => ['column', 'column-reverse'],
            ],
        ]);
        $this->slider([
            'name' => 'item_gap',
            'label' => __('Item Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .list .item' => 'gap: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls(){
        $this->start_style_section([
            'name' => 'style_icon_section',
            'label' => __('Icon', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'default' => ['unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .list .item .item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .list .item .item-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ]
        ]);
        $this->slider([
            'name' => 'box_size_width',
            'label' => __('Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .list .item .item-icon' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'box_size_height',
            'label' => __('Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .list .item .item-icon' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        // Text Color
        $this->color([
            'name' => 'icon_color',
            'separator' => 'before',
            'label' => __( 'Icon Color', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .list .item .item-icon' => 'color: {{VALUE}}',
            ],
        ]);
        // Background 
        $this->group_background([
				'name' => 'icon_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .list .item .item-icon',
                'exclude' => ['image']
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .list .item .item-icon',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Text Style Controls
     */
    protected function register_text_style_controls() {
        $this->start_style_section([
            'name' => 'style_text_section',
            'label' => __('Text', 'mindverse'),
        ]);
        $this->color([
            'name' => 'text_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .list .item' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .list .item',
        ]);
        $this->group_text_shadow([
            'name' => 'text_text_shadow',
            'selector' => '{{WRAPPER}} .list .item',
        ]);
        $this->group_text_stroke([
            'name' => 'text_text_stroke',
            'selector' => '{{WRAPPER}} .list .item',
        ]);

        $this->end_controls_section();
    }
}