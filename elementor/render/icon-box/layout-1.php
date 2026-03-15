<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$title_tag = ($settings['title_tag'] ?? 'h5') ?: 'h5';
$is_icon_image = $settings['is_icon_image'];

$title = $settings['title'];
$desc = $settings['desc'];
$icon = $settings['icon'];
$link = $item['link'] ?? $settings['link'];
$link_attrs = Elementor_Helpers::get_link_attrs($link);
?>

<div class="icon-box">
    <div class="icon-box-icon">
        <?php if( $is_icon_image ) : 
            $img_w = $settings['img_size']['width'] ?? null;
            $img_h = $settings['img_size']['height'] ?? null;
            Elementor_Helpers::the_image_to_size( $settings['image']['id'], $img_w, $img_h, [] ); ?>
        <?php else : ?>
            <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
        <?php endif; ?>
    </div>
    <div class="icon-box-content">
        <<?php echo esc_attr($title_tag); ?> class="icon-box-title">

            <?php echo esc_html($title); ?>
        </<?php echo esc_attr($title_tag); ?>>
        <?php if( !empty( $desc ) ) : ?>
            <p class="icon-box-description">
                <?php echo esc_html($desc); ?>
            </p>
        <?php endif; ?>
        <?php if( !empty( $link_attrs ) ) : ?>
            <a <?php pxl_print_html($link_attrs); ?> class="link box-link"></a>
        <?php endif; ?>
    </div>
</div>