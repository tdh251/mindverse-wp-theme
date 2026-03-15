<?php
    $title_tag = ($settings['title_tag'] ?? 'h5') ?: 'h5';
    $title = $item['title'] ?? $settings['title'];
    $desc = $item['desc'] ?? $settings['desc'];
    $icon = $item['icon'] ?? $settings['icon'];
    $link = $item['link'] ?? $settings['link'];
    $link_attrs = Elementor_Helpers::get_link_attrs($link);
?>

<div class="mindverse-icon-box" data-layout="3">
    <div class="mindverse-icon-box-icon">
        <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
    </div>
    <div class="mindverse-icon-box-content">
        <<?php echo esc_attr($title_tag); ?> class="mindverse-icon-box-title">
            <?php echo esc_html($title); ?>
        </<?php echo esc_attr($title_tag); ?>>
        <p class="mindverse-icon-box-desc">
            <?php echo esc_html($desc); ?>
        </p>
    </div>
    <?php if( !empty( $link_attrs ) ) : ?>
        <a <?php pxl_print_html($link_attrs); ?> class="link box-link"></a>
    <?php endif; ?>
</div>