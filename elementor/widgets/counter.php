<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Counter extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_counter',
            'title'      => __( 'MV Counter', 'mindverse' ),
            'icon'       => 'eicon-counter',
            'script'     => ['mindverse-counter'],
            'keywords'   => [ 'mv', 'mindverse', 'counter', 'number' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_counter_content_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_number_style_controls();
        // Setting
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Counter Content Controls
     */
    protected function register_counter_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_counter_content', 
            'label' => __('Content', 'mindverse')
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
        $this->justify_content_horizontal([
            'name'      => 'counter',
            'selectors' => [
                '{{WRAPPER}} .counter' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->align_items_horizontal([
            'name' => 'counter',
            'selectors' => [
                '{{WRAPPER}} .counter' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->gap([
            'name' => 'counter',
            'selectors' => [
                '{{WRAPPER}} .counter' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name' => 'counter_box_width',
            'label' => __('Box Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .counter' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'counter_box_height',
            'label' => __('Box Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Box Style Controls
     */
    protected function register_box_style_controls() {
        $this->start_style_section([ 
            'name' => 'style_box_section', 
            'label' => __('Box', 'mindverse'),
        ]);
        $this->group_background([
            'name' => 'counter_box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .counter',
		]);
        $this->group_style([
            'name' => 'counter_box_',
            'selector' => '{{WRAPPER}} .counter',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Number Style Controls
     */
    protected function register_number_style_controls() {
        $this->start_style_section([
            'name' => 'section_number_style',
            'label' => __('Number', 'mindverse'),
        ]);
        $this->group_background([
			'name' => 'counter_fill',
			'selector' => '{{WRAPPER}} .counter',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .counter' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .counter' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .counter' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        
        $this->color([
            'name' => 'counter_color',
            'label' => __('Number Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .counter' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_typography([
            'name' => 'counter_typography',
            'selector' => '{{WRAPPER}} .counter',
        ]);
        $this->group_text_shadow([
            'name' => 'counter_text_shadow',
            'selector' => '{{WRAPPER}} .counter',
        ]);
        $this->group_text_stroke([
            'name' => 'counter_text_stroke',
            'selector' => '{{WRAPPER}} .counter',
        ]);
        $this->end_controls_section();
    }
}