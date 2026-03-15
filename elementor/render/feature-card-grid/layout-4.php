<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['contents']);

$title_tag = $settings['title_tag'] ?: 'h5';

$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
$imgs = $settings['imgs'] ?? [];
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 

?>
<div class="grid feature-card-grid" data-layout="4">
    <div class="grid-inner">
        <?php foreach($settings['contents'] as $i => $item) : 
            $link_attrs = Elementor_Helpers::get_link_attrs( $item['link'] );
            $img_id = isset( $imgs[$i] ) ? $imgs[$i]['img']['id'] : '';
            $this->add_render_attribute( 'item_wrapper_'.$i, 'class', 'grid-item elementor-repeater-item-'. $item['_id'] . $entrance_animation );
        ?>
        <div <?php pxl_print_html( $this->get_render_attribute_string('item_wrapper_'.$i) ); ?>>
            <div class="feature-card">
                <div class="feature-card-image">
                    <?php Elementor_Helpers::the_image_to_size($img_id, $img_w, $img_h, []); ?>
                </div>
                <div class="feature-card-content">
                    <<?php echo esc_attr($title_tag); ?> class="feature-card-title">
                        <?php pxl_print_html($item['title']); ?>
                    </<?php echo esc_attr($title_tag); ?>>
                    <p class="feature-card-description">
                        <?php echo esc_html($item['desc']); ?>
                    </p>
                    <a class="link link-underline text-underline feature-card-link" <?php pxl_print_html($link_attrs); ?>>
                        <?php echo esc_html( $settings['btn_text'] ); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>