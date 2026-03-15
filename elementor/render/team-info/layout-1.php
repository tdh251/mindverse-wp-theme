<?php 
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if( !is_singular('team') ) {
    echo '<div class="message">'.esc_html__('This widget only use Single Team!', 'mindverse').'</div>';
    return;
}
$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
$title_tag = $settings['title_tag'] ?: 'h2';
$post_id = get_the_ID();
$featured_image_id = get_post_thumbnail_id($post_id);

$role = mindverse()->get_singular_option('team_role', '');
$email = mindverse()->get_singular_option('team_email', '');
$phone_number = mindverse()->get_singular_option('team_phone_number', '');
$address = mindverse()->get_singular_option('team_address', '');
$socials = mindverse()->get_singular_option('team_socials', [])['social_icon'] ?? [];
?>

<div class="team-info">
    <?php if( $featured_image_id ) : ?>
        <div class="image">
            <?php Elementor_Helpers::the_image_to_size($featured_image_id, $img_w, $img_h, []); ?>
        </div>
    <?php endif; ?>
    <<?php echo esc_attr($title_tag); ?> class="name">
        <?php echo get_the_title($post_id); ?>
    </<?php echo esc_attr($title_tag); ?>>
    <?php if( !empty( $role ) ) : ?>
        <div class="role">
            <?php echo esc_html($role); ?>
        </div>
    <?php endif; ?>
    <div class="contact-list">
        <?php if( !empty( $email ) ) : ?>

            <div class="contact-item contact-email">
                <span class="contact-label">
                    <?php echo esc_html( $settings['email_label'] ); ?>
                </span>
                <a class="contact-info" href="<?php echo esc_url('mailto:'.$email); ?>">
                    <?php echo esc_html($email); ?>
                </a>
            </div>
        <?php endif; ?>
        <?php if( !empty( $phone_number ) ) : ?>
            <div class="contact-item contact-phone">
                <span class="contact-label">
                    <?php echo esc_html( $settings['phone_number_label'] ); ?>
                </span>
                <a class="contact-info" href="<?php echo esc_url('tel:'.$phone_number); ?>">
                    <?php echo esc_html($phone_number); ?>
                </a>
            </div>
        <?php endif; ?>
        <?php if( !empty( $address ) ) : ?>
            <div class="contact-item contact-address">
                <span class="contact-label">
                    <?php echo esc_html( $settings['address_label'] ); ?>
                </span>
                <span class="contact-info">
                    <?php echo esc_html($address); ?>
                </span>
            </div>
        <?php endif; ?>
    </div>
    <?php if( !empty( $socials ) ) : ?>
        <div class="social-list">
            <?php foreach( $socials as $i => $social_icon ) : 
                $social_link = $socials['social_link'][$i] ?? '#';    
            ?>
                <a class="social-item" href="<?php echo esc_url($social_link); ?>">
                    <?php Elementor_Helpers::the_svg_content( $social_icon['url'] ?? '' ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
