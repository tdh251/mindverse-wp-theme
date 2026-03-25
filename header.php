<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" type="text/css" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php mindverse()->layout->get_site_loader(); ?>
    <?php 
		$enableSmoothScroll =  (bool) mindverse()->get_option( 'smooth_scroll', '0' );
        if( $enableSmoothScroll ) {
            echo '<div id="smooth-wrapper">';
            echo '<div id="smooth-content">';
            }
            ?>
    <div class="body-overlay"></div>
    <?php
        mindverse()->layout->get_header(); 
        mindverse()->layout->get_header_sticky();
        mindverse()->layout->get_mobile_header();
        mindverse()->layout->get_hero_section();
    ?>