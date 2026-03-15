<?php 
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;


$text = $settings['text'] ?? '';

$text_style = !empty($settings['text_style']) ? ' '.$settings['text_style'] : '';

$wrapper_attrs = [
    'class' => 'text-editor'. $text_style
];

if( !empty( $settings['text_animation'] )  ) {
    $wrapper_attrs['data-text-animation'] = $this->get_text_animation_settings();
}
if( $settings['auto_get_note_page'] === 'yes' ) {
    $text = mindverse()->layout->get_note();
}else {
    $text = Elementor_Helpers::render_highlight_html( $settings, $text );
}

$this->add_render_attribute('custom_wrapper', $wrapper_attrs);

?>

<div <?php pxl_print_html( $this->get_render_attribute_string('custom_wrapper') ); ?>>
    <?php pxl_print_html($text); ?>
</div>