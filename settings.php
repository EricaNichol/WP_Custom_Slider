<?php
if (!class_exists('Dr_Slider_Settings')) {

  class Dr_Slider_Settings {
    /**
    * Construct the Setting Object
    **/
      function __construct() {
        add_action('wp_enqueue_scripts', 'enqueue_my_scripts');
      }

  }

}

function enqueue_my_scripts() {
 wp_enqueue_script('bbslider', plugin_dir_url(__FILE__) . 'js/jquery.bbslider.js', array('jquery'));
 wp_enqueue_style('bbslider_style', plugin_dir_url(__FILE__) . 'css/dr_slider.css');
 //  wp_localize_script('banner_script', 'php_vars', $dataPassed);
 // wp_localize_script('banner_script', 'php_vars', $atts);

}
