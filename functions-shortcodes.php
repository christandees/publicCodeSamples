<?php

function fc_date_sc($atts){
    return date("Y");
}
add_shortcode("year", "fc_date_sc");

// address directions

function fc_address_directions_sc($atts){
    global $wpdb, $post;

    $address = get_post_meta($post->ID, "address", true);
    if(!empty($address)) $address = urlencode($address." Kelowna BC");
    return $address;
}
add_shortcode('address_directions', 'fc_address_directions_sc');

// Video Popup

function fc_video_popup($atts){
    $vid = get_post_meta(get_the_ID(), 'video', true);
    $html = null;
    if(!empty($vid)){
        $html = '<div class="yt_wrapper"><img class="yvideo btn-vid" href="https://www.youtube.com/embed/'.$vid.'?rel=0&showinfo=0autoplay=1" src="http://img.youtube.com/vi/'.$vid.'/hqdefault.jpg"><img class="yt_icon" src=" '.get_stylesheet_directory_uri().'/images/YouTube-icon.png"></div>';
    }
    return $html;
}

add_shortcode('video_popup','fc_video_popup');

// print menu [menu name="-your menu name-" class="-your class-"]

function print_menu_shortcode($atts, $content = null) {
extract(shortcode_atts(array( 'name' => null, 'class' => null ), $atts));
return wp_nav_menu( array( 'menu' => $name, 'menu_class' => $class, 'echo' => false ) );
}

add_shortcode('menu', 'print_menu_shortcode');

?>
