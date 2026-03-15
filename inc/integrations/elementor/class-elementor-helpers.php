<?php
/**
 * Handles integration with the PXL plugin.
 *
 * @package    Mindverse
 * @subpackage Inc\Integrations
 */
namespace Mindverse\Inc\Integrations\Elementor;

use Mindverse\Inc\Utils\Helpers;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Helpers { 

    /**
     * Check validate in control trait
     */
    public static function validate_control_name($args, $function) {
        if ( !isset($args['name']) || trim($args['name']) === '' ) {
            error_log(sprintf(
                '[Mindverse Widget] Missing or empty "name" in %s() control definition.',
                $function
            ));
            return false;
        }
        return true;
    }

    /**
     * 
     */
    public static function is_items_empty($items = []) {
        if( is_array($items) && ( empty($items) || count($items) === 0 ) ) {
            pxl_print_html('<p class="mindverse-no-found">'.esc_html__('No item found!', 'mindverse').'</p>');
            return;
        }
    }

    /**
     * Get break point device 
     */
    public static function get_elementor_divice() {
        // TODO: In Pro 3.5.0, get the active devices using Breakpoints/Manager::get_active_devices_list().
        $active_breakpoint_instances = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
        // Devices need to be ordered from largest to smallest.
        $active_devices = array_reverse( array_keys( $active_breakpoint_instances ) );

        // Add desktop in the correct position.
        if ( in_array( 'widescreen', $active_devices, true ) ) {
            $active_devices = array_merge( array_slice( $active_devices, 0, 1 ), [ 'desktop' ], array_slice( $active_devices, 1 ) );
        } else {
            $active_devices = array_merge( [ 'desktop' ], $active_devices );
        }

        $device_options = ['' => 'None'];

        foreach ( $active_devices as $device ) {
            $label = 'desktop' === $device ? esc_html__( 'Desktop', 'mindverse' ) : $active_breakpoint_instances[ $device ]->get_label();
            $device_options[ $device ] = $label;
        }

        $device_options['custom'] = 'Custom';
        return $device_options;
    }

    /**
     * Get all link attrs
     */
    public static function get_link_attrs($link) {
        if(!isset($link['url']) || empty($link['url'])) {
            return false;
        }
        $ouput = 'href="' . esc_url(trim($link['url'])) . '"';
        if ($link['is_external']) {
            $ouput .= ' target="_blank"';
        }
        if ($link['nofollow']) {
            $ouput .= ' rel="nofollow"';
        }
        if (!empty($link['custom_attributes'])) {
            $custom_attributes = explode(',', $link["custom_attributes"]);
            foreach ($custom_attributes as $attr) {
                list($key, $value) = explode('|', $attr);
                $ouput .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
            }
        }
        return $ouput;
    }

    /**
     * Load Elementor widget template
     */
    public static function get_template( $slug, $args = [] ) {
        $template_path = get_template_directory() . $slug . '.php';
        if ( !file_exists( $template_path ) ) {
            return;
        } 

        if ( ! empty( $args ) && is_array( $args ) ) {
            extract( $args, EXTR_SKIP );
        }
        include $template_path;
    }

    /**
     * 
     */
    public static function get_image_to_size($img_id, $width = null, $height = null, $attrs = []) {
        return Helpers::get_image_to_size($img_id, $width, $height, $attrs);
    }

    /**
     * 
     */
    public static function the_image_to_size($img_id, $width = null, $height = null, $attrs = []) {
        Helpers::the_image_to_size($img_id, $width, $height, $attrs);
    }

    /**
     * 
     */
    public static function get_swiper_settings( $settings = [], $args = [] ) {
        $params = [];

        // BASIC SETTINGS
        $params['allowTouchMove'] = (bool) $settings['allow_touch_move'];
        $params['centeredSlides'] = (bool) $settings['centered_slides'];
        $params['direction']      = $settings['swiper_direction'] ?? 'horizontal';
        $params['rows']           = $settings['swiper_grid_rows'] ?? '';
        // AUTOPLAY
        if ( (bool) $settings['auto_play'] ) {
            $params['autoplay'] = [
                'delay'                => intval( $settings['delay'] ?? 5000 ),
                'disableOnInteraction' => (bool) $settings['disable_on_interaction'],
                'pauseOnMouseEnter'    => (bool) $settings['pause_on_mouse_enter'],
                'reverseDirection'     => (bool) $settings['reverse_direction'],
            ];
        }else {
            $params['autoplay'] = false;
        }

        // FREE MODE
        if ( (bool) $settings['free_mode'] ) {
            $params['freeMode'] = [
                'enabled' => true,    
                'sticky'  => (bool) $settings['free_mode_sticky'],
                'momentum' => (bool) $settings['momentum']
            ];
        }else {
            $params['freeMode'] = false;
        }


        // LOOP & INTERACTION
        $params['initialSlide'] = max( 0, intval( ( $settings['initial_slide'] ?? 1 ) - 1 ) );
        $params['loop']         = ( (bool) $settings['loop'] );
        $params['mousewheel']   = ( (bool) $settings['mousewheel'] );

        // NAVIGATION
        if ( (bool) $settings['swiper_nav'] ) {
            $params['navigation']['use_nav_widget'] = (bool) $settings['use_nav_widget'];
            if ( (bool) $settings['use_nav_widget']  ) {
                $params['navigation'] = [
                    'prevEl' => '#' . esc_attr( $settings['nav_widget_id'] ) . ' .carousel-button-prev',
                    'nextEl' => '#' . esc_attr( $settings['nav_widget_id'] ) . ' .carousel-button-next',
                ];
            }
        }else {
            $params['navigation'] = false;
        }

        // PAGINATION
        $params['pagination'] = $settings['swiper_pagination'];

        // SCROLLBAR
        $params['scrollbar'] = (bool) $settings['swiper_scrollbar'];

        // SPEED
        $params['speed'] = intval( $settings['speed'] ?? 300 );

        // Drag Reverse
        $params['touchRatio'] = $settings['swiper_drag_reverse'] === 'yes' ? -1 : 1;
        
        // RESPONSIVE
        $params['slides_per_view_xs'] = (int) $settings['slides_per_view_xs'] ?? 1;
        $params['slides_per_view_sm'] = (int) $settings['slides_per_view_sm'] ?? 1;
        $params['slides_per_view_md'] = (int) $settings['slides_per_view_md'] ?? 2;
        $params['slides_per_view_lg'] = (int) $settings['slides_per_view_lg'] ?? 2;
        $params['slides_per_view_xl'] = (int) $settings['slides_per_view_xl'] ?? 3;
        $params['slides_per_view_xxl'] = (int) $settings['slides_per_view_xxl'] ?? 3;

        $params = array_merge($params, $args);


        return $params;
    }

    /**
     * 
     */
    public static function get_swiper_controls( $settings = [] ) {
        ob_start();
        if( !empty( $settings['swiper_pagination'] ) ) : ?>
            <div class="carousel-pagination"></div>
        <?php endif; ?>
        <?php
        if( (bool) $settings['swiper_nav'] ) : 
            $use_nav_widget = $settings['use_nav_widget'] === 'yes';
            $nav_class = $use_nav_widget ? ' carousel-navigation-hide' : '';
            $box_gradient_class = !empty( $settings['swiper_nav_btn_background_color_b'] ) || 
                    !empty( $settings['swiper_nav_btn_background_image'] ) ||  
                    !empty( $settings['swiper_nav_btn_hover_background_color_b'] ) || 
                    !empty( $settings['swiper_nav_btn_hover_background_image'] ) ? ' box-gradient' : '';
        ?>
            <div class="carousel-navigation<?php echo esc_attr($nav_class); ?>">
                <div class="button carousel-button carousel-button-prev<?php echo esc_attr($box_gradient_class); ?>">
                    <?php if(!empty( $settings['nav_prev_icon']['value'] )) : ?>
                        <?php \Elementor\Icons_Manager::render_icon( $settings['nav_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="17" viewBox="0 0 10 17" fill="none">
                            <path d="M1.03125 7.21875L0 8.25L8.25 16.5L9.28125 15.4687L2.0625 8.25L9.28125 1.03125L8.25 -1.90735e-06L4.125 4.125L1.03125 7.21875Z" fill="#2B2B2B"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="button carousel-button carousel-button-next<?php echo esc_attr($box_gradient_class); ?>">
                    <?php if(!empty( $settings['nav_next_icon']['value'] )) : ?>
                        <?php \Elementor\Icons_Manager::render_icon( $settings['nav_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="17" viewBox="0 0 10 17" fill="none">
                            <path d="M8.33594 9.28125L9.36719 8.25L1.03125 -1.90735e-06L0 1.03125L7.21875 8.25L0 15.4687L1.03125 16.5L5.24219 12.375L8.33594 9.28125Z" fill="#2B2B2B"/>
                        </svg>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php
        if( (bool) $settings['swiper_scrollbar'] ) : ?>
            <div class="carousel-scrollbar"></div>
        <?php endif; 
        
        $html = ob_get_clean();
        return $html;
    }

    /**
     * 
     */
    public static function get_contact_form_options() {
        $forms = [ 0  => 'Choose Form' ];

        if ( class_exists( 'WPCF7' ) ) {
            $cf7_posts = get_posts([
                'post_type'      => 'wpcf7_contact_form',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);

            if ( ! empty( $cf7_posts ) ) {
                foreach ( $cf7_posts as $form ) {
                    $forms[ $form->ID ] = $form->post_title;
                }
            } 
        }
        return $forms;
    }

    public static function entrance_animation_options( $custom_options = [] ) {
        $options = array_merge([
            [
                'label' => __( 'None', 'mindverse' ),
                'options' => [
                    ''    => __('None', 'mindverse'),
                ]
            ],
            [
                'label' => __( 'Fade In', 'mindverse' ),
                'options' => [
                    'wow fadeIn'      => __('Fade In', 'mindverse'),
                    'wow fadeInUp'    => __('Fade In Up', 'mindverse'),
                    'wow fadeInRight' => __('Fade In Right', 'mindverse'),
                    'wow fadeInLeft'  => __('Fade In Left', 'mindverse'),
                    'wow fadeInDown'  => __('Fade In Down', 'mindverse'),
                ]
            ],
            [
                'label' => __( 'Reveal In', 'mindverse' ),
                'options' => [
                    'wow revealIn'           => __('Reveal In', 'mindverse'),
                    'wow revealInCircle'     => __('Reveal In Circle', 'mindverse'),
                    'wow revealInTop'        => __('Reveal In Top', 'mindverse'),
                    'wow revealInRight'      => __('Reveal In Right', 'mindverse'),
                    'wow revealInBottom'     => __('Reveal In Bottom', 'mindverse'),
                    'wow revealInLeft'       => __('Reveal In Left', 'mindverse'),
                    'wow revealInHorizontal' => __('Reveal In Horizontal', 'mindverse'),
                    'wow revealInVertical'   => __('Reveal In Vertical', 'mindverse'),
                ]
            ],
            [
                'label' => __( 'Zoom In', 'mindverse' ),
                'options' => [
                    'wow zoomIn'             => __('Zoom In', 'mindverse'),
                    ' wow zoomInUp'           => __('Zoom In Up', 'mindverse'),
                    'wow zoomInRight'        => __('Zoom In Right', 'mindverse'),
                    'wow zoomInBottom'       => __('Zoom In Bottom', 'mindverse'),
                    'wow zoomInLeft'         => __('Zoom In Left', 'mindverse'),
                    'wow zoomInUpRight'      => __('Zoom In Up Right', 'mindverse'),
                    'wow zoomInUpLeft'       => __('Zoom In Up Left', 'mindverse'),
                    'wow zoomInBottomRight'  => __('Zoom In Bottom Right', 'mindverse'),
                    'wow zoomInBottomLeft'   => __('Zoom In Bottom Left', 'mindverse'),
                    'wow zoomInBounce'       => __('Zoom In Bounce', 'mindverse'),
                ]
            ],
            // [
            //     'label' => __( 'Gsap', 'mindverse' ),
            //     'options' => [
            //         'text'             => __('Zoom In', 'mindverse'),
            //         'zoomInUp'           => __('Zoom In Up', 'mindverse'),
            //         'zoomInRight'        => __('Zoom In Right', 'mindverse'),
            //         'zoomInBottom'       => __('Zoom In Bottom', 'mindverse'),
            //         'zoomInLeft'         => __('Zoom In Left', 'mindverse'),
            //         'zoomInUpRight'      => __('Zoom In Up Right', 'mindverse'),
            //         'zoomInUpLeft'       => __('Zoom In Up Left', 'mindverse'),
            //         'zoomInBottomRight'  => __('Zoom In Bottom Right', 'mindverse'),
            //         'zoomInBottomLeft'   => __('Zoom In Bottom Left', 'mindverse'),
            //         'zoomInBounce'       => __('Zoom In Bounce', 'mindverse'),
            //     ]
            // ],
        ], $custom_options);
        return $options;
    }

    public static function loop_animation_options( $custom_options = [] ) {
        $options = array_merge([
            ''      => __( 'None', 'mindverse' ),
            'bellRing'      => __( 'Bell Ring', 'mindverse' ),
            'spin'      => __( 'Spin', 'mindverse' ),
            'floating'      => __( 'Floating ', 'mindverse' ),
            'floating2'      => __( 'Floating 2', 'mindverse' ),
            'floating3'      => __( 'Floating 3', 'mindverse' ),
            'floating4'      => __( 'Floating 4', 'mindverse' ),
            'jumping'        => __('Jumping', 'mindverse'),
            'zoomAndRest'    => __('Zoom And Rest', 'mindverse')
        ], $custom_options);
        return $options;
    }

    public static function entrance_animation_gsap_options( $custom_options = [] ) {
        $options = array_merge([
            [
                'label' => __( 'None', 'mindverse' ),
                'options' => [
                    ''    => __('None', 'mindverse'),
                ]
            ],
            [
                'label' => __( 'Fade In', 'mindverse' ),
                'options' => [
                    'fadeIn'      => __('Fade In', 'mindverse'),
                    'fadeInUp'    => __('Fade In Up', 'mindverse'),
                    'fadeInRight' => __('Fade In Right', 'mindverse'),
                    'fadeInLeft'  => __('Fade In Left', 'mindverse'),
                    'fadeInDown'  => __('Fade In Down', 'mindverse'),
                ]
            ],
            [
                'label' => __( 'Zoom In', 'mindverse' ),
                'options' => [
                    'zoomIn'      => __('Zoom In', 'mindverse'),
                ]
            ],
            [
                'label' => __( 'Custom', 'mindverse' ),
                'options' => [
                    'custom'    => __('Custom', 'mindverse'),
                ]
            ],
        ], $custom_options);
        return $options;
    }

    public static function render_highlight_html( $settings, $title = '' ) {
        if( empty( $title ) ) {
            return '';
        }
        $placeholder = '[highlight]'; 
        if ( !empty($settings['hl_items']) ) {
            foreach ( $settings['hl_items'] as $highlight ) {
                $highlight_anim_class = !empty( $highlight['hl_entrance_animation'] ) ? ' '.$highlight['hl_entrance_animation'] : '';
                $highlight_class = 'highlight elementor-repeater-item-' . esc_attr($highlight['_id']) . $highlight_anim_class ;
                $content = '';
                switch ( $highlight['hl_type'] ) {
                    case 'text':
                        $highlight_class .= ' highlight-text';
                        $content .= esc_html($highlight['hl_text']);
                        break;
                    case 'icon':
                        $highlight_class .= ' highlight-icon';
                        if ( !empty($highlight['hl_icon']['value']) ) {
                            ob_start();
                            \Elementor\Icons_Manager::render_icon( $highlight['hl_icon'], [ 'aria-hidden' => 'true' ] );
                            $content .= ob_get_clean();
                        }
                        break;
                    case 'img': 
                        $highlight_class .= ' highlight-image';
                        $img_attrs = !empty( $highlight['hl_loop_animation'] ) ? ['data-loop-animation' =>  $highlight['hl_loop_animation']] : [];
                        if ( !empty($highlight['hl_img']['id']) ) {
                            $hl_img_w = $highlight['hl_img_size']['width'] ?? null;
                            $hl_img_h = $highlight['hl_img_size']['height'] ?? null;
                            $content .= Elementor_Helpers::get_image_to_size($highlight['hl_img']['id'], $hl_img_w, $hl_img_h, $img_attrs);
                        }
                        break;
                }
                $content = '<span class="'.$highlight_class.'">'.$content.'</span>';
                $pattern = '/' . preg_quote($placeholder, '/') . '/';
                $title = preg_replace($pattern, $content, $title, 1);
            }
        }
        $title = str_replace($placeholder, '', $title);
        if( !empty( $settings['group_hl_items'] ) ) {   
            foreach( $settings['group_hl_items'] as $i => $group ) {
                $replacement = '<span class="highlight-wrapper elementor-repeater-item-' . esc_attr($group['_id']) . '">';
                $pattern = '/' . preg_quote('[start]', '/') . '/';
                $title = preg_replace($pattern, $replacement, $title, 1);
            }
        }
        $title = str_replace('[start]', '<span class="highlight-wrapper">', $title);
        $title = str_replace('[end]', '</span>', $title);

        if( isset( $settings['title_effect'] ) && !empty( $settings['title_effect'] ) ) {
            if( $settings['title_effect'] === 'typing-2' ) {
                $texts = [];
                foreach($settings['texts'] as $value) {
                    $texts[] = $value['text'];
                }
                $texts = implode(', ', $texts);
                $typing_html = '<span class="highlight-typing" data-effect="typing-2" data-text="'.$texts.'">'.
                                    '<span class="dynamic-word">'.esc_html( $settings['texts'][0]['text'] ?? '' ).'</span>'.
                                '</span>';
                $title = str_replace('[typing]', $typing_html, $title);
            }elseif( $settings['title_effect'] === 'typing' ) {
                $texts = [];
                foreach($settings['texts'] as $value) {
                    $texts[] = $value['text'];
                }
                $texts = implode(', ', $texts);
                $typing_html = '<span class="highlight-typing" data-effect="typing" data-text="'.$texts.'"></span>';
                $title = str_replace('[typing]', $typing_html, $title);
            }
        }
        return $title;
    }

    /**
     * Get Gsap Settings
     */
    public static function get_gsap_settings( $settings = []) {
		if( empty( $settings ) ) {
            return [];
        }
        $gsap_settings = [];

        if( isset( $settings['scroll_name'] ) && !empty( $settings['scroll_name'] ) ) {
            $gsap_settings['name'] = $settings['scroll_name'];
        }

        if( $settings['scroll_translate_settings'] === 'yes' ) {
            $gsap_settings['x'] = $settings['scroll_x']['size'] ?: 0;
            $gsap_settings['y'] = $settings['scroll_y']['size'] ?: 0;
            $gsap_settings['z'] = $settings['scroll_z']['size'] ?: 0;
        }
        if( $settings['scroll_rotate_settings'] === 'yes' ) {
            if( $settings['scroll_rotate_keep_proportions'] !== 'yes' ) {
                $gsap_settings['rotateX'] = $settings['scroll_rotate_x']['size'] ?: 0;
                $gsap_settings['rotateY'] = $settings['scroll_rotate_y']['size'] ?: 0;
            }else {
                $gsap_settings['rotate'] = $settings['scroll_rotate']['size'] ?: 0;
            }
        }
        if( $settings['scroll_scale_settings'] === 'yes' ) {
            if( $settings['scroll_scale_keep_proportions'] !== 'yes' ) {
                $gsap_settings['scaleX'] = $settings['scroll_scale_x']['size'] ?: 1;
                $gsap_settings['scaleY'] = $settings['scroll_scale_y']['size'] ?: 1;
            }else {
                $gsap_settings['scale'] = $settings['scroll_scale']['size'] ?: 0;
            }
        }
        if( isset( $settings['scroll_opacity'] ) ) {
            $gsap_settings['opacity'] = $settings['scroll_opacity'];
        }
        if( !empty( $settings['scroll_blur'] ) ) {
            $gsap_settings['filter'] = 'blur('.$settings['scroll_blur'].'px)';
        }
        if( $settings['scroll_perspective'] > 0 ) {
            $gsap_settings['perspective'] = $settings['scroll_perspective'];
        }
        if( isset($settings['scroll_trigger_settings']) && $settings['scroll_trigger_settings'] === 'yes' ) {
            $gsap_settings['type'] = $settings['trigger_type'];

            $trigger_el_start = ( $settings['scroll_trigger_el_start']['size'] ?: 0 ) . ( $settings['scroll_trigger_el_start']['unit'] ?: 'px' );
            $trigger_el_end = ( $settings['scroll_trigger_el_end']['size'] ?: 0 ) . ( $settings['scroll_trigger_el_end']['unit'] ?: 'px' );
            $trigger_vw_start = ( $settings['scroll_trigger_vw_start']['size'] ?: 0 ) . ( $settings['scroll_trigger_vw_start']['unit'] ?: 'px' );
            $trigger_vw_end = ( $settings['scroll_trigger_vw_end']['size'] ?: 0 ) . ( $settings['scroll_trigger_vw_end']['unit'] ?: 'px' );
            $gsap_settings['scrollTrigger'] = [
                'start' => $trigger_el_start.' '.$trigger_vw_start,
                'end'   => $trigger_el_end.' '.$trigger_vw_end,
            ];
        }
        if( !empty( $settings['scroll_responsive'] ) ) {
            $gsap_settings['breakOn'] = $settings['scroll_responsive'] === 'custom' ? $settings['scroll_responsive_screen_w'] : $settings['scroll_responsive'];
        }
        if( isset( $settings['scroll_stagger'] ) ) {
            $gsap_settings['stagger'] = $settings['scroll_stagger']  ?: 0.25;
        }
        return $gsap_settings;
    }

	public static function the_svg_content( $url ) {
		Helpers::the_svg_content( $url );
	}
}