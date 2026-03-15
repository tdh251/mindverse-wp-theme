<?php 
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$wrapper_attrs = [
    'class' => 'tabs',
    'data-layout' => 1,
];
if( !empty( $settings['tab_key'] ) ) {
    $wrapper_attrs['data-key'] = $settings['tab_key'];
}
$this->add_render_attribute('custom_wrapper', $wrapper_attrs);

?>

<div <?php pxl_print_html( $this->get_render_attribute_string('custom_wrapper') ); ?>>
    <?php if( $settings['input_mode'] === 'btn' ) : ?>
            <div class="tab-buttons">
                <?php foreach( $settings['btns'] as $i => $btn ) : 
                    $active_class = ( $i + 1 === $settings['item_active'] ) ? ' is-active' : '';    
                ?>
                    <button class="button tab-button<?php echo esc_attr($active_class); ?>" data-hover="transition-fill-animation" data-hover_direction="vertical">
                        <?php 
                            if( !empty( $active_class ) ) {
                                echo '<span class="direction-item"></span>';
                            }
                        ?>
                        <span class="button-icon">
                            <?php \Elementor\Icons_Manager::render_icon( $btn['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                        <span class="button-text"><?php echo esc_html($btn['btn_text']); ?></span>
                        <span class="action-icon">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['action_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                    </button>
                <?php endforeach; ?>
            </div>
    <?php elseif( $settings['input_mode'] === 'content' ) : 
        $title_tag = $settings['title_tag'] ?: 'div';
    ?>
        <div class="tab-contents">
            <?php foreach( $settings['contents'] as $i => $content ) : ?>
                <div class="tab-content">
                    <<?php echo esc_attr($title_tag); ?> class="content-title">
                        <?php echo esc_html($content['title']); ?>
                    </<?php echo esc_attr($title_tag); ?>>
                    <p class="content-description">
                        <?php echo esc_html($content['desc']); ?>
                    </p>
                    <ul class="content-features feature-list">
                        <?php 
                            $features = explode('|', $content['features']);
                            foreach( $features as $feature ) : ?>
                                <li class="list-item">
                                    <span class="item-icon icon">
                                        <?php \Elementor\Icons_Manager::render_icon( $settings['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
                                    <?php echo esc_html($feature); ?>
                                </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif( $settings['input_mode'] === 'featured' ) : 
        $img_w = $settings['img_size']['width'] ?: null;
        $img_h = $settings['img_size']['height'] ?: null;
    ?>
        <div class="tab-featured-images">
            <?php foreach( $settings['imgs'] as $i => $img ) : ?>
                <?php Elementor_Helpers::the_image_to_size($img['img']['id'], $img_w, $img_h, [
                    'class' => 'tab-featured-image image'
                ]); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
