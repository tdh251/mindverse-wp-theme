<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['items']);

$swiper_settings = Elementor_Helpers::get_swiper_settings($settings, [
    'slides_per_view_xs' => $settings['slides_per_view_xs'] === '' ? 1 : $settings['slides_per_view_xs'],
    'slides_per_view_sm' => $settings['slides_per_view_sm'] === '' ? 2 : $settings['slides_per_view_sm'],
    'slides_per_view_md' => $settings['slides_per_view_md'] === '' ? 2 : $settings['slides_per_view_md'],
    'slides_per_view_lg' => $settings['slides_per_view_lg'] === '' ? 3 : $settings['slides_per_view_lg'],
    'slides_per_view_xl' => $settings['slides_per_view_xl'] === '' ? 3 : $settings['slides_per_view_xl'],
    'slides_per_view_xxl' => $settings['slides_per_view_xxl'] === '' ? 3 : $settings['slides_per_view_xxl']
]);
$swiper_settings = json_encode($swiper_settings);

$img_w = !empty($settings['img_size']['width']) ? $settings['img_size']['width'] : null;
$img_h = !empty($settings['img_size']['height']) ? $settings['img_size']['height'] : null;
$img_attrs = ['class' => 'image'];
if( !empty( $settings['img_hover_style'] ) ) {
    if( $settings['img_hover_style'] === 'distortionTransition' ) {
        wp_enqueue_script('hoverjs');
        $img_attrs['data-displacement'] = content_url(
            '/uploads/default-assets/displacement/' . $settings['img_displacement'] . '.webp'
        );
    }
    if( $settings['img_hover_style'] === 'parallax' ) {
        $img_attrs['data-parallax_settings'] = json_encode([
            'trigger' => $settings['parallax_trigger'],
            'intensity' => $settings['parallax_intensity'] ?: 125,
            'scale'  => $settings['parallax_scale'] ?: 1,
        ]);
    }
    $img_attrs['data-hover'] = $settings['img_hover_style'];
}
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 

?>
<div class="carousel image-carousel">
    <div class="carousel-container swiper" data-swiper = "<?php echo esc_attr($swiper_settings); ?>">
        <div class="carousel-inner swiper-wrapper">
            <?php foreach($settings['items'] as $i => $item) : 
                $item_img_w = !empty($item['item_img_size']['width']) ? $item['item_img_size']['width'] : $img_w;
                $item_img_h = !empty($item['item_img_size']['height']) ? $item['item_img_size']['height'] : $img_h;
                $item_attrs = [
                    'class' => 'carousel-item swiper-slide elementor-repeater-item-' . $item['_id'] . $entrance_animation
                ];

                $link_attrs = Elementor_Helpers::get_link_attrs($item['link']);

                $item_tag = !empty($link_attrs) ? 'a' : 'div';

                $this->add_render_attribute('item_'.$i, $item_attrs);
            ?>
            <div <?php pxl_print_html( $this->get_render_attribute_string( 'item_'.$i ) ); ?>>
                <<?php echo esc_attr($item_tag); ?> class="image-item image" <?php pxl_print_html($link_attrs); ?>>
                    <?php Elementor_Helpers::the_image_to_size($item['img']['id'], $item_img_w, $item_img_h, $img_attrs); ?>
                </<?php echo esc_attr($item_tag); ?>>
            </div>
            <?php endforeach; ?>
        </div>
        <?php echo Elementor_Helpers::get_swiper_controls( $settings ); ?>
    </div>
</div>
<?php