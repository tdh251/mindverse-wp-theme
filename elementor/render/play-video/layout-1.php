<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$link_attrs = Elementor_Helpers::get_link_attrs($settings['link']);
$btn_gradient_class = !empty( $settings['btn_background_image']['url'] ) || 
                        !empty( $settings['btn_hover_background_image']['url'] ) ||
                        !empty( $settings['btn_hover_background_color_b'] ) ||
                        !empty( $settings['btn_background_color_b'] ) ? ' button-gradient' : '';
$btn_attrs = [
    'class' => 'button button-play-video'. $btn_gradient_class . ' wow zoomIn',
    'data-type' => 'play' 
];

if( !empty( $settings['btn_style'] ) ) {
    $btn_attrs['data-style'] = $settings['btn_style'];
}

if( !empty( $settings['btn_hover_style'] ) ) {
    $btn_attrs['data-hover'] = $settings['btn_hover_style'];
}

$this->add_render_attribute('_button', $btn_attrs);
?>
<div class="play-video">
    <div class="button-wrapper">
        <a <?php pxl_print_html($link_attrs); pxl_print_html( $this->get_render_attribute_string('_button') ); ?> >
            <span class="button-icon">
                <?php \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </span>
        </a>
    </div>
</div>
<?php