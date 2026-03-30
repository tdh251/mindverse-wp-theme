<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Show_Case extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_show_case',
            'title'      => __( 'MV Show Case', 'mindverse' ),
            'icon'       => 'widget-icon',
            'script'     => ['mindverse-interactions'],
            'keywords'   => [ 'mv', 'mindverse', 'case',' show' ],
        ];
    }

    /**
     * Register All Content
     */
    protected function register_controls() {
        $this->register_layout_controls();
        $this->register_content_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**  
     * Register Layout Controls
    */
    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_layout', 
            'label' => __('Layout', 'mindverse')
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Layout 1', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/testimonial-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Layout 2', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/testimonial-2.webp'),
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
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->switcher([
            'name' => 'is_coming_soon',
            'label' => __('Is Coming Soon', 'mindverse'),
            'default' => '',
        ]);
        $this->media([
            'name' => 'img_coming_soon',
            'label' => __('Choose Image', 'mindverse'),
            'default' => [
                'id' => 0 
            ],
            'condition' => [
                'is_coming_soon' => 'yes'
            ]
        ]);
        $this->media([
            'name' => 'img',
            'label' => __('Choose Image', 'mindverse'),
            'default' => [
                'id' => 0 
            ],
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
        ]);
        $this->text([
            'name' => 'title',
            'label' => __('Title', 'mindverse'),
            'default' => __('Your Title Here', 'mindverse'),
            'condition' => [
                'is_coming_soon!' => 'yes'
            ]
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => '',
            'condition' => [
                'title!' => '',
                'is_coming_soon!' => 'yes'
            ]
        ]);
        $this->text([
            'name' => 'badge',
            'label' => __('Badge', 'mindverse'),
            'condition' => [
                'is_coming_soon!' => 'yes'
            ]
        ]);
        $this->url([
            'name' => 'link',
            'default' => [
                'url' => '#'
            ],
            'condition' => [
                'is_coming_soon!' => 'yes',
                'layout' => ['1']
            ]
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'text',
            [
                'label' => __('Text', 'mindverse'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Button', 'mindverse'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'mindverse'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->start_controls_tabs('tabs_button_style');

        $repeater->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'mindverse'),
            ]
        );

        $repeater->add_control(
            'color',
            [
                'label' => __('Text Color', 'mindverse'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
            'name' => 'background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'mindverse'),
            ]
        );

        $repeater->add_control(
            'color_hover',
            [
                'label' => __('Text Color', 'mindverse'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
            'name' => 'background_hover',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:before',
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border_hover',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hover',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->repeater([
            'name' => 'btns',
            'label' => __('Buttons', 'mindverse'),
            'condition' => [
                'layout' => ['2'],
                'is_coming_soon!' => 'yes'
            ],
            'fields' =>  $repeater->get_controls()
        ]);
        $this->repeater([
            'name' => 'imgs',
            'label' => __('Images', 'mindverse'),
            'condition' => [
                'layout' => ['2'],
                'is_coming_soon!' => 'yes'
            ],
            'fields' => [
                [
                    'name' => 'img',
                    'label' => __('Image', 'mindverse'),
                    'type' => 'media',
                    'default' => [
                        'id' => 0
                    ]
                ],
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Title Style Controls 
    */
    protected function register_content_style_controls() {
        $this->start_style_section([
            'name' => 'section_content_style',
            'label' => __('Title', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'content_typography',
            'selector' => '{{WRAPPER}} .testimonial .testimonial-content',
        ]);
        $this->start_controls_tabs( 'content_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'content_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'content_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-content' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'content_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'content_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial:hover .testimonial-content' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'content_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-content' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}