<?php
/**
 * Functions and definitions
 *
 * @package Mindverse
 */

if ( ! function_exists( '_debug' ) ) {
    function _debug( $data, $die = false, $label = null ) {
        echo '<pre style="
            background: #1e1e1e;
            color: #dcdcdc;
            padding: 15px;
            margin: 15px 0;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.4;
            overflow: auto;
        ">';

        if ( $label ) {
            echo "<strong style='color:#9cdcfe;'>[{$label}]</strong>\n";
        }

        if ( is_array( $data ) || is_object( $data ) ) {
            print_r( $data );
        } else {
            var_dump( $data );
        }

        echo '</pre>';

        if ( $die ) {
            die();
        }
    }
}

require_once get_template_directory() . '/inc/loader.php';

if ( is_admin() ){ 
	require_once get_template_directory() . '/inc/admin/admin-init.php'; 
}

