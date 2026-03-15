<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['contents']);

$swiper_settings = Elementor_Helpers::get_swiper_settings($settings, [
    'slides_per_view_xs' => $settings['slides_per_view_xs'] === '' ? 1 : $settings['slides_per_view_xs'],
    'slides_per_view_sm' => $settings['slides_per_view_sm'] === '' ? 2 : $settings['slides_per_view_sm'],
    'slides_per_view_md' => $settings['slides_per_view_md'] === '' ? 2 : $settings['slides_per_view_md'],
    'slides_per_view_lg' => $settings['slides_per_view_lg'] === '' ? 2 : $settings['slides_per_view_lg'],
    'slides_per_view_xl' => $settings['slides_per_view_xl'] === '' ? 3 : $settings['slides_per_view_xl'],
    'slides_per_view_xxl' => $settings['slides_per_view_xxl'] === '' ? 3 : $settings['slides_per_view_xxl']
]);

$swiper_settings = json_encode($swiper_settings);

$title_tag = $settings['title_tag'] ?: 'h3';

$swiper_boxshadow = $settings['swiper_boxshadow'] === 'yes' ? ' swiper-boxshadow' : '';

$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
$imgs = $settings['imgs'] ?? [];
?>
<div class="carousel feature-card-carousel" data-layout="1">
    <svg class="feature-card-curve" xmlns="http://www.w3.org/2000/svg" width="843" height="127" viewBox="0 0 843 127" fill="none">
        <path d="M0.320312 55.2734C49.6536 13.9401 192.72 -43.9265 370.32 55.2734C592.32 179.273 762.32 113.273 842.32 55.2734" stroke="black" stroke-dasharray="4 4"/>
    </svg>
    <div class="carousel-container swiper<?php echo esc_attr($swiper_boxshadow); ?>" data-swiper = "<?php echo esc_attr($swiper_settings); ?>">
        <div class="carousel-inner swiper-wrapper">
            <?php foreach($settings['contents'] as $i => $item) : 
                $link_attrs = Elementor_Helpers::get_link_attrs( $item['link'] );
                $img_id = isset( $imgs[$i] ) ? $imgs[$i]['img']['id'] : '';
            ?>
            <div class="carousel-item swiper-slide">
                <div class="feature-card">
                    <div class="feature-card-image">
                        <?php Elementor_Helpers::the_image_to_size($img_id, $img_w, $img_h, []); ?>
                    </div>
                    <div class="feature-card-content">
                        <<?php echo esc_attr($title_tag); ?> class="feature-card-title">
                            <?php pxl_print_html($item['title']); ?>
                        </<?php echo esc_attr($title_tag); ?>>
                        <p class="feature-card-description">
                            <?php echo esc_html($item['desc']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php echo Elementor_Helpers::get_swiper_controls( $settings ); ?>
    </div>
</div>