<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Breadcrumb extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_breadcrumb',
            'title'      => __( 'MV Breadcrumb', 'mindverse' ),
            'icon'       => 'eicon-arrow-right',
            'keywords'   => [ 'mv', 'mindverse', 'breadcrumb' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_breadcrumb_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => __( 'Icon', 'mindverse' ),
            'default' => [
                'value' => [
                    'url' => content_url('uploads/2025/11/arrow-right.svg'),
                    'id' => '2303'
                ],
                'library' => 'svg'
            ]
        ]);
        $this->end_controls_section();
    }
}