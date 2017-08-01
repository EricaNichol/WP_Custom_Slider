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
  $rand = (string)mt_rand(0,1000);

  $array = Array('post');
  foreach ( get_post_types( array('public'=>true, '_builtin'=>false ) ) as $post_type ) {
    $array[] = $post_type;
  }

  vc_map( array(
    "name"              => __( "Dr Slider", "my-text-domain" ),
    "icon"              => plugin_dir_url(__FILE__) . 'images/plugin_logo.png',
    "base"              => "dr_slider",
    "class"             => "",
    "category"          => __( "Content", "my-text-domain"),
    "description"       => __( "CodingByDave plugin with custom built templates"),

    // 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
    // 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
    "params"            => array(
      array(
        "type"          => "dropdown",
        "holder"        => "div",
        "class"         => "",
        "heading"       => __( "Content Type"),
        "param_name"    => "content_type",
        "value"         => $array ,
        "description"   => __( "Select The Content Type" )
      ),
      array(
        "type"          => "dropdown",
        "holder"        => "div",
        "class"         => "",
        "heading"       => __( "List View", "my-text-domain" ),
        "param_name"    => "list_view",
        "value"         => array('Default',
                                 'Publications',
                                //  'Announcements',
                                //  'Basic List',
                                //  'Download List',
                                 'Test',
                                 'Basic Accordion',
                                 'Networks View',
                                 'Category Listview'
                        ),
        "description"   => __( "Pick the list view style to be displayed", "my-text-domain" )
      ),
      array(
        "type"          => "textfield",
        "holder"        => "div",
        "class"         => "",
        "heading"       => __( "Slider Speed", "my-text-domain" ),
        "param_name"    => "slider_speed",
        "value"         => __( 3000, "my-text-domain" ),
        "description"   => __( "The speed you want the slider", "my-text-domain" )
      ),
      array(
        "type"          => "hidden",
        "holder"        => "hidden",
        "class"         => "hidden_input",
        "heading"       => __( "", "my-text-domain" ),
        "param_name"    => "custom_id",
        "value"         => __( $rand, "my-text-domain" ),
        "description"   => __( "The id of the rendered shortcode", "my-text-domain" )
        )
        )
        ) );
      }
