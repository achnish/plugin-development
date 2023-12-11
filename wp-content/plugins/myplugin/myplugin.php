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

function my_uninstall_hook() {
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';
    $q = "DROP TABLE IF EXISTS $wp_emp";
    $wpdb->query($q);

}

register_uninstall_hook(__FILE__, 'my_uninstall_hook');

 ?>