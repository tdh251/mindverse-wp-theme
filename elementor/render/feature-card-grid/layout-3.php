<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['contents']);

$title_tag = $settings['title_tag'] ?: 'h3';
$categories = $settings['categories'] ?? [];
$badges = $settings['badges'] ?? [];
$links = $settings['links'] ?? [];
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 

?>
<div class="grid feature-card-grid" data-layout="3">
    <div class="grid-inner">
        <?php foreach($settings['contents'] as $i => $item) : 
            $link_attrs = Elementor_Helpers::get_link_attrs( $item['link'] );
            $img_id = $imgs[$i]['img']['id'] ?? '';
            $icon = $icons[$i]['icon'] ?? [];
            $category_name = $categories[$i]['name'] ?? '';
            $category_link_attrs = Elementor_Helpers::get_link_attrs( $categories[$i]['link'] ?? [] );
            $category_tag = !empty( $category_link_attrs ) ? 'a' : 'div';
            $badge_str = $badges[$i]['text'] ?? ''; 
            $link2_attrs = Elementor_Helpers::get_link_attrs( $links[$i]['link'] ?? [] );
            $this->add_render_attribute( 'item_wrapper_'.$i, 'class', 'grid-item elementor-repeater-item-'. $item['_id'] . $entrance_animation );
        ?>
        <div <?php pxl_print_html( $this->get_render_attribute_string('item_wrapper_'.$i) ); ?>>
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
</div>