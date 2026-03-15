<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Step_List extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_step_list',
            'title'      => __( 'MV Step List', 'mindverse' ),
            'icon'       => 'eicon-slider-push',
            'keywords'   => [ 'mv', 'mindverse', 'step', 'list', 'work', 'progress' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_box_style_controls();
        $this->register_index_style_controls();
        $this->register_title_style_controls();
        $this->register_decription_style_controls();
        $this->register_line_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse') 
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
        $this->_start_controls_tab([ 
            'name' => 'box_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .step-list .step-inner',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .step-list .step-inner',
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
            'selector' => '{{WRAPPER}} .step-list .step-inner:not(.box-gradient):hover, {{WRAPPER}} .step-list .step-inner.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .step-list .step-inner:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .step-list .step-inner, {{WRAPPER}} .step-list .step-inner.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
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
        ]);
        $this->group_typography([
            'name' => 'index_typography',
            'selector' => '{{WRAPPER}} .step-list .step-index',
        ]);
        $this->color([
            'name' =>  'index_color',
            'label' => __('Text Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .step-list .step-index' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'index_background',
            'types' => [ 'classic', 'gradient' ],
            'separator' => 'before',
            'selector' => '{{WRAPPER}} .step-list .step-index',
		]);
        $this->group_style([
            'name' => 'index_',
            'selector' => '{{WRAPPER}} .step-list .step-index',
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
        $this->color([
            'name' =>  'title_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-list .step-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .step-list .step-title',
        ]);
        $this->group_text_shadow([
            'name' => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .step-list .step-title',
        ]);
        $this->group_text_stroke([
            'name' => 'title_text_stroke',
            'selector' =>'{{WRAPPER}} .step-list .step-title',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Description Style Controls 
     */
    protected function register_decription_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_desc_style', 
            'label' => __('Description', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .step-list .step-description',
        ]);
        $this->color([
            'name' =>  'desc_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-list .step-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Line Style Controls 
     */
    protected function register_line_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_line_style', 
            'label' => __('Line', 'mindverse'),
        ]);
        $this->color([
            'name' =>  'line_color',
            'label' => __('Line Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .step-list .step-line' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_section();
    }

}