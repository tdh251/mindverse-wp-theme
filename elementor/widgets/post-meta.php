<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Meta extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_meta',
            'title'      => __( 'MV Post Meta', 'mindverse' ),
            'icon'       => 'eicon-meta-data',
            'keywords'   => [ 'mv', 'mindverse', 'meta', 'data' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        $this->register_layout_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Meta' , 'mindverse')
        ]);
        $this->number([
            'name' => 'avatar_size',
            'label' => __( 'Avatar Size', 'mindverse' ),
            'default' => 36,
            'min' => 1,
        ]);
        $this->icons([
            'name' => 'date_icon',
            'label' => __( 'Date Icon', 'mindverse' ),
            'separator' => 'before',
            'default' => [
                'value' => [
                    'url' => content_url('/uploads/2026/02/calender.svg'),
                    'id' => 12644,
                ],
                'library' => 'svg',
            ]
        ]);
        $this->icons([
            'name' => 'comment_icon',
            'label' => __( 'Comment Icon', 'mindverse' ),
            'default' => [
                'value' => [
                    'url' => content_url('/uploads/2026/02/comment.svg'),
                    'id' => 12645,
                ],
                'library' => 'svg',
            ]
        ]);
        $this->icons([
            'name' => 'view_icon',
            'label' => __( 'View Icon', 'mindverse' ),
            'default' => [
                'value' => [
                    'url' => content_url('/uploads/2026/02/view.svg'),
                    'id' => 12646,
                ],
                'library' => 'svg',
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Layout Controls Style
     */
    protected function register_layout_style_controls() {
        $this->start_style_section([
            'name' => 'section_layout_style', 
            'label' => __('Layout', 'mindverse')
        ]);
        $this->flex_direction([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-meta' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-meta' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['column', 'column-reverse'],
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-meta' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['', 'row', 'row-reverse'],
            ],
        ]);
        $this->align_items_horizontal([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-meta' => 'align-items: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['column', 'column-reverse'],
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-meta' => 'align-items: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['', 'row', 'row-reverse'],
            ],
        ]);
        $this->gap([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-meta' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }
}