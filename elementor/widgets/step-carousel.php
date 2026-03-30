<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Traits\Swiper_Trait;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Step_Carousel extends Mindverse_Widget_Base {

    use Swiper_Trait;

    protected function widget_info() {
        return [
            'name'       => 'mindverse_step_carousel',
            'title'      => __( 'MV Step Carousel', 'mindverse' ),
            'script'     => ['mindverse-carousel'],
            'style'      => ['swiper', 'mindverse-animation'],
            'icon'       => 'eicon-slider-push',
            'keywords'   => [ 'mv', 'mindverse', 'step', 'carousel', 'swiper', 'work' ],
        ];
    }

    protected function register_controls() {
        // Layout
        $this->register_layout_style_controls();
        // Content
        $this->register_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_box_style_controls();
        $this->register_index_style_controls();
        $this->register_title_style_controls();
        $this->register_description_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_carousel_settings_controls();
    }

    /**  
     * Register Layout Controls
    */
    protected function register_layout_style_controls() {
        $this->start_layout_section([ 
            'name' => 'section_layout', 
            'label' => __( 'Layout', 'mindverse' )
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Layot 1', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/step-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Layot 2', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/step-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Content Controls
    */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __( 'Content', 'mindverse' ),
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Steps', 'mindverse'),
            'title_field' => '{{{ title }}}',
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __("Title", 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 3,
                    'default' => __('Title #', 'mindverse')
                ],
                [
                    'name' => 'desc',
                    'label' => __("Description", 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 10,
                ],
            ],
            'default' => [
                [
                    'title' => __( 'Title #1', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'title' => __( 'Title #2', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'title' => __( 'Title #3', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'title' => __( 'Title #4', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'title' => __( 'Title #5', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
            ],
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
            'selector' => '{{WRAPPER}} .step-carousel .step',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .step-carousel .step',
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
            'selector' => '{{WRAPPER}} .step-carousel .step:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .step-carousel .step:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** Index Style */
    protected function register_index_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_index_style', 
            'label' => __('Index', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'index_typography',
            'selector' => '{{WRAPPER}} .step-carousel .step-index',
        ]);
        $this->group_text_shadow([
            'name' => 'index_text_shadow',
            'selector' => '{{WRAPPER}} .step-carousel .step-index',
        ]);
        $this->start_controls_tabs('index_controls_tabs');
        /** Normal */
        $this->_start_controls_tab([
            'name' => 'index_tab_normal',
            'label' => __('Normal', 'mindverse'),
        ]);
        $this->color([
            'name' =>  'index_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step-index' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'index_text_stroke',
            'selector' =>'{{WRAPPER}} .step-carousel .step-index',
        ]);
        $this->group_background([
            'name' => 'index_background',
            'types' => [ 'classic', 'gradient' ],
            'separator' => 'before',
            'selector' => '{{WRAPPER}} .step-carousel .step-index',
		]);
        $this->group_border([
            'name' => 'index_border',
            'selector' => '{{WRAPPER}} .step-carousel .step-index',
            'separator' => 'before',
        ]);

        // Box Shadow
        $this->group_box_shadow([
            'name' => 'index_box_shadow',
            'selector' => '{{WRAPPER}} .step-carousel .step-index',
        ]);
        // Border Radius
        $this->dimensions([
            'name' => 'index_border_radius',
            'label' => __( 'Border Radius', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step-index' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding 
        $this->dimensions ([
            'name' => 'index_padding',
            'label' => __( 'Padding', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step-index' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'index_tab_hover',
            'label' => __('Hover', 'mindverse'),
        ]);
        $this->color([
            'name' =>  'index_color_hover',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step:hover .step-index' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'index_text_stroke_hover',
            'selector' =>'{{WRAPPER}} .step-carousel .step:hover .step-index',
        ]);

        $this->group_background([
            'name' => 'index_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'separator' => 'before',
            'selector' => '{{WRAPPER}} .step-carousel .step:hover .step-index',
		]);
        $this->group_border([
            'name' => 'index_hover_border',
            'selector' => '{{WRAPPER}} .step-carousel .step:hover .step-index',
            'separator' => 'before',
        ]);

        // Box Shadow
        $this->group_box_shadow(
			[
				'name' => 'index_hover_box_shadow',
				'selector' => '{{WRAPPER}} .step-carousel .step:hover .step-index',
			]
		);
        // Border Radius
        $this->dimensions([
            'name' => 'index_hover_border_radius',
            'label' => __( 'Border Radius', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step:hover .step-index' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding 
        $this->dimensions ([
            'name' => 'index_hover_padding',
            'label' => __( 'Padding', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step:hover .step-index' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'selector' => '{{WRAPPER}} .step-carousel .step-title',
        ]);
        $this->group_text_shadow([
            'name' => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .step-carousel .step-title',
        ]);
        $this->start_controls_tabs('title_controls_tabs');
        /** Normal */
        $this->_start_controls_tab([
            'name' => 'title_tab_normal',
            'label' => __('Normal', 'mindverse'),
        ]);
        $this->color([
            'name' =>  'title_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'title_text_stroke',
            'selector' =>'{{WRAPPER}} .step-carousel .step-title',
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'title_tab_hover',
            'label' => __('Hover', 'mindverse'),
        ]);
        $this->color([
            'name' =>  'title_color_hover',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step:hover .step-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'title_text_stroke_hover',
            'selector' =>'{{WRAPPER}} .step-carousel .step:hover .step-title',
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** 
     * Register Title Style Controls 
    */       
    protected function register_description_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_desc_style', 
            'label' => __('Description', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .step-carousel .step-description',
        ]);
        $this->start_controls_tabs('desc_controls_tabs');
        /** Normal */
        $this->_start_controls_tab([
            'name' => 'desc_tab_normal',
            'label' => __('Normal', 'mindverse'),
        ]);
        $this->color([
            'name' =>  'desc_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'desc_tab_hover',
            'label' => __('Hover', 'mindverse'),
        ]);
        $this->color([
            'name' =>  'desc_color_hover',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-carousel .step:hover .step-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
}