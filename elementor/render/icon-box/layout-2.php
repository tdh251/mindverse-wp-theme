<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$title_tag = $settings['title_tag'] ?: 'div';

$title = $item['title'] ?? $settings['title'];
$desc = $item['desc'] ?? $settings['desc'];
$icon = $item['icon'] ?? $settings['icon'];
$link = $item['link'] ?? $settings['link'];
$link_attrs = Elementor_Helpers::get_link_attrs($link);
?>

<div class="icon-box" data-layout="2">
    <div class="icon-box-icon">
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
    <?php if( !empty( $link_attrs ) ) : ?>
        <a <?php pxl_print_html($link_attrs); ?> class="link box-link"></a>
    <?php endif; ?>
</div>