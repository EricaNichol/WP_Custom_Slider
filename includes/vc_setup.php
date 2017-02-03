<?php
if( !class_exists('VC_Setup') ) {
  class VC_Setup {

    public function __construct() {
      add_action( 'vc_before_init', 'dr_slider_integrateWithVC' );

    }

  }
}

/****
  Visual Shortcode Setup
****/
function dr_slider_integrateWithVC() {

  vc_map( array(
    "name" => __( "Dr Slider", "my-text-domain" ),
    "base" => "dr_slider",
    "class" => "",
    "category" => __( "Content", "my-text-domain"),
    // 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
    // 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
    "params" => array(
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => __( "Content Type", "my-text-domain" ),
        "param_name" => "content_type",
        "value" => __( "Feature Slider", "my-text-domain" ),
        "description" => __( "Type in the content type you would like to display", "my-text-domain" )
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => __( "Slider Speed", "my-text-domain" ),
        "param_name" => "slider_speed",
        "value" => __( 1, "my-text-domain" ),
        "description" => __( "The speed you want the slider", "my-text-domain" )
      )
        )
        ) );
    }
