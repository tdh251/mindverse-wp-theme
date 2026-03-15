<?php
$wrapper_attrs = [
    'class' => 'shape '.$settings['shape_style'],
];
$this->add_render_attribute('custom_wrapper', $wrapper_attrs);
?>
<div <?php pxl_print_html( $this->get_render_attribute_string('custom_wrapper') ); ?>></div>