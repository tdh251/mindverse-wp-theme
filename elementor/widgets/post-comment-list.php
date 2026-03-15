<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Comment_List extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_comment_list',
            'title'      => __( 'MV Post Comment List', 'mindverse' ),
            'icon'       => 'eicon-user-circle-o',
            'keywords'   => [ 'mv', 'mindverse', 'comment', 'post' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Comment List', 'mindverse')
        ]);

        $this->end_controls_section();
    }
}