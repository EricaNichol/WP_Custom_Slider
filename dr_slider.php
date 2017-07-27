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
 * Description:       Themeing By CodingByDave, Create Content type and link it to an already built Template Layout.
 *                    The main view for this template is the SLider view because Slider Revolution sucks.
 * Version:           1.0.0
 * Author:            David Lin @CodingByDave
 * Author URI:        www.codingbydave.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dr_slider
 * Domain Path:       /languages
 */


if( !class_exists('Dr_Slider')) {
  class Dr_Slider {

    const PROJECTS      = 'projects';
    const PUBLICATIONS  = 'publications';
    const TALKS         = 'talks';
    const SLIDERS       = 'sliders';

    /** Construct The Plugin Object **/
    public function __construct() {

      // include_once( plugin_dir_path( __FILE__ ) . 'includes/slider_settings.php');

      // Initialize Settings
      include_once( plugin_dir_path( __FILE__ ) . 'settings.php');
        $DR_Slider_settings = new Dr_Slider_settings();

      //Register custom post types
      include_once( plugin_dir_path( __FILE__ ) . 'includes/custom_type.php');
        $projects         = new Custom_Type(self::PROJECTS);
        $publications     = new Custom_Type(self::PUBLICATIONS);
        $talks            = new Custom_Type(self::TALKS);
        $sliders          = new Custom_Type(self::SLIDERS);


    	// if ( $networks ) {
    	// 	include( PLUGIN_PATH . 'meta/networks_meta.php');
    	// }
      // if ( $talks ) {
      //   include( PLUGIN_PATH . 'meta/talks_presentations_meta.php');
      // }
      // if ( $syllabi ) {
      //   include( PLUGIN_PATH . 'meta/syllabi_meta.php');
      // }
      // if ( $products ) {
      //   include( PLUGIN_PATH . 'meta/resources_meta.php');
      // }
      // $custom_price = new Custom_Type(self::PRICE_TYPE);
      // echo $custom_post_type->content_type;
      // echo $custom_price->content_type;

      include_once( plugin_dir_path( __FILE__ ) . 'includes/taxonomy_setup.php');
       $pub_cat          = new Taxonomy_Categories(self::PUBLICATIONS);
       $talk_cat         = new Taxonomy_Categories(self::TALKS);


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
