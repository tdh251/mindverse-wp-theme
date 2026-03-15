<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$id1 = 'img_1_' . $widget->get_id();
$id2 = 'img_2_' . $widget->get_id();
$id3 = 'img_3_' . $widget->get_id();
$id4 = 'img_4_' . $widget->get_id();
$ids = [$id1, $id2, $id3, $id4];

$img_urls = [];
for ($i = 1; $i <= 4; $i++) {
    $img_id = $settings['img' . $i]['id'] ?? 0;
    $img_urls[$i] = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
}
?>

<svg class="svg-effect svg-effect-4 svg-origintal" width="385" height="145" viewBox="0 0 385 145" fill="none" xmlns="http://www.w3.org/2000/svg">

  <defs>
    <linearGradient id="paint0_linear_<?php echo esc_attr($widget->get_id()); ?>" x1="184" y1="82.33" x2="201" y2="82.33" gradientUnits="userSpaceOnUse">
      <stop stop-color="#00FFAE"/>
      <stop offset="1" stop-color="#00C0FF"/>
    </linearGradient>

    <clipPath id="clip0_<?php echo esc_attr($widget->get_id()); ?>">
      <rect width="385" height="145" fill="white"/>
    </clipPath>

    <?php for ($i = 0; $i < 4; $i++) : 
      $pid = esc_attr($ids[$i]);
      $url = $img_urls[$i + 1] ? esc_url($img_urls[$i + 1]) : '';
    ?>
      <?php if ($url) : ?>
        <pattern 
          id="pattern<?php echo esc_attr($i); ?>_<?php echo esc_attr($pid); ?>" 
          patternUnits="objectBoundingBox" 
          width="1"
          height="1" 
          viewBox="0 0 1 1" 
        >
          <image 
            href="<?php echo esc_url( $url ); ?>" 
            x="0" y="0" 
            width="1" 
            height="1" 
            preserveAspectRatio="xMidYMid slice" 
          />
        </pattern>
      <?php else: ?>
        <pattern 
          id="pattern<?php echo esc_attr($i); ?>_<?php echo esc_attr($pid); ?>" 
          patternUnits="objectBoundingBox" 
          width="1" 
          height="1"
        >
          <rect width="1" height="1" fill="#cccccc" />
        </pattern>
      <?php endif; ?>
    <?php endfor; ?>
  </defs>

  <g clip-path="url(#clip0_<?php echo esc_attr($widget->get_id()); ?>)">
    <path d="M-6.5 78.83H51L64.5 86.83H191.5" stroke="white" stroke-dasharray="6 6"/>
    <path d="M390.5 95.33H328L313.5 86.83H195.5" stroke="white" stroke-dasharray="6 6"/>
    <path d="M21.5 69.83H74.5L92 79.83H190.5" stroke="white" stroke-dasharray="6 6"/>
    <path d="M386.5 127.83H292L250.5 87.83" stroke="white" stroke-dasharray="6 6"/>
    <path d="M387 42.83H315.5L279.5 79.83H193.5" stroke="white" stroke-dasharray="6 6"/>
    <path d="M-5.5 16.83H59L123 80.33" stroke="white" stroke-dasharray="6 6"/>
    <path d="M-1.5 128.33H59L101.5 86.33" stroke="white" stroke-dasharray="6 6"/>
    <circle cx="192" cy="82.83" r="33" fill="#1E316D"/>
    <circle cx="192" cy="82.83" r="21" fill="#14214A"/>
    <circle cx="192.5" cy="82.33" r="8.5" fill="url(#paint0_linear_<?php echo esc_attr($widget->get_id()); ?>)"/>
  </g>

  <rect class="wow zoomIn" x="46" y="0" width="37" height="37" rx="10" fill="url(#pattern0_<?php echo esc_attr($id1); ?>)"/>
  <rect class="wow zoomIn" data-wow-delay="100ms" x="16" y="108" width="37" height="37" rx="10" fill="url(#pattern1_<?php echo esc_attr($id2); ?>)"/>
  <rect class="wow zoomIn" data-wow-delay="200ms" x="299" y="26" width="37" height="37" rx="10" fill="url(#pattern2_<?php echo esc_attr($id3); ?>)"/>
  <rect class="wow zoomIn" data-wow-delay="300ms" x="329" y="108" width="37" height="37" rx="10" fill="url(#pattern3_<?php echo esc_attr($id4); ?>)"/>

</svg>