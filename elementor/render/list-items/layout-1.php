<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['items']);

$divider = ( (bool) $settings['divider'] ) ? ' has-divider' : '';
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
?>
    <ul class="list<?php echo esc_attr($divider); ?>">
        <?php foreach($settings['items'] as $item) : 
            $icon = $item['item_icon']['value'] ? $item['item_icon'] : $settings['icon'];    
            $elementor_item_class = ' elementor-repeater-item-' . $item['_id'] . $entrance_animation;
        ?>
        <li class="item<?php echo esc_attr($elementor_item_class); ?>">
            <?php if($icon['value']) : ?>
                <span class="item-icon">
                    <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            <?php endif; ?>
            <span class="item-text">
                <?php pxl_print_html($item['text']); ?>
            </span>
        </li>
        <?php endforeach; ?>
    </ul>
<?php