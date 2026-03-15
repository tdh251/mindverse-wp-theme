<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
};

$widget_id = $widget->get_id();
$btn_link_attrs = Elementor_Helpers::get_link_attrs($settings['link']);
$btn_style = !empty($settings['btn_style']) && $settings['btn_style'] !== 'box-border-gradient six-colors' ? 
            ' button-'.$settings['btn_style'] : ' '.$settings['btn_style'];

$btn_gradient_class = !empty( $settings['btn_background_image']['url'] ) || 
        !empty( $settings['btn_hover_background_image']['url'] ) ||
        !empty( $settings['btn_hover_background_color_b'] ) ||
        !empty( $settings['btn_background_color_b'] ) ? ' button-gradient' : '';

$is_text_gradient = ( isset($settings['btn_hover_text_fill_background']) && $settings['btn_hover_text_fill_background']  === 'gradient' );

switch ($settings['btn_style']) {
    case 'cta':
        $btn_template = 'cta';
        break;
    case 'highlight':
        $btn_template = 'highlight';
        break;
    case 'highlight-2':
        $btn_template = 'highlight';
        break;
    default: 
        $btn_template = 'default';
        break;
}

$wrapper_attrs['class'] = 'button'.$btn_style.$btn_gradient_class;

if( !empty( $settings['btn_type'] ) ) {
    $wrapper_attrs['data-type'] = $settings['btn_type'];
}
if( $settings['btn_type'] === 'submit' ) {
    $wrapper_attrs['data-target'] = $settings['cf_id'];
}
if( $settings['btn_type'] === 'anchor' ) {
    $wrapper_attrs['data-target'] = $settings['target'];
    $wrapper_attrs['data-offset'] = $settings['offset'] ?: 0;
}
if( !empty( $settings['btn_hover_style'] ) ) {
    $wrapper_attrs['data-hover'] = $settings['btn_hover_style'];
}
if( $settings['btn_style'] === 'highlight' ) {
    $wrapper_attrs['class'] .= ' box-border-gradient three-colors';
}
$this->add_render_attribute( 'custom_wrapper', $wrapper_attrs);

?>
<a <?php pxl_print_html($btn_link_attrs); pxl_print_html($this->get_render_attribute_string('custom_wrapper')); ?>>
    <?php 
        if( $settings['btn_style'] === 'outline' ) {
            pxl_print_html('<span class="background-overlay"></span>');
        }
        if( $settings['btn_hover_style'] === 'iconReversePosition' ) : ?>
            <span class="button-icon clone">
                <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </span>
        <?php endif; ?>
        <?php
        Elementor_Helpers::get_template('/elementor/templates/button/'.$btn_template, [
            'text' => $settings['text'],
            'icon' => $settings['icon'], 
            'is_text_gradient' => $is_text_gradient,
            'widget_id' => $widget_id,
            'highlight' => $settings['btn_text_highlight'] ?? '',
        ]); 
    ?>
</a>