<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Tabs extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_tabs',
            'title'      => __( 'MV Tabs', 'mindverse' ),
            'icon'       => 'eicon-tabs',
            'script'     => [ 'mindverse-tab', 'mindverse-interactions' ],
            'keywords'   => [ 'mv', 'mindverse', 'tabs', 'feature' ],
        ];
    }

    protected function register_controls() {
        // Layout
        $this->layout_section();
        // Content
        $this->content_general_section();
        $this->content_button_section();
        $this->content_button_subtext_section();
        $this->content_content_section();
        $this->content_image_section();
        // Style
        $this->style_layout_buttons_section();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /** Layout */
    protected function layout_section() {
        $this->start_layout_section([ 
            'name' => 'layout_section', 
            'label' => __('Layout', 'mindverse'),
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Tabs 1', 'mindverse' ),
                    'image' => content_url('default-assets/layout/tabs-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Tabs 2', 'mindverse' ),
                    'image' => content_url('default-assets/layout/tabs-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    protected function content_general_section() {
        $this->start_content_section([ 
            'name' => 'content_general_section', 
            'label' => __('General', 'mindverse')
        ]);
        $this->select([
            'name' => 'input_mode',
            'label' => __('Input Mode', 'mindverse'),
            'options' =>[
                'btn' => __('Button', 'mindverse'),
                'content' => __('Content', 'mindverse'),
                'featured' => __('Featured', 'mindverse'),
            ],
            'default' => 'btn',
        ]);        
        $this->text([
            'name' => 'tab_key',
            'label' => __('Tab Key', 'mindverse'),
            'placeholder' => __('eg: tab-demo', 'mindverse'),
            'description' => __('When the button is pressed, the tab associated with the same [tab_key] will be activated.', 'mindverse')
        ]);
        $this->end_controls_section();
    }

    /** Content Button Section */
    protected function content_button_section() {
        $this->start_content_section([ 
            'name' => 'content_button_section', 
            'label' => __('Buttons', 'mindverse'),
            'condition' => [
                // 'layout' => ['1', '2'],
                'input_mode' => 'btn'
            ]
        ]);
        $this->number([
            'name' => 'item_active',
            'label' => __('Default Active', 'mindverse'),
            'min' => 1,
            'default' => 1
        ]);
        $this->icons([
            'name'  => 'action_icon',
            'label' => __( 'Action Icon', 'mindverse' ),
            'type' => 'icons',
            'default' => [
                'value' => [
                    'url' => content_url('/uploads/2025/11/arrow-right.svg'),
                    'id' => 2303
                ],
                'library' => 'svg',
            ],
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->repeater([
            'name' => 'btns',
            'label' => __('Buttons', 'mindverse'),
            'fields' => [
                [
                    'name' => 'btn_text',
                    'label' => __('Button Text', 'mindverse'),
                    'type' => 'text',
                    'default' => __('Click Me', 'mindverse'),
                ],
                [
                    'name'  => 'btn_icon',
                    'label' => __( 'Button Icon', 'mindverse' ),
                    'type' => 'icons',
                    'default' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ]
            ],
            'default' => [
                [
                    'btn_text' => __('Click me', 'mindverse'),
                    'btn_icon' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ],
                [
                    'btn_text' => __('Click me', 'mindverse'),
                    'btn_icon' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ],
                [
                    'btn_text' => __('Click me', 'mindverse'),
                    'btn_icon' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ]
            ]
        ]);
        $this->end_controls_section();
    }

    /** Content Button Section */
    protected function content_button_subtext_section() {
        $this->start_content_section([ 
            'name' => 'content_button_subtext_section', 
            'label' => __('Subtext', 'mindverse'),
            'condition' => [
                'layout' => [ '2' ],
                'input_mode' => 'btn'
            ]
        ]);
        $this->repeater([
            'name' => 'btns_subtext',
            'label' => __('Subtext', 'mindverse'),
            'fields' => [
                [
                    'name' => 'text',
                    'label' => __('Text', 'mindverse'),
                    'type' => 'text',
                    'default' => __('Your subtext', 'mindverse'),
                    'label_block' => true,
                ],
            ],
            'default' => [
                [
                    'text' => __('Your subtext', 'mindverse'),
                ],
                [
                    'text' => __('Your subtext', 'mindverse'),
                ],
                [
                    'text' => __('Your subtext', 'mindverse'),
                ]
            ]
        ]);
        $this->end_controls_section();
    }

    /** Content Content Section */
    protected function content_content_section() {
        $this->start_content_section([ 
            'name' => 'content_content_section', 
            'label' => __('Contents', 'mindverse'),
            'condition' => [
                // 'layout' => ['1'],
                'input_mode' => 'content'
            ]
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => '',
        ]);
        $this->icons([
            'name'  => 'feature_icon',
            'label' => __( 'Feature Icon', 'mindverse' ),
            'type' => 'icons',
            'default' => [
                'value' => 'fas fa-circle',
                'library' => 'fa-solid',
            ],
        ]);
        $this->repeater([
            'name' => 'contents',
            'label' => __('Contents', 'mindverse'),
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __('Title', 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 3,
                    'default' => __('Your Title', 'mindverse'),
                ],
                [
                    'name'  => 'desc',
                    'label' => __('Description', 'mindverse'),
                    'type'  => 'textarea',
                    'rows'  => 10,
                    'default' => __('Item description. Click the edit description.', 'mindverse'),
                ],
                [
                    'name' => 'features',
                    'label' => __('Features', 'mindverse'),
                    'type' => 'textarea',
                    'default' =>  __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                    'description' => __('Separate features with |', 'mindverse'),
                    'rows' => 10,
                ],
            ],
            'default' => [
                [
                    'title'     => __('Title #1', 'mindverse'),
                    'description'      => __('Item description. Click the edit description.', 'mindverse'),
                    'features'  => __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                ],
                [
                    'title'     => __('Title #2', 'mindverse'),
                    'description'      => __('Item description. Click the edit description.', 'mindverse'),
                    'features'  => __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                ],
                [
                    'title'     => __('Title #3', 'mindverse'),
                    'description'      => __('Item description. Click the edit description.', 'mindverse'),
                    'features'  => __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                ],
            ]
        ]);
        $this->end_controls_section();
    }

    /** Content Image Section*/
    protected function content_image_section() {
        $this->start_content_section([ 
            'name' => 'content_image_section', 
            'label' => __('Images', 'mindverse'), 
            'condition' => [
                // 'layout' => ['1'],
                'input_mode' => 'featured'
            ]
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Apply all items)', 'mindverse' ),
        ]);
        $this->repeater([
            'name' => 'imgs',
            'label' => __('Images', 'mindverse'),
            'fields' => [
                [
                    'name' => 'img',
                    'type' => 'media',
                    'label' => __('Choose Image', 'mindverse'),
                    'default' => [
                        'id' => 0,
                    ]
                ]
            ],
            'default' => [
                ['img' => ['id' => 0]],
                ['img' => ['id' => 0]],
                ['img' => ['id' => 0]],
            ]
        ]);
        $this->end_controls_section();
    }

    /**  Style Layout Section */
    protected function style_layout_buttons_section() {
        $this->start_style_section([
            'name' => 'style_layout_buttons_section', 
            'label' => __('Layout', 'mindverse'),
            'condition' => [
                'layout' => ['1'],
                'input_mode' => 'btn'
            ]
        ]);
        $this->flex_direction([
            'name' => 'tab_btn',             
            'selectors' => [
                '{{WRAPPER}} .tabs .tab-buttons' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .tabs .tab-buttons' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .tabs .tab-buttons' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->align_items_horizontal([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .tabs .tab-buttons' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'list',
            'condition' => [
                'list_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .tabs .tab-buttons' => 'align-items: {{VALUE}};',
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
                '{{WRAPPER}} .tabs .tab-buttons' => 'flex-wrap: {{VALUE}};',
            ],
            'condition' => [
                'list_flex_direction' => ['row', 'row-reverse', ''],
            ],
        ]);
        $this->slider([
            'name' => 'item_gap',
            'label' => __('Item Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .tabs .tab-buttons .item' => 'gap: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_section();
    }

}