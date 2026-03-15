<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Filter_Button extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_filter_button',
            'title'      => __( 'MV Post Filter Button', 'mindverse' ),
            'icon'       => 'eicon-meta-data',
            'keywords'   => [ 'mv', 'mindverse', 'filter', 'data' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_source_content_controls();
        // Style
        $this->register_layout_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Grid Source Content Controls
     */
    protected function register_source_content_controls() {      
        $post_types = mindverse()->post->get_post_type_list();  
        $this->start_content_section([ 
            'name' => 'content_archive_source', 
            'label' => __('Source', 'mindverse') 
        ]);
        $this->text([
            'name' => 'trigger_id',
            'label' => __('Trigger ID', 'mindverse'),
            'placeholder' => __('Ex: #name-id', 'mindverse'),
        ]);
        $this->select([
            'name' => 'post_type',
            'label' => __('Post Type', 'mindverse'),
            'options' => $post_types,
            'separator' => 'before',
            'default' => 'post',
        ]);
        foreach( $post_types as $post_type => $label ) {
            $category_key = $post_type === 'post' ? 'category' : $post_type.'_category';
            $this->select2([
                'name' => $post_type.'_categories',
                'label_block' => true,
                'label' => __('Post Categories', 'mindverse'),
                'options' => mindverse()->post->get_cpt_category_list( $category_key ),
                'multiple' => true,
                'condition' => [
                    'post_type' => $post_type
                ]
            ]);
        }
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
                '{{WRAPPER}} .post-filter-button' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-filter-button' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['column', 'column-reverse'],
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-filter-button' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['', 'row', 'row-reverse'],
            ],
        ]);
        $this->align_items_horizontal([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-filter-button' => 'align-items: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['column', 'column-reverse'],
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'layout',
            'selectors' => [
                '{{WRAPPER}} .post-filter-button' => 'align-items: {{VALUE}};',
            ],
            'condition' => [
                'layout_flex_direction!' => ['', 'row', 'row-reverse'],
            ],
        ]);
        $this->gap([
            'name' => 'layout_row',
            'label' => __('Row Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-filter-button' => 'row-gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->gap([
            'name' => 'layout_column',
            'label' => __('Column Gap', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-filter-button' => 'column-gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }
}