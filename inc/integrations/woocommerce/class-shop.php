<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Mindverse\Inc\Core\Options;

class Shop {
    private $options;
    public function __construct( Options $options_instance ) {
        $this->options = $options_instance;
        
        add_filter( 'single_product_archive_thumbnail_size', [ $this, 'set_thumbnail_size' ] );
        add_filter( 'loop_shop_columns', [ $this, 'shop_columns' ] );
        add_filter( 'loop_shop_per_page', [ $this, 'products_per_page' ], 20 );
        add_filter( 'woocommerce_product_loop_start', [ $this, 'product_loop_start' ] );
        add_filter( 'woocommerce_product_loop_end', [ $this, 'product_loop_end' ] );

        add_action( 'wp', [ $this, 'remove_actions' ] );
        add_action( 'woocommerce_before_main_content', [ $this, 'shop_before_content_wrapper' ], 10 );
        add_action( 'woocommerce_after_main_content', [ $this, 'shop_after_content_wrapper' ], 10 );
        add_action( 'woocommerce_before_shop_loop_item', [ $this, 'archive_content' ], 10 );

    }

    public function set_thumbnail_size( $size ) {
        $product_thumb_size = $this->options->get_theme_option('product_thumb_size', []);
        $width = $product_thumb_size['width'] ?? 0;
        $height = $product_thumb_size['height'] ?? 0;
        if( $width != 0 && $height !== 0 ) {
            return [ $width, $height ];
        }
        return 'full';
    }

    public function products_per_page() {
        $columns = (int) $this->options->get_theme_option('products_per_page', 9);
        return $columns;
    }

    public function shop_columns( $columns ) {
        $columns = (int) $this->options->get_theme_option('product_columns', 3);
        $sidebar_pos = $this->options->get_theme_option('shop_sidebar_mode', 'none');

        $has_sidebar = ( isset( $_GET['sidebar'] ) && ( $_GET['sidebar'] !== 'none' ) ) || $sidebar_pos !== 'none'; 

        if( intval( $columns ) ) {
            if( $has_sidebar ) {
                return $columns - 1;
            }
            return $columns;
        }
        return 3;
    }

    public function product_loop_start() {
        ob_start();
        ?>
        <div class="grid post-grid is-post-type-product columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ) ?>">
            <div class="grid-inner">
        <?php
        return ob_get_clean();
    }

    public function product_loop_end() {
        ob_start();
        ?>
            <!-- Grid Inner -->
            </div> 
        <!-- Grid -->
        </div>
        <?php
        return ob_get_clean();
    }

    public function remove_actions() {
        // Shop before Wrapper
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        // 
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
        // Shop header .woocommerce-products-header
        remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10 );
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

        // Shop after Wrapper
        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

        // Before Shop Loop
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        // Archive Content
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
        
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );    
    }

    public function shop_before_content_wrapper() {
        ?>
        <main id="main">
            <?php
                $before_page_template_id = (int) mindverse()->get_theme_option('shop_before_template_id', 0);
                if( $before_page_template_id !== 0 ) {
                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $before_page_template_id );
                }
            ?>
            <div class="inner">
                <?php if( is_shop() ) : ?>
                    <div class="content-area">
                        <div class="content-header">
                            <?php
                                woocommerce_result_count();
                                woocommerce_catalog_ordering();
                            ?>
                        </div>
                <?php endif; ?>
        <?php
    }

    public function shop_after_content_wrapper() {
        ?>
                <?php if( is_shop() ) : ?>
                    <!-- Content Area -->
                    </div>
                    <!-- Sidebar -->
                    <?php 
                    $sidebar_mode = $this->options->get_theme_option('shop_sidebar_mode', 'none');
                    if( isset( $_GET['sidebar'] ) ) {
                        $sidebar_mode = $_GET['sidebar'];
                    }
                    if( $sidebar_mode !== 'none' ) : ?>
                        <div class="sidebar-area">
                            <?php get_sidebar(); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <!-- Inner -->
            </div>
            <?php
                $after_page_template_id = (int) mindverse()->get_theme_option('shop_after_template_id', 0);
                if( $after_page_template_id !== 0 ) {
                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $after_page_template_id );
                }
            ?>
        <!-- Main -->
        </main>
        <?php
    }

    public function archive_content() {
        global $product;
        ?>
        <div class="product-thumbnail">
            <?php
                woocommerce_template_loop_product_thumbnail(); 
                woocommerce_show_product_loop_sale_flash();
            ?>
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-link"></a>
        </div>

        <div class="product-content">
            <h4 class="product-title">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" data-hover="text-underline-slide">
                    <span><?php pxl_print_html( $product->get_name() ); ?></span>
                </a>
            </h4>
            <div class="product-price">
                <?php woocommerce_template_loop_price(); ?>
            </div>
        </div>

        <?php
    }

}