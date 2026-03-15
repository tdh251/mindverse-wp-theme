<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['items']);
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
?>
<ul class="links">
    <?php foreach($settings['items'] as $i => $item) : 
        $link_attrs = Elementor_Helpers::get_link_attrs($item['link']);
        $item_wrapper_attrs = [
            'class' => 'link-wrapper',
        ];
        if( !empty( $settings['link_hover_style'] ) ) {
            $item_wrapper_attrs['data-hover'] = $settings['link_hover_style'];
            if( $settings['link_hover_style'] === 'text-flip-3d' ) {
                $item_wrapper_attrs['data-text'] = $item['text'];
            }
        }
        $this->add_render_attribute( 'link_wrapper_'.$i, $item_wrapper_attrs );
    ?>
    <li class="<?php echo esc_attr($entrance_animation) ?>">
        <a class="link-item" <?php pxl_print_html($link_attrs); ?> <?php pxl_print_html($this->get_render_attribute_string('link_wrapper_'.$i)); ?>>
            <span><?php pxl_print_html($item['text']); ?></span>
        </a>
    </li>
    <?php endforeach; ?>
</ul>