<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['items']);

$wrapper_attrs = [
    'class' => 'marquee icon-box-marquee',
    'data-layout' => 2
];

$this->add_render_attribute('custom_wrapper', $wrapper_attrs);
$title_tag = $settings['title_tag'] ?: 'div';
?>

<div <?php pxl_print_html( $this->get_render_attribute_string('custom_wrapper') ); ?>>
    <div class="marquee-inner<?php if((bool) $settings['pause_on_hover']) echo ' pause-on-hover'; ?>" data-direction="<?php echo esc_attr($settings['direction']); ?>">
        <?php for ($i=0; $i<2; $i++) : 
            $list_class = $i === 0 ? 'main' : 'clone';
        ?>
            <div class="marquee-list <?php echo esc_attr($list_class); ?>">
                <?php foreach($settings['items'] as $item) : 
                    $link_attrs = Elementor_Helpers::get_link_attrs($item['link']);
                    $item_tag = !empty($link_attrs) ? 'a' : 'div';
                    $is_icon_img = $item['is_icon_img'] === 'yes';
                ?>
                    <<?php echo esc_attr($item_tag); ?> class="marquee-item" <?php pxl_print_html($link_attrs); ?>>
                        <div class="icon-box">
                            <div class="icon-box-icon">
                                <?php if( $is_icon_img ) : 
                                    $img_w = $item['img_size']['width'] ?? null;
                                    $img_h = $item['img_size']['height'] ?? null;
                                    Elementor_Helpers::the_image_to_size( $item['img']['id'], $img_w, $img_h, [] ); ?>
                                <?php else : ?>
                                    <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                <?php endif; ?>
                            </div>
                            <<?php echo esc_attr($title_tag); ?> class="icon-box-title">
                                <?php echo esc_html($item['title']); ?>
                            </<?php echo esc_attr($title_tag); ?>>
                        </div>
                    </<?php echo esc_attr($item_tag); ?>>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>