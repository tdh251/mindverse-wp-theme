<?php 
$widget_id = $widget->get_id();
?>
<svg class="svg-effect svg-effect-6 svg-original" width="625" height="350" viewBox="0 0 625 350" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" role="img" aria-labelledby="svg-title-<?php echo esc_attr($widget_id); ?>">
  <path d="M571.598 139.512L517.681 139.825C476.19 140.067 442.426 116.308 442.426 74.8155C442.426 33.4928 408.927 -0.00585938 367.605 -0.00585938H0V349.201H367.387C408.83 349.201 442.426 315.605 442.426 274.162C442.426 232.719 476.021 208.932 517.464 208.932L571.598 208.941V139.512Z" fill="url(#paint0_linear_<?php echo esc_attr($widget_id); ?>)"/>
  <path d="M176.578 46.8623H363.264C393.024 46.8623 417.151 70.9881 417.151 100.749C417.151 130.51 441.276 154.635 471.037 154.635H622.112" stroke="#5F6A77" stroke-width="0.980989" stroke-dasharray="4.9 4.9"/>
  <path d="M255.057 116.512H361.792C376.112 116.512 387.721 128.121 387.721 142.44C387.721 156.761 399.329 168.369 413.649 168.369H622.112" stroke="#5F6A77" stroke-width="0.980989" stroke-dasharray="4.9 4.9"/>
  <path d="M178.969 301.041H365.655C395.415 301.041 419.541 276.915 419.541 247.154C419.541 217.393 443.667 193.268 473.428 193.268H624.502" stroke="#5F6A77" stroke-width="0.980989" stroke-dasharray="4.9 4.9"/>
  <path d="M316.307 238.258H360.75C376.965 238.258 390.112 225.111 390.112 208.896C390.112 192.68 403.257 179.534 419.474 179.534H624.502" stroke="#5F6A77" stroke-width="0.980989" stroke-dasharray="4.9 4.9"/>
  <rect x="157" y="275.39" width="49" height="49" fill="url(#pattern0_452_139_<?php echo esc_attr($widget_id); ?>)"/>
  <rect x="301" y="213.39" width="49" height="49" fill="url(#pattern1_452_139_<?php echo esc_attr($widget_id); ?>)"/>
  <rect x="248" y="91.3901" width="49" height="49" fill="url(#pattern2_452_139_<?php echo esc_attr($widget_id); ?>)"/>
  <rect x="164" y="21.3901" width="49" height="49" fill="url(#pattern3_452_139_<?php echo esc_attr($widget_id); ?>)"/>

  <defs>
    <linearGradient id="paint0_linear_<?php echo esc_attr($widget_id); ?>" x1="124.205" y1="174.597" x2="41.7262" y2="174.597" gradientUnits="userSpaceOnUse">
      <stop stop-color="var(--gradient-color, #DEF1ED)" stop-opacity="0.7"/>
      <stop offset="1" stop-color="var(--gradient-color-2, #DEF1ED)" stop-opacity="0"/>
    </linearGradient>

    <?php for($i=0; $i<4; $i++) :
        $img_url = isset($settings['img'.($i + 1)]['url']) ? esc_url($settings['img'.($i + 1)]['url']) : '';
        $pattern_id = 'pattern'.$i.'_452_139_'.$widget_id;
    ?>
    <pattern id="<?php echo esc_attr($pattern_id); ?>" 
         patternContentUnits="objectBoundingBox" 
            width="1" height="1">
        <image width="1" height="1" preserveAspectRatio="xMidYMid slice" 
            xlink:href="<?php echo esc_url($img_url); ?>" />
    </pattern>

    <?php endfor; ?>

  </defs>
</svg>
