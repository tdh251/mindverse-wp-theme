<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Counter_Box extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_counter_box',
            'title'      => __( 'MV Counter Box', 'mindverse' ),
            'icon'       => 'eicon-counter-circle',
            'script'     => ['mindverse-counter'],
            'keywords'   => [ 'mv', 'mindverse', 'counter', 'box', 'number'],
        ];
    }

    protected function register_controls() {
        // Layout
        $this->register_layout_controls();
        // Content
        $this->register_content_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_icon_style_controls();
        $this->register_number_style_controls();
        $this->register_description_style_controls();
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
            'label' => __( 'Layout', 'mindverse' )
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Counter Box 1', 'mindverse' ),
                    ],
                    '2' => [
                        'title' => esc_attr__( 'Counter Box 2', 'mindverse' ),
                        'image' => content_url('default-assets/layout/counter-box-2.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Counter Box 3', 'mindverse' ),
                        'image' => content_url('default-assets/layout/counter-box-3.webp'),
                ],
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
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse'), 
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => esc_html__('Icon', 'mindverse'),
            'type' => 'icons',
            'default' => [
                'value' => 'fas fa-star',
                'library' => 'Font Awesome 5 Free',
            ],
            'condition' => [
                'layout' => ['1', '2'],
            ],
        ]);
        $this->textarea([
            'name' => 'title',
            'label' => esc_html__('Title', 'mindverse'),
            'type' => 'textarea',
            'rows' => 2,
            'default' => esc_html__('Title.', 'mindverse'),
            'condition' => [
                'layout' => ['3'],
            ],
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'label' => esc_html__('Title HTML Tag', 'mindverse'),
            'default' => '',
            'condition' => [
                'layout' => ['3'],
            ],
        ]);
        $this->number([
            'name' => 'starting_number',
            'label' => esc_html__('Starting Number', 'mindverse'),
            'separator' => 'before',
            'min' => 1,
            'default' => 1,
        ]);
        $this->number([
            'name' => 'ending_number',
            'label' => esc_html__('Ending Number', 'mindverse'),
            'min' => 1,
            'default' => 100,
        ]);
        $this->text([
            'name' => 'number_prefix',
            'label' => esc_html__('Number Prefix', 'mindverse'),
            'label_block' => false,
            'separator' => 'before',
        ]);
        $this->text([
            'name' => 'number_suffix',
            'label_block' => false,
            'label' => esc_html__('Number Suffix', 'mindverse'),
        ]);
        $this->select([
            'name' => 'number_delimiter',
            'label' => esc_html__('Number Delimiter', 'mindverse'),
            'separator' => 'before',
            'options' => [
                ''  => esc_html__('None', 'mindverse'),
                '.' => esc_html__('Dot', 'mindverse'),
                ',' => esc_html__('Comma', 'mindverse'),
                ' ' => esc_html__('Space', 'mindverse'),
            ],
            'default' => '',
        ]);
        $this->duration([
            'name' => 'number_anim_duration',
            'label' => __('Animation Duration', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-number' => '--mv-animation-duration: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->textarea([
            'name' => 'desc',
            'label' => esc_html__('Description', 'mindverse'),
            'type' => 'textarea',
            'separator' => 'before',
            'rows' => 5,
            'default' => esc_html__('Enter your description.', 'mindverse'),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Layout Style Controls
     */
    protected function register_layout_style_controls() {
        $this->start_style_section([
            'name' => 'section_layout_style', 
            'label' => __( 'Layout', 'mindverse' ),
        ]);
        $this->flex_direction([
            'name' => 'counter',
            'selectors' => [
                '{{WRAPPER}} .counter-box' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name'      => 'counter',
            'condition' => [
                'counter_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .counter-box' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'counter',
            'condition' => [
                'counter_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .counter-box' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->align_items_horizontal([
            'name' => 'counter',
            'condition' => [
                'counter_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .counter-box' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'counter',
            'condition' => [
                'counter_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .counter-box' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->gap([
            'name' => 'counter',
            'selectors' => [
                '{{WRAPPER}} .counter-box' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);

        $this->gap([
            'label' => __('Content Gap', 'mindverse'),
            'name' => 'counter_content',
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-content' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->align_items_vertical([
            'name' => 'content_',
            'label' => __('Content Align Items', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-content' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->text_alignment([
            'name' => 'content_',
            'label' => __('Content Text Align', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-content' => 'text-align: {{VALUE}};'
            ]
        ]);
        $this->select([
            'name' => 'content_width',
            'label' => __('Content Width', 'mindverse'),
            'default' => '',
            'options' => [
                '' => __('Auto', 'mindverse'),
                '100%' => __('100%', 'mindverse'),
            ],
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-content' => 'width: {{VALUE}};'
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
        $this->_start_controls_tab([ 
            'name' => 'box_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .counter-box',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .counter-box',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'box_style_hover_tab', 
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'box_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .counter-box:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .counter-box:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .counter-box, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
            'name' => 'style_icon_section',
            'label' => __('Icon', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .counter-box .counter-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->color([
            'name' => 'icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .counter-box .counter-box-icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .counter-box .counter-box-icon',
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Layout Style Controls
     */
    protected function register_number_style_controls() {
        $this->start_style_section([
            'name' => 'section_number_style',
            'label' => __('Number', 'mindverse'),
        ]);
        $this->color([
            'name' => 'text_color',
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-number' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .counter-box .counter-box-number',
        ]);
        $this->group_text_shadow([
            'name' => 'text_text_shadow',
            'selector' => '{{WRAPPER}} .counter-box .counter-box-number',
        ]);
        $this->group_text_stroke([
            'name' => 'text_text_stroke',
            'selector' => '{{WRAPPER}} .counter-box .counter-box-number',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Description Style Controls
     */
    protected function register_description_style_controls() {
        $this->start_style_section([
            'name' => 'section_desc_style',
            'label' => __('Description', 'mindverse'),
        ]);
        $this->color([
            'name' => 'desc_color',
            'selectors' => [
                '{{WRAPPER}} .counter-box .counter-box-desc' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .counter-box .counter-box-desc',
        ]);
        $this->group_text_shadow([
            'name' => 'desc_text_shadow',
            'selector' => '{{WRAPPER}} .counter-box .counter-box-desc',
        ]);
        $this->group_text_stroke([
            'name' => 'desc_text_stroke',
            'selector' => '{{WRAPPER}} .counter-box .counter-box-desc',
        ]);
        $this->end_controls_section();
    }
}