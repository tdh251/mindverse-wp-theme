<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Mindverse\Inc\Core\Options;

class Single_Product {
    private $options;
    private $version = '1.0.0';
    public function __construct( Options $options_instance ) {
        $this->options = $options_instance;
 
        add_filter( 'woocommerce_product_description_heading', '__return_false' );
        add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
        add_filter( 'woocommerce_reviews_title', [$this, 'review_heading_title'] );

        add_filter( 'woocommerce_product_review_comment_form_args', [$this, 'product_review_form_args'] );

        add_filter( 'woocommerce_output_related_products_args', [ $this, 'custom_related_products_args' ] );


        add_action( 'wp', [ $this, 'remove_actions' ] );
        add_action('woocommerce_before_single_product_summary', [ $this, 'product_images' ], 10);
        add_action('woocommerce_single_product_summary', [ $this, 'product_summary' ], 10);
        add_action('woocommerce_after_single_product', [ $this, 'product_tabs' ], 10);
        
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        
    }

    public function remove_actions() {
        /**
         * Hook: woocommerce_before_single_product.
         *
         * @hooked woocommerce_output_all_notices - 10
         */
        remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
  
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

        /**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    }

    public function review_heading_title() {
        return __('Reviews', 'mindverse');
    }

    public function custom_related_products_args( $args ) {
        $columns = (int) $this->options->get_theme_option('product_columns', 3);
        $posts_per_page = (int) $this->options->get_theme_option('related_products_per_page', 3);
        $args['posts_per_page'] = $posts_per_page;
        $args['columns']        = $columns;
        return $args;
    }

    public function product_images() {
        woocommerce_show_product_images();
    }

    public function product_summary() {
        woocommerce_template_single_title();
        woocommerce_template_single_rating();
        ?>
        <div class="product-price">
            <?php woocommerce_template_single_price(); ?>
        </div>
        <?php
        woocommerce_template_single_excerpt();
        woocommerce_template_single_add_to_cart();
        woocommerce_template_single_meta();
        woocommerce_template_single_sharing();
    }

    public function product_tabs() {
        woocommerce_output_product_data_tabs();
        woocommerce_upsell_display();
        woocommerce_output_related_products();
    }

    public function product_review_form_args() {
        $commenter = wp_get_current_commenter();

        $comment_form = array(
            'title_reply'         => have_comments()
                ? esc_html__( 'Add a review', 'woocommerce' )
                : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),

            'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
            'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
            'title_reply_after'   => '</span>',
            'comment_notes_after' => '',
            'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
            'logged_in_as'        => '',
        );

        $name_email_required = (bool) get_option( 'require_name_email', 1 );

        // ===== NAME + EMAIL =====
        $fields = array(
            'author' => array(
                'label'        => __( 'Name', 'woocommerce' ),
                'type'         => 'text',
                'value'        => $commenter['comment_author'],
                'required'     => $name_email_required,
                'autocomplete' => 'name',
            ),
            'email'  => array(
                'label'        => __( 'Email', 'woocommerce' ),
                'type'         => 'email',
                'value'        => $commenter['comment_author_email'],
                'required'     => $name_email_required,
                'autocomplete' => 'email',
            ),
        );

        $comment_form['fields'] = array();

        foreach ( $fields as $key => $field ) {
            $field_html  = '<div class="field-control comment-form-' . esc_attr( $key ) . '">';
            $field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

            if ( $field['required'] ) {
                $field_html .= ' <span class="required">*</span>';
            }

            $field_html .= '</label>';
            $field_html .= '<input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" autocomplete="' . esc_attr( $field['autocomplete'] ) . '" ' . ( $field['required'] ? 'required' : '' ) . ' />';
            $field_html .= '</div>';

            $comment_form['fields'][ $key ] = $field_html;
        }

        // ===== LOGIN =====
        $account_page_url = wc_get_page_permalink( 'myaccount' );
        if ( $account_page_url ) {
            $comment_form['must_log_in'] = '<p class="must-log-in">' .
                sprintf(
                    esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ),
                    '<a href="' . esc_url( $account_page_url ) . '">',
                    '</a>'
                ) . '</p>';
        }

        // ===== RATING + COMMENT =====
        $comment_field = '';

        if ( wc_review_ratings_enabled() ) {
            $comment_field .= '<div class="field-control comment-form-rating">';
            $comment_field .= '<label for="rating">' . esc_html__( 'Your rating', 'woocommerce' );

            if ( wc_review_ratings_required() ) {
                $comment_field .= ' <span class="required">*</span>';
            }

            $comment_field .= '</label>';
            $comment_field .= '<select name="rating" id="rating" required>
                <option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
                <option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
                <option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
                <option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
                <option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
                <option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
            </select>';
            $comment_field .= '</div>';
        }

        $comment_field .= '<div class="field-control comment-form-comment">';
        $comment_field .= '<label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . ' <span class="required">*</span></label>';
        $comment_field .= '<textarea id="comment" name="comment" rows="5" required></textarea>';
        $comment_field .= '</div>';

        $comment_form['comment_field'] = $comment_field;
        // ===== CUSTOM SUBMIT BUTTON =====
        $comment_form['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s button" value="%4$s">
            <span class="button-text">' . esc_html__( 'Submit Review', 'woocommerce' ) . '</span>
        </button>';

        // ===== CUSTOM WRAP CHO BUTTON =====
        $comment_form['submit_field'] = '<div class="form-submit review-submit-wrap">%1$s %2$s</div>';
        return $comment_form;
    }

    public function enqueue_scripts() {
        wp_register_script('wc-carousel-js', get_template_directory_uri() . '/woocommerce/assets/js/carousel.js', ['jquery'], $this->version, true);
        wp_register_style('wc-carousel-style', get_template_directory_uri() . '/woocommerce/assets/css/carousel.css', $this->version);
    }

}