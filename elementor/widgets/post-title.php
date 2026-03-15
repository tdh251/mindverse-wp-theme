<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Title extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_title',
            'title'      => __( 'MV Post Title', 'mindverse' ),
            'icon'       => 'eicon-post-title',
            'keywords'   => [ 'mv', 'mindverse', 'title', 'post', 'heading' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        $this->register_title_style_controls();
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
        $this->title_tag([
            'name'      => 'title_tag',
            'default'   => 'h2',
        ]);
        $this->text_alignment([
            'selectors' => [
                '{{WRAPPER}} .post-title' => 'text-align: {{VALUE}}',
            ],
            'separator' => 'before',
        ]);
        $this->end_controls_section();
    }

        /**
     * Register Title Style Controls
     */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style',
            'label' => __('Title', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .title',
        ]);
        $this->group_background([
			'name' => 'title_fill',
			'selector' => '{{WRAPPER}} .title',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .title' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .title' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .title' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_background([
            'name' => 'title_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .title',
        ]);
        // Group Style
        $this->group_style([
            'name' => 'title_',
            'selector' => '{{WRAPPER}} .title'
        ]);
        $this->end_controls_section();
    }

}