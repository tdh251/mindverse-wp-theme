<?php
/**
 * Search Form Template
 * 
 * This file renders the search form for the Mindverse theme.
 * It provides a customizable search interface for WordPress sites
 * using the Mindverse theme.
 * 
 * @package Mindverse
 * @subpackage Templates
 * @since 1.0.0
 * @version 1.0.0
 */
$template_file = ( $args['template'] ?? 'default' );
$template_path = "template-parts/searchform/{$template_file}";
if ( locate_template( $template_path.'.php' ) ) {
    get_template_part( $template_path, null, [ 'args' => $args ] );
} 
?>