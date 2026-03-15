<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Title extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_title',
            'title'      => __( 'MV Title', 'mindverse' ),
            'icon'       => 'eicon-t-letter',
            'keywords'   => [ 'mv', 'mindverse', 'title', 'heading' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_title_content_controls();
        // Style
        $this->register_title_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Title Content Controls
     */
    protected function register_title_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_ttle_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->select([
            'name' => 'get_page_title',
            'label' => __('Get Title', 'mindverse'),
            'options' => [
                ''        => __('Enter Manually', 'mindverse'),
                'default' => __('Default', 'mindverse'),
                'custom'  => __('Custom', 'mindverse'),
            ],
            'default' => '',
        ]);
        // Title
        $this->textarea([
            'name'  => 'title',
            'label' => __('Title', 'mindverse'),
            'default' => __('Your Title Here', 'mindverse'),
            'condition' => [
                'get_page_title' => ''
            ]
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => 'h5',
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before',
        ]);
        $this->text_alignment([
            'selectors' => [
                '{{WRAPPER}} .title' => 'text-align: {{VALUE}}',
            ],
            'separator' => 'before',
        ]);
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
            'selector' => '{{WRAPPER}} .title',
        ]);
        $this->group_text_shadow([
            'name' => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .title',
        ]);
        $this->start_controls_tabs( 'title_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([ 
            'name' => 'title_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
			'name' => 'title_fill',
			'selector' => '{{WRAPPER}} .title',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .title' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .title' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .title' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_background([
            'name' => 'title_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .title',
        ]);
        // Group Style
        $this->group_style([
            'name' => 'title_',
            'selector' => '{{WRAPPER}} .title'
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->_start_controls_tab([ 
            'name' => 'title_style_hover_tab',
            'label' => __( 'Hover', 'mindverse' ) 
        ]);  
        $this->color([
            'name' => 'title_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post .post-title:hover a:not([data-text]), 
                {{WRAPPER}} .post .post-title a:after' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
			'name' => 'title_hover_fill',
			'selector' => '{{WRAPPER}} .title:hover',
            'separator' => 'before',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .title:hover' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .title:hover' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .title:hover' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_background([
            'name' => 'title_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .title:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        // Border Color 
        $this->color([
			'name' => 'title_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .title:hover' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'title_hover',
            'selector' => '{{WRAPPER}} .title:hover'
        ]);
        $this->duration([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->select([
            'name' => 'title_hover_style',
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
                '{{WRAPPER}} .title' => '--mv-line-thickness: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'title_hover_style' => ['text-underline', 'text-underline-slide'],
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}