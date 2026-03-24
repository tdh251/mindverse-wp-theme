<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Traits\Swiper_Trait;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Testimonial_Carousel extends Mindverse_Widget_Base {

    use Swiper_Trait;

    protected function widget_info() {
        return [
            'name'       => 'mindverse_testimonial_carousel',
            'title'      => __( 'MV Testimonial Carousel', 'mindverse' ),
            'icon'       => 'eicon-testimonial-carousel',
            'script'     => ['mindverse-carousel'],
            'style'      => ['swiper'],
            'keywords'   => [ 'mv', 'mindverse', 'testimonial', 'carousel' ],
        ];
    }

    protected function register_controls() {
        // Layout
        $this->register_layout_controls();
        // Content
        $this->register_icon_content_controls();
        $this->register_title_content_controls();
        $this->register_rating_content_controls();
        $this->register_main_content_controls();
        $this->register_image_content_controls();
        $this->register_user_content_controls();
        $this->register_video_link_controls();
        $this->register_layout_3_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_box_inner_style_controls();
        $this->register_content_style_controls();
        $this->register_rating_icon_style_controls();
        $this->register_rating_label_style_controls();
        $this->register_icon_style_controls();
        $this->register_title_style_controls();
        $this->register_user_name_style_controls();
        $this->register_user_title_style_controls();
        $this->register_user_img_style_controls();
        $this->register_shape_blur_style_controls();
        $this->register_navigation_button_carousel_controls();
        // Setting
        $this->register_display_settings_controls();
        $this->register_carousel_settings_controls();
        $this->register_custom_options_settings_controls();
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
                    'title' => esc_attr__( 'Testimonial 1', 'mindverse' ),
                    'image' => content_url('default-assets/layout/testimonial-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Testimonial 2', 'mindverse' ),
                    'image' => content_url('default-assets/layout/testimonial-2.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Testimonial 3', 'mindverse' ),
                    'image' => content_url('default-assets/layout/testimonial-3.webp'),
                ],
                '4' => [
                    'title' => esc_attr__( 'Testimonial 4', 'mindverse' ),
                    'image' => content_url('default-assets/layout/testimonial-4.webp'),
                ],
                '5' => [
                    'title' => esc_attr__( 'Testimonial 5', 'mindverse' ),
                    'image' => content_url('default-assets/layout/testimonial-5.webp'),
                ],
                '6' => [
                    'title' => esc_attr__( 'Testimonial 6', 'mindverse' ),
                    'image' => content_url('default-assets/layout/testimonial-6.webp'),
                ],
                '7' => [
                    'title' => esc_attr__( 'Testimonial 7', 'mindverse' ),
                    'image' => content_url('default-assets/layout/testimonial-7.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Icon Content Controls 
    */
    protected function register_icon_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_icon_content', 
            'label' => __('Icon', 'mindverse'), 
            'condition' => [
                'layout' => ['1', '4', '6', '7']
            ]
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => __('Common Icon', 'mindverse'),
        ]);
        $this->repeater([
            'name' => 'icons',
            'label' => __('Icons', 'mindverse'),
            'fields' => [
                [
                    'name' => 'own_icon',
                    'label' => __("Own Icon", 'mindverse'),
                    'type' => 'icons',
                    'default' => [
                        'value' => 'fas fa-circle',
					    'library' => 'fa-solid',
                    ],
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Title Content Controls
    */
    protected function register_title_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_title_content', 
            'label' => __('Title', 'mindverse'), 
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => '',
        ]);
        $this->repeater([
            'name' => 'titles',
            'label' => __('Titles', 'mindverse'),
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __("Title", 'mindverse'),
                    'type' => 'text',
                    'label_block' => true,
                    'default' => __('Title', 'mindverse'),
                ],
            ],
            'default' => [
                [
                    'title' => __('Title #1', 'mindverse'),
                ],
                [
                    'title' => __('Title #2', 'mindverse'),
                ],
                [
                    'title' => __('Title #3', 'mindverse'),
                ],
                [
                    'title' => __('Title #4', 'mindverse'),
                ],
                [
                    'title' => __('Title #5', 'mindverse'),
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Rating Content Controls
    */
    protected function register_rating_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_rating_content', 
            'label' => __('Rating', 'mindverse'), 
            'condition' => [
                'layout' => ['2', '5', '7']
            ]
        ]);
        $this->text([
            'name' => 'rating_label',
            'label' => __('Label', 'mindverse'),
            'default' => __('Rating', 'mindverse'),
            'condition' => [
                'layout' => ['7']
            ]
        ]);
        $this->icons([
            'name' => 'rating_icon',
            'label' => __('Rating Icon', 'mindverse'),
            'default' => [
                'value' => [
                    'url' => content_url('/uploads/2025/11/star.svg'),
                    'id'  => 3765,
                ],
                'library' => 'svg'
            ],
        ]);
        $this->repeater([
            'name' => 'ratings',
            'label' => __('Rating Items', 'mindverse'),
            'fields' => [
                [
                    'name' => 'rating',
                    'label' => __('Rating', 'mindverse'),
                    'type' => 'number',
                    'min' => 1,
                    'max' => 5,
                    'default' => 5,
                ],
            ],
            'default' => [
                [
                    'rating'     => 5,
                ],
                [
                    'rating'     => 5,
                ],
                [
                    'rating'     => 5,
                ],
                [
                    'rating'     => 5,
                ],
                [
                    'rating'     => 5,
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Content Content Controls  
    */
    protected function register_main_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content_main', 
            'label' => 'Content', 
            'condition' => [
                'layout!' => ['3']
            ]
        ]);
        $this->repeater([
            'name' => 'contents',
            'label' => __('Contents', 'mindverse'),
            'fields' => [
                [
                    'name' => 'content',
                    'label' => __('Content', 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 10,
                    'default' => __('Item description. Click the edit button to change this text.', 'mindverse'),
                ],

            ],
            'default' => [
                [
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Image Content Controls  
    */
    protected function register_image_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_image_content', 
            'label' => __('Image', 'mindverse'), 
            'condition' => [
                'layout' => ['6']
            ]
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
        ]);
        $this->repeater([
            'name' => 'images',
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
                ['img' => ['id' => 0]],
                ['img' => ['id' => 0]],
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register User Content Controls  
    */    
    protected function register_user_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_user_content', 
            'label' => __('Users', 'mindverse'), 
            'condition' => [
                'layout!' => ['3']
            ]
        ]);
        $this->repeater([
            'name' => 'users',
            'label' => __('Users', 'mindverse'),
            'fields' => [
                [
                    'name' => 'image',
                    'label' => __('User Image', 'mindverse'),
                    'type' => 'media',
                    'default' => [
                        'id' => 0,
                    ],
                ],
                [
                    'name' => 'name',
                    'label' => __('User Name', 'mindverse'),
                    'type' => 'text',
                    'label_block' => true,
                    'default' => __('User Name #', 'mindverse'),
                ],
                [
                    'name' => 'title',
                    'label' => __('User Title', 'mindverse'),
                    'type' => 'text',
                    'label_block' => true,
                    'default' => __('User Title #', 'mindverse'),
                ],
            ],
            'default' => [
                [
                    'name' => __('User Name #1', 'mindverse'),
                    'title' => __('User Title #1', 'mindverse'),
                ],
                [
                    'name' => __('User Name #2', 'mindverse'),
                    'title' => __('User Title #2', 'mindverse'),
                ],
                [
                    'name' => __('User Name #3', 'mindverse'),
                    'title' => __('User Title #3', 'mindverse'),
                ],
                [
                    'name' => __('User Name #4', 'mindverse'),
                    'title' => __('User Title #4', 'mindverse'),
                ],
                [
                    'name' => __('User Name #5', 'mindverse'),
                    'title' => __('User Title #5', 'mindverse'),
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Video Link Controls
    */
    protected function register_video_link_controls() {
        $this->start_content_section([ 
            'name' => 'section_video_link', 
            'label' => __('Video Link', 'mindverse'), 
            'condition' => [
                'layout' => ['6']
            ]
        ]);
        $this->repeater([
            'name' => 'video_links',
            'label' => __('Video Links', 'mindverse'),
            'fields' => [
                [
                    'name' => 'link',
                    'label' => __("Link", 'mindverse'),
                    'type' => 'url',
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Layout 3 Content Controls  
    */  
    protected function register_layout_3_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_layout_3_section', 
            'label' => 'Content', 
            'condition' => [
                'layout' => ['3']
            ]
        ]);
        $this->repeater([
            'name' => 'layout3_items',
            'label' => __('Items', 'mindverse'),
            'fields' => [
                [
                    'name' => 'item_layout',
                    'label' => __('Item Layout', 'mindverse'),
                    'default' => 'content',
                    'type' => 'select',
                    'options' => [
                        'content' => __("Content", 'mindverse'),
                        'video' => __('Video', 'mindverse'),
                    ]
                ],
                [
                    'name' => 'content',
                    'label' => __('Content', 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 10,
                    'default' => __('Item description. Click the edit button to change this text.', 'mindverse'),
                    'condition' => [
                        'item_layout' => 'content'
                    ]
                ],
                [
                    'name' => 'video_thumbnail',
                    'label' => __('Video Thumbnail', 'mindverse'),
                    'type' => 'media',
                    'separator' => 'before',
                    'default' => [
                        'id' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .testimonial-video' => 'background-image: url({{URL}});' 
                    ],
                    'condition' => [
                        'item_layout' => 'video'
                    ]
                ],
                [
                    'name' => 'user_image',
                    'label' => __('User Image', 'mindverse'),
                    'type' => 'media',
                    'separator' => 'before',
                    'default' => [
                        'id' => 0,
                    ],
                    'condition' => [
                        'item_layout' => 'content'
                    ]
                ],
                [
                    'name' => 'user_name',
                    'label' => __('User Name', 'mindverse'),
                    'type' => 'text',
                    'label_block' => true,
                    'default' => __('User Name', 'mindverse'),
                    'condition' => [
                        'item_layout' => 'content'
                    ]
                ],
                [
                    'name' => 'user_title',
                    'label' => __('User Title', 'mindverse'),
                    'type' => 'text',
                    'label_block' => true,
                    'default' => __('User Title', 'mindverse'),
                    'condition' => [
                        'item_layout' => 'content'
                    ]
                ],
                [
                    'name' => 'link',
                    'label' => __('Link', 'mindverse'),
                    'type' => 'url',
                ]
            ],
            'default' => [
                [
                    'user_name' => __('User Name #1', 'mindverse'),
                    'user_title' => __('User Title #1', 'mindverse'),
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'user_name' => __('User Name #2', 'mindverse'),
                    'user_title' => __('User Title #2', 'mindverse'),
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'user_name' => __('User Name #3', 'mindverse'),
                    'user_title' => __('User Title #3', 'mindverse'),
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'user_name' => __('User Name #4', 'mindverse'),
                    'user_title' => __('User Title #4', 'mindverse'),
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'user_name' => __('User Name #5', 'mindverse'),
                    'user_title' => __('User Title #5', 'mindverse'),
                    'content' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
            ],
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
        $this->slider([
            'name' => 'title_spacing',
            'label' => __('Title Spacing', 'mindverse'),
            'size_units' => [ 'px', 'custom' ],
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->slider([
            'name' => 'icon_spacing',
            'label' => __('Icon Spacing', 'mindverse'),
            'size_units' => [ 'px', 'custom' ],
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-title' => 'gap: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->slider([
            'name' => 'content_spacing',
            'label' => __('Content Spacing', 'mindverse'),
            'size_units' => [ 'px', 'custom' ],
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->slider([
            'name' => 'rating_gap',
            'label' => __('Rating Gap', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-rating' => 'gap: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['2', '5', '7']
            ]
        ]);
        $this->slider([
            'name' => 'rating_spacing',
            'label' => __('Rating Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['2', '5', '7']
            ]
        ]);
        $this->align_items_horizontal([
            'name' => 'user',
            'label' => __('User Align Items', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->slider([
            'name' => 'user_gap',
            'label' => __('User Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'user_name_spacing',
            'label' => __('User Name Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user .user-name' => 'margin-bottom: {{SIZE}}{{UNIT}};'
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
            'selector' => '{{WRAPPER}} .testimonial',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .testimonial',
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
            'selector' => '{{WRAPPER}} .testimonial:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .testimonial:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Box Style Controls 
    */
    protected function register_box_inner_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_inner_style', 
            'label' => __('Box Inner', 'mindverse'),
            'condition' => [
                'layout' => '3'
            ]
        ]);

        $this->start_controls_tabs( 'box_inner_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([ 
            'name' => 'box_inner_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'box_inner_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .testimonial .testimonial-inner',
		]);
        $this->group_style([
            'name' => 'box_inner_',
            'selector' => '{{WRAPPER}} .testimonial .testimonial-inner',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'box_inner_style_hover_tab', 
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'box_inner_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .testimonial:after',
		]);
        $this->duration([
            'name' => 'box_inner_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial:after' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Content Style Controls 
    */
    protected function register_content_style_controls() {
        $this->start_style_section([
            'name' => 'section_content_style',
            'label' => __('Content', 'mindverse'),
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

    /** 
     * Register Rating Icon Style Controls 
    */
    protected function register_rating_icon_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_rating_icon_style', 
            'label' => __('Rating Icon', 'mindverse'),
            'condition' => [
                'layout' => ['2', '7']
            ]
        ]);
        $this->slider([
            'name' => 'rating_icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-rating' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .testimonial .testimonial-rating svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ]
        ]);
        $this->start_controls_tabs( 'rating_icon_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'rating_icon_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'rating_icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-rating' => 'color: {{VALUE}};',
            ]
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'rating_icon_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'rating_hover_icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial:hover .testimonial-rating' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'rating_icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-rating' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Rating Label Style Controls 
    */
    protected function register_rating_label_style_controls() {
        $this->start_style_section([
            'name' => 'section_rating_label_style',
            'label' => __('Rating Label', 'mindverse'),
            'condition' => [
                'layout' => ['2', '7']
            ]
        ]);
        $this->group_typography([
            'name' => 'rating_label_typography',
            'selector' => '{{WRAPPER}} .testimonial .testimonial-rating .rating-label',
        ]);
        $this->color([
            'name' => 'rating_label_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-rating .rating-label' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Icon Style Controls 
    */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_style_icon',
            'label' => __('Icon', 'mindverse'),
            'condition' => [
                'layout' => ['1', '6']
            ]
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .testimonial .testimonial-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ]
        ]);
        $this->start_controls_tabs( 'icon_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'icon_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-icon' => 'color: {{VALUE}};',
            ]
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'icon_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_hover_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial:hover .testimonial-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
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
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .testimonial .testimonial-title',
        ]);
        $this->start_controls_tabs( 'title_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'title_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'title_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'title_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'title_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial:hover .testimonial-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register User Name Style Controls 
    */    
    protected function register_user_name_style_controls() {
        $this->start_style_section([
            'name' => 'section_user_name_style',
            'label' => __('User Name', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'user_name_typography',
            'selector' => '{{WRAPPER}} .testimonial .testimonial-user .user-name',
        ]);
        $this->start_controls_tabs( 'user_name_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'user_name_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'user_name_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user .user-name' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'user_name_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'user_name_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial:hover .testimonial-user .user-name' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'user_name_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user .user-name' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register User Title Style Controls 
    */   
    protected function register_user_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_user_title_style',
            'label' => __('User Title', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'user_title_typography',
            'selector' => '{{WRAPPER}} .testimonial .testimonial-user .user-title',
        ]);
        $this->start_controls_tabs( 'user_title_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'user_title_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'user_title_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user .user-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'user_title_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'user_title_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial:hover .testimonial-user .user-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'user_title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user .user-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register User Image Style Controls 
    */   
    protected function register_user_img_style_controls() {
        $this->start_style_section([
            'name' => 'section_user_img_style',
            'label' => __('User Image', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'user_img_box_size',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user .user-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->start_controls_tabs( 'user_img_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'user_img_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_style_image([
            'name' => 'user_img_',
            'selector' => '{{WRAPPER}} .testimonial .testimonial-user .user-image',
        ]);
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'user_img_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->group_style_image([
            'name' => 'user_img_hover_',
            'selector' => '{{WRAPPER}} .testimonial:hover .testimonial-user .user-image',
        ]);
        $this->duration([
            'name' => 'user_img_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .testimonial-user .user-image' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Shape Blur Style Controls 
    */  
    protected function register_shape_blur_style_controls() {
        $this->start_style_section([
            'name' => 'style_shape_blur_section',
            'label' => __('Overlay', 'mindverse'),
            'condition' => [
                'layout' => ['3', '4', '5'],
            ]
        ]);
        // Size Controls
        $this->popover_toggle([
            'name' => 'overlay_size_toggle',
            'label' => __('Size', 'mindverse'),
            'label_on' => __('Custom', 'mindverse'),
            'label_off' => __('Default', 'mindverse'),
            'return_value' => 'custom',
            'default' => '',
        ]);
        $this->start_popover();
        $this->slider([
            'name' => 'overlay_width',
            'label' => __('Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_size_toggle' => 'custom',
            ],
        ]);
        $this->slider([
            'name' => 'overlay_max_width',
            'label' => __('Max Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_size_toggle' => 'custom',
            ],
        ]);
        $this->slider([
            'name' => 'overlay_height',
            'label' => __('Height', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_size_toggle' => 'custom',
            ],
        ]);
        $this->slider([
            'name' => 'overlay_max_height',
            'label' => __('Max Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'max-height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_size_toggle' => 'custom',
            ],
        ]);
        $this->end_popover();
        // Offset Controls
        $this->popover_toggle([
            'name' => 'overlay_offset_toggle',
            'label' => __('Offset', 'mindverse'),
            'label_on' => __('Custom', 'mindverse'),
            'label_off' => __('Default', 'mindverse'),
            'return_value' => 'custom',
            'default' => '',
        ]);
        $this->start_popover();
        $this->slider([
            'name' => 'overlay_offset_top',
            'label' => __('Top Offset', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'top: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_offset_toggle' => 'custom',
            ],
        ]);
        $this->slider([
            'name' => 'overlay_offset_right',
            'label' => __('Right Offset', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'right: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_offset_toggle' => 'custom',
            ],
        ]);
        $this->slider([
            'name' => 'overlay_offset_bottom',
            'label' => __('Bottom Offset', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_offset_toggle' => 'custom',
            ],
        ]);
        $this->slider([
            'name' => 'overlay_offset_left',
            'label' => __('Left Offset', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'left: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'overlay_offset_toggle' => 'custom',
            ],
        ]);
        $this->end_popover();

        // Tabs Controls
        $this->start_controls_tabs( 'overlay_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'overlay_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'overlay_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .testimonial .overlay',
        ]);
        $this->opacity([
            'name' => 'overlay_opacity',
            'label' => __('Opacity', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial .overlay' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'overlay_css_filter',
            'label' => __('CSS Filter', 'mindverse'),
            'selector' => '{{WRAPPER}} .testimonial .overlay',
        ]);
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'overlay_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'overlay_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .testimonial:hover .overlay',
        ]);
        $this->opacity([
            'name' => 'overlay_hover_opacity',
            'label' => __('Opacity', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial:hover .overlay' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'overlay_hover_css_filter',
            'label' => __('CSS Filter', 'mindverse'),
            'selector' => '{{WRAPPER}} .testimonial:hover .overlay',
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Carousel Settings Controls 
    */  
    protected function register_display_settings_controls() {
        $this->start_settings_section([ 
            'name' => 'section_display_settings', 
            'label' => __('Display', 'mindverse'), 
        ]);
        $this->switcher([
            'name' => 'show_title',
            'label' => __('Show Title', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->switcher([
            'name' => 'show_icon',
            'label' => __('Show Icon', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->switcher([
            'name' => 'show_user',
            'label' => __('Show User', 'mindverse'),
            'default' => 'yes',
        ]);
        $this->switcher([
            'name' => 'show_rating',
            'label' => __('Show Rating', 'mindverse'),
            'default' => 'yes',
        ]);
        $this->end_controls_section();
    }
}