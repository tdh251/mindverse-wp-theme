<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;


Elementor_Helpers::is_items_empty($settings['items']);

$swiper_settings = Elementor_Helpers::get_swiper_settings($settings, [
    'slides_per_view_xs' => $settings['slides_per_view_xs'] === '' ? 1 : $settings['slides_per_view_xs'],
    'slides_per_view_sm' => $settings['slides_per_view_sm'] === '' ? 1 : $settings['slides_per_view_sm'],
    'slides_per_view_md' => $settings['slides_per_view_md'] === '' ? 2 : $settings['slides_per_view_md'],
    'slides_per_view_lg' => $settings['slides_per_view_lg'] === '' ? 2 : $settings['slides_per_view_lg'],
    'slides_per_view_xl' => $settings['slides_per_view_xl'] === '' ? 3 : $settings['slides_per_view_xl'],
    'slides_per_view_xxl' => $settings['slides_per_view_xxl'] === '' ? 3 : $settings['slides_per_view_xxl']
]);
$swiper_settings = json_encode($swiper_settings);

$title_tag = $settings['title_tag'] ?: 'div';
$swiper_boxshadow = $settings['swiper_boxshadow'] === 'no' ? '' : ' swiper-boxshadow';
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 

$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                    !empty( $settings['box_background_image']['url'] ) ||  
                    !empty( $settings['box_hover_background_color_b'] ) || 
                    !empty( $settings['box_hover_background_image']['url'] ) ? ' box-gradient' : '';
?>
<div class="carousel icon-box-carousel" data-layout="2">
    <div class="carousel-container swiper<?php echo esc_attr($swiper_boxshadow); ?>" data-swiper = "<?php echo esc_attr($swiper_settings); ?>">
        <div class="carousel-inner swiper-wrapper">
            <?php foreach($settings['items'] as $i => $item) : 
                $this->add_render_attribute('item_'.$i, 'class', 'carousel-item swiper-slide'   . $entrance_animation );   
                $link_attrs = Elementor_Helpers::get_link_attrs($item['link']); 
            ?>
            <div <?php pxl_print_html( $this->get_render_attribute_string('item_'.$i) ); ?>>
                <div class="icon-box<?php echo esc_attr( $box_gradient_class ); ?>">
                    <?php Elementor_Helpers::get_template('/elementor/templates/icon-box/layout-2', [
                        'settings' => $settings,
                        'item' => $item,
                    ]); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php echo Elementor_Helpers::get_swiper_controls( $settings ); ?>
    </div>
</div>