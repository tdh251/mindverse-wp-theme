<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Play_Video extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_play_video',
            'title'      => __( 'Mindverse Play Video', 'mindverse' ),
            'icon'       => 'eicon-play',
            'script'     => ['mindverse-interactions'],
            'keywords'   => [ 'mv', 'mindverse', 'play', 'video' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_video_content_controls();
        $this->register_button_content_controls();

        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_button_style_controls();
        $this->register_button_icon_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Video Content Controls
     */
    protected function register_video_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_video_content', 
            'label' => __('Video', 'mindverse'),
        ]);
        $this->group_background([
            'name' => 'thumbnail',
            'label' => __('Video Thumbnail', 'mindverse'),
            'selector' => '{{WRAPPER}} .play-video'
        ]);
        $this->slider([
            'name'  => 'video_height',
            'label' => __('Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .play-video' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->url([
            'name' => 'link',
            'label' => __('Video Link', 'mindverse'),
            'separator' => 'before',
            'options' => [ 'url' ],
            'default' => [
                'url' => 'https://youtu.be/NSnkb1IAjbE?si=8JLIfyH90RkLAw5J'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Button Play Video Controls
     */
    protected function register_button_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_button_content', 
            'label' => __('Button', 'mindverse'),
        ]);
        $this->visual_choice([
            'name' => 'btn_style',
            'label' => __('Button Style', 'mindverse'),
            'columns' => 3,
            'options' => [
                'primary' => [
                    'title' => esc_attr__( 'Primary', 'mindverse' ),
                    'image' => content_url('default-assets/layout/btn-play-1.webp'),
                ],
                'secondary' => [
                    'title' => esc_attr__( 'Secondary', 'mindverse' ),
                ],
                'third' => [
                    'title' => esc_attr__( 'Third', 'mindverse' ),
                    'image' => content_url('default-assets/layout/btn-play-3.webp'),
                ],
                '' => [
                    'title' => esc_attr__( 'Custom', 'mindverse' ),
                    'image' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ],
            'default' => 'primary',
        ]);
        $this->icons([
            'name' => 'btn_icon',
            'label' => __('Button Icon', 'mindverse'),
            'separator' => 'before',
            'default' => [
                'value' => [
                    'url' => content_url('/wp-content/uploads/2025/10/play.svg'),
                    'id'  => 749,
                ],
                'library' => 'svg',
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
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .play-video'
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Button Style Controls
     */
    protected function register_button_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_button_style', 
            'label' => __('Button', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'btn_width',
            'label' => __('Button Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button-play-video' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name' => 'btn_height',
            'label' => __('Button Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button-play-video' => 'height: {{SIZE}}{{UNIT}};',
            ]
        ]);
        // Start Tab
        $this->start_controls_tabs( 'btn_tabs' );
        // Normal Tab
        $this->_start_controls_tab([
            'name' => 'btn_normal_tab', 
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'btn_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .button-play-video',
		]);
        $this->group_style([
            'name' => 'btn_',
            'selector' => '{{WRAPPER}} .button-play-video',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([ 
            'name' => 'btn_hover_tab',
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'btn_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} [data-hover]:before, {{WRAPPER}} .button-gradient:before, 
                        {{WRAPPER}} .button:not([data-hover]):not(.button-gradient):not([data-hover="spotlightFill"]):hover, 
                        {{WRAPPER}} .button[data-hover="spotlightFill"] .spotlight-item',
		]);
        $this->group_style([
            'name' => 'btn_hover_',
            'selector' => '{{WRAPPER}} .button-play-video:hover',
        ]);
        $this->duration([
            'name' => 'btn_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button-play-video, {{WRAPPER}} .button-play-video.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->select([
			'name' => 'btn_hover_style',
			'label' => __( 'Hover Style', 'mindverse' ),
			'default' => '',
			'options' => [
				''               => __('None', 'mindverse'),
                'fillFromLeft'   => __('Fill From Left', 'mindverse'),
                'fillFromRight'  => __('Fill From Right', 'mindverse'),
                'fillFromTop'    => __('Fill From Top', 'mindverse'),
                'fillFromBottom' => __('Fill From Bottom', 'mindverse'),
                'fillCircle'     => __('Fill In Circle', 'mindverse'),
                'fillHorizontal' => __('Fill In Horizontal', 'mindverse'),
                'fillVertical'   => __('Fill In Vertical', 'mindverse'),
				'spotlightFill'  => __('Fill Spotlight', 'mindverse'),
                'overlayShine'   => __('Overlay Shine', 'mindverse'),
                'parallax'       => __('Parallax', 'mindverse'),
                'followCursor'   => __('Follow Cursor', 'mindverse'),
			],
		]);
        // End Hover Tab
        $this->end_controls_tab();
        // End Tabs
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Button Style Controls
     */
    protected function register_button_icon_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_button_icon_style', 
            'label' => __('Button Icon', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button-play-video' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .button-play-video svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ]
        ]);
        $this->slider([
            'name' => 'box_icon_width',
            'label' => __('Button Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button-play-video .button-icon' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name' => 'box_icon_height',
            'label' => __('Button Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button-play-video .button-icon' => 'height: {{SIZE}}{{UNIT}};',
            ]
        ]);
        // Start Tab
        $this->start_controls_tabs( 'btn_icon_tabs' );
        // Normal Tab
        $this->_start_controls_tab([
            'name' => 'btn_icon_normal_tab', 
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->color([
            'name' => 'btn_icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button-play-video' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'btn_icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .button-play-video .button-icon',
		]);
        $this->group_style([
            'name' => 'btn_icon_',
            'selector' => '{{WRAPPER}} .button-play-video .button-icon',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([ 
            'name' => 'btn_icon_hover_tab',
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->color([
            'name' => 'btn_hover_icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .button-play-video:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'btn_icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .button-play-video .button-icon:not(.box-gradient):hover, {{WRAPPER}} .button-play-video .button-icon.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'btn_icon_hover_',
            'selector' => '{{WRAPPER}} .button-play-video:hover .button-icon',
        ]);
        $this->duration([
            'name' => 'btn_icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .button-play-video .button-icon, {{WRAPPER}} .button-play-video .button-icon.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        // End Tabs
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}