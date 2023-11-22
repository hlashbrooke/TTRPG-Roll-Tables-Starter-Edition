<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Add the shortcode for the display
add_shortcode( 'roll_table', 'trt_roll_tables_shortcode' );
function trt_roll_tables_shortcode ( $atts ) {

    $output = '';

    // Check which table or table group we're using
    $atts = shortcode_atts( array(
            'table' => 0,
            'group' => 0,
        ), $atts, 'roll_table'
    );

    $table_ids = $atts['table'];
    $group_ids = $atts['group'];

    // If no table or table group is specified then let's get out of here
    if( ! $table_ids && ! $group_ids ) {
        return $output;
    }

    $included_tables = array();

    // If groups are specified, get all of the roll tables in those groups
    if( $group_ids ) {

        $group_ids_array = explode ( ',', $group_ids );

        $args = array(
            'post_type' => 'roll_table',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => array(
                array(
                    'taxonomy' => 'roll_table_group',
                    'field' => 'term_id',
                    'terms' => $group_ids_array,
                )
            ),
        );

        $included_tables = get_posts( $args );
    }

    // If individual tables are specified add them to the array as well
    if ( $table_ids ) {
        $table_ids_array = explode ( ',', $table_ids );
        if ( 0 < count( $table_ids_array ) ) {
            foreach( $table_ids_array as $table_to_add ) {
                // Only add the table if it is not already in the array
                if ( ! in_array( $table_to_add, $included_tables ) ) {
                    $included_tables[] = $table_to_add;
                }
            }
        }
    }

    // If there are no table IDs available, then let's get out of here
    if ( ! count( $included_tables ) ) {
        return $output;
    }

    // Load the necessary JS for rolling on tables
    wp_enqueue_script( 'shuffle-letters' );
    wp_enqueue_script( 'trt-scripts' );

    // Initiate the output markup
    $output = '<div class="rolltable_tables">';

    // Add each table to the markup based on the above array
    if ( is_array( $included_tables ) && 0 < count( $included_tables ) ) {

        foreach ( $included_tables as $table_id ) {

            // Get the table description by parsing the content from the Roll Table post
            $description = get_the_content( null, false, $table_id );
            if( ! is_single( $table_id ) ) {
                $description = apply_filters( 'the_content', $description );
            }
            $description = str_replace( ']]>', ']]&gt;', $description );

            // Get the total number of items in the table and figure out the dice notation
            $table_total = intval( get_post_meta( $table_id, 'trt_table_size', true ) );
            $dice_notation = get_post_meta( $table_id, 'trt_dice_notation', true );
            if( ! $dice_notation ) {
                $dice_notation = trt_get_dice_notation( $table_total );
            }

            $dice_notation = apply_filters( 'trt_roll_table_dice_notation', $dice_notation, $table_id );

            $output .= '<div class="rolltable_data_block" id="rolltable-' . esc_attr( $table_id ) . '">';

                $output .= '<h3 class="rolltable_title">' . apply_filters( 'trt_roll_table_title', get_the_title( $table_id ), $table_id ) . '</h3>';

                if( $description ) {
                    $output .= '<aside class="rolltable_description">' . apply_filters( 'trt_roll_table_description', $description, $table_id ) . '</aside>';
                }

                if( has_post_thumbnail( $table_id ) ) {
                    $output .= get_the_post_thumbnail( $table_id, 'medium' );
                }

                $output .= '<div class="rolltable_result_output"><span id="' . esc_attr( $table_id ) . '-result"></span>&nbsp;</div>';

                $button_text = __( 'Roll', 'ttrpg-roll-tables' );
                if( apply_filters( 'trt_show_dice_notation', true, $table_id ) ) {
                    $button_text .= ' ' . $dice_notation;
                }

                $output .= '<div><button id="' . esc_attr( $table_id ) . '-button" data-ref="' . esc_attr( $table_id ) . '" class="rolltable_button wp-block-button__link wp-element-button">' . apply_filters( 'trt_roll_table_button_text', esc_html( $button_text ), $table_id, $dice_notation ) . '</button></div>';

            $output .= '</div>';

        }

    }

    // Close things off
    $output .= '</div>';

    // Send the shortcode output to the browser for display
    return $output;
}

// Get the dice notation based on the number of items in the table
function trt_get_dice_notation ( $table_total = '6' ) {

    $return = '';

    $dice = apply_filters( 'trt_dice_notation', array(
        '2' => 'd2',
        '3' => 'd3',
        '4' => 'd4',
        '6' => 'd6',
        '8' => 'd8',
        '10' => 'd10',
        '11' => '2d6',
        '12' => 'd12',
        '16' => '3d6',
        '20' => 'd20',
        '21' => '4d6',
        '26' => '5d6',
        '31' => '6d6',
        '36' => 'd66',
        '100' => 'd100',
    ) );

    if ( isset( $dice[ $table_total ] ) ) {
        $return = $dice[ $table_total ];
    }

    return $return;
}
