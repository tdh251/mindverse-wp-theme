<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Team_Info extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_team_info',
            'title'      => __( 'Team Info', 'mindverse' ),
            'icon'       => 'eicon-post-info',
            'keywords'   => [ 'mv', 'mindverse', 'team', 'our team', 'info', 'details', 'single' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        $this->register_content_controls();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
        ]);
        $this->title_tag([
            'name' => 'title_tag',
        ]);
        $this->text([
            'name'        => 'email_label',
            'label'       => __( 'Email Label', 'mindverse' ),
            'placeholder' => __( 'Ex: Email Address', 'mindverse' ),
            'default'     => __( 'Email Address', 'mindverse' ) 
        ]);
        $this->text([
            'name'        => 'phone_number_label',
            'label'       => __( 'Phone Number Label', 'mindverse' ),
            'placeholder' => __( 'Ex: Phone Number', 'mindverse' ),
            'default'     => __( 'Phone Number', 'mindverse' ) 
        ]);
        $this->text([
            'name'        => 'address_label',
            'label'       => __( 'Address Label', 'mindverse' ),
            'placeholder' => __( 'Ex: Address', 'mindverse' ),
            'default'     => __( 'Address', 'mindverse' ) 
        ]);
        $this->end_controls_section();
    }
}