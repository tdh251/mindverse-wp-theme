<?php
/**
 * Template part for displaying header default.
 *
 * @package Mindverse
 */

$header_logo = mindverse()->get_theme_option('header_logo', ['url'=>   get_template_directory_uri() . '/assets/img/site-logo.webp']);

$logo_html = (!empty($header_logo['url'])) 
            ? sprintf(
                '<a href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
                esc_url( home_url( '/' ) ),
                esc_attr( get_bloginfo( 'name' ) ),
                esc_url( $header_logo['url'] )
            ) : '';

?>
<header id="header-desktop" class="header header-desktop" data-layout="<?php echo esc_attr($type); ?>">
    <div class="header-inner">
        <div class="header-logo">
            <?php echo wp_kses_post($logo_html); ?>
        </div>
        <div class="header-navigation">
            <?php  
            if ( has_nav_menu( 'primary' ) ) {
                mindverse()->layout->get_nav_menu([
                    'menu_class' => 'header-menu navigation-menu',
                ]);
            } else { 
                printf(
                    '<ul class="header-menu header-menu-empty"><li><a href="%1$s">%2$s</a></li></ul>',
                    esc_url( admin_url( 'nav-menus.php' ) ),
                    esc_html__( 'Create New Menu', 'mindverse' )
                );
            }
            ?>
        </div>
    </div>
</header>