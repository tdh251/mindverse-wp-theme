<?php
/**
 * The core Hookable class.
 *
 * This file defines the base class for all other classes in the theme that need to
 * interact with the WordPress hook system (actions and filters).
 *
 * @package    Mindverse
 * @subpackage Inc\Core
 * @author     Case Theme
 */
namespace Mindverse\Inc\Utils;

// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helpers {
    /**
     * Get theme name
     */
    public static function get_theme_name(){
        $theme = wp_get_theme();
        if( $theme->parent_theme ) {
            $template_dir  = basename( get_template_directory() );
            $theme = wp_get_theme( $template_dir );
        }
        return $theme->get('Name');
    }

	/**
	 * Get theme version
	 */
    public static function get_theme_version(){
        $theme = wp_get_theme();
        return $theme->get('Version');
    }

	/**
	 * Get theme slug
	 */
    public static function get_theme_slug(){ 
        return get_template();
    }

	/**
	 * Get template to \mindverse\
	 * Support Child Theme & Parent Theme
	 */
	public static function get_template( $slug, $args = array() ) {
		$template_file = $slug . '.php';
		$template_path = locate_template( $template_file );

		if ( ! $template_path ) {
			return;
		}

		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args, EXTR_SKIP );
		}

		include $template_path;
	}

    /**
     * Get Post List 
    */
    public static function get_post_options($post_type = 'post', $default = false){
        $post_list = array();
        $posts = get_posts([
            'post_type' => $post_type, 
            'orderby' => 'date', 
            'order' => 'ASC', 
            'posts_per_page' => '-1'
        ]);
        if($default){
        	$post_list[0] = __( 'None', 'mindverse' );
        }
        foreach($posts as $post){
            $post_list[$post->ID] = $post->post_title;
        }
        return $post_list;
    }
    /**
     * old mindverse_get_templates_option()
     */
	public static function get_templates_by_type($template_type = 'df', $meta_type = null){
		$post_list = ['' => 'None'];

		$meta_query = [
			[
				'key'     => 'template_type',
				'value'   => $template_type,
				'compare' => '='
			]
		];

		if(!is_null($meta_type)) {
			switch ($template_type) {
				case 'header':
					$meta_query[] = [
						'key'     => 'header_type',
						'value'   => $meta_type,
						'compare' => '='
					];
					break;
				case 'hero-section' :
					$meta_query[] = [
						'key'     => 'hero_section_display_on',
						'value'   => $meta_type,
						'compare' => 'LIKE'
					];
					break;
			}
		}

		$args = [
			'post_type'      => 'pxl-template',
			'orderby'        => 'date',
			'order'          => 'ASC',
			'posts_per_page' => -1,
			'meta_query'     => $meta_query,
		];

        $posts = get_posts($args);
        foreach($posts as $post){  
        	$template_type = get_post_meta( $post->ID, 'template_type', true );
        	if($template_type == 'df') {
				continue;
			}
            $post_list[$post->ID] = $post->post_title;
        }
         
        return $post_list;
    }
	/**
	 * 
	 */
    public static function get_templates_by_slug($meta_value = 'df'){
        $post_list = array();
        $posts = get_posts(
        	array(
        		'post_type' => 'pxl-template', 
        		'orderby' => 'date', 
        		'order' => 'ASC', 
        		'posts_per_page' => '-1',
        		'meta_query' => array(
	                array(
	                    'key'       => 'template_type',
	                    'value'     => $meta_value,
	                    'compare'   => '='
	                )
	            )
        	)
        );
         
        foreach($posts as $post){
        	$template_type = get_post_meta( $post->ID, 'template_type', true );
        	if($template_type == 'df') continue;
        	$value_args = [
        		'post_id' => $post->ID, 
        		'title' => $post->post_title
        	];
        	$template_position = get_post_meta( $post->ID, 'template_position', true );
        	 
    		$value_args['position'] = !empty($template_position) ? $template_position : '';

            $post_list[$post->post_name] = $value_args;
        }
        return $post_list;
    }
	/**
	 * Get Header Options
	 */
	public static function get_header_options( $scope="global" ){	
		$header_mode_options = [
			'default' => __('Default', 'mindverse'),
			'builder' => __('Builder', 'mindverse'),
		];
		$header_sticky_mode_options = [
			'hide'    => __('None', 'mindverse'),
			'builder' => __('Builder', 'mindverse'),
		];
		if ($scope === 'private') {
			unset($header_mode_options['default']);
			$header_mode_options = ['inherit' => __('Inherit', 'mindverse')] + $header_mode_options;
			$header_mode_options['hide']    = __('Hide', 'mindverse');
			unset($header_sticky_mode_options['hide']);
			$header_sticky_mode_options = [
				'inherit' => __('Inherit', 'mindverse'),
			] + $header_sticky_mode_options;
			$header_sticky_mode_options['hide'] = __('Hide', 'mindverse');
		}

		$opts = array(
			array(
	            'id'      => 'header_mode',
	            'type'    => 'button_set',
	            'title'   => __( 'Header Mode', 'mindverse' ),
	            'options' => $header_mode_options, 
                'default' => $scope === 'private' ? 'inherit' : 'default'
	        ),
	        array(
				'id'      => 'header_layout',
				'type'    => 'select',
				'title'   => __('Header Layout', 'mindverse'),
				'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','mindverse'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
				'options' => self::get_templates_by_type('header'),
				'select2'  => [ 'allowClear' => false ],
				'required' => ['header_mode', '=', 'builder'],
	        ),
			array(
	            'id'      => 'header_sticky_mode',
	            'type'    => 'button_set',
	            'title'   => __( 'Header Sticky Mode', 'mindverse' ),
	            'options' => $header_sticky_mode_options, 
                'default' => $scope === 'private' ? 'inherit' : 'hide'
	        ),
            array(
				'id'      => 'header_sticky_layout',
				'type'    => 'select',
				'title'   => __('Header Sticky', 'mindverse'),
				'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','mindverse'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
				'options' => self::get_templates_by_type('header'),
				'select2'  => [ 'allowClear' => false ],
				'required' => ['header_sticky_mode', '=', 'builder'],
			),
			array(
				'id'       => 'header_sticky_scroll_direction',
				'type'     => 'button_set',
				'title'    => __('Show Sticky Header When Scrolling', 'mindverse'),
				'options'  => array(
					'up'   => __('Sroll Up', 'mindverse'),
					'down' => __('Scroll Down', 'mindverse'),
				),
				'default'  => 'up',
				'required' => [ 'header_sticky_layout', '!=' , '' ],
			),
	    );
 
		return $opts;
	}
	
	/**
	 * Get Mobile Header Options
	 */
	public static function get_header_mobile_options($args=[]){
		$args = wp_parse_args($args,[
			'default'         => false,
			'default_value'   => ''
		]);
		 
		$opts = array(
	        array(
				'id'      => 'header_mobile_layout',
				'type'    => 'select',
				'title'   => __('Header Layout', 'mindverse'),
				'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','mindverse'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
				'options' => self::get_templates_by_type('header-mobile'),
				'default' => '0'  
	        ),
	    );
 
		return $opts;
	}

	/**
	 * Get Page Hero Options
	 */
	public static function get_page_hero_options( $page="page", $scope="global" ){
		$mode_options = [
			'default'   => __('Default', 'mindverse'),
			'builder'   => __('Builder', 'mindverse'),
			'hide'      => __('Hide', 'mindverse'),
		];
		if($scope === 'private') {
			unset($mode_options['default']);
			$mode_options = ['inherit' => __('Inherit', 'mindverse')] + $mode_options;
		}
		$final_options = array(
			array(
				'id' => $page.'_hero_section_heading',
				'title' => __('Hero Section', 'mindverse'),
				'type'  => 'section',
				'indent' => true,
			),
	        array(
	            'id'      => $page.'_hero_mode',
	            'type'    => 'button_set',
	            'title'   => __( 'Hero Section Mode', 'mindverse' ),
	            'options' => $mode_options, 
                'default' => ($scope === 'private') ? 'inherit' : 'default',
	        ),
	        array(
	            'id'       => $page.'_hero_layout',
	            'type'     => 'select',
	            'title'    => __('Hero Section Layout', 'mindverse'),
	            'desc'     => sprintf(__('Please create your layout before choosing. %sClick Here%s','mindverse'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
	            'options'  => self::get_templates_by_type( 'hero-section', 'page' ),
	            'required' => [ $page.'_hero_mode', '=', 'builder' ],
				'select2'  => [ 'allowClear' => false ],
	        ),
	    ); 
		if( $page !== 'page' || ($page === 'page' && $scope === 'private') ) {
			$final_options[] = [
				'id'       => $page.'_title',
				'type'     => 'text',
				'title'    => __('Hero Section Title', 'mindverse'),
				'required' => [ $page.'_hero_mode', '!=', 'hide' ],
				'placeholder' => sprintf('Ex: %1s Title', ucwords($page)),
				'desc' => __('Leave blank to display default title', 'mindverse')
			];
			$final_options[] = [
				'id'       => $page.'_note',
				'type'     => 'textarea',
				'title'    => __('Hero Section Note', 'mindverse'),
				'required' => [ $page.'_hero_mode', '!=', 'hide' ],
			];
		}
		return $final_options;
	}
	/**
	 * Get footer options
	 */
	public static function get_footer_options($scope = 'global'){
		$mode_options = [
			'default' => __('Default', 'mindverse'),
			'builder' => __('Builder', 'mindverse'),
			'hide'    => __('Hide', 'mindverse'),
		];
		if ($scope === 'private') {
			unset($mode_options['default']);
			$mode_options = ['inherit' => __('Inherit', 'mindverse')] + $mode_options;
		}

		$final_options = [
			array(
	            'id'      => 'footer_mode',
	            'type'    => 'button_set',
	            'title'   => __( 'Footer Mode', 'mindverse' ),
	            'options' => $mode_options, 
                'default' => $scope === 'private' ? 'inherit' : 'default'
	        ),
	        array(
				'id'      => 'footer_layout',
				'type'    => 'select',
				'title'   => __('Footer Layout', 'mindverse'),
				'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','mindverse'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
				'options' => self::get_templates_by_type('footer'),
				'default' => 0,
				'select2'  => [ 'allowClear' => false ],
				'required' => ['footer_mode', '=', 'builder'],
	        ),
		];
		return $final_options;
	}

	public static function get_sidebar_options($args=[]){
		$args = wp_parse_args($args,[
			'prefix'        => 'blog',
			'page_option'   => false,
			'default'       => 'right'
		]);
		$prefix = isset($args['prefix']) ? $args['prefix'].'_' : null;
		if($args['page_option']){
			$options = [
				'inherit'    => __('Inherit','mindverse'),
				'left'       => __('Left','mindverse'),
				'right'      => __('Right','mindverse'),
				'disable'    => __('Disable','mindverse'),
			];
		} else {
			$options = [
				'left'      => __('Left','mindverse'),
				'right'     => __('Right','mindverse'),
				'disable'   => __('Disable','mindverse'),
			]; 
		}  
		$opts = [
			'id'       => $prefix.'sidebar',
			'type'     => 'button_set',
			'title'    => __('Sidebar', 'mindverse'),
			'options'  => $options,
			'default'  => $args['default'],
		];
		return $opts;
	}

	/**
	 * Get Navigation by Slug
	 */
    public static function get_nav_menu_by_slug_options(){
        $menus = array(
            '-1' => __('Inherit', 'mindverse')
        );
        $obj_menus = wp_get_nav_menus();
        foreach ($obj_menus as $obj_menu){
            $menus[$obj_menu->slug] = $obj_menu->name;
        }
        return [
            'id'       => 'primary_menu',
            'type'     => 'select',
            'title'    => __( 'Navigation Menu', 'mindverse' ),
            'options'  => $menus,
            'default' => '',
            'description' => 'When you select Custom Menu. The custom menu will apply to the entire layout when you use Case Nav Menu widget in Elementor and Menu on header layout in Mobile.'
        ];
    }

    public static function get_nav_menu_options() {
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        $pxl_menus = '';
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            $pxl_menus = array(
                '' => __('Default', 'mindverse')
            );
            foreach ( $menus as $value ) {
                if ( is_object( $value ) && isset( $value->name, $value->slug ) ) {
                    $pxl_menus[ $value->slug ] = $value->name;
                }
            }
        }
        return $pxl_menus;
    }

	/**
	 * Crop an image from the Media Library to a custom size.
	 */
	public static function custom_crop_image($attachment_id, $width = null, $height = null, $crop = true) {
        if (!$width || !$height) {
            return wp_get_attachment_url($attachment_id);
        }

        $original_path = get_attached_file($attachment_id);
		
        if (!$original_path || !file_exists($original_path)) {
            return false;
        }

        $upload_info = wp_upload_dir();
        $upload_dir = $upload_info['basedir'];
        $upload_url = $upload_info['baseurl'];

        $file_info = pathinfo($original_path);
        $new_filename = $file_info['filename'] . '-' . $width . 'x' . $height . '.' . $file_info['extension'];
        $new_path = $upload_dir . str_replace(basename($original_path), $new_filename, str_replace($upload_dir, '', $original_path));

        if (file_exists($new_path)) {
            return str_replace($upload_dir, $upload_url, $new_path);
        }

        $image_editor = wp_get_image_editor($original_path);
        if (!is_wp_error($image_editor)) {
            $image_editor->resize($width, $height, $crop);
            $saved = $image_editor->save($new_path);

            if (!is_wp_error($saved) && $saved) {
                $cropped_files = get_post_meta($attachment_id, '_custom_cropped_files', true);
                if (!is_array($cropped_files)) {
                    $cropped_files = [];
                }

                if (!in_array($new_path, $cropped_files)) {
                    $cropped_files[] = $new_path;
                    update_post_meta($attachment_id, '_custom_cropped_files', $cropped_files);
                }

                return str_replace($upload_dir, $upload_url, $new_path);
            }
        }
        return false;
    }

	/**
	 * Get image by size
     */
    public static function get_image_to_size($attachment_id, $width = null, $height = null, $attrs = []) {
        $image_url = $attachment_id === 0 ? \Elementor\Utils::get_placeholder_image_src() : self::custom_crop_image($attachment_id, $width, $height, true);
        if (!$image_url) {
            return '';
        }        
        if (empty($attrs['alt'])) {
            $attrs['alt'] = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
			$attrs['alt'] = !empty($attrs['alt']) ? $attrs['alt'] : get_the_title($attachment_id);
        }
        if (empty($attrs['loading'])) {
            $attrs['loading'] = 'lazy';
        }
        $attrs_str = '';
        foreach ($attrs as $name => $value) {
            $attrs_str .= ' ' . esc_attr($name) . '="' . esc_attr($value) . '"';
        }
        if ($width && $height) {
            $attrs_str .= ' width="' . esc_attr($width) . '"';
            $attrs_str .= ' height="' . esc_attr($height) . '"';
        }

        return '<img src="' . esc_url($image_url) . '"' . $attrs_str . '>';
    }

    /**
	 * Display image by size
     */
    public static function the_image_to_size($attachment_id, $width = null, $height = null, $attrs = []) {
        echo wp_kses_post(self::get_image_to_size($attachment_id, $width, $height, $attrs));
    }

	/**
	 * Get SVG Content By Image SVG
	 */
	public static function get_svg_content( $url ) { 
		if ( empty( $url ) ) {
			return '';
		}

		$content = '';
		
		if ( pathinfo( $url, PATHINFO_EXTENSION ) === 'svg' ) {
			$upload_dir = wp_upload_dir();
			$base_url   = $upload_dir['baseurl'];
			$base_dir   = $upload_dir['basedir'];
			
			// Chuyển URL thành Path vật lý trên server
			$path = wp_normalize_path( str_replace( $base_url, $base_dir, $url ) );
			
			// Sử dụng hàm PHP thuần thay vì WP_Filesystem
			if ( file_exists( $path ) ) {
				$content = file_get_contents( $path );
			}
		} else {
			$attachment_id = attachment_url_to_postid( $url );
			$content = self::get_image_to_size( $attachment_id, null, null, [] );
		}

		return $content;
	}

	public static function the_svg_content( $url ) {
		pxl_print_html(self::get_svg_content( $url ));
	}

	/**
	 * Get user profile picture
	 */
	public static function get_avatar( $user_id = 0, $img_size = 96 ) {
		if(  $user_id === 0 || empty( $user_id ) ) {
			return '';
		}	
		$user_avatar_id = get_the_author_meta('mindverse_user_avatar_id', $user_id);
		if( empty( $user_avatar_id ) || $user_avatar_id === 0 ) {
			return get_avatar( $user_id, $img_size );
		}
		return self::get_image_to_size( $user_avatar_id, $img_size, $img_size );
	}

	public static function the_avatar( $user_id = 0, $img_size = 96 ) {
		echo wp_kses_post( self::get_avatar( $user_id, $img_size ) );
	}

	/**
	 * Get Sidebar Options
	 */
	public static function get_sidebar_option() {
		global $wp_registered_sidebars;
		$options = [];
		if ( !$wp_registered_sidebars ) {
			$options[''] = esc_html__( 'No sidebars', 'mindverse' );
		} else {
			$options[''] = esc_html__( 'Choose Sidebar', 'mindverse' );
			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$options[ $sidebar_id ] = $sidebar['name'];
			}
		}
		return $options;
	}

	/**
	 * Get 
	 */
	public static function get_breadcrumb_option( $prefix_id = '' ) {
		return [
			array(
				'id' => $prefix_id.'_breadcrumb_heading',
				'title' => esc_html__('Breadcrumb', 'mindverse'),
				'type'  => 'section',
				'indent' => true,
			),
			array(
				'id'      => $prefix_id.'_breadcrumb_mode',
				'type'    => 'button_set',
				'title'   => __( 'Breadcrumb Mode', 'mindverse' ),
				'options' => [
					'default'   => __( 'Default', 'mindverse' ),
					'custom'    => __( 'Custom', 'mindverse' ),
				], 
				'default' => 'default',
			),
			array(
				'id'    => $prefix_id.'_breadcrumb_label',
				'type'  => 'text',
				'title' => __( 'Breadcrumb Label', 'mindverse' ),
				'placeholder' => __('Ex: Something', 'mindverse'),
				'required' => [ $prefix_id.'_breadcrumb_mode', '=', 'custom' ]
			),
			array(
				'id'    => $prefix_id.'_breadcrumb_highight',
				'type'  => 'text',
				'title' => __( 'Breadcrumb Highight', 'mindverse' ),
				'placeholder' => __('Ex: Something', 'mindverse'),
			),
		];
	}

}