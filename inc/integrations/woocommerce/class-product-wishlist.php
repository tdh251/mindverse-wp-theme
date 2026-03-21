<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Product_Wishlist extends Woo_Extend {

    /**
     * User meta key.
     *
     * @var string
     */
    protected $meta_key = 'wishlist_product_ids';

    /**
     * Session key.
     *
     * @var string
     */
    protected $session_key = 'wishlist_products';

    public function __construct() {
        add_action( 'init', [ $this, 'init' ], 1 );
        add_action( 'wp_login', [ $this, 'merge_guest_wishlist_to_user' ], 10, 2 );

        add_action( 'wp_ajax_toggle_wishlist', [ $this, 'ajax_toggle_wishlist' ] );
        add_action( 'wp_ajax_nopriv_toggle_wishlist', [ $this, 'ajax_toggle_wishlist' ] );

        add_action( 'wp_ajax_get_wishlist_popup', [ $this, 'ajax_get_wishlist_popup' ] );
        add_action( 'wp_ajax_nopriv_get_wishlist_popup', [ $this, 'ajax_get_wishlist_popup' ] );

        add_action( 'wp_ajax_remove_wishlist_item', [ $this, 'ajax_remove_wishlist_item' ] );
        add_action( 'wp_ajax_nopriv_remove_wishlist_item', [ $this, 'ajax_remove_wishlist_item' ] );

        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_footer', [ $this, 'render_popup_markup' ] );
    }

    public function init() {
        $this->start_session();

        if ( function_exists( 'pxl_register_shortcode' ) ) {
            pxl_register_shortcode( 'wishlist_btn', [ $this, 'shortcode_btn' ] );
        }
    }

    /**
     * Start PHP session for guest users.
     *
     * @return void
     */
    public function start_session() {
        if ( ! session_id() && ! headers_sent() ) {
            session_start();
        }
    }

    /**
     * Sanitize product IDs.
     *
     * @param array $product_ids Product IDs.
     * @return array
     */
    public function sanitize_product_ids( $product_ids ) {
        $product_ids = array_map( [ $this, 'normalize_product_id' ], (array) $product_ids );
        $product_ids = array_filter( $product_ids );
        $product_ids = array_values( array_unique( $product_ids ) );

        return $product_ids;
    }

    /**
     * Get guest wishlist from session.
     *
     * @return array
     */
    public function get_guest_wishlist() {
        if ( ! session_id() ) {
            return [];
        }

        if ( empty( $_SESSION[ $this->session_key ] ) || ! is_array( $_SESSION[ $this->session_key ] ) ) {
            return [];
        }

        return $this->sanitize_product_ids( $_SESSION[ $this->session_key ] );
    }

    /**
     * Save guest wishlist to session.
     *
     * @param array $product_ids Product IDs.
     * @return void
     */
    public function set_guest_wishlist( $product_ids ) {
        if ( ! session_id() ) {
            return;
        }

        $_SESSION[ $this->session_key ] = $this->sanitize_product_ids( $product_ids );
    }

    /**
     * Clear guest wishlist session.
     *
     * @return void
     */
    public function clear_guest_wishlist() {
        if ( session_id() && isset( $_SESSION[ $this->session_key ] ) ) {
            unset( $_SESSION[ $this->session_key ] );
        }
    }

    /**
     * Get logged-in user wishlist.
     *
     * @param int $user_id User ID.
     * @return array
     */
    public function get_user_wishlist( $user_id = 0 ) {
        $user_id = $user_id ? absint( $user_id ) : get_current_user_id();

        if ( ! $user_id ) {
            return [];
        }

        $product_ids = get_user_meta( $user_id, $this->meta_key, true );

        if ( ! is_array( $product_ids ) ) {
            $product_ids = [];
        }

        return $this->sanitize_product_ids( $product_ids );
    }

    /**
     * Save logged-in user wishlist.
     *
     * @param array $product_ids Product IDs.
     * @param int   $user_id     User ID.
     * @return bool
     */
    public function set_user_wishlist( $product_ids, $user_id = 0 ) {
        $user_id = $user_id ? absint( $user_id ) : get_current_user_id();

        if ( ! $user_id ) {
            return false;
        }

        $product_ids = $this->sanitize_product_ids( $product_ids );

        return (bool) update_user_meta( $user_id, $this->meta_key, $product_ids );
    }

    /**
     * Merge guest wishlist into user wishlist after login.
     *
     * @param string  $user_login User login.
     * @param \WP_User $user      User object.
     * @return void
     */
    public function merge_guest_wishlist_to_user( $user_login, $user ) {
        if ( ! $user || empty( $user->ID ) ) {
            return;
        }

        $guest_wishlist = $this->get_guest_wishlist();

        if ( empty( $guest_wishlist ) ) {
            return;
        }

        $user_wishlist = $this->get_user_wishlist( $user->ID );
        $merged        = array_merge( $user_wishlist, $guest_wishlist );
        $merged        = $this->sanitize_product_ids( $merged );

        $this->set_user_wishlist( $merged, $user->ID );
        $this->clear_guest_wishlist();
    }

    /**
     * Get current wishlist by login state.
     *
     * @return array
     */
    public function get_current_wishlist() {
        if ( is_user_logged_in() ) {
            return $this->get_user_wishlist();
        }

        return $this->get_guest_wishlist();
    }

    /**
     * Check if product exists in wishlist.
     *
     * @param int $product_id Product ID.
     * @return bool
     */
    public function is_in_wishlist( $product_id ) {
        $product_id = $this->normalize_product_id( $product_id );

        if ( ! $product_id ) {
            return false;
        }

        return in_array( $product_id, $this->get_current_wishlist(), true );
    }

    /**
     * Add product to wishlist.
     *
     * @param int $product_id Product ID.
     * @return bool
     */
    public function add_to_wishlist( $product_id ) {
        $product_id = $this->normalize_product_id( $product_id );

        if ( ! $product_id || 'product' !== get_post_type( $product_id ) ) {
            return false;
        }

        $wishlist = $this->get_current_wishlist();

        if ( in_array( $product_id, $wishlist, true ) ) {
            return true;
        }

        $wishlist[] = $product_id;
        $wishlist   = $this->sanitize_product_ids( $wishlist );

        if ( is_user_logged_in() ) {
            return $this->set_user_wishlist( $wishlist );
        }

        $this->set_guest_wishlist( $wishlist );

        return true;
    }

    /**
     * Remove product from wishlist.
     *
     * @param int $product_id Product ID.
     * @return bool
     */
    public function remove_from_wishlist( $product_id ) {
        $product_id = $this->normalize_product_id( $product_id );

        if ( ! $product_id ) {
            return false;
        }

        $wishlist = $this->get_current_wishlist();

        $wishlist = array_filter(
            $wishlist,
            function ( $id ) use ( $product_id ) {
                return (int) $id !== (int) $product_id;
            }
        );

        $wishlist = array_values( $wishlist );

        if ( is_user_logged_in() ) {
            return $this->set_user_wishlist( $wishlist );
        }

        $this->set_guest_wishlist( $wishlist );

        return true;
    }

    /**
     * Add product to wishlist only.
     * If product already exists, return "exists" instead of removing it.
     *
     * @param int $product_id Product ID.
     * @return array
     */
    public function add_product_to_wishlist( $product_id ) {
        $product_id = $this->normalize_product_id( $product_id );

        if ( ! $product_id || 'product' !== get_post_type( $product_id ) ) {
            return [
                'success'    => false,
                'product_id' => 0,
                'action'     => '',
                'message'    => esc_html__( 'Invalid product.', 'mindverse' ),
                'added'      => false,
            ];
        }

        if ( $this->is_in_wishlist( $product_id ) ) {
            return [
                'success'    => true,
                'product_id' => $product_id,
                'action'     => 'exists',
                'message'    => esc_html__( 'Product already exists in wishlist.', 'mindverse' ),
                'added'      => true,
            ];
        }

        $added = $this->add_to_wishlist( $product_id );

        return [
            'success'    => (bool) $added,
            'product_id' => $product_id,
            'action'     => 'added',
            'message'    => esc_html__( 'Product added to wishlist.', 'mindverse' ),
            'added'      => true,
        ];
    }

    /**
     * Get wishlist products.
     *
     * @return array
     */
    public function get_wishlist_products() {
        $product_ids = $this->get_current_wishlist();

        if ( empty( $product_ids ) ) {
            return [];
        }

        $products = [];

        foreach ( $product_ids as $product_id ) {
            $product = wc_get_product( $product_id );

            if ( ! $product ) {
                continue;
            }

            $products[] = $product;
        }

        return $products;
    }

    /**
     * Render wishlist button shortcode.
     *
     * @param array $attrs Shortcode attrs.
     * @return string
     */
    public function shortcode_btn( $attrs ) {
        $attrs = shortcode_atts(
            [
                'id' => 0,
            ],
            $attrs,
            'wishlist_btn'
        );

        $product_id = isset( $attrs['id'] ) ? absint( $attrs['id'] ) : 0;

        if ( ! $product_id ) {
            global $product;

            if ( $product && is_a( $product, 'WC_Product' ) ) {
                $product_id = $product->get_id();
            }
        }

        $product_id = $this->normalize_product_id( $product_id );

        if ( ! $product_id ) {
            return '';
        }

        $is_added = $this->is_in_wishlist( $product_id );
        $class    = 'button wishlist-btn' . ( $is_added ? ' is-added' : '' );
        $text     =  esc_html__( 'Add to wishlist', 'mindverse' );
        $icon     = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
                        <path d="M14.9252 2.98931C14.8384 2.64973 14.7045 2.32398 14.5274 2.02157C14.3572 1.70697 14.1396 1.42046 13.8822 1.1721C13.509 0.800206 13.0672 0.504396 12.5811 0.301137C11.6028 -0.100379 10.5057 -0.100379 9.52735 0.301137C9.06796 0.495587 8.6459 0.768473 8.28004 1.10759L8.22628 1.1721L7.52735 1.87103L6.82843 1.1721L6.77466 1.10759C6.40881 0.768473 5.98674 0.495587 5.52735 0.301137C4.54902 -0.100379 3.45191 -0.100379 2.47359 0.301137C1.98755 0.504396 1.54566 0.800206 1.17251 1.1721C0.662151 1.6687 0.300869 2.29815 0.129502 2.98931C0.0383356 3.3403 -0.00506651 3.70198 0.000469976 4.06458C0.000469976 4.40544 0.0434807 4.74522 0.129502 5.07533C0.219646 5.40871 0.349614 5.73002 0.516599 6.03232C0.696938 6.34308 0.917478 6.6287 1.17251 6.88178L7.52735 13.2366L13.8822 6.88178C14.137 6.63124 14.3553 6.34415 14.5274 6.03232C14.8766 5.43566 15.0586 4.75592 15.0542 4.06458C15.0598 3.70198 15.0164 3.34029 14.9252 2.98931ZM13.8499 4.742C13.7211 5.23331 13.4653 5.68204 13.108 6.04307L7.50585 11.6345L1.9037 6.04307C1.72114 5.85922 1.56221 5.65333 1.43058 5.43017C1.30671 5.20939 1.20927 4.9748 1.14025 4.73124C1.08516 4.48772 1.05632 4.23898 1.05423 3.98931C1.05569 3.7325 1.08453 3.47657 1.14025 3.22587C1.20725 2.98161 1.30479 2.74678 1.43058 2.52694C1.55961 2.30114 1.71875 2.09684 1.9037 1.91404C2.17993 1.64151 2.50444 1.42273 2.86068 1.26888C3.57855 0.9817 4.37938 0.9817 5.09724 1.26888C5.45208 1.41619 5.77251 1.63232 6.04348 1.90329L7.50585 3.37641L8.96821 1.90329C9.23899 1.63184 9.5605 1.41628 9.91445 1.26888C10.6323 0.9817 11.4331 0.9817 12.151 1.26888C12.5069 1.42264 12.8317 1.642 13.108 1.91404C13.2951 2.09146 13.4521 2.29791 13.5704 2.52694C13.8194 2.96615 13.9492 3.4629 13.9467 3.9678C13.9613 4.22761 13.9396 4.48819 13.8822 4.742H13.8499Z" fill="currentColor"/>
                    </svg>';
        if( $is_added ) {
            $text = esc_html__( 'Browse wishlist', 'mindverse' );
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none" aria-hidden="true">
                            <path d="M8 13.4C7.85 13.4 7.71 13.35 7.6 13.25L2.18 8.24C0.78 6.95 0 5.82 0 4.33C0 1.86 1.79 0 4.16 0C5.65 0 7.05 0.69 8 1.87C8.95 0.69 10.35 0 11.84 0C14.21 0 16 1.86 16 4.33C16 5.82 15.22 6.95 13.82 8.24L8.4 13.25C8.29 13.35 8.15 13.4 8 13.4Z" fill="currentColor"/>
                        </svg>';
        }
        
        ob_start();
        ?>
        <button
            type="button"
            class="<?php echo esc_attr( $class ); ?>"
            data-product-id="<?php echo esc_attr( $product_id ); ?>"
            data-nonce="<?php echo esc_attr( wp_create_nonce( 'wishlist_nonce' ) ); ?>"
            aria-label="<?php echo esc_attr( $text ); ?>"
        >
            <span class="button-icon" aria-hidden="true">
                <?php pxl_print_html( $icon ); ?>
            </span>
        </button>
        <?php
        return ob_get_clean();
    }

    /**
     * Render popup wrapper.
     *
     * @return void
     */
    public function render_popup_markup() {
        ?>
        <div class="wishlist-drawer drawer" id="wishlistDrawer" data-drawer="right" aria-hidden="true">
            <div class="wishlist-drawer__header">
                <h3 class="wishlist-drawer__title"><?php echo esc_html__( 'Your wishlist', 'mindverse' ); ?></h3>
                <button type="button" class="button-close" aria-label="<?php echo esc_attr__( 'Close wishlist', 'mindverse' ); ?>">
                    <span class="icon-close"></span>
                </button>
            </div>
            <div class="wishlist-drawer__body" id="wishlistDrawerContent">
                <?php pxl_print_html( $this->render_popup_content() ); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render wishlist popup content.
     *
     * @return string
     */
    public function render_popup_content() {
        $products = $this->get_wishlist_products();

        ob_start();

        if ( empty( $products ) ) :
            ?>
            <div class="wishlist-empty">
                <p><?php echo esc_html__( 'Your wishlist is empty.', 'mindverse' ); ?></p>
            </div>
            <?php
        else :
            ?>
            <div class="wishlist-list">
                <?php foreach ( $products as $product ) : ?>
                    <?php
                    $product_id   = $product->get_id();
                    $product_name = $product->get_name();
                    $product_link = get_permalink( $product_id );
                    $image_html   = $product->get_image( 'full' );
                    $price_html   = $product->get_price_html();

                    $add_to_cart_url = $product->add_to_cart_url();

                    $add_to_cart_class = implode(
                        ' ',
                        array_filter(
                            [
                                'button',
                                'product_type_' . $product->get_type(),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                            ]
                        )
                    );
                    ?>
                    <div class="wishlist-item" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                        <a class="wishlist-item__image" href="<?php echo esc_url( $product_link ); ?>">
                            <?php echo wp_kses_post( $image_html ); ?>
                        </a>

                        <div class="wishlist-item__content">
                            <h4 class="wishlist-item__title">
                                <a href="<?php echo esc_url( $product_link ); ?>">
                                    <?php echo esc_html( $product_name ); ?>
                                </a>
                            </h4>

                            <div class="wishlist-item__price product-price">
                                <?php echo wp_kses_post( $price_html ); ?>
                            </div>

                            <div class="wishlist-item__actions">
                                <?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
                                    <a
                                        href="<?php echo esc_url( $add_to_cart_url ); ?>"
                                        data-quantity="1"
                                        class="<?php echo esc_attr( $add_to_cart_class ); ?>"
                                        data-product_id="<?php echo esc_attr( $product_id ); ?>"
                                        data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                                        data-success_message = "<?php echo esc_attr( $product_name ).' has been added to your cart'; ?>"
                                        aria-label="<?php echo esc_attr( sprintf( __( 'Add to cart: "%s"', 'mindverse' ), $product_name ) ); ?>"
                                        rel="nofollow"
                                    >
                                        <?php echo esc_html( $product->add_to_cart_text() ); ?>
                                    </a>
                                <?php endif; ?>

                                <button
                                    type="button"
                                    class="remove-wishlist-item"
                                    data-product-id="<?php echo esc_attr( $product_id ); ?>"
                                >
                                    <?php echo esc_html__( 'Remove', 'mindverse' ); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        endif;

        return ob_get_clean();
    }

    /**
     * AJAX: Add product or return existing state, then return popup content.
     *
     * @return void
     */
    public function ajax_toggle_wishlist() {
        check_ajax_referer( 'wishlist_nonce', 'nonce' );

        $product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;

        if ( ! $product_id ) {
            wp_send_json_error(
                [
                    'message' => esc_html__( 'Product ID is required.', 'mindverse' ),
                ]
            );
        }

        $result = $this->add_product_to_wishlist( $product_id );

        if ( empty( $result['success'] ) ) {
            wp_send_json_error( $result );
        }

        $result['html']  = $this->render_popup_content();
        $result['count'] = count( $this->get_current_wishlist() );

        wp_send_json_success( $result );
    }

    /**
     * AJAX: Get popup content.
     *
     * @return void
     */
    public function ajax_get_wishlist_popup() {
        check_ajax_referer( 'wishlist_nonce', 'nonce' );

        wp_send_json_success(
            [
                'html'  => $this->render_popup_content(),
                'count' => count( $this->get_current_wishlist() ),
            ]
        );
    }

    /**
     * AJAX: Remove item from wishlist.
     *
     * @return void
     */
    public function ajax_remove_wishlist_item() {
        check_ajax_referer( 'wishlist_nonce', 'nonce' );

        $product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;

        if ( ! $product_id ) {
            wp_send_json_error(
                [
                    'message' => esc_html__( 'Product ID is required.', 'mindverse' ),
                ]
            );
        }

        $removed = $this->remove_from_wishlist( $product_id );

        if ( ! $removed ) {
            wp_send_json_error(
                [
                    'message' => esc_html__( 'Unable to remove product from wishlist.', 'mindverse' ),
                ]
            );
        }

        wp_send_json_success(
            [
                'product_id' => $product_id,
                'html'       => $this->render_popup_content(),
                'count'      => count( $this->get_current_wishlist() ),
                'message'    => esc_html__( 'Product removed from wishlist.', 'mindverse' ),
            ]
        );
    }

    /**
     * Enqueue assets.
     *
     * @return void
     */
    public function enqueue_scripts() {

        wp_enqueue_script(
            'wishlist-js',
            get_template_directory_uri() . '/woocommerce/assets/js/wishlist.js',
            [ 'jquery' ],
            '1.0.0',
            true
        );

        wp_localize_script(
            'wishlist-js',
            'wishlist_params',
            [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'wishlist_nonce' ),
                'texts'    => [
                    'add'     => esc_html__( 'Add to wishlist', 'mindverse' ),
                    'browse'  => esc_html__( 'Browse wishlist', 'mindverse' ),
                    'loading' => esc_html__( 'Loading wishlist...', 'mindverse' ),
                    'error'   => esc_html__( 'Something went wrong. Please try again.', 'mindverse' ),
                ],
            ]
        );
    }
}