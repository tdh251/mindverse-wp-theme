<?php
    $title_tag = $settings['title_tag'] ?: 'div';

    $title = ( $item['title'] ?? $settings['title'] ) ?? '';
    $desc = ( $item['desc'] ?? $settings['desc'] ) ?? '';
    $icon = ( $item['icon'] ?? $settings['icon'] ) ?? '';

    $icon_box_gradient_class = !empty( $settings['icon_background_color_b'] ) || 
                    !empty( $settings['icon_background_image']['url'] ) ||  
                    !empty( $settings['icon_hover_background_color_b'] ) || 
                    !empty( $settings['icon_hover_background_image']['url'] ) ? ' box-gradient' : '';
?>

<div class="icon-box-icon<?php echo esc_attr( $icon_box_gradient_class ); ?>">
    <span class="icon-main">
        <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
    </span>
    <span class="icon-copy">
        <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
    </span>
</div>
<div class="icon-box-content">
    <<?php echo esc_attr($title_tag); ?> class="icon-box-title">
        <?php echo esc_html( $title ); ?>
    </<?php echo esc_attr($title_tag); ?>>
    <p class="icon-box-description">
        <?php echo esc_html( $desc ); ?>
    </p>
</div>