<?php
namespace Mindverse\Inc\Integrations\Elementor\Traits;

use \Elementor\Controls_Manager;
// use \Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


trait Css_Trait {
    /**
     * Quick flex direction control
     */
    protected function flex_direction($args = []) {
        $defaults = [
            'label' => __( 'Flex Direction', 'mindverse' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'row' => [ 'title' => __( 'Row', 'mindverse' ), 'icon' => 'eicon-arrow-right', ],
                'column' => [ 'title' => __( 'Column', 'mindverse' ), 'icon' => 'eicon-arrow-down', ],
                'row-reverse' => [ 'title' => __( 'Row Reverse', 'mindverse' ), 'icon' => 'eicon-arrow-left', ],
                'column-reverse' => [ 'title' => __( 'Column Reverse', 'mindverse' ), 'icon' => 'eicon-arrow-up', ],
            ],
            'toggle' => true,
        ];

        $this->_register_control_helper(
            'add_responsive_control',
            $args,
            $defaults,
            __FUNCTION__,
            '_flex_direction' 
        );
    }

    /**
     * Quick justify content horizontal layout flex
     */
    protected function justify_content_horizontal($args = []) {
        $defaults = [
            'label' => __( 'Justify Content', 'mindverse' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'start' => [ 'title' => __( 'Start', 'mindverse' ), 'icon' => 'eicon-justify-start-h', ],
                'center' => [ 'title' => __( 'Center', 'mindverse' ), 'icon' => 'eicon-justify-center-h', ],
                'end' => [ 'title' => __( 'End', 'mindverse' ), 'icon' => 'eicon-justify-end-h', ],
                'space-between' => [ 'title' => __( 'Space Between', 'mindverse' ), 'icon' => 'eicon-justify-space-between-h', ],
                'space-around' => [ 'title' => __( 'Space Around', 'mindverse' ), 'icon' => 'eicon-justify-space-around-h', ],
                'space-evenly' => [ 'title' => __( 'Space Evenly', 'mindverse' ), 'icon' => 'eicon-justify-space-evenly-h', ],
            ],
            'toggle' => true,
            'label_block' => true,
        ];
        
        $this->_register_control_helper(
            'add_responsive_control',
            $args,
            $defaults,
            __FUNCTION__,
            '_justify_content_h' 
        );
    }

    /**
     * Quick justify content vertical layout flex
     */
    protected function justify_content_vertical($args = []) {
        $defaults = [
            'label' => __( 'Justify Content', 'mindverse' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'start' => [ 'title' => __( 'Start', 'mindverse' ), 'icon' => 'eicon-justify-start-v', ],
                'center' => [ 'title' => __( 'Center', 'mindverse' ), 'icon' => 'eicon-justify-center-v', ],
                'end' => [ 'title' => __( 'End', 'mindverse' ), 'icon' => 'eicon-justify-end-v', ],
                'space-between' => [ 'title' => __( 'Space Between', 'mindverse' ), 'icon' => 'eicon-justify-space-between-v', ],
                'space-around' => [ 'title' => __( 'Space Around', 'mindverse' ), 'icon' => 'eicon-justify-space-around-v', ],
                'space-evenly' => [ 'title' => __( 'Space Evenly', 'mindverse' ), 'icon' => 'eicon-justify-space-evenly-v', ],
            ],
            'toggle' => true,
            'label_block' => true,
        ];
        
        $this->_register_control_helper(
            'add_responsive_control',
            $args,
            $defaults,
            __FUNCTION__,
            '_justify_content_v' 
        );
    }

    /**
     * Quick align-items horizontal layout flex
     */
    protected function align_items_horizontal($args = []) {
        $defaults = [
            'label' => __( 'Align Items', 'mindverse' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'start' => [ 'title' => __( 'Start', 'mindverse' ), 'icon' => 'eicon-align-start-v', ],
                'center' => [ 'title' => __( 'Center', 'mindverse' ), 'icon' => 'eicon-align-center-v', ],
                'end' => [ 'title' => __( 'End', 'mindverse' ), 'icon' => 'eicon-align-end-v', ],
                'stretch' => [ 'title' => __( 'Stretch', 'mindverse' ), 'icon' => 'eicon-align-stretch-v', ],
            ],
            'toggle' => true,
        ];

        $this->_register_control_helper(
            'add_responsive_control',
            $args,
            $defaults,
            __FUNCTION__,
            '_align_items_h' 
        );
    }

    /**
     * Quick align-items vertical layout flex
     */
    protected function align_items_vertical($args = []) {
        $defaults = [
            'label' => __( 'Align Items', 'mindverse' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'start' => [ 'title' => __( 'Start', 'mindverse' ), 'icon' => 'eicon-align-start-h', ],
                'center' => [ 'title' => __( 'Center', 'mindverse' ), 'icon' => 'eicon-align-center-h', ],
                'end' => [ 'title' => __( 'End', 'mindverse' ), 'icon' => 'eicon-align-end-h', ],
                'stretch' => [ 'title' => __( 'Stretch', 'mindverse' ), 'icon' => 'eicon-align-stretch-h', ],
            ],
            'toggle' => true,
        ];

        $this->_register_control_helper(
            'add_responsive_control',
            $args,
            $defaults,
            __FUNCTION__,
            '_align_items_v' 
        );
    }

    /**
     * Quick gap
     */
    protected function gap($args = []) {
        $defaults = [
            'label' => __( 'Gap', 'mindverse' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0, 'max' => 500, ],
            ],
            'default' => [
                'unit' => 'px',
            ],
        ];

        $this->_register_control_helper(
            'add_responsive_control',
            $args,
            $defaults,
            __FUNCTION__,
            '_gap' 
        );
    }

    /**
     * Text Align
     */
    protected function text_alignment( $args = [] ) {
        $name = $args['name'] ?? 'text_alignment';
        unset($args['name']);
        $this->choose(
            array_merge(
                [
                    'label' => __('Text Align', 'mindverse'),
                    'name' => $name,
                    'options' => [
                        'left' =>  [
                            'title' => esc_html__('Left', 'mindverse'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' =>  [
                            'title' => esc_html__('Center', 'mindverse'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' =>  [
                            'title' => esc_html__('Right', 'mindverse'),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' =>  [
                            'title' => esc_html__('Justify', 'mindverse'),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'method' => 'add_responsive_control',
                ],
                $args,
            )
        );
    }

    /**
     * Duration
     */
    protected function duration( $args = [] ) {
        $defaults = [
            'type' => 'slider',
            'label' => __( 'Duration', 'mindverse' ),
            'size_units' => ['s', 'ms'],
            'range' => [
                's' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 0.01,
                ],
                'ms' => [
                    'min' => 0,
                    'max' => 100000,
                    'step' => 10,
                ],
            ],
            'default' => [
                'unit' => 'ms',
            ]
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    protected function grid_controls_section() {
        $this->start_controls_tabs('grid_controls_tabs');
        /**
         * TAB: Options
         */
        $this->_start_controls_tab([
            'name'  => 'grid_tab_options',
            'label' => __('Options', 'mindverse'),
        ]);
        $this->select([
            'name' => 'grid_load_type',
            'label' => __('Load Type', 'mindverse'),
            'options' => [
                '' => __('None', 'mindverse'),
                'pagination' => __('Pagination', 'mindverse'),
                'load_more' => __('Load More', 'mindverse'),
            ],
            'default' => '',
        ]);
        $this->end_controls_tab();
        /**
         * TAB: Responsive
         */
        $this->_start_controls_tab([
            'name'  => 'grid_tab_responsive',
            'label' => __('Responsive', 'mindverse'),
        ]);
        $this->select([
            'name' => 'grid_columns',
            'label' => __("Columns", 'mindverse'),
            'default' => '',
            'options' => [
                ''     => __('Default', 'mindverse'),
                'custom' => __('Custom', 'mindverse'),
                '100%' => __('1', 'mindverse'),
                '50%'  => __('2', 'mindverse'),
                '33.333333%' => __('3', 'mindverse'),
                '25%'  => __('4', 'mindverse'),
                '20%'  => __('5', 'mindverse'),
                '16.666666%' => __('6', 'mindverse'),
            ],
            'method' => 'add_responsive_control',
            'selectors' => [
                '{{WRAPPER}} .grid' => '--mv-grid-size: {{VALUE}};'
            ]
        ]);
        $this->slider([
            'name' => 'grid_columns_custom',
            'label' => __('Column Size(%)', 'mindverse'),
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ]
            ],
            'default' => [
                'unit' => '%',
            ],
            'selectors' => [
                '{{WRAPPER}} .grid' => '--mv-grid-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'grid_columns' => 'custom',
            ]
        ]);

        $this->slider([
            'name' => 'grid_spacing_inline',
            'label' => __('Spacing Inline', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .grid .grid-inner' => '--mv-spacing-inline: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'grid_spacing_block',
            'label' => __('Spacing Block', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .grid .grid-inner' => '--mv-spacing-block: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
    }
    
}