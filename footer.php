    <?php 
        mindverse()->layout->get_footer();
        $enableSmoothScroll =  (bool) mindverse()->get_option( 'smooth_scroll', '0' );
        if( $enableSmoothScroll ) {
            echo '</div>';
            echo '</div>';
        }
        mindverse()->layout->get_back_to_top();
        mindverse()->layout->get_blur_bottom_site();
        if( class_exists( 'Woocommerce' ) ) { ?>
            <div class="site-toast" id="siteToast" aria-live="polite" aria-atomic="true">
                <div class="site-toast__icon"></div>
                <div class="site-toast__content">
                    <div class="site-toast__title" id="siteToastTitle"></div>
                    <div class="site-toast__message" id="siteToastMessage"></div>
                </div>
                <button type="button" class="site-toast__close" id="siteToastClose" aria-label="Close">
                    ×
                </button>
            </div>
        <?php }
        wp_footer(); 
    ?>
</body>
</html>