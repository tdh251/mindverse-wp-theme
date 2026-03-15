<?php

$post_id = get_the_ID();

$socials = $settings['social_networks'];

if( empty($socials) ) {
    return;
}

?>
<div class="post-social-share">
    <h4 class="post-social-share-label"><?php echo esc_html($settings['share_text']); ?></h4>
    <ul class="post-social-share-list">
        <?php foreach( $socials as $i => $social ) : 
            switch ( $social ) {
                case 'facebook' : 
                    $share_url = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink( $post_id ) );
                    $label     = 'Facebook';
                    break;
                case 'X' : 
                    $share_url = 'https://twitter.com/intent/tweet?url=' . urlencode( get_permalink( $post_id ) ) . '&text=' . urlencode( get_the_title( $post_id ) );
                    $label     = 'X';
                    break;
                case 'linkedin' : 
                    $share_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink( $post_id ) ) . '&title=' . urlencode( get_the_title( $post_id ) );
                    $label     = 'Linked In';
                    break;
                case 'pinterest' : 
                    $share_url = 'https://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink( $post_id ) ) . '&description=' . urlencode( get_the_title( $post_id ) );
                    $label     = 'Pinterest';   
                    break;
                case 'reddit' : 
                    $share_url = 'https://www.reddit.com/submit?url=' . urlencode( get_permalink( $post_id ) ) . '&title=' . urlencode( get_the_title( $post_id ) );
                    $label     = 'Reddit';   
                    break;  
                case 'tumblr' : 
                    $share_url = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . urlencode( get_permalink( $post_id ) ) . '&title=' . urlencode( get_the_title( $post_id ) );
                    $label     = 'Tumblr';
                    break;
                case 'whatsapp' :
                    $share_url = 'https://api.whatsapp.com/send?text=' . urlencode( get_the_title( $post_id ) . ' ' . get_permalink( $post_id ) );
                    $label     = 'WhatsApp';
                    break;
                case 'telegram' :
                    $share_url = 'https://t.me/share/url?url=' . urlencode( get_permalink( $post_id ) ) . '&text=' . urlencode( get_the_title( $post_id ) );
                    $label     = 'Telegram';    
                    break;
                case 'email' :
                    $share_url = 'mailto:?subject=' . rawurlencode( get_the_title( $post_id ) ) . '&body=' . rawurlencode( get_permalink( $post_id ) );
                    $label     = 'Email';
                    break;
                case 'instagram' :
                    $share_url = $settings['instagram_url']['url'];
                    $label     = 'Instagram';
                    break;
                case 'youtube' :
                    $share_url = $settings['youtube_url']['url'];
                    $label     = 'YouTube';
                    break;
            }  
        ?>
        <a class="button post-social-share-link" href="<?php echo esc_url( $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $label ); ?>" >
            <?php echo esc_html($label); ?>
        </a>
        <?php endforeach; ?>
    </ul>
</div>