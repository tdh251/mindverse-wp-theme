<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['items']);

$box_gradient_class = !empty( $settings['icon_background_color_b'] ) || 
                    !empty( $settings['icon_background_image'] ) ||  
                    !empty( $settings['icon_hover_background_color_b'] ) || 
                    !empty( $settings['icon_hover_background_image'] ) ? ' box-gradient' : '';
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 

?>
<div class="social-icons">
    <?php foreach ( $settings['items'] as $item ) : 
        $link_attrs = Elementor_Helpers::get_link_attrs( $item['link'] );
    ?>
        <a class="social-item<?php echo esc_attr(' elementor-repeater-item-' . $item['_id'] . $box_gradient_class . $entrance_animation ); ?>" <?php pxl_print_html( $link_attrs ); ?>>
            <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
        </a>
    <?php endforeach; ?>
</div>