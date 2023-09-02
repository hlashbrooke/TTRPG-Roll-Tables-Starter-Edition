<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Run the table roll ajax request
add_action( 'wp_ajax_do_roll', 'trt_handle_table_roll' );
add_action( 'wp_ajax_nopriv_do_roll', 'trt_handle_table_roll' );
function trt_handle_table_roll () {

    // Security check
    check_ajax_referer( 'roll-table-nonce', 'nonce' );

    // Set a default result just in case
    $result = apply_filters( 'trt_roll_error_text', __( 'Error - reload the page and roll again.', 'ttrpg-roll-tables' ) );

    // Get the ID of the table we're rolling on
    $table_id = esc_html( $_POST['ref'] );

    // Load the data from the table we're rolling on
    $table_options = trt_roll_table_data( $table_id );

    // Get a random entry from the table
    if( is_array( $table_options ) && 0 < count( $table_options ) ) {
        $result_key = array_rand( $table_options );
        $result = $table_options[ $result_key ];
    }

    // Send the result back to the ajax request
    echo $result;

    // Script takes a critical hit
    die(); 
}

// Get the date for the requested table
function trt_roll_table_data ( $table_id = 0 ) {

    // If no table ID is specified then what are we even doing here?
    if ( ! $table_id ) {
        return;
    }

    // Get the table options for this table
    $options = get_post_meta( $table_id, 'trt_table_options', true );

    // If there are no table options then let's get out of here
    if ( ! count( $options) ) {
        return;
    }

    // Make sure we're building an array
    $data = array();

    // Loop through each table option and add it to the array of options
    foreach ( $options as $option ) {

        // Add text options to the array
        // Starter Edition does not include any other types of table items
        if( 'text' == $option['trt_text_or_math'] ) {
            $data[] = apply_filters( 'trt_table_option', stripslashes( strip_tags( $option['trt_table_option'] ) ), $table_id );
        }
    }

    // Return the table options
    return $data;
}
