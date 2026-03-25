    <?php 
        mindverse()->layout->get_footer();
        $enableSmoothScroll =  (bool) mindverse()->get_option( 'smooth_scroll', '0' );
        if( $enableSmoothScroll ) {
            echo '</div>';
            echo '</div>';
        }
        mindverse()->layout->get_back_to_top();
        mindverse()->layout->get_blur_bottom_site();
        wp_footer(); 
    ?>
</body>
</html>