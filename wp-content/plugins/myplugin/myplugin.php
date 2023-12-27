<?php
/*
Plugin Name: My Registration Plugin
Description: A WordPress plugin for custom user registration.
Version: 1.0
Author: Jack
Author URI: https://www.w3schools.com/
*/

if (!defined('ABSPATH')) {
    // header("Location: /customplugindevelopment");
    exit; // or die("Can't Access");
}

function my_activation_hook() {
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';
    $q = "CREATE TABLE `$wp_emp` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `status` BOOLEAN NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($q);

    $q = "INSERT INTO `$wp_emp` (`id`, `name`, `email`, `status`) 
    VALUES (NULL, 'Test', 'mailto:test123@yopmail.com', '1')";
    dbDelta($q);
}

register_activation_hook(__FILE__, 'my_activation_hook');

function my_deactivation_hook() {
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';

    $q = "TRUNCATE $wp_emp";

    $wpdb->query($q);
}

register_deactivation_hook(__FILE__, 'my_deactivation_hook');

// function my_custom_shortcode() {
//     include 'slider.php';
// }
// add_action("my_shortcode", "my_custom_shortcode");



function my_uninstall_hook() {
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';
    $q = "DROP TABLE IF EXISTS $wp_emp";
    $wpdb->query($q);

}

register_uninstall_hook(__FILE__, 'my_uninstall_hook');

//Enqueue Scripts in Custom Plugin
function my_custom_scripts()
{
    $is_login= is_user_logged_in() ? 1 : 0 ;
    $path_js= plugins_url('js/main.js',__FILE__);
    $dep = array('jquery');
    $ver = filemtime(plugin_dir_path(__FILE__).'js/main.js');
    wp_enqueue_script('my-custom-js',$path_js,$dep,$ver,true);

    $is_login=is_user_logged_in() ? 1 : 0 ;
    wp_add_inline_script('my-custom-js','var is_login='.$is_login.';','before');

    // if(is_page('home')){
    //             wp_enqueue_script('my-custom-js', $path_js, $dep, $ver, true);
    //  }

}
add_action('wp_enqueue_scripts','my_custom_scripts');
add_action('admin_enqueue_scripts','my_custom_scripts');



//Enqueue Style in Custom Plugin
function my_custom_style() {
    $path_css = plugins_url('css/main.css', __FILE__);
    $ver_style = filemtime(plugin_dir_path(__FILE__) . 'css/main.css');
    wp_enqueue_style('my-custom-style', $path_css, array(), $ver_style);
}
add_action('wp_enqueue_scripts', 'my_custom_style');
// add_action('admin_enqueue_scripts','my_custom_style');


function shortcode_example() {
    include 'slider.php';
  }
  add_shortcode('example', 'shortcode_example');

?>