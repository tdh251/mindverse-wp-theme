<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Price_Table extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_price_table',
            'title'      => __( 'MV Price Table', 'mindverse' ),
            'icon'       => 'eicon-price-table',
            'script'     => ['mindverse-interactions', 'mindverse-scrolling'],
            'keywords'   => [ 'mv', 'mindverse', 'pricing', 'table', 'switcher', 'price', 'filter' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Layout
        $this->register_layout_controls();
        $this->register_style_layout_controls();
        // Content
        $this->register_interactions_content_controls();
        $this->register_main_content_controls();
        $this->register_icon_content_controls();
        $this->register_note_content_controls();
        $this->register_items_animation_controls();
        // Card Price Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_box_border_gradient_style_controls();
        $this->register_box_overview_style_controls();
        $this->register_icon_style_controls();
        $this->register_title_style_controls();
        $this->register_description_style_controls();
        $this->register_amount_style_controls();
        $this->register_amount_suffix_style_controls();
        $this->register_divider_style_controls();
        $this->register_feature_icon_style_controls();
        $this->register_feature_text_style_controls();
        $this->register_button_style_controls();
        $this->register_badge_style_controls();
        $this->register_note_style_controls();
        // Filter Button Style
        $this->register_filter_header_layout_style_controls();
        $this->register_filter_header_box_style_controls();
        $this->register_filter_button_style_controls();
        $this->register_filter_button_note_controls();
        $this->register_button_icon_slider_style_controls();

        // Settings
        $this->register_grid_settings_controls();
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
            'columns' => 1,
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Price Table 1', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Price Table 2', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-2.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Price Table 3', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-3.webp'),
                ],
                '4' => [
                    'title' => esc_attr__( 'Price Table 4', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-4.webp'),
                ],
                '5' => [
                    'title' => esc_attr__( 'Price Table 5', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-5.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Style Layout Controls 
     */    
    protected function register_style_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'layout_style_section', 
            'label' => __('Layout Style', 'mindverse'),
            'condition' => [
                'layout' => ['2','5']
            ] 
        ]);
        $this->visual_choice([
            'name' => 'layout5_style',
            'label' => __('Layout Style', 'mindverse'),
            'columns' => 1,
            'condition' => [
                'layout' => ['5']
            ], 
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Default', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-5.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Border Gradient', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-5_2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->visual_choice([
            'name' => 'layout2_style',
            'label' => __('Layout Style', 'mindverse'),
            'columns' => 1,
            'condition' => [
                'layout' => ['2']
            ], 
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Default', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-2.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Border Gradient', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/price-table-2_2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Interactions Content Controls 
     */ 
    protected function register_interactions_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_interactions_content', 
            'label' => __('Interactions', 'mindverse'), 
        ]);
        $this->switcher([
            'name' => 'on_filter',
            'label' => __('Enable The Filter', 'mindverse'),
            'default' => 'btns',
        ]);
        $this->select([
            'name' => 'input_mode',
            'label' => __('Input Mode', 'mindverse'),
            'default' => 'btns',
            'options' => [
                'btns'  => __('Filter Buttons', 'mindverse'),
                'items' => __('Filter Items', 'mindverse'),
            ],
            'condition' => [
                'on_filter' => 'yes'
            ],
        ]);
        $this->icons([
            'name' => 'slider_icon',
            'label' => __('Slider Icon', 'mindverse'),
            'default' => [],
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns'
            ],
        ]);
        $this->visual_choice([
            'name' => 'filter_header_layout',
            'label' => __('Filter Header Layout', 'mindverse'),
            'options' => [
                'switcher' => [
                    'title' => esc_attr__( 'Switcher', 'mindverse' ),
                ],
                'choose' => [
                    'title' => esc_attr__( 'Choose', 'mindverse' ),
                ],
                'custom' => [
                    'title' => esc_attr__( 'Custom', 'mindverse' ),
                ],
            ],
            'default' => 'choose',
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns'
            ],
        ]);
        $this->text([
            'name' => 'filter_active',
            'label' => __('Filter Active', 'mindverse'),
            'default' => '*',
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns'
            ],
        ]);
        $this->repeater([
            'name' => 'btns',
            'label' => __('Filter Buttons', 'mindverse'),
            'title_field' => '{{{ btn_text }}}',
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns'
            ],
            'fields' => [
                [
                    'name' => 'data_filter',
                    'label' => __('Data Filter', 'mindverse'),
                    'type' => 'text',
                ],
                [
                    'name' => 'btn_text',
                    'label' => __('Text', 'mindverse'),
                    'type' => 'textarea',
                    'default' => __('Click here', 'mindverse'),
                ],
                [
                    'name' => 'btn_note',
                    'label' => __('Note', 'mindverse'),
                    'type' => 'text',
                ],
            ],
            'default' => [
                [
                    'btn_text' => __('Click here', 'mindverse'),
                    'data_filter' => '*'
                ],
                [
                    'btn_text' => __('Click here', 'mindverse'),
                    'data_filter' => '*'
                ],
                [
                    'btn_text' => __('Click here', 'mindverse'),
                    'data_filter' => '*'
                ],
            ]
        ]);
        $this->number([
            'name' => 'item_active',
            'label' => __('Item Active', 'mindverse'),
            'default' => 1,
            'separator' => 'before',
            'min' => 1,
            'step' => 1,
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'label' => __('Title HTML Tag', 'mindverse'),
            'default' => '',
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);        
        $this->end_controls_section();
    }

    /** 
     * Register Main Content Controls 
     */ 
    protected function register_main_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_main_content', 
            'label' => __('Content', 'mindverse'), 
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->text([
            'name' => 'btn_text',
            'label' => __('Button Text', 'mindverse'),
            'default' => __('Click here', 'mindverse'),
        ]);
        $this->icons([
            'name' => 'feature_icon',
            'label' => __('Feature Icon', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->text([
            'name' => 'feture_title',
            'label' => __('Feature Title', 'mindverse'),
            'default' => __('Feature Title', 'mindverse'),
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->title_tag([
            'name' => 'feature_title_tag',
            'label' => __('Feature Title HTML Tag', 'mindverse'),
            'default' => '',
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->repeater([
            'name' => 'contents',
            'label' => __('Contents', 'mindverse'),
            'separator' => 'before',
            'fields' => [
                [
                    'name' => 'filter_by',
                    'label' => __('Filter by Data Filter', 'mindverse'),
                    'type' => 'text',
                    'default' => 'all',
                ],
                [
                    'name' => 'title',
                    'label' => __('Title', 'mindverse'),
                    'type' => 'text',
                    'default' => __('Title #', 'mindverse'),
                ],
                [
                    'name' => 'description',
                    'label' => __('Description', 'mindverse'),
                    'type' => 'textarea',
                    'default' => __('Lorem ipsum dolor sit amet', 'mindverse'),
                ],
                [
                    'name' => 'price',
                    'label' => __('Price', 'mindverse'),
                    'type' => 'text',
                    'default' => __('$10', 'mindverse'),
                ],
                [
                    'name' => 'price_suffix',
                    'label' => __('Price Suffix', 'mindverse'),
                    'type' => 'text',
                    'default' => __('/something', 'mindverse'),
                ],
                [
                    'name' => 'features',
                    'label' => __('Features', 'mindverse'),
                    'type' => 'textarea',
                    'default' =>  __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                    'description' => __('Separate features with |', 'mindverse'),
                    'rows' => 10,
                ],
                [
                    'name' => 'badge_img',
                    'label' => __('Bagde Image', 'mindverse'),
                    'separator' => 'before',
                    'type' => 'media',
                    'default' => []
                ],
                [
                    'name' => 'badge_text',
                    'label' => __('Bagde Text', 'mindverse'),
                    'type' => 'text',
                ],
                [
                    'name' => 'btn_text',
                    'label' => __('Button Text', 'mindverse'),
                    'type' => 'text',
                    'separator' => 'before',
                ],
                [
                    'name' => 'link',
                    'label' => __('Link  URL', 'mindverse'),
                    'type' => 'url',
                    'default' => ['url' => '#'],
                ]
            ],
            'default' => [
                [
                    'title'     => __('Title #1', 'mindverse'),
                    'price'     => __('$10', 'mindverse'),
                    'description'      => __('Item description. Click the edit description.', 'mindverse'),
                    'features'  => __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                ],
                [
                    'title'     => __('Title #2', 'mindverse'),
                    'price'     => __('$49', 'mindverse'),
                    'description'      => __('Item description. Click the edit description.', 'mindverse'),
                    'features'  => __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                ],
                [
                    'title'     => __('Title #3', 'mindverse'),
                    'price'     => __('$99', 'mindverse'),
                    'description'      => __('Item description. Click the edit description.', 'mindverse'),
                    'features'  => __('Feature Item #1 | Feature Item #2 | Feature Item #3 | Feature Item #4 | Feature Item #5', 'mindverse'),
                ],
            ],
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
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name'     => 'on_filter',
                                'operator' => '!==',
                                'value'    => 'yes',
                            ],
                            [
                                'name'     => 'layout',
                                'operator' => 'in',
                                'value'    => [ '2', '4' ],
                            ],
                        ],
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name'     => 'on_filter',
                                'operator' => '===',
                                'value'    => 'yes',
                            ],
                            [
                                'name'     => 'input_mode',
                                'operator' => '===',
                                'value'    => 'items',
                            ],
                            [
                                'name'     => 'layout',
                                'operator' => 'in',
                                'value'    => [ '2', '4' ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->repeater([
            'name' => 'icons',
            'label' => __('Icons', 'mindverse'),
            'fields' => [
                [
                    'name' => 'icon',
                    'label' => __('Icon', 'mindverse'),
                    'type' => 'icons',
                ],
            ],
            'default' => [
                [
                    'icon'      => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ],
                [
                    'icon'      => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ],
                [
                    'icon'      => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ],
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Note Content Controls 
     */ 
    protected function register_note_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_note_content', 
            'label' => __('Note', 'mindverse'),
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'items',
                'layout' => ['1']
            ],
        ]);
        $this->repeater([
            'name' => 'notes',
            'label' => __('Notes', 'mindverse'),
            'fields' => [
                [
                    'name' => 'note',
                    'label' => __('Note 1', 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 3
                ],
                [
                    'name' => 'note_2',
                    'label' => __('Note 2', 'mindverse'),
                    'type' => 'textarea',
                    'rows' => 3
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
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ], 
        ]);
        // $this->align_items_horizontal([
        //     'name' => 'title_align_items',
        //     'label' => __('Title Align Items', 'mindverse'),
        //     'separator' => 'before',
        //     'selectors' => [
        //         '{{WRAPPER}} .price .price-title' => 'align-items: {{VALUE}};',
        //     ],
        // ]);
        // $this->slider([
        //     'name' => 'title_gap',
        //     'label' => __('Title Gap', 'mindverse'),
        //     'selectors' => [
        //         '{{WRAPPER}} .price .price-title' => 'gap: {{SIZE}}{{UNIT}};'
        //     ]
        // ]);
        $this->slider([
            'name' => 'title_spacing',
            'label' => __('Title Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->slider([
            'name' => 'desc_spacing',
            'label' => __('Description Spacing', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->slider([
            'name' => 'desc_max_width',
            'label' => __('Description Max Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-desc' => 'max-width: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->align_items_horizontal([
            'name' => 'price_align_items',
            'label' => __('Price Align Items', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-amount' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->slider([
            'name' => 'price_gap',
            'label' => __('Price Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-amount' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'price_spacing',
            'label' => __('Price Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-amount' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            
        ]);
        $this->slider([
            'name' => 'badge_gap',
            'label' => __('Badge Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-badge' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        // $this->slider([
        //     'name' => 'divider_spacing_top',
        //     'label' => __('Divider Spacing Top', 'mindverse'),
        //     'separator' > 'mindverse',
        //     'separator' => 'before',
        //     'selectors' => [
        //         '{{WRAPPER}} .price .price-divider' => 'margin-top: {{SIZE}}{{UNIT}};'
        //     ],
            
        // ]);
        // $this->slider([
        //     'name' => 'divider_spacing_bottom',
        //     'label' => __('Divider Spacing Bottom', 'mindverse'),
        //     'selectors' => [
        //         '{{WRAPPER}} .price .price-divider' => 'margin-bottom: {{SIZE}}{{UNIT}};'
        //     ]
        // ]);

        $this->align_items_horizontal([
            'name' => 'feature_align_items',
            'label' => __('Feature Align Items', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-feature li' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->slider([
            'name' => 'featured_item_spacing',
            'label' => __('Feature Item Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-feature li + li' => 'margin-top: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'feature_item_gap',
            'label' => __('Feature Item Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-feature li' => 'gap: {{SIZE}}{{UNIT}};'
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
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
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
            'selector' => '{{WRAPPER}} .price',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .price',
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
            'selector' => '{{WRAPPER}} .price:not(.box-gradient):hover, {{WRAPPER}} .price.box-gradient:before, 
                        {{WRAPPER}} .price:not(.box-gradient).is-active',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .price:hover, {{WRAPPER}} .price.is-active',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
    protected function register_box_border_gradient_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_border_gradient_style', 
            'label' => __('Box Border Gradient', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                            [
                                'name' => 'layout',
                                'operator' => 'in',
                                'value' => ['5'],
                            ]
                        ],
                    ],
                ],
            ],
        ]);
        $this->group_background([
            'name' => 'box_gradient_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price .box-border-gradient',
            'fields_options' => [			
				'color' => [
					'selectors' => [
						'{{WRAPPER}} .price .box-border-gradient' => '--mv-background-color: {{VALUE}};',
					],
				],
                'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .price .box-border-gradient' => '--mv-background-color-b: {{VALUE}};',
					],
				],
			],
		]);
        $this->color([
            'name' => 'gradient_color_1',
            'label' => __('Gradient Color 1', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price' => '--gradient-color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name' => 'gradient_color_2',
            'label' => __('Gradient Color 2', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price' => '--gradient-color-2: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name' => 'gradient_color_3',
            'label' => __('Gradient Color 3', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price' => '--gradient-color-3: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Box Overview Style Controls 
     */ 
    protected function register_box_overview_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_overview_style', 
            'label' => __('Box Overview', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name'     => 'on_filter',
                                'operator' => '!==',
                                'value'    => 'yes',
                            ],
                            [
                                'name'     => 'layout',
                                'operator' => 'in',
                                'value'    => [ '1', '2' ],
                            ],
                        ],
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name'     => 'on_filter',
                                'operator' => '===',
                                'value'    => 'yes',
                            ],
                            [
                                'name'     => 'input_mode',
                                'operator' => '===',
                                'value'    => 'items',
                            ],
                            [
                                'name'     => 'layout',
                                'operator' => 'in',
                                'value'    => [ '1', '2' ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $this->start_controls_tabs( 'box_overview_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'box_overview_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_overview_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price .price-overview',
		]);
        $this->group_style([
            'name' => 'box_overview_',
            'selector' => '{{WRAPPER}} .price .price-overview',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'box_overview_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_overview_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price:hover .price-overview:not(.box-gradient), {{WRAPPER}} .price.is-active .price-overview:not(.box-gradient), 
                        {{WRAPPER}} .price .price-overview.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_overview_hover_',
            'selector' => '{{WRAPPER}} .price:hover .price-overview, {{WRAPPER}} .price.is-active .price-overview',
        ]);
        $this->duration([
            'name' => 'box_overview_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-overview, {{WRAPPER}} .price-overview.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Icon Style Controls 
     */ 
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __('Icon', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name'     => 'on_filter',
                                'operator' => '!==',
                                'value'    => 'yes',
                            ],
                            [
                                'name'     => 'layout',
                                'operator' => 'in',
                                'value'    => [ '2' ],
                            ],
                        ],
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name'     => 'on_filter',
                                'operator' => '===',
                                'value'    => 'yes',
                            ],
                            [
                                'name'     => 'input_mode',
                                'operator' => '===',
                                'value'    => 'items',
                            ],
                            [
                                'name'     => 'layout',
                                'operator' => 'in',
                                'value'    => [ '2' ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .price .price-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size',
            'separator' => 'before',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
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
                '{{WRAPPER}} .price .price-icon' => 'color: {{VALUE}};',
                '{{WRAPPER}} .price .price-icon path' => 'fill: currentcolor;'
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price .price-icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .price .price-icon',
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
                '{{WRAPPER}} .price:hover .price-icon, {{WRAPPER}} .price.is-active .price-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price:hover .price-icon:not(.box-gradient), {{WRAPPER}} .price.is-active .price-icon:not(.box-gradient),
                        {{WRAPPER}} .price .price-icon.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .price:hover .price-icon, {{WRAPPER}} .price.is-active .price-icon',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** 
     * Register Note Style Controls 
     */ 
    protected function register_note_style_controls() {
        $this->start_style_section([
            'name' => 'section_note_style',
            'label' => __('Note', 'mindverse'),
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'items',
                'layout' => ['1']
            ],
        ]);
        $this->group_typography([
            'name' => 'note_typography',
            'selector' => '{{WRAPPER}} .price .price-note',
        ]);
        $this->start_controls_tabs( 'note_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'note_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'note_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-note' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'note_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'note_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price:hover .price-note, 
                {{WRAPPER}} .price.is-active .price-note' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'note_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-note' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .price .price-title',
        ]);
        $this->group_text_shadow([
            'name' => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .price .price-title',
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
                '{{WRAPPER}} .price .price-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'title_text_stroke',
            'selector' => '{{WRAPPER}} .price .price-title',
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
                '{{WRAPPER}} .price:hover .price-title, {{WRAPPER}} .price.is-active .price-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'title_hover_text_stroke',
            'selector' => '{{WRAPPER}} .price:hover .price-title, {{WRAPPER}} .price.is-active .price-title',
        ]);
        $this->duration([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Description Style Controls 
     */ 
    protected function register_description_style_controls() {
        $this->start_style_section([
            'name' => 'section_desc_style',
            'label' => __('Description', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .price .price-description',
        ]);
        $this->start_controls_tabs( 'desc_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'desc_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'desc_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'desc_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'desc_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price:hover .price-description, 
                {{WRAPPER}} .price.is-active .price-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'desc_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-description' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Amount Style Controls 
     */ 
    protected function register_amount_style_controls() {
        $this->start_style_section([
            'name' => 'section_amount_style',
            'label' => __('Amount', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->group_typography([
            'name' => 'amount_typography',
            'selector' => '{{WRAPPER}} .price .price-amount',
        ]);
        $this->start_controls_tabs( 'amount_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'amount_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'amount_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-amount' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'amount_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'amount_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price:hover .price-amount, {{WRAPPER}} .price.is-active .price-amount' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'amount_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-amount' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** 
     * Register Amount Suffix Style Controls 
     */ 
    protected function register_amount_suffix_style_controls() {
        $this->start_style_section([
            'name' => 'section_amount_suffix_style',
            'label' => __('Amount Suffix', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->group_typography([
            'name' => 'amount_suffix_typography',
            'selector' => '{{WRAPPER}} .price .price-amount .amount-suffix',
        ]);
        $this->start_controls_tabs( 'amount_suffix_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'amount_suffix_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'amount_suffix_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-amount .amount-suffix' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'amount_suffix_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'amount_suffix_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price:hover .price-amount .amount-suffix, {{WRAPPER}} .price.is-active .price-amount .amount-suffix' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'amount_suffix_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-amount .amount-suffix' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Divider Style Controls 
     */ 
    protected function register_divider_style_controls() {
        $this->start_style_section([
            'name' => 'section_divider_style',
            'label' => __('Divider', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->slider([
            'name' => 'divider_weight',
            'label' => __('Weight', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'default' => [
                'size' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .price .price-divider' => 'height: {{SIZE}}{{UNIT}};',
            ] 
        ]);
        $this->start_controls_tabs( 'divider_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'divider_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'divider_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price .price-divider',
		]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'divider_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->group_background([
            'name' => 'divider_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price:hover .price-divider, {{WRAPPER}} .price.is-active .price-divider',
		]);
        $this->duration([
            'name' => 'divider_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-divider' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Feature Icon Style Controls 
     */ 
    protected function register_feature_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_feature_icon_style',
            'label' => __('Feature Icon', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->slider([
            'name' => 'feature_icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-feature .feature-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .price .price-feature .feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
            ]
        ]);
        $this->slider([
            'name' => 'feature_icon_box_size',
            'separator' => 'before',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-feature .feature-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs( 'feature_icon_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'feature_icon_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'feature_icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-feature .feature-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'feature_icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price .price-feature .feature-icon',
		]);
        $this->group_style([
            'name' => 'feature_icon_',
            'selector' => '{{WRAPPER}} .price .price-feature .feature-icon',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'feature_icon_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'feature_icon_hover_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price:hover .price-feature .feature-icon, {{WRAPPER}} .price.is-active .price-feature .feature-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'feature_icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price:hover .price-feature .feature-icon, {{WRAPPER}} .price.is-active .price-feature .feature-icon',
		]);
        $this->group_style([
            'name' => 'feature_icon_hover_',
            'selector' => '{{WRAPPER}} .price:hover .price-feature .feature-icon, {{WRAPPER}} .price.is-active .price-feature .feature-icon',
        ]);
        $this->duration([
            'name' => 'feature_icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-feature .feature-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** 
     * Register Feature Text Style Controls 
     */ 
    protected function register_feature_text_style_controls() {
        $this->start_style_section([
            'name' => 'section_feature_text_style',
            'label' => __('Feature Text', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->group_typography([
            'name' => 'feature_text_typography',
            'selector' => '{{WRAPPER}} .price .price-feature li',
        ]);
        $this->start_controls_tabs( 'feature_text_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'feature_text_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'feature_text_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-feature li' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'feature_text_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'feature_text_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price:hover .price-feature li, 
                {{WRAPPER}} .price.is-active .price-feature li' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'feature_text_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-feature li' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Button Style Controls 
     */ 
    protected function register_button_style_controls() {
        $this->start_style_section([
            'name' => 'section_button_style', 
            'label' => __('Button', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->group_typography([
            'name' => 'btn_typography',
            'selector' => '{{WRAPPER}} .price-table .button',
        ]);
        $this->start_controls_tabs( 'btn_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'btn_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        // Color
        $this->color([
            'name' => 'btn_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price-table .button' => 'color: {{VALUE}};'
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'btn_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price-table .button',
            'exclude' => ['image']
        ]);
        // Group Style
        $this->group_style([
            'name' => 'btn_',
            'selector' => '{{WRAPPER}} .price-table .button'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'btn_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        // Color
        $this->color([
            'name' => 'btn_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price-table .price:hover .button, {{WRAPPER}} .price-table .price.is-active .button' => 'color: {{VALUE}};'
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'btn_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .price-table .price:hover .button:not(.box-gradient), {{WRAPPER}} .price-table .price.is-active .button:not(.box-gradient), 
                            {{WRAPPER}} .price-table .price.button.box-gradient:before',
		]);
        // Border Color 
        $this->color([
			'name' => 'btn_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .price-table .price:hover .button, {{WRAPPER}} .price-table .price.is-active .button' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'btn_hover',
            'selector' => '{{WRAPPER}} .price-table .price:hover .button, {{WRAPPER}} .price-table .price.is-active .button'
        ]);
        $this->duration([
            'name' => 'btn_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price-table .button' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** 
     * Register Filter Header Layout Style Controls 
     */
    protected function register_filter_header_layout_style_controls() {
        $this->start_style_section([
            'name' => 'section_filter_header_layout_style', 
            'label' => __('Filter Layout', 'mindverse'),
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns',
            ],
        ]);
        $this->gap([
            'name' => 'filter_btn_spacing',
            'label' => __('Button Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->gap([
            'name' => 'filter_btn_gap',
            'label' => __('Button Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header .filter-button' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'filter_btn_height',
            'label' => __('Button Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header .filter-button' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);

        $this->slider([
            'name' => 'filter_switcher_slider_size',
            'label' => __('Icon Slider Size', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .filter-header .toggle-switch .slider' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'filter_header_layout' => 'switcher'
            ]
        ]);
        $this->slider([
            'name' => 'filter_switcher_box_width',
            'label' => __('Slider Box Width', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .filter-header .toggle-switch' => 'width: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'filter_header_layout' => 'switcher'
            ]
        ]);
        $this->slider([
            'name' => 'filter_switcher_box_height',
            'label' => __('Slider Box Height', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .filter-header .toggle-switch' => 'height: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'filter_header_layout' => 'switcher'
            ]
        ]);
        $this->slider([
            'name' => 'filter_switcher_icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'separator' => 'before',
            'size_units' => ['px', 'custom'],
            'default' => ['unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .filter-header .toggle-switch .slider' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .filter-header .toggle-switch .slider svg' => 'width: {{SIZE}}{{UNIT}}; height:auto;',
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Filter Header Box Style Controls 
     */
    protected function register_filter_header_box_style_controls() {
        $this->start_style_section([
            'name' => 'section_box_filter_header_style', 
            'label' => __('Filter Header', 'mindverse'),
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns',
            ],
        ]);

        // Background 
        $this->group_background([
            'name' => 'filter_header_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .filter-header',
            'exclude' => ['image']
        ]);
        // Group Style
        $this->group_style([
            'name' => 'filter_header_',
            'selector' => '{{WRAPPER}} .filter-header'
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Filter Button Style Controls 
     */
    protected function register_filter_button_style_controls() {
        $this->start_style_section([
            'name' => 'section_filter_button_style', 
            'label' => __('Filter Button', 'mindverse'),
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns',
            ],
        ]);
        $this->group_typography([
            'name' => 'filter_btn_typography',
            'selector' => '{{WRAPPER}} .filter-header button',
        ]);
        $this->start_controls_tabs( 'filter_btn_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'filter_btn_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        $this->color([
            'name' => 'filter_btn_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header button' => 'color: {{VALUE}};'
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'filter_btn_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .filter-header button',
            'exclude' => ['image']
        ]);
        // Group Style
        $this->group_style([
            'name' => 'filter_btn_',
            'selector' => '{{WRAPPER}} .filter-header button'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'filter_btn_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        $this->color([
            'name' => 'filter_btn_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header button:hover, 
                {{WRAPPER}} .filter-header button.is-active' => 'color: {{VALUE}};'
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'filter_btn_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .filter-header button:not(.box-gradient):hover, 
                            {{WRAPPER}} .filter-header .box-gradient:before,
                            {{WRAPPER}} .filter-header button:not(.box-gradient).is-active,
                            {{WRAPPER}} .filter-header is-active.box-gradient:before'
		]);
        // Border Color 
        $this->color([
			'name' => 'filter_btn_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .filter-header .button:hover, {{WRAPPER}} .filter-header button.is-active' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'filter_btn_hover',
            'selector' => '{{WRAPPER}} .filter-header .button:hover, {{WRAPPER}} .filter-header .button.is-active'
        ]);
        $this->duration([
            'name' => 'filter_btn_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .filter-header button' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** 
     * Register Filter Button Note Style Controls 
     */
    protected function register_filter_button_note_controls() {
        $this->start_style_section([
            'name' => 'style_filter_btn_note_section', 
            'label' => __('Filter Button Note', 'mindverse'),
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns',
            ],
        ]);
        $this->group_typography([
            'name' => 'filter_btn_note_typography',
            'selector' => '{{WRAPPER}} .filter-header button .button-note',
        ]);
        $this->start_controls_tabs( 'filter_btn_note_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'filter_btn_note_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        $this->color([
            'name' => 'filter_btn_note_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header button .button-note' => 'color: {{VALUE}};'
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'filter_btn_note_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .filter-header button .button-note',
            'exclude' => ['image']
        ]);
        // Group Style
        $this->group_style([
            'name' => 'filter_btn_note_',
            'selector' => '{{WRAPPER}} .filter-header button .button-note'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'filter_btn_note_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        $this->color([
            'name' => 'filter_btn_note_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header button:hover .button-note, 
                {{WRAPPER}} .filter-header button.is-active .button-note' => 'color: {{VALUE}};'
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'filter_btn_note_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .filter-header button:hover .button-note, 
                            {{WRAPPER}} .filter-header button.is-active .button-note'
		]);
        // Border Color 
        $this->color([
			'name' => 'filter_btn_note_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .filter-header button:hover .button-note, 
                            {{WRAPPER}} .filter-header button.is-active .button-note' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'filter_btn_note_hover',
            'selector' => '{{WRAPPER}} .filter-header button:hover .button-note, 
                            {{WRAPPER}} .filter-header button.is-active .button-note'
        ]);
        $this->duration([
            'name' => 'filter_btn_note_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .filter-header button .button-note' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** 
     * Register Button Icon Slider Style Controls 
     */
    protected function register_button_icon_slider_style_controls() {
        $this->start_style_section([
            'name' => 'style_filter_switch_section', 
            'label' => __('Filter Button Switch', 'mindverse'),
            'condition' => [
                'on_filter' => 'yes',
                'input_mode' => 'btns',
                'filter_header_layout' => 'switcher'
            ],
        ]);
        $this->color([
            'name' => 'filter_switcher_icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .filter-header .toggle-switch .slider' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'filter_switcher_color',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .filter-header .toggle-switch .slider',
            'fields_options' => [
                'background' => [
                    'label' => __('Icon Background', 'mindverse'),
                ]
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'filter_switcher_background',
            'types' => [ 'classic', 'gradient' ],
            'fields_options' => [
                'background' => [
                    'label' => __('Box Background', 'mindverse'),
                ]
            ],
            'selector' => '{{WRAPPER}} .filter-header .toggle-switch',
        ]);

        // Group Style
        $this->group_style([
            'name' => 'filter_switcher_',
            'selector' => '{{WRAPPER}} .filter-header .toggle-switch'
        ]);

        $this->end_controls_section();
    }

    /** 
     * Register Badge Style Controls 
     */ 
    protected function register_badge_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_badge_style', 
            'label' => __('Badge', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'badge_typography_',
            'selector' => '{{WRAPPER}} .price .price-badge',
        ]);

        $this->start_controls_tabs( 'badge_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'badge_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'badge_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price .price-badge' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'badge_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price .price-badge',
		]);
        $this->group_style([
            'name' => 'badge_',
            'selector' => '{{WRAPPER}} .price .price-badge',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'badge_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'badge_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .price:hover .price-badge, {{WRAPPER}} .price.is-active .price-badge' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'badge_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .price:hover .price-badge:not(.badge-gradient), {{WRAPPER}} .price .price-badge.badge-gradient:before, 
                        {{WRAPPER}} .price.is-active .price-badge:not(.badge-gradient)',
		]);
        $this->group_style([
            'name' => 'badge_hover_',
            'selector' => '{{WRAPPER}} .price:hover .price-badge, {{WRAPPER}} .price.is-active .price-badge',
        ]);
        $this->duration([
            'name' => 'badge_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .price .price-badge, {{WRAPPER}} .price .price-badge.badge-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    
    /** 
     * Register Grid Settings Controls 
     */
    protected function register_grid_settings_controls() {
        $this->start_settings_section([ 
            'name' => 'section_grid_settings', 
            'label' => __('Grid', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'on_filter',
                        'operator' => '!==',
                        'value' => 'yes',
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'on_filter',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                            [
                                'name' => 'input_mode',
                                'operator' => '===',
                                'value' => 'items',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $this->grid_controls_section();
        $this->end_controls_section();
    }
}