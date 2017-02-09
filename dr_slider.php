<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.codingbydave.com
 * @since             1.0.0
 * @package           Dr_slider
 *
 * @wordpress-plugin
 * Plugin Name:       DR Slider
 * Plugin URI:        www.codingbydave.com
 * Description:       Minimalist Slider with Title, Body, Button
 * Version:           1.0.0
 * Author:            David Lin / Richard Hung
 * Author URI:        www.codingbydave.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dr_slider
 * Domain Path:       /languages
 */


if( !class_exists('Dr_Slider')) {
  class Dr_Slider {
    // const FEATURE_SLIDER = 'publications';
    const PUBLICATIONS = 'publications';
    /** Construct The Plugin Object **/
    public function __construct() {

      // include_once( plugin_dir_path( __FILE__ ) . 'includes/slider_settings.php');

      //Initialize Settings
      // include_once( plugin_dir_path( __FILE__ ) . 'settings.php');
      // $DR_Slider_settings = new Dr_Slider_settings();

      //Register custom post types
      include_once( plugin_dir_path( __FILE__ ) . 'includes/custom_type.php');
      $custom_post_type = new Custom_Type(self::PUBLICATIONS);
      // $custom_price = new Custom_Type(self::PRICE_TYPE);
      // echo $custom_post_type->content_type;
      // echo $custom_price->content_type;

      //Add Shortcode params to Visual Composer
      include_once( plugin_dir_path( __FILE__ ) . 'includes/vc_setup.php');
      $vc_setup = new VC_Setup();

      include_once( plugin_dir_path( __FILE__ ) . 'includes/query_type.php');
      $query_type = new Query_Type();

    }

    /** Activate the plugin **/
    public static function activate() {



    }

    /** Deactivate the plugin **/
    public static function deactivate() {



    }
  }
}//end if (!class_exists('Dr_SLider'))

if( class_exists('Dr_Slider')) {
  register_activation_hook(__FILE__, array('Dr_Slider', 'activate'));
  register_deactivation_hook(__FILE__, array('Dr_Slider', 'deactivate'));

  $dr_slider = new Dr_Slider();
}
