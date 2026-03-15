<?php
namespace Mindverse\Inc\Integrations\Elementor;

use Mindverse\Inc\Core\Hookable;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Init extends Hookable {

    public function __construct() {
        new Elementor_Hooks();
        $this->add_action( 'elementor/widgets/register', 'load_and_register_widgets' );
        $this->add_action( 'elementor/elements/elements_registered', 'load_and_register_elements' );

    }

    // function add_panel_tab() {
    //     \Elementor\Controls_Manager::add_tab(
    //         'mindverse-tab',
    //         esc_html__( 'Mindverse', 'mindverse' )
    //     );
    // }

    /**
     * Resgister element
     */
    public function load_and_register_elements( $element_manager ) {
        $element_container_file = get_template_directory() . '/elementor/elements/container.php';
        if ( file_exists( $element_container_file ) ) {
            require_once $element_container_file;
            $element_manager->register_element_type( new \Elementor\Includes\Elements\Mindverse_Container() );
        }
    }

    /**
     * @param \Elementor\Widgets_Manager $widgets_manager
     */
    public function load_and_register_widgets( $widgets_manager ) {

        $control_trait_file = get_template_directory() . '/inc/integrations/elementor/traits/controls-trait.php';
        $css_trait_file = get_template_directory() . '/inc/integrations/elementor/traits/css-trait.php';
        $group_controls_trait_file = get_template_directory() . '/inc/integrations/elementor/traits/group-controls-trait.php';
        $swiper_trait_file = get_template_directory() . '/inc/integrations/elementor/traits/swiper-trait.php';

        if ( file_exists( $control_trait_file ) ) {
            require_once $control_trait_file;
        }
        if ( file_exists( $css_trait_file ) ) {
            require_once $css_trait_file;
        }
        if ( file_exists( $group_controls_trait_file ) ) {
            require_once $group_controls_trait_file;
        }
        if ( file_exists( $swiper_trait_file ) ) {
            require_once $swiper_trait_file;
        }

        $base_widget_file = get_template_directory() . '/elementor/widget-base.php';
        if ( file_exists( $base_widget_file ) ) {
            require_once $base_widget_file;
        }

        $widgets_path = get_template_directory() . '/elementor/widgets/*.php';

        foreach ( glob( $widgets_path ) as $file ) {
            require_once $file;

            $filename   = basename( $file, '.php' );
            $class_name = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $filename ) ) );
            $full_class_name = '\\Mindverse\\Elementor\\Widgets\\' . $class_name;
            if ( class_exists( $full_class_name ) ) {
                $reflection = new \ReflectionClass( $full_class_name );
                if ( ! $reflection->isAbstract() ) {
                    $widgets_manager->register( new $full_class_name() );
                }
            }
        }

    }
}