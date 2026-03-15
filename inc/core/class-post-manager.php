<?php
namespace Mindverse\Inc\Core;

// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Mindverse\Inc\Core\Hookable;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;
use Mindverse\Inc\Frontend\Layout;

class Post_Manager extends Hookable {

    /**
     * Name option in database.
     * @var string
     */
	private $options, $layout;

    public function __construct( Options $options_instance, Layout $layout_instance ) {
        $this->options = $options_instance;
        $this->layout = $layout_instance;
        $this->add_action('wp_ajax_load_posts', 'load_posts_ajax');
        $this->add_action('wp_ajax_nopriv_load_posts', 'load_posts_ajax');
        // $this->remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
	}


    /**
     * Get view post count for display
     */
    public function get_post_view($post_id) {
        $count_key = 'post_views_count';
        $count = get_post_meta($post_id, $count_key, true);

        if ( $count == '' ) {
            $count = 0;
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, '0' );
        } else {
            $count ++;
            update_post_meta( $post_id, $count_key, $count );
        }
        
        if ($count >= 1000000) {
            $count = round($count / 1000000, 1) . 'M';
        } elseif ($count >= 1000) {
            $count = round($count / 1000, 1) . 'k';
        }
        return $count;
    }

    /** 
	 * Get cpt support
	 */
	public function get_post_type_list() {
		$cpts = ['post' => 'Post'];
        $career_status = (bool) $this->options->get_theme_option('career_status', '');

        $post_types = $this->options->get_theme_option('pxl_post_type', []);

        if( $career_status ) {
            $post_types['career'] = 'Career';
        }

		if( is_array( $post_types ) && !empty( $post_types ) ) {
			foreach( $post_types as $post_type ) {
                if( !empty( $post_type ) ) {
                    $cpts[sanitize_title( $post_type )] = $post_type;
                }
			}
        }
		return $cpts;
	}

	/**
	 * Get post list option
	 */
    public function get_cpt_post_list( $post_type = 'post' ) {
        $posts = $this->get_posts([
            'post_type' => $post_type,
            'posts_per_page'  => -1, 
        ])['posts'];
        
        $options = [];
        foreach($posts as $post){
            $options[$post->ID] = $post->post_title;
        }
        return $options;
    }

	/**
	 * Get post category list option
	 */
	public function get_cpt_category_list( $taxonomy = 'category' ) {
		$options = [];
		$args = array(
            'taxonomy'    => $taxonomy,  
			'hide_empty'  => false,    
			'orderby'     => 'name',    
			'order'       => 'ASC'
        );
        $categories = get_terms($args);

		if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$options[ $category->term_id ] = $category->name;
			}
		}
		return $options;
	}

    /**
     * 
     */
    public function get_posts( $custom_args = [] ) {

        $paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

        if( is_home() || is_archive() || is_search() ) {
            global $wp_query;
            $posts = $wp_query->posts;
            $query = $wp_query; 
            return [
                'query' => $query,           
                'posts' => $query->posts,    
            ];
        }

        $default_args = [
            'post_type'        => 'post',   
            'post_status'      => 'publish',
            'posts_per_page'   => 6, 
            'orderby'          => 'date',   
            'order'            => 'DESC', 
            'paged'            => $paged,    
            'suppress_filters' => false,   
        ];

        $args = array_merge( $default_args, $custom_args );

        $query = new \WP_Query( $args );

        return [
            'query' => $query,           
            'posts' => $query->posts,    
        ];
    }

    public function load_posts_ajax() {
        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }

        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $layout = isset($_POST['layout']) ? $_POST['layout'] : 1;
        $settings = isset($_POST['settings']) ? $_POST['settings'] : [];
        $cat_slug = isset($_POST['cat_slug']) ? $_POST['cat_slug'] : '';
        
        $query_args = $settings[0];
        $query_args['paged'] = $paged;

        $display_args = $settings[1];
        
        if( isset( $settings['post_ids'] ) && !empty( $settings['post_ids'] ) ) {
            $query_args['post__in'] = $settings['post_ids'];
        }

        $post_type = $query_args['post_type'] === 'team' ? 'team' : 'post';

        if( !empty( $cat_slug ) && $cat_slug !== '*' ) {
            $query_args['tax_query'] = [
                [
                    'taxonomy' => $query_args['post_type'] . '_category',
                    'field'    => 'slug',
                    'terms'    => (array) $cat_slug,
                    'operator' => 'IN',
                ]
            ];
        }

        extract( $this->get_posts($query_args) );

        $html = '';
        ob_start();
        if( count( $posts ) === 0 ) {
            $html = '<div class="message">'.esc_html__('No Posts Found.', 'mindverse').'</div>';
        }else {
            foreach( $posts as $post ) : 
                $display_args['post'] = $post;    
            ?>
                <div class="grid-item">
                    <?php Elementor_Helpers::get_template('/elementor/templates/content/'.$post_type.'/layout-'.$layout, $display_args ); ?>
                </div>
            <?php endforeach;
        }
        $html = ob_get_clean();

        $pagination_html = $this->layout->get_pagination( $query, true );

        wp_send_json_success([
            'grid_html' => $html,
            'pagination_html' => $pagination_html,
        ]);
    }
}