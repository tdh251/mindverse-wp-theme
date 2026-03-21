<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

use Mindverse\Inc\Utils\Helpers;
use \Mindverse\Inc\Core\Options;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woo_Init {
    private $version;
    public function __construct( Options $options_instance ) {
        error_log( 'WOO_Init instantiated' );

        $this->version = Helpers::get_theme_version();

        add_filter('woocommerce_get_star_rating_html', [$this, 'star_rating_html'], 10, 3);
        add_action('woocommerce_before_quantity_input_field', [$this, 'before_quantity_input_field'] );
        add_action('woocommerce_after_quantity_input_field', [$this, 'after_quantity_input_field'] );
        add_action('woocommerce_before_add_to_cart_quantity', [$this, 'before_add_to_cart_quantity']);
        add_action('woocommerce_after_add_to_cart_quantity', [$this, 'after_add_to_cart_quantity']);
        add_action('woocommerce_share', [$this, 'woocommerce_share']);
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        new Product_Wishlist();
        new Product_Compare();
        new Shop( $options_instance );
        new Cart();
        new Single_Product( $options_instance );
        new Checkout();
    }

    public function init() {
        
    }


    private function custom_round_rating( $number ) {
        $integer  = floor( $number );
        $decimal  = $number - $integer;

        if ( $decimal < 0.25 ) {
            return (float) $integer;
        }

        if ( $decimal < 0.75 ) {
            return (float) ( $integer + 0.5 );
        }

        return (float) ( $integer + 1 );
    }

    private function rating_to_array( $number ) {
        $rounded = $this->custom_round_rating( $number );
        $result  = array();

        $full = floor( $rounded );

        for ( $i = 0; $i < $full; $i++ ) {
            $result[] = 'full';
        }

        if ( $rounded - $full === 0.5 ) {
            $result[] = 'half';
        }

        if( count( $result ) < 5 ) {
            $result[] = 'empty';
        }

        return $result;
    }

    public function star_rating_html( $html, $rating, $count = 0 ) {
        $html = '';
        $i = 0;
        $count = $this->rating_to_array( floatval( $rating ) );
        if( $rating != 0 ) {
            foreach( $count as $star ) {
                switch( $star ) {
                    case 'full' : 
                        $html .= '<svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6.77717 0.52817L4.92395 4.45401L0.777627 5.08558C0.0340696 5.19825 -0.263921 6.15599 0.2753 6.70454L3.27507 9.75863L2.56557 14.0729C2.43786 14.8527 3.22399 15.4369 3.88241 15.0721L7.59168 13.0351L11.301 15.0721C11.9594 15.4339 12.7455 14.8527 12.6178 14.0729L11.9083 9.75863L14.9081 6.70454C15.4473 6.15599 15.1493 5.19825 14.4057 5.08558L10.2594 4.45401L8.40619 0.52817C8.07414 -0.171602 7.11206 -0.180497 6.77717 0.52817Z" fill="#060F16"/>
                        </svg>';
                        break;
                    case 'half' : 
                        $html .= '<svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M14.4059 5.08607L10.2597 4.45412L8.40678 0.528094C8.24021 0.177276 7.9153 -6.10352e-05 7.59039 -6.10352e-05C7.26746 -6.10352e-05 6.94481 0.174903 6.77768 0.528094L4.92424 4.45382L0.777707 5.08518C0.0341187 5.19787 -0.263883 6.15543 0.275183 6.70404L3.27475 9.75851L2.56487 14.0727C2.46402 14.6889 2.93397 15.1833 3.46029 15.1833C3.59994 15.1833 3.74356 15.1486 3.88151 15.0721L7.59096 13.0354L11.3001 15.0727C11.4378 15.1483 11.5811 15.1827 11.7202 15.1827C12.2471 15.1827 12.7179 14.6901 12.617 14.0736L11.908 9.7591L14.9081 6.70523C15.4475 6.15661 15.1495 5.19876 14.4059 5.08607ZM10.9574 8.73956L10.4441 9.26208L10.5653 9.9999L11.1183 13.3643L8.2252 11.775L7.59124 11.4269L7.59209 2.02063L9.03762 5.08369L9.35432 5.75479L10.0628 5.86273L13.2986 6.35589L10.9574 8.73956Z" fill="#060F16"/>
                        </svg>';
                        break;
                    default :
                        $html .= '<svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M14.8671 5.08596L10.5879 4.45431L8.67538 0.527991C8.3327 -0.171867 7.33981 -0.180764 6.9942 0.527991L5.08164 4.45431L0.802529 5.08596C0.0351606 5.19865 -0.272373 6.15651 0.284116 6.70513L3.37995 9.75959L2.64773 14.0744C2.51593 14.8543 3.32723 15.4385 4.00673 15.0738L7.83479 13.0365L11.6628 15.0738C12.3424 15.4356 13.1537 14.8543 13.0219 14.0744L12.2896 9.75959L15.3855 6.70513C15.942 6.15651 15.6344 5.19865 14.8671 5.08596ZM10.7813 9.26139L11.4754 13.3656L7.83479 11.4292L4.19418 13.3656L4.88833 9.26139L1.94187 6.3552L6.01302 5.75617L7.83479 2.01964L9.65656 5.75617L13.7277 6.3552L10.7813 9.26139Z" fill="#060F16"/>
                        </svg>';
                        break;
                }
            }
        }
        return $html;
    }

    public function before_quantity_input_field() {
        ?>
        <span class="quantity-label"><?php echo __('Quantity', 'mindverse'); ?></span>
        <div class="quantity-field">
            <span class="quantity-icon icon-minus"></span>
        <?php
    }

    public function after_quantity_input_field() {
        ?>
            <span class="quantity-icon icon-plus"></span>
        </div>
        <?php
    }

    public function before_add_to_cart_quantity() {
        ?>
        <div class="form-group">
        <?php
    }

    public function after_add_to_cart_quantity() {
        global $product;
        ?>
        <div class="buttons">
            <?php pxl_print_html( do_shortcode( '[wishlist_btn id="' . $product->get_id() . '"]' ) ); ?>
            <?php pxl_print_html( do_shortcode( '[woosc_btn id="' . $product->get_id() . '"]'  ) ); ?>
        </div>
        </div>
        <?php
    }

    public function woocommerce_share() {
        global $product;
        $product_url   = get_permalink( $product->get_id() );
        $product_title = $product->get_name();
        $product_image = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
        $url   = urlencode( $product_url );
        $title = urlencode( $product_title );
        $image = urlencode( $product_image );
        $facebook = "https://www.facebook.com/sharer/sharer.php?u={$url}";
        $twitter = "https://twitter.com/intent/tweet?url={$url}&text={$title}";
        $pinterest = "https://pinterest.com/pin/create/button/?url={$url}&media={$image}&description={$title}";
        $instagram = apply_filters(
            'mindverse_product_share_instagram_url',
            'https://www.instagram.com/',
            $product
        );

        $youtube = apply_filters(
            'mindverse_product_share_youtube_url',
            'https://www.youtube.com/',
            $product
        );
        ?>
        <div class="product-share">
            <span class="social-label">Share:</span>

            <div class="social-list">
                <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="nofollow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="14" viewBox="0 0 7 14" fill="none">
                        <path d="M6.25276 7.47107L6.59877 5.06831H4.43095V3.50652C4.43095 2.84952 4.73459 2.20753 5.70551 2.20753H6.69056V0.161435C6.69056 0.161435 5.79378 0 4.93936 0C3.15286 0 1.98422 1.15257 1.98422 3.23621V5.06831H0V7.47107H1.98422V13.2827H4.42742V7.47107H6.25276Z" fill="#060F16"/>
                    </svg>
                </a>
    
                <a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="nofollow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10" fill="none">
                        <path d="M11.7777 1.15971C11.4008 1.3293 10.9881 1.4305 10.5809 1.49889C10.7735 1.46606 11.0569 1.12142 11.1697 0.979183C11.343 0.765831 11.4861 0.522391 11.5659 0.259805C11.5769 0.240658 11.5851 0.213305 11.5631 0.196893C11.5384 0.185952 11.5191 0.191423 11.4998 0.202364C11.0486 0.443068 10.5809 0.618126 10.0829 0.741214C10.0416 0.752155 10.0114 0.741214 9.98386 0.716596C9.94259 0.672832 9.90407 0.629067 9.86005 0.590773C9.65095 0.41298 9.42534 0.276216 9.17222 0.172276C8.83931 0.0382469 8.47613 -0.019194 8.11846 0.00268825C7.76904 0.0245705 7.42788 0.123041 7.11973 0.284422C6.80883 0.445804 6.5337 0.670096 6.31359 0.938154C6.08523 1.21715 5.9174 1.54812 5.83211 1.89824C5.74957 2.23468 5.75507 2.56838 5.80735 2.91029C5.8156 2.96773 5.8101 2.9732 5.75782 2.96773C3.80988 2.68053 2.1976 1.9885 0.885222 0.503244C0.827444 0.437598 0.797179 0.437598 0.750407 0.508715C0.178131 1.36212 0.456015 2.73523 1.17136 3.41085C1.26766 3.50111 1.36395 3.59138 1.47125 3.67343C1.43274 3.68164 0.956756 3.62967 0.530301 3.41085C0.472523 3.37529 0.445009 3.39443 0.439507 3.46008C0.434004 3.55308 0.442258 3.63787 0.456015 3.73634C0.566068 4.60343 1.16861 5.40487 1.99676 5.71669C2.09581 5.75772 2.20311 5.79327 2.31041 5.81242C2.12332 5.85345 1.92797 5.88354 1.38871 5.83978C1.31993 5.8261 1.29517 5.86166 1.31993 5.92457C1.72438 7.02415 2.60205 7.35238 3.25687 7.53838C3.34491 7.55479 3.43295 7.5548 3.52099 7.57394C3.51549 7.58215 3.50999 7.58215 3.50448 7.59035C3.28713 7.92132 2.53327 8.16476 2.1811 8.28785C1.54279 8.50941 0.846703 8.61061 0.172628 8.54497C0.0653264 8.52855 0.0405644 8.53129 0.0130512 8.54497C-0.0172134 8.56411 0.0102999 8.58873 0.0433158 8.61608C0.180882 8.70635 0.318448 8.78567 0.461517 8.86226C0.890724 9.08929 1.33644 9.26708 1.80417 9.39564C4.21983 10.0576 6.93814 9.5707 8.75127 7.78182C10.1737 6.37589 10.6744 4.43658 10.6744 2.49453C10.6744 2.41794 10.7652 2.37691 10.8175 2.33588C11.1889 2.05962 11.4861 1.72865 11.764 1.35939C11.8272 1.27733 11.8272 1.20348 11.8272 1.17339C11.8272 1.16792 11.8272 1.16245 11.8272 1.16245C11.8272 1.12962 11.8245 1.13783 11.7777 1.15971Z" fill="#060F16"/>
                    </svg>
                </a>
    
                <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="nofollow">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.97405 2.33046C9.5501 2.33046 9.21094 2.6734 9.21094 3.09379C9.21094 3.51786 9.55378 3.85711 9.97405 3.85711C10.398 3.85711 10.7372 3.51417 10.7372 3.09379C10.7372 2.6734 10.3943 2.33046 9.97405 2.33046Z" fill="#060F16"/>
                        <path d="M6.57815 3.31139C4.80862 3.31139 3.36719 4.75322 3.36719 6.52325C3.36719 8.29328 4.80862 9.73512 6.57815 9.73512C8.34768 9.73512 9.7891 8.29328 9.7891 6.52325C9.7891 4.75322 8.34768 3.31139 6.57815 3.31139ZM6.57815 8.58091C5.4427 8.58091 4.52107 7.65902 4.52107 6.52325C4.52107 5.38748 5.4427 4.46559 6.57815 4.46559C7.71359 4.46559 8.63522 5.38748 8.63522 6.52325C8.63522 7.65902 7.70991 8.58091 6.57815 8.58091Z" fill="#060F16"/>
                        <path d="M9.12414 13.0465H3.91877C1.75847 13.0465 0 11.2875 0 9.12662V3.91979C0 1.75888 1.75847 -9.15527e-05 3.91877 -9.15527e-05H9.12782C11.2881 -9.15527e-05 13.0466 1.75888 13.0466 3.91979V9.13031C13.0429 11.2875 11.2844 13.0465 9.12414 13.0465ZM3.91877 1.22787C2.43679 1.22787 1.22761 2.4337 1.22761 3.91979V9.13031C1.22761 10.6127 2.4331 11.8222 3.91877 11.8222H9.12782C10.6098 11.8222 11.819 10.6164 11.819 9.13031V3.91979C11.819 2.43739 10.6135 1.22787 9.12782 1.22787H3.91877Z" fill="#060F16"/>
                    </svg>

                </a>
    
                <a href="<?php echo esc_url( $youtube ); ?>" target="_blank" rel="nofollow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                        <path d="M15.2074 3.70769C15.2074 1.65883 13.7141 0 11.8698 0H3.33758C1.49324 0 0 1.65883 0 3.70769V8.12027C0 10.1691 1.49324 11.828 3.33758 11.828H11.8698C13.7141 11.828 15.2074 10.1691 15.2074 8.12027V3.70769ZM10.1904 6.24527L6.36214 8.35053C6.21408 8.43981 5.70224 8.32233 5.70224 8.12966V3.81107C5.70224 3.61841 6.21408 3.50093 6.36637 3.59491L10.0297 5.80825C10.182 5.90223 10.3469 6.15129 10.1904 6.24527Z" fill="#060F16"/>
                    </svg>
                </a>
    
                <a href="<?php echo esc_url( $pinterest ); ?>" target="_blank" rel="nofollow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.08894 7.85462C4.07823 7.88866 4.06753 7.91928 4.06039 7.94651C3.59653 9.67871 3.54657 10.0633 3.06843 10.8698C2.84007 11.251 2.58673 11.6151 2.30127 11.9622C2.26916 12.0031 2.24061 12.0507 2.17639 12.0405C2.10502 12.0235 2.10145 11.9656 2.09075 11.9112C2.01582 11.3837 1.973 10.8562 1.99084 10.3253C2.01582 9.63447 2.10502 9.39625 3.03989 5.64258C3.05416 5.58472 3.03989 5.53708 3.01848 5.48603C2.79368 4.9109 2.75086 4.32556 2.94712 3.73001C3.37173 2.45043 4.89178 2.35173 5.15939 3.40671C5.32353 4.06011 4.88821 4.9143 4.55637 6.18028C4.28162 7.22164 5.56617 7.96353 6.66874 7.20462C7.6821 6.50357 8.07817 4.81902 8.00324 3.62791C7.85694 1.24911 5.12371 0.735239 3.38957 1.50095C1.40209 2.37896 0.94893 4.72713 1.84811 5.80253C1.9623 5.93865 2.04793 6.02373 2.01225 6.15986C1.95516 6.37426 1.9052 6.59206 1.84098 6.80646C1.79459 6.9664 1.65543 7.02426 1.48773 6.9596C1.15588 6.83368 0.881134 6.62949 0.656339 6.36745C-0.110822 5.46561 -0.328481 3.68577 0.677748 2.17817C1.79459 0.507228 3.87484 -0.169999 5.76955 0.0341903C8.03535 0.279217 9.4662 1.75618 9.73381 3.43053C9.85513 4.19284 9.76949 6.07478 8.64551 7.40541C7.35383 8.93342 5.2593 9.03552 4.29589 8.09625C4.22096 8.02478 4.1603 7.9397 4.08894 7.85462Z" fill="#060F16"/>
                    </svg>
                </a>
            </div>
        </div>
        <?php
    }



    public function enqueue_scripts() {
        wp_enqueue_script('wc-main-js', get_template_directory_uri() . '/woocommerce/assets/js/main.js', ['jquery'], $this->version, true);
        wp_enqueue_script('toast-js', get_template_directory_uri() . '/woocommerce/assets/js/toast.js', ['jquery'], $this->version, true);
        wp_enqueue_style('wc-custom-style', get_template_directory_uri() . '/woocommerce/assets/css/woo-custom-style.css', $this->version);
    }
    
}