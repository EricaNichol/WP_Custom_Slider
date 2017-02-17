<?php
if (!class_exists('Dr_Slider_Settings')) {

  class Dr_Slider_Settings {
    /**
    * Construct the Setting Object
    **/
      function __construct() {
        add_action('wp_enqueue_scripts', 'enqueue_my_scripts');
        add_action( 'admin_enqueue_scripts', 'plugin_add_admin_styles' );
      }

  }

}

function enqueue_my_scripts() {
 wp_enqueue_script('bbslider', plugin_dir_url(__FILE__) . 'js/jquery.bbslider.js', array('jquery'));
 wp_enqueue_style('bbslider_style', plugin_dir_url(__FILE__) . 'css/dr_slider.css');
 // wp_enqueue_script('banner_script', '../js/jquery.dr_slider.js');

 //  wp_localize_script('banner_script', 'php_vars', $dataPassed);
 // wp_localize_script('banner_script', 'php_vars', $atts);

}

function plugin_add_admin_styles() {
  wp_enqueue_style('admin-meta-boxes', plugin_dir_url(__FILE__) . '/css/admin.css' );
  wp_enqueue_script('admin-meta-boxes', plugin_dir_url(__FILE__) .'js/CMD_attachment.js');
}
