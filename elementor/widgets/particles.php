<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use \Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Particles extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_particles',
            'title'      => __( 'MV Particles', 'mindverse' ),
            'icon'       => 'eicon-ellipsis-h',
            'script'     => ['mindverse-effects'],
            'keywords'   => [ 'mv', 'mindverse', 'particles', 'par', 'seed', 'nasa', 'star'],
        ];
    }

    protected function register_controls() {
        $this->content_section();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    protected function content_section() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => 'Content' 
        ]);
                $this->number([
            'name' => 'number',
            'label' => __('Number', 'mindverse'),
        ]);
        $this->number([
            'name' => 'size',
            'label' => __('Size', 'mindverse'),
        ]);
        $this->color([
            'name' => 'color',
            'label' => __('Color' , 'mindverse'),
        ]);
        $this->select([
            'name' => 'shape',
            'label' => __('Shape', 'mindverse'),
            'default' => 'circle',
            'options' => [
                'circle' => __('Circle', 'mindverse'),
                'star'   => __('Star'  , 'mindverse'),
                'image'    => __('Image' , 'mindverse'),
            ]
        ]);
        $this->media([
            'name' => 'shape_img',
            'label' => __('Shape Image', 'mindverse'),
            'condition' => [
                'shape' => ['image']
            ]
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Apply all items)', 'mindverse' ),
            'condition' => [
                'shape' => ['image']
            ]
        ]);
        $this->select([
            'name' => 'dir',
            'label' => __('Direction', 'mindverse'),
            'default' => 'none',
            'options' => [
                'none'         => __('Random', 'mindverse'),
                'top'          => __('Top'  , 'mindverse'),
                'top-right'    => __('Top Right' , 'mindverse'),
                'right'        => __('Right', 'mindverse'),
                'bottom-right' => __('Bottom Right', 'mindverse'),
                'bottom'       => __('Bottom', 'mindverse'),
                'bottom-left'  => __('Bottom Left', 'mindverse'),
                'left'         => __('Left', 'mindverse'),
                'top-left'     => __('Top Left', 'mindverse'),
            ]
        ]);

        $this->slider([
            'name' => 'layout_width',
            'label' => __('Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .particles' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'layout_max_width',
            'label' => __('Max Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .particles' => 'max-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'layout_height',
            'label' => __('Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .particles' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** Render */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = 'particles-js-' . $this->get_id();
        $particles_settings = [
            'number' => $settings['number'] ?? 30,
            'color'  => $settings['color'] ?? '#FFF',
            'dir'    => $settings['dir'],
            'size'   => $settings['size'] ?? 5,
            'shape'  => [
                'type' => $settings['shape'] ??' circle',
                'image' => [
                    'src'    => $settings['shape_img']['url'] ?? '' ,
                    'width'  => $settings['img_size']['width'] ?? 10,
                    'height' => $settings['img_size']['height'] ?? 10 
                ], 
            ],
        ];
        ?>
        <div id="<?php echo esc_attr($widget_id); ?>" class="particles" data-settings="<?php echo esc_attr( wp_json_encode( $particles_settings ) ); ?>"></div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var imgSrc = ( settings.shape_img && settings.shape_img.url ) ? settings.shape_img.url : '';
        
        var imgWidth = 10; 
        var imgHeight = 10;
        if ( settings.img_size && settings.img_size.width ) {
            imgWidth = settings.img_size.width;
        }
        if ( settings.img_size && settings.img_size.height ) {
            imgHeight = settings.img_size.height;
        }

        var particlesSettings = {
            'number': settings.number || 30,
            'color':  settings.color || '#FFF',
            'dir':    settings.dir, 
            'size':   settings.size || 5,
            'shape': {
                'type': settings.shape || 'circle',
                'image': {
                    'src':    imgSrc,
                    'width':  imgWidth,
                    'height': imgHeight
                }
            }
        };
        #>
        <div id="particles-js-{{ view.getID() }}"
             class="particles"
             data-settings='{{ JSON.stringify(particlesSettings) }}'></div>
        <?php
    }
}