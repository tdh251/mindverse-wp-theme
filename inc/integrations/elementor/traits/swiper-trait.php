<?php
namespace Mindverse\Inc\Integrations\Elementor\Traits;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

trait Swiper_Trait {
    protected function register_carousel_settings_controls() {
        $this->start_settings_section([ 
            'name' => 'section_carousel_settings', 
            'label' => __('Carousel', 'mindverse'),
        ]);
        $this->start_controls_tabs('swiper_controls_tabs');
        /**
         * TAB: Options
         */
        $this->_start_controls_tab([
            'name'  => 'swiper_tab_options',
            'label' => __('Options', 'mindverse'),
        ]);

        // 🧭 BASIC BEHAVIOR
        $this->heading([
            'name' => 'swiper_basic_settings',
            'label' => __('Basic Settings', 'mindverse'),
            'separator' => '',
        ]);
        $this->select([
            'name'  => 'swiper_boxshadow',
            'label' => __('Slide Boxshadow', 'mindverse'),
            'default' => '',
            'options' => [
                ''          => __('Default', 'mindverse'),
                'yes' => __('Yes', 'mindverse'),
                'no'  => __('No', 'mindverse'),
            ]
        ]);
        $this->switcher([
            'name'  => 'allow_touch_move',
            'label' => __('Allow Touch Move', 'mindverse'),
            'default' => 'yes'
        ]);
        $this->switcher([
            'name'  => 'centered_slides',
            'label' => __('Centered Slides', 'mindverse'),
        ]);
        $this->select([
            'name'    => 'swiper_direction',
            'label'   => __('Direction', 'mindverse'),
            'options' => [
                'horizontal' => __('Horizontal', 'mindverse'),
                'vertical'   => __('Vertical', 'mindverse'),
            ],
            'default' => 'horizontal',
        ]);
        $this->switcher([
            'name'    => 'swiper_drag_reverse',
            'label'   => __('Drag Reverse', 'mindverse'),
            'default' => '',
        ]);
        $this->slider([
            'name' => 'swiper_wrapper_height',
            'label' => __('Wrapper Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel .carousel-container.swiper-vertical' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'swiper_direction' => ['vertical'],
            ]
        ]);

        //  AUTOPLAY SETTINGS
        $this->popover_toggle([
            'name'  => 'swiper_auto_play_params',
            'label' => __('Autoplay', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->start_popover();

        $this->switcher([
            'name'  => 'auto_play',
            'label' => __('Enable', 'mindverse'),
        ]);
        $this->number([
            'name'    => 'delay',
            'label'   => __('Delay (ms)', 'mindverse'),
            'default' => 5000,
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);
        $this->switcher([
            'name'  => 'disable_on_interaction',
            'label' => __('Disable On Interaction', 'mindverse'),
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);
        $this->switcher([
            'name'  => 'pause_on_mouse_enter',
            'label' => __('Pause On Mouse Enter', 'mindverse'),
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);
        $this->switcher([
            'name'  => 'reverse_direction',
            'label' => __('Reverse Direction', 'mindverse'),
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);

        $this->end_popover();

        // FREE MODE
        $this->popover_toggle([
            'name'  => 'swiper_free_mode_params',
            'label' => __('Free Mode', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->start_popover();
        $this->switcher([
            'name'  => 'free_mode',
            'label' => __('Enable', 'mindverse'),
        ]);
        $this->switcher([
            'name'  => 'free_mode_sticky',
            'label' => __('Sticky', 'mindverse'),
            'condition' => [
                'free_mode' => 'yes'
            ]
        ]);
        $this->switcher([
            'name'  => 'momentum',
            'label' => __('Momentum', 'mindverse'),
            'condition' => [
                'free_mode' => 'yes'
            ]
        ]);
        
        $this->end_popover();

        // LOOP & INTERACTION
        $this->heading([
            'name' => 'swiper_interaction',
            'label' => __('Loop & Interaction', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->number([
            'name'    => 'initial_slide',
            'label'   => __('Initial Slide', 'mindverse'),
            'default' => 1,
            'method' => 'add_control',
        ]);
        $this->switcher([
            'name'  => 'loop',
            'label' => __('Loop', 'mindverse'),
        ]);
        $this->switcher([
            'name'  => 'mousewheel',
            'label' => __('Mousewheel', 'mindverse'),
        ]);

        $this->select([
            'name' => 'swiper_grid_rows',
            'label' => __('Grid Rows', 'mindverse'),
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'default' => '1',
            'condition' => [
                'swiper_direction' => 'horizontal',
            ]   
        ]);

        // SPEED
        $this->heading([
            'name' => 'swiper_transition_heading',
            'label' => __('Transition', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->select([
            'name' => 'swiper_transition',
            'label' => __('Transition Timing', 'mindverse'),
            'default' => '',
            'options' => [
                ''            => __('Ease', 'mindverse'),
                'linear'      => __('Linear', 'mindverse'),
                'ease-in'     => __('Ease In', 'mindverse'),
                'ease-out'    => __('Ease Out', 'mindverse'),
                'ease-in-out' => __('Ease In Out', 'mindverse'),
            ],
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper .swiper-wrapper' => 'transition-timing-function: {{VALUE}};'
            ]
        ]);
        $this->number([
            'name'    => 'speed',
            'label'   => __('Speed (ms)', 'mindverse'),
            'default' => 500,
            'method' => 'add_control',
        ]);
        $this->opacity([
            'name' => 'slide_opacity',
            'label' => __('Slide Opacity', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel .carousel-container .carousel-item' => 'opacity: {{SIZE}} !important;'
            ],
        ]);
        // NAVIGATION ELEMENTS
        $this->heading([
            'name' => 'swiper_controls_and_nav',
            'label' => __('Controls & Navigation', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->popover_toggle([
            'name'  => 'swiper_nav_params',
            'label' => __('Navigation', 'mindverse'),
        ]);
        $this->start_popover();
        $this->switcher([
            'name'  => 'swiper_nav',
            'label' => __('Enable', 'mindverse'),
        ]);
        $this->switcher([
            'name'  => 'use_nav_widget',
            'label' => __('Use Navigation Widget', 'mindverse'),
            'condition' => [
                'swiper_nav' => 'yes',
            ]
        ]);
        $this->text([
            'name'  => 'nav_widget_id',
            'label' => __('Navigation Widget ID', 'mindverse'),
            'placeholder' => __('Ex: nav-carousel-2526', 'mindverse'),
            'condition' => [
                'swiper_nav' => 'yes',
                'use_nav_widget' => 'yes'
            ]
        ]);
        $this->icons([
            'name' => 'nav_prev_icon',
            'label' => __('Previous Icon', 'mindverse'),
            'default' => [],
            'condition' => [
                'swiper_nav' => 'yes',
                'use_nav_widget' => ''
            ]
        ]);
        $this->icons([
            'name' => 'nav_next_icon',
            'label' => __('Next Icon', 'mindverse'),
            'default' => [],
            'condition' => [
                'swiper_nav' => 'yes',
                'use_nav_widget' => ''
            ]
        ]);
        $this->end_popover();

        $this->select([
            'name'  => 'swiper_pagination',
            'label' => __('Pagination', 'mindverse'),
            'default' => '',
            'options' => [
                '' => __('None', 'mindverse'),
                'bullets' => __('Bullets', 'mindverse'),
                'progress' => __('Progress', 'mindverse'),
            ],
        ]);

        $this->switcher([
            'name'  => 'swiper_scrollbar',
            'label' => __('Scrollbar', 'mindverse'),
        ]);

        $this->end_controls_tab();

        /**
         * TAB: Responsive
         */
        $this->_start_controls_tab([
            'name'  => 'swiper_tab_responsive',
            'label' => __('Responsive', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'swiper_space_between',
            'label' => __('Space Between', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper:not(.swiper-vertical)' => '--mv-spacing-inline: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .carousel .swiper.swiper-vertical'       => '--mv-spacing-block: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'swiper_grid_rows' => ['1', ''],
            ]
        ]);
        $this->slider([
            'name' => 'swiper_space_between_horizontal',
            'label' => __('Space Between Horizontal', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper'       => '--mv-spacing-inline: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'swiper_grid_rows!' => ['1'],
            ]
        ]);
        $this->slider([
            'name' => 'swiper_space_between_vertical',
            'label' => __('Space Between Vertical', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper'       => '--mv-spacing-block: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'swiper_grid_rows!' => ['1'],
            ]
        ]);
        $columns_options = [
            ''           => __('Default', 'mindverse'),
            '1'          => '1',
            '2'          => '2',
            '3'          => '3',
            '4'          => '4',
            '5'          => '5',
            '6'          => '6',
        ];
        $this->select([
            'name'    => 'slides_per_view',
            'label'   => __('Slides Per View', 'mindverse'),
            'separator' => 'before',
            'options' => [
                ''               => __('Default', 'mindverse'),
                'free-mode'      => __('Free Mode', 'mindverse'),
            ],
            'default' => '',
        ]);
        $this->select([
            'name' => 'slides_per_view_xs',
            'label' => __('Slides Per View XS (<= 576px)', 'mindverse'),
            'options' => $columns_options,
            'label_block' => true,
            'default' => '',
            'condition' => [
                'slides_per_view' => [''],
            ]
        ]);
        $this->select([
            'name' => 'slides_per_view_sm',
            'label' => __('Slides Per View SM (< 768px)', 'mindverse'),
            'options' => $columns_options,
            'label_block' => true,
            'default' => '',
            'condition' => [
                'slides_per_view' => [''],
            ]
        ]);
        $this->select([
            'name' => 'slides_per_view_md',
            'label' => __('Slides Per View MD (< 992px)', 'mindverse'),
            'options' => $columns_options,
            'label_block' => true,
            'default' => '',
            'condition' => [
                'slides_per_view' => [''],
            ]
        ]);
        $this->select([
            'name' => 'slides_per_view_lg',
            'label' => __('Slides Per View LG (< 1200px)', 'mindverse'),
            'options' => $columns_options,
            'label_block' => true,
            'default' => '',
            'condition' => [
                'slides_per_view' => [''],
            ]
        ]);
        $this->select([
            'name' => 'slides_per_view_xl',
            'label' => __('Slides Per View XL (< 1400px)', 'mindverse'),
            'options' => $columns_options,
            'label_block' => true,
            'default' => '',
            'condition' => [
                'slides_per_view' => [''],
            ]
        ]);
        $this->select([
            'name' => 'slides_per_view_xxl',
            'label' => __('Slides Per View XXL (>= 1400px)', 'mindverse'),
            'options' => $columns_options,
            'label_block' => true,
            'default' => '',
            'condition' => [
                'slides_per_view' => [''],
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function register_navigation_button_carousel_controls() {
        $this->start_style_section([ 
            'name' => 'style_swiper_nav_btn_section', 
            'label' => __('Navigation Button', 'mindverse'),
            'condition' => [
                'swiper_nav' => 'yes',
                'nav_widget_id' => ''
            ]
        ]);
        $this->choose([
            'name' => 'swiper_nav_justify_content',
            'label' => __('Justify Content', 'mindverse'),
            'options' => [
                'start' => [ 'title' => __( 'Start', 'mindverse' ), 'icon' => 'eicon-justify-start-h', ],
                'center' => [ 'title' => __( 'Center', 'mindverse' ), 'icon' => 'eicon-justify-center-h', ],
                'end' => [ 'title' => __( 'End', 'mindverse' ), 'icon' => 'eicon-justify-end-h', ],
                'space-between' => [ 'title' => __( 'Space Between', 'mindverse' ), 'icon' => 'eicon-justify-space-between-h', ],
                'space-around' => [ 'title' => __( 'Space Around', 'mindverse' ), 'icon' => 'eicon-justify-space-around-h', ],
                'space-evenly' => [ 'title' => __( 'Space Evenly', 'mindverse' ), 'icon' => 'eicon-justify-space-evenly-h', ],
            ],
            'method' => 'add_responsive_control',
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation' => 'justify-content: {{VALUE}};'
            ]
        ]);
        $this->slider([
            'name' => 'swiper_nav_gap',
            'label' => __( 'Gap', 'mindverse' ),
            'size_units' => [ 'px', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0, 'max' => 500, ],
            ],
            'default' => [
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'swiper_nav_spacing_top',
            'label' => __( 'Spacing Top', 'mindverse' ),
            'size_units' => [ 'px', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0, 'max' => 500, ],
            ],
            'default' => [
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation' => 'margin-top: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs( 'swiper_nav_btn_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'swiper_nav_btn_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'swiper_nav_btn_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation .carousel-button' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'swiper_nav_btn_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button',
		]);
        $this->group_style([
            'name' => 'swiper_nav_btn_',
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'swiper_nav_btn_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'swiper_nav_btn_hover_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation .carousel-button:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'swiper_nav_btn_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button:not(.box-gradient):hover, {{WRAPPER}} .carousel-navigation .carousel-button.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'swiper_nav_btn_hover_',
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button:hover',
        ]);
        $this->duration([
            'name' => 'swiper_nav_btn_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation .carousel-button, {{WRAPPER}} .carousel-navigation .carousel-button.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}