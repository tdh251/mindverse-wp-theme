<svg class="svg-effect svg-effect-1 svg-origintal" width="312" height="3" viewBox="0 0 312 3" fill="none" xmlns="http://www.w3.org/2000/svg" data-animation_duration="<?php echo esc_attr($settings['anim_duration'] ?: 5); ?>">
  <rect 
    class="moving-highlight" 
    x="0" 
    width="42" 
    height="3" 
    rx="1.5" 
    fill="url(#paint0_linear_<?php echo esc_attr($widget->get_id()); ?>)" 
  />
  <path 
    class="line" 
    d="M312 1.5 L-48 1.5" 
    stroke="var(--mv-line-color)" 
    stroke-width="3" 
    fill="none"
  />
  <defs>
    <linearGradient id="paint0_linear_<?php echo esc_attr($widget->get_id()); ?>" x1="0" y1="1.5" x2="42" y2="1.5" gradientUnits="userSpaceOnUse">
      <stop stop-color="var(--mv-highlight-color)"/>
      <stop offset="1" stop-opacity="0"/>
    </linearGradient>
  </defs>
</svg>
