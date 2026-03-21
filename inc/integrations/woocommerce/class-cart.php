<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cart {
    public function __construct() {   
        add_filter( 'woocommerce_cart_totals_coupon_label', [ $this, 'coupon_label' ] );
        add_filter( 'woocommerce_return_to_shop_text', [ $this, 'button_text_cart_empty' ] );
        add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'add_cart_fragments' ] );

        add_action( 'wp_ajax_mindverse_remove_cart_item', [ $this, 'ajax_remove_cart_item' ] );
        add_action( 'wp_ajax_nopriv_mindverse_remove_cart_item', [ $this, 'ajax_remove_cart_item' ] );

        add_action( 'wp_ajax_mindverse_update_cart_fragments', [ $this, 'ajax_update_cart_fragments' ] );
        add_action( 'wp_ajax_nopriv_mindverse_update_cart_fragments', [ $this, 'ajax_update_cart_fragments' ] );

        remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
        remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
        remove_action( 'woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5 );

        add_action( 'woocommerce_cart_is_empty', [ $this, 'empty_cart_message' ] );

        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_footer', [ $this, 'render_cart_markup' ] );
    }

    public function coupon_label() {
        return 'Coupon';
    }

    public function button_text_cart_empty() {
        return 'Shopping Now';
    }

    public function empty_cart_message() {
        ?>
            <div class="empty-cart-label"><?php echo __('Empty Cart!', 'mindverse'); ?></div>
        <?php
    }

    public function ajax_remove_cart_item() {
        check_ajax_referer( 'mindverse_remove_cart_item_nonce', 'nonce' );

        if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
            wp_send_json_error( [
                'message' => __( 'Cart is unavailable.', 'mindverse' ),
            ] );
        }

        $cart_item_key = isset( $_POST['cart_item_key'] )
            ? wc_clean( wp_unslash( $_POST['cart_item_key'] ) )
            : '';

        if ( ! $cart_item_key ) {
            wp_send_json_error( [
                'message' => __( 'Cart item key is missing.', 'mindverse' ),
            ] );
        }

        $removed = WC()->cart->remove_cart_item( $cart_item_key );

        if ( ! $removed ) {
            wp_send_json_error( [
                'message' => __( 'Unable to remove this item.', 'mindverse' ),
            ] );
        }

        WC()->cart->calculate_totals();

        \WC_AJAX::get_refreshed_fragments();
    }

    /**
     * Register WooCommerce cart fragments.
     *
     * @param array $fragments Cart fragments.
     * @return array
     */
    public function add_cart_fragments( $fragments ) {
        ob_start();
        ?>
        <div class="cart-drawer__body" id="cartDrawerContent">
            <?php pxl_print_html( $this->render_cart_content() ); ?>
        </div>
        <?php
        $fragments['#cartDrawerContent'] = ob_get_clean();
        ob_start();
        ?>
        <div class="cart-total">
            <?php pxl_print_html( $this->cart_drawer_subtotal_fragment() ); ?>
        </div>
        <?php
        $fragments['.cart-total'] = ob_get_clean();

        return $fragments;
    }

    /**
     * Render popup wrapper.
     *
     * @return void
     */
    public function render_cart_markup() {
        ?>
        <div class="cart-drawer drawer" id="cartDrawer" data-drawer="right" aria-hidden="true">
            <div class="cart-drawer__header">
                <h3 class="cart-drawer__title"><?php echo esc_html__( 'Your cart', 'mindverse' ); ?></h3>
                <button type="button" class="button-close" aria-label="<?php echo esc_attr__( 'Close cart', 'mindverse' ); ?>">
                    <span class="icon-close"></span>
                </button>
            </div>
            <div class="cart-drawer__body" id="cartDrawerContent">
                <?php echo $this->render_cart_content(); ?>
            </div>
            <div class="cart-drawer__footer">
                <div class="cart-total">
                    <?php pxl_print_html( $this->cart_drawer_subtotal_fragment() ); ?>
                </div>
                <div class="cart-actions">
                    <?php 
                        woocommerce_widget_shopping_cart_button_view_cart();
                        woocommerce_widget_shopping_cart_proceed_to_checkout();
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function cart_drawer_subtotal_fragment() {
        ob_start();
        ?>
        <div class="label"><?php echo esc_html__('Subtotal:', 'mindverse'); ?></div>
        <div class="value"><?php echo WC()->cart->get_cart_subtotal() ?></div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render cart popup content.
     *
     * @return string
     */
    public function render_cart_content() {
        $cart_items = [];

        if ( function_exists( 'WC' ) && WC()->cart ) {
            $cart_items = WC()->cart->get_cart();
        }

        ob_start();

        if ( empty( $cart_items ) ) :
            ?>
            <div class="cart-empty">
                <p><?php echo esc_html__( 'Your cart is empty.', 'mindverse' ); ?></p>
            </div>
            <?php
        else :
            ?>
            <div class="cart-list">
                <?php foreach ( $cart_items as $cart_item_key => $cart_item ) : ?>
                    <?php
                    $product = isset( $cart_item['data'] ) ? $cart_item['data'] : false;

                    if ( ! $product || ! is_a( $product, 'WC_Product' ) || ! $product->exists() ) {
                        continue;
                    }

                    $product_id   = $product->get_id();
                    $product_name = $product->get_name();
                    $product_link = $product->is_visible() ? $product->get_permalink( $cart_item ) : '';
                    $image_html   = $product->get_image( 'full' );
                    $price_html   = WC()->cart->get_product_price( $product );
                    $quantity     = isset( $cart_item['quantity'] ) ? (int) $cart_item['quantity'] : 1;
                    $remove_url   = wc_get_cart_remove_url( $cart_item_key );
                    ?>
                    <div class="cart-item" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                        <?php if ( $product_link ) : ?>
                            <a class="cart-item__image" href="<?php echo esc_url( $product_link ); ?>">
                                <?php echo wp_kses_post( $image_html ); ?>
                            </a>
                        <?php else : ?>
                            <span class="cart-item__image">
                                <?php echo wp_kses_post( $image_html ); ?>
                            </span>
                        <?php endif; ?>

                        <div class="cart-item__content">
                            <h4 class="cart-item__title">
                                <?php if ( $product_link ) : ?>
                                    <a href="<?php echo esc_url( $product_link ); ?>">
                                        <?php pxl_print_html( $product_name . '<span class="product-quantity"> x' . $quantity . '</span>'); ?>
                                    </a>
                                <?php else : ?>
                                    <?php pxl_print_html( $product_name . '<span class="product-quantity"> x' . $quantity . '</span>' ); ?>
                                <?php endif; ?>
                            </h4>

                            <div class="cart-item__price product-price">
                                <?php echo wp_kses_post( $price_html ); ?>
                            </div>

                                <a
                                    href="<?php echo esc_url( $remove_url ); ?>"
                                    class="remove-cart-item"
                                    data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>"
                                    aria-label="<?php echo esc_attr( sprintf( __( 'Remove "%s" from cart', 'mindverse' ), $product_name ) ); ?>"
                                >
                                    <span class="icon-close"></span>
                                </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        endif;

        return ob_get_clean();
    }

    function ajax_update_cart_fragments() {
        \WC_AJAX::get_refreshed_fragments();
    }

    public function enqueue_scripts() {
        if ( is_admin() ) {
            return;
        }
        wp_enqueue_script(
            'wc-cart-js',
            get_template_directory_uri() . '/woocommerce/assets/js/cart.js',
            [ 'jquery' ],
            null,
            true
        );

        wp_localize_script(
            'wc-cart-js',
            'mindverse_cart_params',
            [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'wc_ajax_url' => \WC_AJAX::get_endpoint( 'add_to_cart' ),
                'nonce'    => wp_create_nonce( 'mindverse_remove_cart_item_nonce' ),
            ]
        );

    }
}