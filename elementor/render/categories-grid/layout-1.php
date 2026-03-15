<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['items']);

$img_width = $settings['img_size']['width'] ?: null;
$img_height = $settings['img_size']['height'] ?: null;
$title_tag = $settings['title_tag'] ?: 'h5';
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                    !empty( $settings['box_background_image']['url'] ) ||  
                    !empty( $settings['box_hover_background_color_b'] ) || 
                    !empty( $settings['box_hover_background_image']['url'] ) ? ' box-gradient' : '';
$img_attrs = [];
if( !empty( $settings['img_hover_style'] ) ) {
    $img_attrs['data-hover'] = $settings['img_hover_style'];

    if( $settings['img_hover_style'] === 'parallax' ) {
        $img_attrs['data-parallax_settings'] = json_encode([
            'trigger' => $settings['parallax_trigger'],
            'intensity' => $settings['parallax_intensity'] ?: 125,
            'scale'  => $settings['parallax_scale'] ?: 1,
        ]);
    }

    if( ( $settings['img_hover_style'] === 'flowmapDeformation' || $settings['img_hover_style'] === 'flowmapDeformation2' ) && !empty( $settings['hover_trigger'] ) ) {
        $img_attrs['data-hover_trigger'] = $settings['hover_trigger'];
    }
}
?>
<div class="grid categories-grid">
    <div class="grid-inner">
        <?php foreach( $settings['items'] as $item ) : 
            $link_attrs = Elementor_Helpers::get_link_attrs($item['link']);    
        ?>
            <div class="grid-item<?php echo esc_attr(' elementor-repeater-item-'.$item['_id'] . $entrance_animation); ?>">
                <div class="category<?php echo esc_attr($box_gradient_class); ?>">
                    <div class="overlay"></div>
                    <div class="category-thumbnail image">
                        <a <?php pxl_print_html($link_attrs); ?>>
                            <?php Elementor_Helpers::the_image_to_size($item['thumbnail']['id'], $img_width, $img_height, $img_attrs); ?>
                        </a>
                    </div>
                    <div class="category-content">
                        <<?php echo esc_attr($title_tag); ?> class="category-title">
                            <a <?php pxl_print_html($link_attrs); ?>>
                                <?php echo esc_html($item['title']); ?>
                            </a>
                        </<?php echo esc_attr($title_tag); ?>>
                        <p class="category-description">
                            <?php echo esc_html($item['desc']); ?>
                        </p>
                        <div class="category-meta">
                            <?php echo esc_html($item['meta']); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>