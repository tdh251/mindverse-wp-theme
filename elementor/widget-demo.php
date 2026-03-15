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
            'keywords'   => [ 'mv', 'mindverse', 'case',' show' ],
        ];
    }

    /**
     * Register All Content
     */
    protected function register_controls() {
        $this->register_content_controls();
    }

    
    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->media([
            'name' => 'img',
            'label' => __('Choose Logo', 'mindverse'),
        ]);
        $this->group_size([
            'name'  => 'logo',
            'label' => 'Image Size',
            'selectors' => '{{WRAPPER}} .mv-site-logo img'
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before',
            'default' => [
                'url' => home_url(),
            ]
        ]);
        $this->end_controls_section();
    }
}