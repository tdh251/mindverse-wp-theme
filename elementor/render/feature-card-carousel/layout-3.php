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


$swiper_boxshadow = $settings['swiper_boxshadow'] === 'yes' ? ' swiper-boxshadow' : '';
$title_tag = $settings['title_tag'] ?: 'h3';
$categories = $settings['categories'] ?? [];
$badges = $settings['badges'] ?? [];
$links = $settings['links'] ?? [];
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
                    <?php if(!empty( $category_name )) : ?>
                        <<?php echo esc_attr($category_tag); ?> class="feature-card-category" <?php pxl_print_html($category_link_attrs); ?>>
                            <?php echo esc_html($category_name); ?>
                        </<?php echo esc_attr($category_tag); ?>>
                    <?php endif; ?>
                    <div class="feature-card-content">
                        <<?php echo esc_attr($title_tag); ?> class="feature-card-title">
                            <?php if( !empty( $link_attrs ) ) : ?>
                                <a <?php pxl_print_html($link_attrs); ?>>
                            <?php endif; ?>
                                <?php pxl_print_html($item['title']); ?>
                            <?php if( !empty( $link_attrs ) ) : ?>
                                </a>
                            <?php endif; ?>
                        </<?php echo esc_attr($title_tag); ?>>
                        <p class="feature-card-description">
                            <?php echo esc_html($item['desc']); ?>
                        </p>
                    </div>
                    <?php if( !empty( $badge_str ) ) : 
                        $badges_style = $settings['badges_style'] ?? [];
                    ?>
                        <div class="feature-card-badges">
                            <?php foreach( explode('|', $badge_str) as $j => $badge ) : 
                                $badge_style_class = ( isset( $badges_style[$j] ) ) ? ' elementor-repeater-item-'.$badges_style[$j]['_id'] : '';
                            ?>
                                <span class="badge<?php echo esc_attr($badge_style_class); ?>"><?php echo esc_html($badge); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="feature-card-links">
                        <a <?php pxl_print_html($link_attrs); ?> class="link feature-card-link"><?php echo esc_html($settings['btn_text']); ?></a>
                        <?php if( !empty( $link2_attrs ) ) : ?>
                            <a <?php pxl_print_html($link2_attrs); ?> class="link link-2">
                                <?php echo esc_html($settings['link2_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php echo Elementor_Helpers::get_swiper_controls( $settings ); ?>
    </div>
</div>