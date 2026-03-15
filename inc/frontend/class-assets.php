<?php
/**
 * Handles front-end scripts and styles.
 *
 * @package    Mindverse
 * @subpackage Inc\Frontend
 * @author     Case Theme
 */

namespace Mindverse\Inc\Frontend;

use Mindverse\Inc\Core\Hookable;
use Mindverse\Inc\Core\Options;
use Mindverse\Inc\Utils\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages the enqueuing of scripts and styles for the theme's front-end.
 */
class Assets extends Hookable {

    private $version;
	private $options;

    public function __construct(Options $options_instance) {
        $this->options = $options_instance;
		$this->version = Helpers::get_theme_version();
		$this->add_action( 'wp_enqueue_scripts', 'enqueue_swiper', 1 );
		$this->add_action( 'wp_enqueue_scripts', 'enqueue_assets' );
	}

    public function enqueue_assets(){
        $this->enqueue_styles();
        $this->enqueue_by_libs();
        $this->enqueue_by_elementor();
        $this->enqueue_scripts();
    }

    public function enqueue_scripts() {
        wp_enqueue_script('jquery'); 
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
        wp_enqueue_script('mindverse-main-js', get_template_directory_uri() . '/assets/js/theme.js', ['jquery', 'imagesloaded', 'gsap', 'ScrollTrigger', 'SplitText'], $this->version);
    }

    /**
	 * Enqueues theme stylesheets.
	 */
    public function enqueue_styles() {
        wp_enqueue_style('mindverse-style', get_template_directory_uri() . '/assets/css/style.min.css', [], $this->version);
        wp_enqueue_style('mindverse-block-style', get_template_directory_uri() . '/assets/css/wp-block.css', [], $this->version);
        wp_add_inline_style( 'mindverse-style', $this->generate_global_inline_styles() );
		wp_add_inline_style( 'mindverse-style', $this->render_inline_style() );
        // Enquence Google Font
        $google_font_url = $this->get_google_fonts_url();
        if ( ! empty( $google_font_url ) ) {
            wp_enqueue_style( 'mindverse-google-fonts', $google_font_url, [], null );
        }
    }


	public function enqueue_swiper() {
        wp_register_script('swiper', get_template_directory_uri() . '/assets/js/libs/swiper.min.js', ['jquery'], '12.0.2', true);
	}
    /**
	 * Enqueues third-party libraries.
	 */
    public function enqueue_by_libs() {
		// Swiper
		// wp_deregister_script('swiper');
		// // Swiper Carousel
        // wp_register_script('swiper', get_template_directory_uri() . '/assets/js/libs/swiper.min.js', ['jquery'], '12.0.2', true);
		// GSAP
		wp_register_script('gsap', get_template_directory_uri() . '/assets/js/libs/gsap/gsap.min.js', [], '3.14.1', true);
		wp_register_script('SplitText', get_template_directory_uri() . '/assets/js/libs/gsap/SplitText.min.js', ['gsap'], '3.14.1', true);
		wp_register_script('ScrollTrigger', get_template_directory_uri() . '/assets/js/libs/gsap/ScrollTrigger.min.js', ['gsap'], '3.14.1', true);
		wp_register_script('MotionPathPlugin', get_template_directory_uri() . '/assets/js/libs/gsap/MotionPathPlugin.min.js', ['gsap'], '3.14.1', true);
		$enableSmoothScroll =  (bool) $this->options->get_option( 'smooth_scroll', '0' );
		if( $enableSmoothScroll ) {
			wp_enqueue_script('ScrollSmoother', get_template_directory_uri() . '/assets/js/libs/gsap/ScrollSmoother.min.js', ['gsap', 'ScrollTrigger'], '3.14.1', true);
		}
		// Particles
		wp_register_script('particles', get_template_directory_uri() . '/assets/js/libs/particles.min.js', ['jquery'], '2.0.0', true);
		// Wow aniamtion
		wp_enqueue_script('wow', get_template_directory_uri() . '/assets/js/libs/wow.min.js', ['jquery'], '1.1.2', true);
		// Nice Select
		wp_enqueue_script('nice-select', get_template_directory_uri() . '/assets/js/libs/nice-select.min.js', ['jquery'], '2.0.0', true);
		wp_enqueue_style('nice-select', get_template_directory_uri() . '/assets/css/nice-select.css', [], '2.0.0');
		// Tilt
		wp_register_script('tilt', get_template_directory_uri() . '/assets/js/libs/tilt.min.js', ['jquery'], $this->version, true);
		// Hover JS
		wp_register_script('threejs', get_template_directory_uri() . '/assets/js/libs/three.min.js', ['jquery'], $this->version, true);
		wp_register_script('hoverjs', get_template_directory_uri() . '/assets/js/libs/hover-effect.umd.js', ['jquery', 'gsap', 'threejs'], $this->version, true);

		wp_register_script('ogl', get_template_directory_uri() . '/assets/js/libs/ogl.min.js', ['jquery', 'gsap', 'threejs'], $this->version, true);
    }

	/**
	 * Enqueues by elementor.
	 */
    public function enqueue_by_elementor() {
        wp_register_script('mindverse-carousel', get_template_directory_uri() . '/elementor/assets/js/carousel.js', ['jquery', 'swiper'], $this->version, true);
        wp_register_script('mindverse-interactions', get_template_directory_uri() . '/elementor/assets/js/interactions.js', ['jquery', 'gsap', 'isotope', 'tilt'], $this->version, true);
        wp_register_script('mindverse-post', get_template_directory_uri() . '/elementor/assets/js/post.js', ['jquery', 'isotope'], $this->version, true);
        wp_register_script('mindverse-effects', get_template_directory_uri() . '/elementor/assets/js/effects.js', ['jquery', 'ScrollTrigger', 'MotionPathPlugin', 'particles'], $this->version, true);
        wp_register_script('mindverse-accordion', get_template_directory_uri() . '/elementor/assets/js/accordion.js', ['jquery'], $this->version, true);
        wp_register_script('mindverse-tab', get_template_directory_uri() . '/elementor/assets/js/tab.js', ['jquery', 'gsap'], $this->version, true);
        wp_register_script('mindverse-counter', get_template_directory_uri() . '/elementor/assets/js/counter.js', ['jquery', 'ScrollTrigger'], $this->version, true);
        wp_register_script('mindverse-scrolling', get_template_directory_uri() . '/elementor/assets/js/scrolling.js', ['jquery', 'ScrollTrigger'], $this->version, true);
        wp_register_script('mindverse-animation', get_template_directory_uri() . '/elementor/assets/js/animation.js', ['jquery', 'SplitText', 'ScrollTrigger'], $this->version, true);
		wp_enqueue_script('mindverse-elementor-editor', get_template_directory_uri() . '/elementor/assets/js/render.js', ['jquery'], $this->version, true);
		wp_localize_script('mindverse-post', 'MindverseAjax', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('mindverse_ajax_nonce') 
		));
    }

    /**
	 * Generates the Google Fonts URL.
	 *
	 * @return string The final Google Fonts URL.
	 */
	public function get_google_fonts_url() {
		$fonts = [];
		if ( 'off' !== _x( 'on', 'Golos Text font: on or off', 'mindverse' ) ) {
			$fonts[] = 'Golos+Text:wght@400..900';
		}
		if ( 'off' !== _x( 'on', 'Space Grotesk font: on or off', 'mindverse' ) ) {
			$fonts[] = 'Space+Grotesk:wght@300..700';
		}
		if ( 'off' !== _x( 'on', 'DM Sans font: on or off', 'mindverse' ) ) {
			$fonts[] = 'DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000';
		}
		if ( 'off' !== _x( 'on', 'Onest font: on or off', 'mindverse' ) ) {
			$fonts[] = 'Onest:wght@100..900';
		}
		if ( 'off' !== _x( 'on', 'Geist font: on or off', 'mindverse' ) ) {
			$fonts[] = 'Geist:wght@100..900';
		}
		if ( 'off' !== _x( 'on', 'Inter font: on or off', 'mindverse' ) ) {
			$fonts[] = 'Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900';
		}
		if ( empty( $fonts ) ) {
			return '';
		}
		$query_string     = implode( '&family=', $fonts );
		$google_fonts_url = 'https://fonts.googleapis.com/css2?family=' . $query_string . '&display=swap';

		return $google_fonts_url;
	}

	/**
	 * Generates the global inline CSS for :root variables.
	 *
	 * @return string The generated CSS.
	 */
	public function generate_global_inline_styles() {
		$theme_colors     = $this->get_style_config( 'theme_colors' );
		$link_colors      = $this->get_style_config( 'link' );
		$theme_typography = $this->get_style_config( 'theme_typography' );

		ob_start();
		echo ':root{';
		foreach ( $theme_colors as $color => $value ) {
			printf( '--mv-%1$s-color: %2$s;', esc_attr( $color ), esc_attr( $value['value'] ) );
		}
		foreach ( $link_colors as $color => $value ) {
			printf( '--mv-link-%1$s: %2$s;', esc_attr( $color ), esc_attr( $value ) );
		}
		foreach ( $theme_typography as $font => $value ) {
			$font_family = is_array( $value['value'] ) ? $value['value']['font-family'] : $value['value'];
			printf( '--mv-%1$s-font: %2$s;', esc_attr( $font ), esc_attr( $font_family ) );
		}
		echo '}';
		return ob_get_clean();
	}

	/**
	 * Private helper to get style configurations.
	 * This is the equivalent of the old mindverse_global_style_config().
	 *
	 * @param string $key The configuration key to retrieve.
	 * @return array The configuration array.
	 */
	public function get_style_config( $key ) {
		$configs = [
			'theme_colors'     => [
				'primary'   => [ 'value' => $this->options->get_option( 'primary_color', '#CDF683' ) ],
				'secondary' => [ 'value' => $this->options->get_option( 'secondary_color', '#000' ) ],
				'third'     => [ 'value' => $this->options->get_option( 'third_color', '#EDDD5E' ) ],
				'body-bg'   => [ 'value' => $this->options->get_option( 'body_bg_color', '#FFF' ) ],
				'heading'     => [ 'value' => $this->options->get_option( 'heading_color', '#060F16' ) ],
			],
			'link'             => [
				'color'       => $this->options->get_option( 'link_color', [ 'regular' => '#000' ] )['regular'],
				'hover-color' => $this->options->get_option( 'link_color', [ 'hover' => '#FFF' ] )['hover'],
			],
			'theme_typography' => [
				'primary'   => [ 'value' => $this->options->get_option( 'primary_font', 'Inter' ) ],
                'secondary' => [ 'value' => $this->options->get_option( 'secondary_font', 'Inter' ) ],
                'third'     => [ 'value' => $this->options->get_option( 'third_font', 'Inter' ) ],
                'heading'   => [ 'value' => $this->options->get_option( 'heading_font', 'Inter' ) ],
			],
		];
		return isset( $configs[ $key ] ) ? $configs[ $key ] : [];
	}

	/**
	 * Render Inline Style 
	 */
	public function render_inline_style() {
		$post_type = get_post_type();
		$prefix = '';
		if( is_home() ) {
			$post_type = 'blog';
		}
		if( is_single() ) {
			$prefix = 'single_';
		}
		$content_spacing = $this->options->get_theme_option( $prefix . $post_type . '_content_spacing', [] );
		$pd_top = ( $content_spacing['padding-top'] ?? 0 ) ?: 0;
		$pd_bottom = ( $content_spacing['padding-bottom'] ?? 0 ) ?: 0;

		$container_width = $this->options->get_theme_option( $prefix . $post_type . '_container_width', ['width' => 0] )['width'];

		ob_start();
		if( $pd_top !== 0 ) {
			echo 'body #main .inner {
				padding-top: ' . esc_attr( $pd_top ) . ';
			}';
		}
		if( $pd_bottom !== 0 ) {
			echo 'body #main .inner {
				padding-bottom: ' . esc_attr( $pd_bottom ) . ';
			}';
		}
		if( $container_width !== 0 && $container_width !== 'px' ) {
			echo 'body #main .inner {
				max-width: ' . esc_attr( $container_width ) . ';
			}';
		}
		return ob_get_clean();
	}
}