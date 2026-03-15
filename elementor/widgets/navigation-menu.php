<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use \Mindverse\Inc\Utils\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Navigation_Menu extends Mindverse_Widget_Base {
    
    // private $main_menu_selector;

    // public function __construct($data = [], $args = null) {
    //     parent::__construct($data, $args);

    //     $this->main_menu_selector = '{{WRAPPER}} .navigation-menu';
    // }

    protected function widget_info() {
        return [
            'name'       => 'mindverse_navigation_menu',
            'title'      => __( 'MV Nav Menu', 'mindverse' ),
            'icon'       => 'eicon-nav-menu',
            'keywords'   => [ 'nav', 'menu', 'header', 'mindverse', 'navigation' ],
            'script'     => [ 'mindverse-interactions' ],
        ];
    }

    protected function register_controls() {
        $this->content_section();

        $this->style_section_layout();
        $this->style_section_main_menu();
        $this->style_section_submenu();
        $this->style_section_mega_menu();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    protected function content_section() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => 'Navigation Menu' 
        ]);
        $this->select([
            'name' => 'nav_menu',
            'label' => __( 'Navigation Menu', 'mindverse' ),
            'options' => Helpers::get_nav_menu_options(),
            'default' => '',
        ]);
        $this->icons([
            'name' => 'menu_icon',
            'label' => __('Menu Has Child Icon', 'mindverse'),
            'default' => [],
        ]);
        $this->end_controls_section();
    }
    /**
     * Options layout style
     */
    protected function style_section_layout() {
        $this->start_style_section([
            'name' => 'style_section_layout', 
            'label' => 'Layout',
        ]);
        // Main Menu
        $this->heading([
            'name' => 'main_menu_heading', 
            'label' => 'Main Menu'
        ]);
        $this->flex_direction([
            'name' => 'main_menu',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name'      => 'main_menu',
            'condition' => [
                'main_menu_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .navigation-menu' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'main_menu',
            'condition' => [
                'main_menu_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .navigation-menu' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'main_menu',
            'condition' => [
                'main_menu_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .navigation-menu' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->gap([
            'name' => 'main_menu',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->slider([
            'name'  => 'main_menu_link_height',
            'label' => __('Link Height', 'mindverse'),
            'separator' => 'after',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->slider([
            'name'  => 'children_icon_size',
            'label' => __('Children Icon Size', 'mindverse'),
            'size_units' => [ 'px', 'custom' ], 
            'default' => [
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li.menu-item-has-children > a .menu-link-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .navigation-menu li.menu-item-has-children > a .menu-link-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ],
        ]);
        $this->gap([
            'name' => 'main_menu_link',
            'label' => __('Link Menu Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li.menu-item-has-children > a .menu-link-inner' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        // Submenu 
        $this->heading([
            'name' => 'submenu_heading', 
            'label' => 'Submenu'
        ]);
        $this->slider([
            'name' => 'submenu_item_spacing',
            'label' => __('Item Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li + li > a ' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->slider([
            'name' => 'submenu_link_height',
            'label' => __('Link Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
    }
    /**
     * Options menu (depth == 0) style
     */
    protected function style_section_main_menu() {
        $this->start_style_section([
            'name' => 'style_section_main_menu', 
            'label' => 'Main Menu',
        ]);
        $this->group_typography([
            'name' => 'main_menu_typography',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        $this->group_text_shadow([
            'name' => 'main_menu_text_shadow',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        /** ============= Control Tabs Style ============= */
        $this->start_controls_tabs( 'main_menu_tabs' );
        /** Normal Tab Style */
        $this->start_tab([
            'name' => 'main_menu_normal_tab',
            'label' => __( 'Normal', 'mindverse' ),
        ]);
        // Text Color
        $this->color([
            'name' => 'main_menu_color',
            'label' => __( 'Text Color', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a' => 'color: {{VALUE}}',
            ],
        ]);
        // Background 
        $this->group_background([
            'name' => 'main_menu_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        $this->group_style([
            'name' => 'main_menu_',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        $this->end_controls_tab();

        /** Hover/Active Tab Style */
        $this->start_tab([
            'name' => 'main_menu_normal_hover',
            'label' => __( 'Hover/Active', 'mindverse' ),
        ]);
        // Text Color Hover
        $this->color([
            'name' => 'main_menu_color_hover',
            'label' => __( 'Text Color', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a:hover' => 'color: {{VALUE}}',
            ],
        ]);
        // Background Hover
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'main_menu_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .navigation-menu > li > a.box-gradient > .menu-link-inner,
                            {{WRAPPER}} .navigation-menu > li > a .direction-item',
                'fields_options' => [			
                    'color' => [
                        'selectors' => [
                            '{{WRAPPER}} .navigation-menu > li > a:hover:not([data-hover="transition-fill-animation"]):not([data-hover="rotation-fill-animation"]):not(.box-gradient) > .menu-link-inner,
                            {{WRAPPER}} .navigation-menu > li > a.box-gradient > .menu-link-inner,
                            {{WRAPPER}} .navigation-menu > li > a.box-gradient > .direction-item' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '{{WRAPPER}} .navigation-menu > li > a.box-gradient > .menu-link-inner,
                            {{WRAPPER}} .navigation-menu > li > a .direction-item' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                ],
			]
		);
        // Border Hover 
        $this->color([
            'name' => '_main_menu_border_color_hover',
            'label' => __( 'Border Color', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a:hover > .menu-link-inner' => 'border-color: {{VALUE}}',
            ],
        ]);
       $this->group_style([
            'name' => 'main_menu_hover_',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a:hover > .menu-link-inner',
        ]);
        $this->select([
            'name' => 'main_menu_hover_style',
            'label' => __( 'Hover Style', 'mindverse' ),
            'separator' => 'before',
            'default' => '',
            'groups' => [
                [
                    'label' => __('None', 'mindverse'),
                    'options' => [
                        '' => __('None', 'mindverse'),
                    ]
                ],
                [
                    'label' => __('Underline', 'mindverse'),
                    'options' => [
                        'underline-ltr' => __('Underline LTR', 'mindverse'),
                        'underline-rtl' => __('Underline RTL', 'mindverse'),
                        'transition-fill-animation' => __('Transition Fill Animation', 'mindverse'),
                        'rotation-fill-animation' => __('Rotation Fill Animation', 'mindverse'),
                    ]
                ],
            ],
        ]);
        $this->select([
            'name' => 'menu_hover_direction',
            'label' => __( 'Hover Direction', 'mindverse' ),
            'default' => 'horizontal',
            'options' => [
                'horizontal' => __('Horizontal', 'mindverse'),
                'vertical' => __('Vertical', 'mindverse'),
            ],
            'condition' => [
                'main_menu_hover_style' => [ 'rotation-fill-animation', 'transition-fill-animation' ],
            ],
        ]);
        $this->slider([
            'name' => 'main_menu_link_line_thickness',
            'label' => __('Line Thickness', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner:after' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'main_menu_hover_style' => [ 'underline-ltr', 'underline-rtl' ],
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    /**
     * Options submenu (depth > 0) style
     */
    protected function style_section_submenu() {
        $this->start_style_section([
            'name' => 'style_section_submenu', 
            'label' => 'Submenu',
        ]);
        $this->group_typography([
            'name' => 'submenu_typography',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
        ]);
        $this->group_text_shadow([
            'name' => 'submenu_text_shadow',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
        ]);
        /** ============= Control Tabs Style ============= */
        $this->start_controls_tabs( 'submenu_tabs' );
        /** Box Tab Style */
        $this->start_tab([
            'name' => 'submenu_box_tab',
            'label' => __( 'Box', 'mindverse' ),
        ]);
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'submenu_box_background',
                'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu',
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submenu_box_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu',
            ]
        );

        // Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submenu_box_box_shadow',
                'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu',
            ]
        );
        // Border Radius
        $this->dimensions([
            'name' => 'submenu_box_border_radius',
            'label' => __( 'Border Radius', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding
        $this->dimensions ([
            'name' => 'submenu_box_padding',
            'label' => __( 'Padding', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Animation
        $this->select([
            'name' => 'submenu_anim',
            'label' => __('Animation', 'mindverse'),
            'separator' => 'before',
            'default' => 'fade',
            'groups' => [
                [
                    'label' => __('Fade', 'mindverse'),
                    'options' => [
                        'fade'          => __('Fade In', 'mindverse'),
                        'fade-in-up'    => __('Fade In Up', 'mindverse'),
                        'fade-in-right' => __('Fade In Right', 'mindverse'),
                        'fade-in-left'  => __('Fade In Left', 'mindverse'),
                    ],
                ],
                [
                    'label' => __('Reveal', 'mindverse'),
                    'options' => [
                        'reveal-in'        => __('Reveal In', 'mindverse'),
                        'fillCircle' => __('Reveal In Circle', 'mindverse'),
                        'reveal-in-top'    => __('Reveal In Top', 'mindverse'),
                        'reveal-in-right'  => __('Reveal In Right', 'mindverse'),
                        'reveal-in-bottom' => __('Reveal In Bottom', 'mindverse'),
                        'reveal-in-left'   => __('Reveal In Left', 'mindverse'),
                        'fillHorizontal'      => __('Reveal In Horizontal', 'mindverse'),
                        'fillVertical'      => __('Reveal In Vertical', 'mindverse'),
                    ],
                ],
                [
                    'label' => __('Flip', 'mindverse'),
                    'options' => [
                        'flip-x'           => __('Flip X', 'mindverse'),
                        'flip-y'           => __('Flip Y', 'mindverse'),
                        'flip-3d-in-top'   => __('Flip 3d In Top', 'mindverse'),
                    ],
                ],
            ],
        ]);
        $this->end_controls_tab();
        /** Normal Tab Style */
        $this->start_tab([
            'name' => 'submenu_normal_tab',
            'label' => __( 'Normal', 'mindverse' ),
        ]);
        // Text Color
        $this->color([
            'name' => 'submenu_color',
            'label' => __( 'Text Color', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a' => 'color: {{VALUE}}',
            ],
        ]);
        // Background 
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'submenu_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
                'exclude' => ['image']
			]
		);
        // Border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'submenu_border',
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
			]
		);
        // Box Shadow 
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'submenu_box_shadow',
				'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
			]
		);
        // Border Radius
        $this->dimensions([
            'name' => 'submenu_border_radius',
            'label' => __( 'Border Radius', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding
        $this->dimensions ([
            'name' => 'submenu_padding',
            'label' => __( 'Padding', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        /** Hover/Active Tab Style */
        $this->start_tab([
            'name' => 'submenu_normal_hover',
            'label' => __( 'Hover/Active', 'mindverse' ),
        ]);
        // Text Color Hover
        $this->color([
            'name' => 'submenu_color_hover',
            'label' => __( 'Text Color', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover' => 'color: {{VALUE}}',
            ],
        ]);
        // Background Hover
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'submenu_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover',
                'exclude' => ['image']
			]
		);
        // Border Hover 
        $this->color([
            'name' => '_submenu_border_color_hover',
            'label' => __( 'Border Color', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover' => 'border-color: {{VALUE}}',
            ],
        ]);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'submenu_border_hover',
				'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover',
			]
		);

        // Box Shadow Hover
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'submenu_box_shadow_hover',
				'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover',
			]
		);
        // Border Radius Hover
        $this->dimensions([
            'name' => 'submenu_border_radius_hover',
            'label' => __( 'Border Radius', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding Hover
        $this->dimensions ([
            'name' => 'submenu_padding_hover',
            'label' => __( 'Padding', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->select([
            'name' => 'submenu_hover_style',
            'label' => __( 'Hover Style', 'mindverse' ),
            'separator' => 'before',
            'default' => '',
            'groups' => [
                [
                    'label' => __('None', 'mindverse'),
                    'options' => [
                        '' => __('None', 'mindverse'),
                    ]
                ],
                [
                    'label' => __('Underline', 'mindverse'),
                    'options' => [
                        'underline-ltr' => __('Underline LTR', 'mindverse'),
                        'underline-rtl' => __('Underline RTL', 'mindverse'),
                        'underline-expland' => __('Underline Expland', 'mindverse'),
                    ]
                ],
            ],
        ]);
        $this->slider([
            'name' => 'submenu_link_line_weight',
            'label' => __('Link Weight', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:after' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'submenu_hover_style!' => [''],
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    protected function style_section_mega_menu() {
        $this->start_style_section([
            'name' => 'style_section_megamenu', 
            'label' => 'Mega Menu',
        ]);
        $this->group_background([
            'name' => 'mega_menu_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu.pxl-mega-menu',
		]);
        $this->group_style([
            'name' => 'mega_menu_',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu.pxl-mega-menu',
        ]);
        $this->end_controls_section();
    }
}