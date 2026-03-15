<?php
/**
 * Template Button Third
 */
?>
<span class="button-text" <?php if($is_text_gradient) : ?> data-text="<?php echo esc_attr($text); ?>" <?php endif; ?>>
    <?php if( !$is_text_gradient ) { echo esc_html($text); } ?>
</span>
<span class="button-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
        <g class="main">
            <path d="M3.33398 8H12.6673" stroke="currentcolor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8 3.3335L12.6667 8.00016L8 12.6668" stroke="currentcolor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
        </g>
        <g class="copy">
            <path d="M3.33398 8H12.6673" stroke="currentcolor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8 3.3335L12.6667 8.00016L8 12.6668" stroke="currentcolor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
        </g>
    </svg>
</span>
