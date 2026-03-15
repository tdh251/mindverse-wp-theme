<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
$img_attrs = [];
$link_attrs = Elementor_Helpers::get_link_attrs( $settings['link'] );

$wrapper_attrs = [
    'class' => 'image',
];

if( !empty( $settings['html_id'] ) ) {
    $wrapper_attrs['id'] = $settings['html_id'];
}

if( !empty( $settings['img_effects'] ) ) {
    $wrapper_attrs['data-effect'] = $settings['img_effects'];
}

if( !empty( $settings['loop_animation'] ) ) {
    $wrapper_attrs['data-loop-animation'] = $settings['loop_animation'];
}

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

// if( $settings['enable_move_on'] === 'yes' ) {
//     $img_attrs['class'] = 'image-move-on';
//     // $setting_attrs = [];
//     // foreach( $settings['move_on_settings'] as $setting ) {
//         $setting_attrs = [
//             'target' => $settings['target'],
//             // 'scale' => $setting['scale'],
//             // 'flipX' => (bool) $setting['flipX'], 
//         ];
//     // }
//     $img_attrs['data-settings'] = json_encode( $setting_attrs );

// }

$this->add_render_attribute('custom_wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('custom_wrapper') ); ?>>
    <?php if( $settings['img_effects'] === 'random-transition' ) : ?>
        <span class="image-random-transition">
            <?php if( !empty( $link_attrs ) ) : ?> <a <?php pxl_print_html($link_attrs); ?>> <?php endif; ?>
                <?php Elementor_Helpers::the_image_to_size($settings['img']['id'], $img_w, $img_h, $img_attrs); ?>
            <?php if( !empty( $link_attrs ) ) : ?> </a> <?php endif; ?>
            <?php if( $settings['show_overlay'] === 'yes' ) : ?>
                <div class="overlay"></div>
            <?php endif; ?>
        </span>
        <?php foreach( $settings['imgs'] as $img ) :
            $item_link_attrs = Elementor_Helpers::get_link_attrs( $img['item_link'] );
        ?>
            <span class="image-random-transition">
                <?php if( !empty( $item_link_attrs ) ) : ?> <a <?php pxl_print_html($item_link_attrs); ?>> <?php endif; ?>
                    <?php Elementor_Helpers::the_image_to_size($img['item_img']['id'], null, null, []); ?>
                <?php if( !empty( $item_link_attrs ) ) : ?> </a> <?php endif; ?>
                <?php if( $settings['show_overlay'] === 'yes' ) : ?>
                    <div class="overlay"></div>
                <?php endif; ?>
            </span>
        <?php endforeach; ?>
    <?php else: ?>
        <?php if( !empty( $link_attrs ) ) : ?> <a <?php pxl_print_html($link_attrs); ?>> <?php endif; ?>
            <?php Elementor_Helpers::the_image_to_size($settings['img']['id'], $img_w, $img_h, $img_attrs); ?>
            <?php if( $settings['show_overlay'] === 'yes' ) : ?>
                <div class="overlay"></div>
            <?php endif; ?>
        <?php if( !empty( $link_attrs ) ) : ?> </a> <?php endif; ?>
    <?php endif; ?>
</div>