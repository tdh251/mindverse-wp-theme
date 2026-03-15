<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Tag extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_tag',
            'title'      => __( 'MV Post Tag', 'mindverse' ),
            'icon'       => 'eicon-tags',
            'keywords'   => [ 'mv', 'mindverse', 'tag', 'post' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        $this->register_tag_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Title' , 'mindverse')
        ]);
        $this->justify_content_horizontal([
            'name' => 'post_tag',
            'selectors' => [
                '{{WRAPPER}} .post-tag' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->choose([
            'name' => 'flex_wrap',
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
                '{{WRAPPER}} .post-tag' => 'flex-wrap: {{VALUE}};',
            ],
        ]);
        $this->gap([
            'name' => 'column',
            'label' => __('Column Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-tag' => 'column-gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->gap([
            'name' => 'row',
            'label' => __('Row Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-tag' => 'row-gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }

        /** 
     * Register Tag Style Controls 
     */
    protected function register_tag_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_tag_style', 
            'label' => __('Tag', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'tag_typography',
            'selector' => '{{WRAPPER}} .post-tag a',
        ]);
        $this->start_controls_tabs( 'tag_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([ 
            'name' => 'tag_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'tag_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post-tag a',
		]);
        $this->group_style([
            'name' => 'tag_',
            'selector' => '{{WRAPPER}} .post-tag a',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'tag_style_hover_tab', 
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'tag_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post-tag a:hover',
		]);
        $this->group_style([
            'name' => 'tag_hover_',
            'selector' => '{{WRAPPER}} .post-tag a:hover',
        ]);
        $this->duration([
            'name' => 'tag_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post-tag a' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


}