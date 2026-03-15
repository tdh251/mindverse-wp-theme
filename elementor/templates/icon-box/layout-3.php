<?php
    use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;
    $title_tag = $settings['title_tag'] ?: 'div';

    $title = ( $item['title'] ?? $settings['title'] ) ?? '';
    $desc = ( $item['desc'] ?? $settings['desc'] ) ?? '';
    $icon = ( $item['icon'] ?? $settings['icon'] ) ?? '';
    $link = $item['link'] ?? $settings['link'];
    $link_attrs = Elementor_Helpers::get_link_attrs($link);
    $is_icon_img = ( $item['is_icon_img'] ?? $settings['is_icon_img'] ) === 'yes';

    $icon_box_gradient_class = !empty( $settings['icon_background_color_b'] ) || 
                !empty( $settings['icon_background_image']['url'] ) ||  
                !empty( $settings['icon_hover_background_color_b'] ) || 
                !empty( $settings['icon_hover_background_image']['url'] ) ? ' box-gradient' : '';
    
?>
<div class="icon-box-icon<?php echo esc_attr( $icon_box_gradient_class ); ?>">
    <?php if( $is_icon_img ) : 
        Elementor_Helpers::the_image_to_size( $item['img']['id'] ?? $settings['img']['id'] , null, null, [] ); ?>
    <?php else : ?>
        <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
    <?php endif; ?>
</div>
<div class="icon-box-content">
    <<?php echo esc_attr($title_tag); ?> class="icon-box-title">
        <?php echo esc_html( $title ); ?>
    </<?php echo esc_attr($title_tag); ?>>
    <p class="icon-box-description">
        <?php echo esc_html( $desc ); ?>
    </p>
</div>
<?php if( !empty( $link_attrs ) ) : ?>
    <a <?php pxl_print_html($link_attrs); ?> class="link box-link"></a>
<?php endif; ?>