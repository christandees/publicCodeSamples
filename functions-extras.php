<?php
function fc_remove_related_videos($embed) {
    if (strstr($embed,'https://www.youtube.com/embed/')) {
        return str_replace('?fs=1','?fs=1&rel=0',$embed);
    } else {
        return $embed;
    }
}
add_filter('oembed_result', 'fc_remove_related_videos', 1, true);

function custom_excerpt_length($length) {
    return (defined('CUSTOM_EXCERPT_WORD_LENGTH')) ? CUSTOM_EXCERPT_WORD_LENGTH : 40;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);


//////////////////Column Sorting for facets ///////////////
function my_facetwp_sort_options( $options, $params ) {
    $options = array( 
    	'lot_number_desc' => array(
        'label' => 'Lot Number DESC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value_num', // sort by numerical custom field
            'meta_key' => 'lot_number', // required when sorting by custom fields
            'order' => 'DESC', // descending order
        )
    ),
    'lot_number_asc' => array(
        'label' => 'Lot Number ASC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value_num', // sort by numerical custom field
            'meta_key' => 'lot_number', // required when sorting by custom fields
            'order' => 'ASC', // Ascending order
        )
    ),
    'view_type_desc' => array(
        'label' => 'View Type DESC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value', // sort by custom field
            'meta_key' => 'view_type', // required when sorting by custom fields
            'order' => 'DESC', // descending order
        )
	),
    'view_type_asc' => array(
        'label' => 'View Type ASC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value', // sort by custom field
            'meta_key' => 'view_type', // required when sorting by custom fields
            'order' => 'ASC', // ascending order
        )
	),
    'size_sqft_desc' => array(
        'label' => 'Size Sqft DESC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value_num', // sort by numerical custom field
            'meta_key' => 'size_sq_ft', // required when sorting by custom fields
            'order' => 'DESC', // descending order
        )
	),
    'size_sqft_asc' => array(
        'label' => 'Size Sqft ASC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value_num', // sort by numerical custom field
            'meta_key' => 'size_sq_ft', // required when sorting by custom fields
            'order' => 'ASC', // descending order
        )
    ),
   'lot_type_desc' => array(
        'label' => 'Lot Type DESC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value', // sort by numerical custom field
            'meta_key' => 'lot_type', // required when sorting by custom fields
            'order' => 'DESC', // descending order
        )
    ),
    'lot_type_asc' => array(
        'label' => 'Lot Type ASC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value', // sort by numerical custom field
            'meta_key' => 'lot_type', // required when sorting by custom fields
            'order' => 'ASC', // descending order
        )
    ),
    'price_desc' => array(
        'label' => 'Price DESC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value_num', // sort by numerical custom field
            'meta_key' => 'price', // required when sorting by custom fields
            'order' => 'DESC', // descending order
        )
    ),
    'price_asc' => array(
        'label' => 'Price ASC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value_num', // sort by numerical custom field
            'meta_key' => 'price', // required when sorting by custom fields
            'order' => 'ASC', // descending order
        )
    ),
    'status_desc' => array(
        'label' => 'Status DESC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value', // sort by numerical custom field
            'meta_key' => 'status', // required when sorting by custom fields
            'order' => 'DESC', // descending order
        )
    ),
    'status_asc' => array(
        'label' => 'Status ASC',
        'query_args' => array(
        	'post_type' => 'lots',
            'orderby' => 'meta_value', // sort by numerical custom field
            'meta_key' => 'status', // required when sorting by custom fields
            'order' => 'ASC', // descending order
        )
 	)   
    );
    return $options;
}

add_filter( 'facetwp_sort_options', 'my_facetwp_sort_options', 10, 2 );
function fc_get_post(){
    global $post, $wp_extras_post;

    if(!empty($post)) $wp_extras_post = $post;
}

?>