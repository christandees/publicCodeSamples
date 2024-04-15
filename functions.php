<?php
/*
 * Simple Child Theme genearted by Ultimatum Framework
*/

$theme = array(
	'theme_name' => 'Wilden Theme',
	'theme_slug' =>'go-re-starter',
);
require_once(get_template_directory() . '/wonderfoundry/wonderworks.php');

add_theme_support('post-thumbnails');

wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css');

function init_scripts(){
    global $current_user, $post;

    if (!is_admin()){
        wp_register_style('fontawesome-css', get_stylesheet_directory_uri() . '/css/all.css', array());
        wp_enqueue_style('fontawesome-css');

        wp_register_script('jqs-scripts', get_stylesheet_directory_uri() . '/js/nouislider.min.js', '', null,'');
        wp_enqueue_script('jqs-scripts');

        wp_register_script('wnum-scripts', get_stylesheet_directory_uri() . '/js/wNumb.js', '', null,'');
        wp_enqueue_script('wnum-scripts');

        wp_register_script('print-preview', get_stylesheet_directory_uri() . '/js/jquery.print-preview.js', array(), '', null, '');
        wp_enqueue_script('print-preview');

        wp_register_script('site-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array(), '2.1', '');
        wp_enqueue_script('site-scripts');

        wp_register_script('react-lot-map', get_stylesheet_directory_uri() . '/react-lot-map/dist/bundle.js', array(), '0.0.1', '');
        wp_enqueue_script('react-lot-map', '', [], false, true);
    }
}
add_action('wp_enqueue_scripts', 'init_scripts');

/**
 * Because post types are registered via Ultimatum we have to 
 * add REST API support.
 */
add_action('init', 'my_custom_post_type_rest_support', 25 );
function my_custom_post_type_rest_support() {
  global $wp_post_types;

  // It is expensive to map over every post type, so make an array
  // of the ones we need
  $custom_post_types = array('listings','lots','neighbourhoods','units','homeplans');
  foreach ( $custom_post_types as $post_type_name ) {
    if( isset( $wp_post_types[ $post_type_name ] ) ) {
        $wp_post_types[$post_type_name]->show_in_rest = true;
  }

    // Optionally customize the rest_base or controller class
    // $wp_post_types[$post_type_name]->rest_base = $post_type_name;
    // $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
  }
}

add_action( 'rest_api_init', function() {
    register_rest_field( 'lots', 'custom_fields', array(
        'get_callback' => 'get_custom_fields',
        'schema' => null,
    ));
}, 15 );

add_action( 'rest_api_init', function() {
    register_rest_field( 'homeplans', 'custom_fields', array(
        'get_callback' => 'get_custom_fields',
        'schema' => null,
    ));
}, 15 );

add_action( 'rest_api_init', function() {
    
	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	add_filter( 'rest_pre_serve_request', function( $value ) {
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Methods: POST, GET, OPTIONS' );
		header( 'Access-Control-Allow-Credentials: true' );

		return $value;
		
	});
}, 16 );

add_action( 'rest_lots_query', 'lots_override_per_page' );
function deepIncludeACFFields(&$item, $key, $postTypes, $level=0, $post) {
    if( isset($item->post_type) && in_array($item->post_type, $postTypes) ) {
        $item = get_fields($item->ID);
    }
}

/*
 * params is the query array passed to WP_Query
 */
function lots_override_per_page( $params ) {
    if ( isset( $params ) AND isset( $params[ 'posts_per_page' ] ) ) {
        $params[ 'posts_per_page' ] = 106;
    }
    return $params;
}
/**
 * Add REST API support to an already registered taxonomy.
 */
add_action( 'init', 'my_custom_taxonomy_rest_support', 25 );
function my_custom_taxonomy_rest_support() {
  global $wp_taxonomies;
 
  //Register Custom taxonomy for rest api - be sure to set this to the name of your taxonomy!
  $taxonomy_name = 'homeplans_styles';
 
  if ( isset( $wp_taxonomies[ $taxonomy_name ] ) ) {
    $wp_taxonomies[ $taxonomy_name ]->show_in_rest = true;
 
    // Optionally customize the rest_base or controller class
    $wp_taxonomies[ $taxonomy_name ]->rest_base = $taxonomy_name;
    $wp_taxonomies[ $taxonomy_name ]->rest_controller_class = 'WP_REST_Terms_Controller';
  }
}


function get_custom_fields( $object ) {
    //get the id of the post object array
    $post_id = $object['id'];
    
    //return the post meta
    return get_post_meta( $post_id );
}
function get_post_meta_for_status( $object ) {
    //get the id of the post object array
    $post_id = $object['id'];
    
    //return the post meta
    $post_meta = get_post_meta( $post_id );
    $status = $post_meta['status'];
    return $status[0];
}

function my_allow_meta_query( $valid_vars ) {
	$valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value', 'meta_query' ) );
	return $valid_vars;
}
add_filter( 'rest_query_vars', 'my_allow_meta_query' );

function init_admin_scripts(){
    global $user_roles, $post;

    if(is_array($user_roles)) {
        $user_role = array_shift($user_roles);
    }else{
        $user_role = '';
    }

    // if(strtolower($user_role) != 'administrator')
    wp_enqueue_script('admin-scripts', get_stylesheet_directory_uri() . '/js/admin-script-general.js', '', false,'');
    if($post->post_type == 'wonderloops') wp_deregister_script('yoast-seo-post-scraper');
}
add_action('admin_enqueue_scripts', 'init_admin_scripts');

function breadcrumbs(){
    echo the_widget ('UltimatumBcumb', array(),array());
}
add_filter( 'rest_units_query', function( $args ) {
    $args['meta_query'] = array(
        array(
            'key'   => 'neighbourhood',
            'value' => esc_sql( $_GET['neighbourhood'] ),
        )
    );

    return $args;
} );
add_shortcode('breadcrumbs', 'breadcrumbs');
add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');
include('functions-extras.php');
include('functions-shortcodes.php');
// include('functions-map.php');
include('pageBanner.php');


