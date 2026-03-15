<?php
/**
 * @package Case-Themes
 */

if ( post_password_required() ) {
    return;
} ?>
<div id="comment" class="comment-area">
    <?php
    $comment_count = (get_comments_number() < 10 && get_comments_number() != 0) ? '0'.get_comments_number() : get_comments_number();
    if ( have_comments() ) : 
    ?>
        <div class="comment-wrapper">
            <h2 class="comment-title">
                <?php echo esc_html__('Comments', 'mindverse'); ?>
            </h2>
            <ul class="comment-list">
                <?php
                    wp_list_comments( array(
                        'style'      => 'ul',
                        'short_ping' => true,
                        'callback'   => array(mindverse()->customize, 'comment_list'),
                        'max_depth'  => 3
                    ) );
                ?>
            </ul>
            <?php the_comments_navigation(); ?>
        </div>

        <?php if ( !comments_open() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'mindverse' ); ?></p>
        <?php
        endif;

    endif;
    $commenter = wp_get_current_commenter(); 
    $field_class = 'grid-item form-control grid-item-full';
    if( is_login() ) {
        $field_class = 'form-control';
    }
    $args = array(
        'id_form'           => 'commentform',
        'id_submit'         => 'submit',
        'class_submit'      => 'button',
        'title_reply'       => esc_html__( 'Make a Comment', 'mindverse'),
        'title_reply_to'    => esc_html__( 'Write your comment %s', 'mindverse'),
        'cancel_reply_link' => esc_html__( 'Cancel Comment', 'mindverse'),
        
        'submit_button'     => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">
                <span class="button-text">
                    '.esc_html__('Make Comment', 'mindverse').'
                </span>
            </button>',
        'comment_notes_after' => '',
        'comment_notes_before' => '<p class="comment-note">' . esc_html__('Your email address will not be published. Required field are marked*', 'mindverse') . '</p><div class="grid"><div class="grid-inner">',
        
        'fields' => array(
            'author' => '<div class="grid-item form-control">'.
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                        '" size="30" placeholder="'.esc_attr__('Name*', 'mindverse').'"/></div>',

            'email' => '<div class="grid-item form-control">'.
                        '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
                        '" size="30" placeholder="'.esc_attr__('Email Address*', 'mindverse').'"/></div></div></div>',
        ),
        
        'comment_field' => '<div class="grid-item form-control grid-item-full">'.
                        '<textarea id="comment" name="comment" placeholder="'.esc_attr__('Comment Here', 'mindverse').'" aria-required="true"></textarea>'.
                        '</div>',
    );
    comment_form($args); ?>
</div>