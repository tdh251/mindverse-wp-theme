<?php

$nav_menu = $settings['nav_menu'] ?? '';

$menu_settings = [
    'menu_hover_style' => $settings['main_menu_hover_style'] ?? '',
    'submenu_hover_style' => $settings['submenu_hover_style'] ?? '',
    'menu_hover_direction' => $settings['menu_hover_direction'] ?? 'horizontal',
];


add_filter('nav_menu_link_attributes', function($attrs, $item, $args, $depth) use ($menu_settings) {
    if ($depth === 0) {
        $attrs['data-hover'] = $menu_settings['menu_hover_style'];
        // rotation fill animation
        if( in_array( $menu_settings['menu_hover_style'], [ 'rotation-fill-animation', 'transition-fill-animation' ] ) ) {
            $attrs['data-hover_direction'] = $menu_settings['menu_hover_direction'];
        }

    }else {
        $attrs['data-hover'] = $menu_settings['submenu_hover_style'];
    }
    return $attrs;
}, 10, 4);

mindverse()->layout->get_nav_menu([
    'menu' =>  wp_get_nav_menu_object($nav_menu),
    'menu_class' => 'header-menu navigation-menu',
    'menu_icon'  => $settings['menu_icon'],
]);