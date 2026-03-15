<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['contents']);

$swiper_settings = Elementor_Helpers::get_swiper_settings($settings, [
    'slides_per_view_xs' => $settings['slides_per_view_xs'] === '' ? 1 : $settings['slides_per_view_xs'],
    'slides_per_view_sm' => $settings['slides_per_view_sm'] === '' ? 1 : $settings['slides_per_view_sm'],
    'slides_per_view_md' => $settings['slides_per_view_md'] === '' ? 2 : $settings['slides_per_view_md'],
    'slides_per_view_lg' => $settings['slides_per_view_lg'] === '' ? 2 : $settings['slides_per_view_lg'],
    'slides_per_view_xl' => $settings['slides_per_view_xl'] === '' ? 3 : $settings['slides_per_view_xl'],
    'slides_per_view_xxl' => $settings['slides_per_view_xxl'] === '' ? 3 : $settings['slides_per_view_xxl']
]);

$swiper_settings = json_encode($swiper_settings);

$title_tag = $settings['title_tag'] ?: 'h4';

$swiper_boxshadow = $settings['swiper_boxshadow'] === 'yes' ? ' swiper-boxshadow' : '';

$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
$imgs = $settings['imgs'] ?? [];
$icons = $settings['icons'] ?? [];
?>
<div class="carousel feature-card-carousel" data-layout="2">
    <div class="carousel-container swiper<?php echo esc_attr($swiper_boxshadow); ?>" data-swiper = "<?php echo esc_attr($swiper_settings); ?>">
        <div class="carousel-inner swiper-wrapper">
            <?php foreach($settings['contents'] as $i => $item) : 
                $link_attrs = Elementor_Helpers::get_link_attrs( $item['link'] );
                $img_id = $imgs[$i]['img']['id'] ?? '';
                $icon = $icons[$i]['icon'] ?? [];
            ?>
            <div class="carousel-item swiper-slide">
                <div class="feature-card">
                    <div class="feature-card-icon">
                        <?php 
                            if( $settings['use_img_icon'] === 'yes' ) {
                                Elementor_Helpers::the_image_to_size($img_id, $img_w, $img_h, []); 
                            }else {
                                \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); 
                            } 
                        ?>
                    </div>
                    <div class="feature-card-content">
                        <<?php echo esc_attr($title_tag); ?> class="feature-card-title">
                            <?php pxl_print_html($item['title']); ?>
                        </<?php echo esc_attr($title_tag); ?>>
                        <p class="feature-card-description">
                            <?php echo esc_html($item['desc']); ?>
                        </p>
                        <a class="link link-underline feature-card-link" <?php pxl_print_html($link_attrs); ?>>
                            <?php echo esc_html($settings['btn_text']); ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php echo Elementor_Helpers::get_swiper_controls( $settings ); ?>
    </div>
</div>