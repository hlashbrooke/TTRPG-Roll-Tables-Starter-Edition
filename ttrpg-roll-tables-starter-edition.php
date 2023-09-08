<?php

/*
 * Plugin Name: TTRPG Roll Tables: Starter Edition
 * Version: 1.1
 * Plugin URI: https://hlashbrooke.itch.io/ttrpg-roll-tables-wordpress-plugin
 * Description: Create easy roll tables for tabletop role-playing games. Starter Edition. Get the Complete Edition for more features!
 * Author: Hugh Lashbrooke
 * Author URI: https://hughlashbrooke.com/
 * Requires at least: 6.0
 * Tested up to: 6.3
 *
 * Text Domain: ttrpg-roll-tables
 * Domain Path: /languages/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Don't allow the plugin to activate if the full version is already active
add_action( 'admin_init', 'trt_deactivate_if_full_version_is_active', 0 );
function trt_deactivate_if_full_version_is_active () {
    if ( function_exists( 'is_plugin_active' ) && is_plugin_active( 'ttrpg-roll-tables/ttrpg-roll-tables.php' ) ) {
        deactivate_plugins( 'ttrpg-roll-tables-starter-edition/ttrpg-roll-tables-starter-edition.php' );
    }
}

// Only proceed if the full version of the plugin isn't active
if( ! function_exists( 'tttrpg_roll_tables_plugin_setup' ) ) {
    // Include plugin files
    include 'includes/post-types.php';
    include 'includes/metabox.php';
    include 'includes/ajax.php';
    include 'includes/shortcode.php';

    // Set up the plugin
    add_action( 'init', 'tttrpg_roll_tables_plugin_setup', 0 );
    function tttrpg_roll_tables_plugin_setup () {
        trt_register_post_type();
        trt_register_taxonomy();
        trt_register_post_meta();
    }

    function trt_plugin_list_table_links( $links ) {
        $extra_link = '<strong><a href="https://hlashbrooke.itch.io/ttrpg-roll-tables-wordpress-plugin" target="_blank">' . __( 'Upgrade to the Complete Edition', 'ttrpg-roll-tables' ) . '</a></strong>';
        array_push( $links, $extra_link );
        return $links;
    }
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'trt_plugin_list_table_links' );

    // Load plugin CSS & JS
    add_action( 'wp_enqueue_scripts', 'trt_custom_scripts' );
    function trt_custom_scripts() {

        // Register and load the CSS
        if( apply_filters( 'trt_use_plugin_css', true ) ) {
            wp_register_style( 'trt-styles', plugins_url( 'assets/style.css', __FILE__ ), array(), '1.0' );
            wp_enqueue_style( 'trt-styles' );
        }

        // Regsiter the required JS - it will only be enqueued in the shortcode
        wp_register_script( 'shuffle-letters', plugins_url( 'assets/jquery.shuffleLetters.js', __FILE__ ), array( 'jquery' ), '1.0' );
        wp_register_script( 'trt-scripts', plugins_url( 'assets/scripts.js', __FILE__ ), array( 'jquery', 'shuffle-letters' ), '1.0' );

        // Add ajax parameters and localised strings to the JS
        wp_localize_script( 'trt-scripts', 'roll_table', 
            array( 
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'roll-table-nonce' ),
                'rolling' => apply_filters( 'trt_rolling_text', __( 'Rolling...', 'ttrpg-roll-tables' ) ),
                'error_message' => apply_filters( 'trt_roll_error_text', __( 'Error - reload the page and roll again.', 'ttrpg-roll-tables' ) ),
            )
        );
    }
}
