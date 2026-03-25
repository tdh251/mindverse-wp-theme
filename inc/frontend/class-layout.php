<?php
namespace Mindverse\Inc\Frontend;

use \Mindverse\Inc\Core\Options;
use \Mindverse\Inc\Utils\Helpers;
use \Mindverse\Inc\Frontend\Breadcrumb;

class Layout {

    private $options;

    public function __construct(Options $options_instance) {
        $this->options = $options_instance;
    }

    public function get_header() {
        $mode   = $this->options->get_singular_option('header_mode', 'inherit');
        $layout = $this->options->get_singular_option('header_layout', 'hide');
        $show_header_404_page = $this->options->get_theme_option('404_page_show_header', '0');

        if( is_404() ) {
            if( !$show_header_404_page ) {
                return;
            }
            $mode = 'builder';
            $layout = $this->options->get_theme_option('404_page_header_layout', '');
        }
        if ($mode === 'inherit') {
            $mode   = $this->options->get_theme_option('header_mode', '');
            $layout = $this->options->get_theme_option('header_layout', '0');
        }

        if ($mode === 'hide') {
            return;
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout) &&
            $layout > 0 &&
            class_exists('Pxltheme_Core') &&
            class_exists('\Elementor\Plugin')
        );

        return Helpers::get_template(
            $is_builder ? 'template-parts/header/builder' : 'template-parts/header/default',
            [
                'layout' => $is_builder ? $layout : 0,
                'type'   => $is_builder ? 'builder' : 'default', 
            ]
        );
    }

    public function the_header() {
        $this->get_header();
    }

    /**
     * Get Sticky Header
     */
    public function get_header_sticky() {
        $mode = $this->options->get_option( 'header_sticky_mode', 'hide' );
        $layout = $this->options->get_option( 'header_sticky_layout', 0 );
        $scroll_direction = $this->options->get_option( 'header_sticky_scroll_direction', 'inherit' );
        if( $mode === 'inherit' ) {
            $mode = $this->options->get_theme_option( 'header_sticky_mode', 'hide' );
            $layout = $this->options->get_theme_option( 'header_sticky_layout', 0 );
            $scroll_direction = $this->options->get_theme_option( 'header_sticky_scroll_direction', 'up' );
        }
        if( $mode === 'hide' || is_404() ) {
            return;
        }
        $is_builder = (
            is_numeric($layout) &&
            $layout > 0 &&
            class_exists('Pxltheme_Core') &&
            class_exists('\Elementor\Plugin')
        );

        return Helpers::get_template(
            'template-parts/header/sticky',
            [
                'layout' => $layout,
                'scroll_direction'   => $scroll_direction, 
            ]
        );
    }
    public function the_header_sticky() {
        $this->get_sticky_header();
    }

    /**
     * Get Mobile Header
     */
    public function get_mobile_header() {
        $layout = $this->options->get_option( 'header_mobile_layout', 0 );
        $logo = $this->options->get_option('header_mobile_logo', ['url'=>   get_template_directory_uri() . '/assets/img/site-logo.webp']  );
        $logo_h = $this->options->get_option('header_mobile_logo_height', '');
        $show_header_404_page = $this->options->get_theme_option('404_page_show_header_mobile', '0');

        if( is_404() ) {
            if( !$show_header_404_page ) {
                return;
            }
            $layout = $this->options->get_theme_option('404_page_header_mobile_layout', '');
        }
        return Helpers::get_template(
            'template-parts/header/mobile',
            [
                'layout' => (int) $layout,
                'logo' => $logo,
                'logo_h'            => $logo_h
            ]
        );
    }
    public function the_mobile_header() {
        $this->get_mobile_header();
    }

    /**
     * Display searchform
     */
    public function the_get_search_form( $template = '' ) {
        if( empty( $template ) ) {
            $template = 'default';
        }
        get_search_form( [ 'template' => $template ] );
    }

    /**
     * Get hero section
     */
    public function get_hero_section() {
        $title = get_the_title( get_queried_object_id() );
        if ( is_home() ) {
            $page = 'blog';
            $title = $this->options->get_option( $page.'_title', 'Blog &' );
            $note = $this->options->get_option( $page.'_note', 'Insights, tips, and ideas to help you design, build, and grow with confidence.' );
        } elseif ( is_single() ) {
            $page = get_post_type();
            $title = $this->options->get_option( $page.'_title', get_the_title() );
            $note = $this->options->get_option( $page.'_note', 'Our team brings together diverse expertise, shared values, and a commitment to delivering excellence in everything we do' );
        } elseif( is_404() ) {
            $page = '404_page';
            $title = $this->options->get_option( $page.'_title', 'Page Not Found' );
            $note = $this->options->get_option( $page.'_note', 'Oops! The page you are looking for does not exist. It might have been moved or deleted.' );
        } elseif ( class_exists( 'Woocommerce' ) && is_shop() ) {
            $page = 'shop';
            $title = $this->options->get_option( $page.'_title', 'Shop' );
            $note = $this->options->get_option( $page.'_note', '' );
        } else {
            $page = 'page';
            $title = $this->options->get_option( $page.'_title', get_the_title() );
            $note = $this->options->get_option( $page.'_note', 'If You have more questions asked us in our support chat. We are ready to answer you 24/7.' );
        }

        
        $mode   = $this->options->get_singular_option( $page.'_hero_mode', 'inherit');
        $layout = $this->options->get_singular_option( $page.'_hero_layout', 'hide');
        if ( $mode === 'inherit' ) {
            $mode   = $this->options->get_theme_option( $page.'_hero_mode', '');
            $layout = $this->options->get_theme_option( $page.'_hero_layout', '');
        }
            
        if ( ($layout === 'hide' && $mode !== 'default') || $mode === 'hide' ) {
            return;
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout) &&
            $layout > 0 &&
            class_exists('Pxltheme_Core') &&
            class_exists('\Elementor\Plugin')
        );

        return Helpers::get_template(
            $is_builder ? 'template-parts/hero-section/builder' : 'template-parts/hero-section/default',
            [
                'layout' => $is_builder ? $layout : 0,
                'type'   => 'builder', 
                'title'  => $title
            ]
        );

    }

    public function the_hero_section() {
        $this->get_hero_section();
    }
    /**
     * Display footer
     */
    public function get_footer() {
        $mode   = $this->options->get_singular_option('footer_mode', 'inherit');
        $layout = $this->options->get_singular_option('footer_layout', 'hide');
        $show_footer_404_page = $this->options->get_theme_option('404_page_show_footer', '0');

        if( is_404() ) {
            if( !$show_footer_404_page ) {
                return;
            }
            $mode = 'builder';
            $layout = $this->options->get_theme_option('404_page_footer_layout', '');
        }
        if ($mode === 'inherit') {
            $mode   = $this->options->get_theme_option('footer_mode', '');
            $layout = $this->options->get_theme_option('footer_layout', 0);
        }

        if ($mode === 'hide') {
            return;
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout) &&
            $layout > 0 &&
            class_exists('Pxltheme_Core') &&
            method_exists('\Elementor\Plugin', 'instance')
        );

        return Helpers::get_template(
            $is_builder ? 'template-parts/footer/builder' : 'template-parts/footer/default',
            [
                'layout' => $is_builder ? $layout : '',
                'type'   => $is_builder ? 'builder' : 'default',
            ]
        );
    }


    /**
     * Display sidebar
     */
    public function get_sidebar() {
        
    }

    /**
     * Display navigation menu
     */
    public function get_nav_menu($args = []) {
        if(has_nav_menu('primary') || (isset($args['menu']) && $args['menu'] !== 'empty')) :
            $menu_icon = '<span class="menu-link-icon menu-link-icon--desktop">';
            if( !empty($args['menu_icon']['value']) ) {
                ob_start();
                \Elementor\Icons_Manager::render_icon( $args['menu_icon'], [ 'aria-hidden' => 'true' ] );
                $menu_icon .= ob_get_clean();
            }else {
                $menu_icon .= '<svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 12 8" fill="none">
                                    <path d="M10.1094 0L5.78125 4.32812L1.4375 0L0 1.4375L5.76562 7.5L11.5469 1.4375L10.1094 0Z" fill="white"/>
                                </svg>';
            }
            $menu_icon .= '</span>';
            wp_nav_menu(
                array_merge(
                    array(
                        'theme_location' => 'primary',
                        'container'      => '',
                        'menu_id'        => '',
                        'menu_class'     => 'header-menu menu-primary',
                        'before'         => '',
                        'after'          => '',
                        'link_before'    => '<span class="menu-link-inner">
                                                <span class="menu-link-text">',
                        'link_after'     => '   </span>
                                                <span class="menu-link-icon menu-link-icon--mobile"><span class="icon-plus"></span>
                                                </span>'.
                                                $menu_icon .
                                            '</span>',
                        'walker'         => class_exists( 'PXL_Mega_Menu_Walker' ) ? new \PXL_Mega_Menu_Walker : '',
                    ),
                    $args,
                )
            );
        else : ?>
            <ul class="header-menu header-menu-empty">
                <li>
                    <a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">
                        <?php echo esc_html__( 'Create New Menu', 'mindverse' ); ?>
                    </a>
                </li>
            </ul>
        <?php endif;
    }

    /**
     * Get Back To Top Button
     */
    public function get_back_to_top() {
        $has_back_to_top = (bool) $this->options->get_theme_option('back_to_top', '');
        if( $has_back_to_top ) { ?>
            <button class="back-to-top">
                <span class="button-icon" data-loop-animation="bongBenhStop">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 12 12" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6 10.375C6.09946 10.375 6.19484 10.3355 6.26516 10.2652C6.33549 10.1948 6.375 10.0995 6.375 10V5.375H5.625V10C5.625 10.207 5.793 10.375 6 10.375Z" fill="black"/>
                        <path d="M2.99967 5.37504C2.92555 5.37497 2.85311 5.35294 2.7915 5.31173C2.7299 5.27052 2.68188 5.21198 2.65353 5.1435C2.62517 5.07502 2.61775 4.99967 2.63219 4.92697C2.64663 4.85427 2.68229 4.78748 2.73467 4.73504L5.73467 1.73504C5.80498 1.66481 5.9003 1.62537 5.99967 1.62537C6.09905 1.62537 6.19436 1.66481 6.26467 1.73504L9.26467 4.73504C9.31705 4.78748 9.35271 4.85427 9.36715 4.92697C9.38159 4.99967 9.37417 5.07502 9.34581 5.1435C9.31746 5.21198 9.26944 5.27052 9.20784 5.31173C9.14623 5.35294 9.07379 5.37497 8.99967 5.37504H2.99967Z" fill="black"/>
                    </svg>
                </span>
            </button>
        <?php
        } 
    }

    /**
     * Get Blur Bottom Site
     */
    public function get_blur_bottom_site() {
        $blur_bottom_site = ( bool ) $this->options->get_theme_option('blur_bottom_site', '0');
        if ( $blur_bottom_site ) {
            ?>
            <div class="blur-bottom-site">
                <div class="blur blur-1"></div>
                <div class="blur blur-2"></div>
                <div class="blur blur-3"></div>
            </div>
            <?php
        }
    }
    public function the_get_blur_bottom_site() {
        pxl_print_html( $this->get_blur_bottom_site() );
    }

    /** Get cursor */
    public function get_cursor() {
        ?>
            <span class="cursor cursor-close"></span>
            <span class="cursor cursor-flower"></span>
        <?php
    }


    /**
     * Get Page Title
     */
    public function get_title( $title = '' ) {
        $page = 'page';
        if ( is_home() ) {
            $page = 'blog';
            $title = $this->options->get_option( $page.'_title', 'Blog & New' );
        } elseif ( is_single() ) {
            $page = get_post_type();
            $title = $this->options->get_option( $page.'_title', 'Single Page' );
        } elseif( is_404() ) {
            $page = '404_page';
            $title = $this->options->get_option( $page.'_title', 'Page Not Found' );
        } elseif( is_archive() ) {
            $title = get_the_archive_title();
            if ( class_exists( 'Woocommerce' ) && is_shop() ) {
                $title = $this->options->get_option( 'shop_title', 'Shop' );
            }
        } elseif ( is_search() ) {
            $title = __( 'Search Results', 'mindverse' );
        } else {
            $page = 'page';
            $title = $this->options->get_option( $page.'_title', get_the_title() );;
        }
        $title = ( empty( $title ) ) ? get_the_title( get_queried_object_id() ) : $title;
        return $title;
    }

    public function get_the_title() {
        echo esc_html( $this->get_title() );
    }

    public function get_note( $title = '' ) {
        $page = 'page';
        $note = '';
        if ( is_home() ) {
            $note = $this->options->get_option( 'blog_note', 'Insights, tips, and ideas to help you design, build, and grow with confidence.' );
        } elseif ( is_single() ) {
            $page = get_post_type();
            $note = $this->options->get_option( $page.'_note', 'Insights, tips, and ideas to help you design, build, and grow with confidence.' );
        } elseif( is_404() ) {
            $page = '404_page';
            $note = $this->options->get_option( '404_page_note', 'Oops! The page you are looking for does not exist. It might have been moved or deleted.' );
        }elseif( class_exists( 'Woocommerce' ) && is_shop() ) {
            $note = $this->options->get_option( 'shop_note', '' );
        }else {
            $page = 'page';
            $note = $this->options->get_option( 'page_note', 'If You have more questions asked us in our support chat. We are ready to answer you 24/7.' );
        }
        return $note;
    }

    /**
     * 
     */
    public function get_breadcrumb( $args = [] ) {
        if ( !class_exists(Breadcrumb::class) ) 
            return;

        $breadcrumb = new Breadcrumb();
        $entries = $breadcrumb->get_entries();

        if (empty($entries)) 
            return;
        
        ob_start();

        echo '<ul class="breadcrumb-path">';

        foreach ($entries as $i => $entry) {
            $entry = wp_parse_args($entry, array(
                'label' => '',
                'url'   => ''
            ));
            $entry_label = $entry['label'];

            if (!empty($_GET['blog_title'])) {
                $blog_title = $_GET['blog_title'];
                $custom_title = explode('_', $blog_title);
                foreach ($custom_title as $index => $value) {
                    $arr_str_b[$index] = $value;
                }
                $str = implode(' ', $arr_str_b);
                $entry_label = $str;
            }

            if (empty($entry_label)) {
                continue;
            }

            echo '<li>';

            if (!empty($entry['url'])) {
                printf(
                '<a class="link breadcrumb-link" href="%1$s">%2$s</a>',
                esc_url($entry['url']),
                esc_attr($entry_label)
                );
            } else {
                if( is_single() ) {
                    $post_type = get_post_type();
                    $breadcrumb = mindverse()->get_theme_option('single_'.$post_type.'_breadcrumb_mode', 'default' );
                    $breadcrumb_label = mindverse()->get_theme_option('single_'.$post_type.'_breadcrumb_label', get_the_title());
                }else {
                    $breadcrumb = mindverse()->get_singular_option( 'breadcrumb_mode', 'default' );
                    $breadcrumb_label = mindverse()->get_singular_option('breadcrumb_label', get_the_title());
                }
                $entry_label = ( $breadcrumb === 'custom' && !empty( $breadcrumb_label ) ) ? $breadcrumb_label : $entry_label;
                // $entries 
                printf('<span class="breadcrumb-current">%s</span>', esc_html( $entry_label ));
            }
            echo '</li>';
            if( $i < count( $entries ) - 1 ) {
                echo '<li class="breadcrumb-separator">.</li>';
            }
            if( $i === count( $entries ) - 2 ) {
                echo '<li>Page</li><li class="breadcrumb-separator">.</li>';
            }
            }
        echo '</ul>';

        $output = ob_get_clean();
        if ($output) {
            echo wp_kses( $output, [
                'ul' => ['class' => true],
                'li' => ['class' => true],
                'a'  => ['href' => true, 'class' => true],
                'span' => ['class' => true],
                'svg' => [
                    'class' => true,
                    'xmlns' => true,
                    'width' => true,
                    'height' => true,
                    'viewBox' => true,
                    'fill' => true,
                ],
                'path' => [
                    'd' => true,
                    'fill' => true,
                ],
            ] );
        }

    }

    /** 
     * Get Pagination
     */
    public function get_current_page($link){
        $parts = parse_url($link);
        if( !isset($parts['query']) ) return $link;
        
        parse_str($parts['query'], $query_vars);
        
        $current_page = 1;
        if(isset($query_vars['page'])){
            $current_page = $query_vars['page'];
        } elseif(isset($query_vars['paged'])){
            $current_page = $query_vars['paged'];
        }
        
        return '#' . $current_page;
    }

    /**
     * Get Pagination HTML
     * * @param WP_Query $query
     * @param bool $ajax
     * @return string
     */
    public function get_pagination( $query = null, $ajax = false ) {
        if ( $ajax ) {
            add_filter( 'paginate_links', array( $this, 'get_current_page' ) );
        }

        if ( empty( $query ) ) {
            $query = $GLOBALS['wp_query'];
        }

        // Luôn trả về chuỗi rỗng thay vì null để tránh lỗi PHP 8.1+
        if ( empty( $query->max_num_pages ) || $query->max_num_pages < 2 ) {
            return '';
        }

        $paged = $query->get( 'paged' );
        if ( ! $paged ) {
            $paged = $query->get( 'page' );
        }
        $paged = $paged ? intval( $paged ) : 1;

        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        unset( $query_args['elementor-preview'], $query_args['ver'] );

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $prev_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"><path d="M6.4092 10.8639C6.57239 10.7073 6.66406 10.4949 6.66406 10.2735C6.66406 10.052 6.57239 9.83964 6.4092 9.68304L2.10028 5.54922L6.4092 1.41541C6.56776 1.2579 6.6555 1.04695 6.65352 0.827986C6.65154 0.609021 6.55999 0.399564 6.39859 0.244727C6.2372 0.0898905 6.01887 0.0020628 5.79063 0.000160217C5.56239 -0.00174236 5.3425 0.0824327 5.17832 0.234555L0.253969 4.9588C0.0907769 5.1154 -0.000898838 5.32778 -0.000898838 5.54922C-0.000898838 5.77066 0.0907769 5.98304 0.253969 6.13965L5.17832 10.8639C5.34157 11.0204 5.56294 11.1084 5.79376 11.1084C6.02458 11.1084 6.24595 11.0204 6.4092 10.8639Z" fill="currentColor"/></svg>';
        $next_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"><path d="M0.254867 10.8639C0.091676 10.7073 0 10.4949 0 10.2735C0 10.052 0.091676 9.83964 0.254867 9.68304L4.56379 5.54922L0.254867 1.41541C0.0963009 1.2579 0.00856014 1.04695 0.0105435 0.827986C0.0125268 0.609021 0.104075 0.399564 0.265471 0.244727C0.426867 0.0898905 0.645196 0.0020628 0.873435 0.000160217C1.10167 -0.00174236 1.32156 0.0824327 1.48574 0.234555L6.41009 4.9588C6.57329 5.1154 6.66496 5.32778 6.66496 5.54922C6.66496 5.77066 6.57329 5.98304 6.41009 6.13965L1.48574 10.8639C1.3225 11.0204 1.10113 11.1084 0.870303 11.1084C0.63948 11.1084 0.418108 11.0204 0.254867 10.8639Z" fill="currentColor"/></svg>';

        $paginate_links_args = array(
            'base'               => $ajax ? '%_%' : $pagenum_link,
            'format'             => $ajax ? '?page=%#%' : 'page/%#%/',
            'total'              => $query->max_num_pages,
            'current'            => $paged,
            'mid_size'           => 1,
            'add_args'           => array_map( 'urlencode', $query_args ),
            'prev_text'          => $prev_svg, 
            'next_text'          => $next_svg, 
            'before_page_number' => '<span>',
            'after_page_number'  => '</span>',
        );

        $links = paginate_links( $paginate_links_args );

        if ( $links ) {
            // Thêm số 0 phía trước các con số (01, 02...)
            $links = preg_replace_callback( '/>(\d+)</', function( $matches ) {
                return '>' . sprintf( '%02d', $matches[1] ) . '<';
            }, $links );

            $ajax_class = $ajax ? ' ajax' : '';
            
            // Khai báo bộ lọc HTML cho phép SVG
            $allowed_html = wp_kses_allowed_html( 'post' );
            $allowed_html['svg']  = array( 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true );
            $allowed_html['path'] = array( 'd' => true, 'fill' => true );

            ob_start();
            ?>
            <div class="grid-pagination<?php echo esc_attr( $ajax_class ); ?>">
                <?php echo wp_kses( $links, $allowed_html ); ?>
            </div>
            <?php
            return ob_get_clean();
        }

        return '';
    }

    /** * Render the Pagination
     */
    public function the_pagination( $query = null, $ajax = false ) {
        $pagination = $this->get_pagination( $query, $ajax );
        
        if ( ! empty( $pagination ) ) {
            // Định nghĩa lại các thẻ được phép để escape "vòng cuối" cho Envato
            $allowed_html = wp_kses_allowed_html( 'post' );
            $allowed_html['svg']  = array(
                'xmlns'   => true,
                'width'   => true,
                'height'  => true,
                'viewbox' => true,
                'fill'    => true,
                'class'   => true,
            );
            $allowed_html['path'] = array(
                'd'    => true,
                'fill' => true,
            );

            echo wp_kses( $pagination, $allowed_html );
        }
    }

    /**
     * Get Loader
     */
    public function get_site_loader() {
        $enable_loader = (bool) $this->options->get_theme_option('site_loader', '');
        if ( ! $enable_loader ) {
            return '';
        }

        $loader_image = $this->options->get_theme_option('loader_logo', []);

        ob_start();
        ?>
        <div id="siteLoader" class="site-loader">
            <div class="loader-logo image">
                <?php
                if ( ! empty( $loader_image['id'] ) ) {
                    echo wp_get_attachment_image( $loader_image['id'], 'full' );
                } elseif ( ! empty( $loader_image['url'] ) ) {
                    echo '<img src="' . esc_url( $loader_image['url'] ) . '" alt="Site Loader Logo">';
                }
                ?>
            </div>
        </div>
        <?php
        $loader_html = ob_get_clean();
        echo wp_kses_post( $loader_html );
    }
}