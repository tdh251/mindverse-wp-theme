<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$link_attrs = Elementor_Helpers::get_link_attrs($settings['link']);
$text_tag = !empty($link_attrs) ? 'a' : 'span';
?>

<div class="icon-text" <?php if(!empty($style)) : ?> data-style="<?php echo esc_attr($style); ?>" <?php endif; ?>>
    <span class="icon-text-icon">
        <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
    </span>
    <<?php echo esc_attr($text_tag); ?> class="icon-text-text" <?php pxl_print_html($link_attrs); ?>>
        <?php echo esc_html($settings['text']); ?>
    </<?php echo esc_attr($text_tag); ?>>
</div>