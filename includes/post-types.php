<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Register Custom Post Type
function trt_register_post_type() {

    $labels = array(
        'name'                  => _x( 'Roll Tables', 'Post Type General Name', 'ttrpg-roll-tables' ),
        'singular_name'         => _x( 'Roll Table', 'Post Type Singular Name', 'ttrpg-roll-tables' ),
        'menu_name'             => __( 'Roll Tables', 'ttrpg-roll-tables' ),
        'name_admin_bar'        => __( 'Roll Table', 'ttrpg-roll-tables' ),
        'archives'              => __( 'Roll Table Archives', 'ttrpg-roll-tables' ),
        'attributes'            => __( 'Roll Table Attributes', 'ttrpg-roll-tables' ),
        'parent_item_colon'     => __( 'Parent Roll Table:', 'ttrpg-roll-tables' ),
        'all_items'             => __( 'All Roll Tables', 'ttrpg-roll-tables' ),
        'add_new_item'          => __( 'Add New Roll Table', 'ttrpg-roll-tables' ),
        'add_new'               => __( 'Add New', 'ttrpg-roll-tables' ),
        'new_item'              => __( 'New Roll Table', 'ttrpg-roll-tables' ),
        'edit_item'             => __( 'Edit Roll Table', 'ttrpg-roll-tables' ),
        'update_item'           => __( 'Update Roll Table', 'ttrpg-roll-tables' ),
        'view_item'             => __( 'View Roll Table', 'ttrpg-roll-tables' ),
        'view_items'            => __( 'View Roll Tables', 'ttrpg-roll-tables' ),
        'search_items'          => __( 'Search Roll Table', 'ttrpg-roll-tables' ),
        'not_found'             => __( 'Not found', 'ttrpg-roll-tables' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'ttrpg-roll-tables' ),
        'featured_image'        => __( 'Featured Image', 'ttrpg-roll-tables' ),
        'set_featured_image'    => __( 'Set featured image', 'ttrpg-roll-tables' ),
        'remove_featured_image' => __( 'Remove featured image', 'ttrpg-roll-tables' ),
        'use_featured_image'    => __( 'Use as featured image', 'ttrpg-roll-tables' ),
        'insert_into_item'      => __( 'Insert into Roll Table', 'ttrpg-roll-tables' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Roll Table', 'ttrpg-roll-tables' ),
        'items_list'            => __( 'Roll Tables list', 'ttrpg-roll-tables' ),
        'items_list_navigation' => __( 'Roll Tables list navigation', 'ttrpg-roll-tables' ),
        'filter_items_list'     => __( 'Filter Roll Tables list', 'ttrpg-roll-tables' ),
    );

    $rewrite = array(
        'slug'                  => 'roll-table',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );

    $args = array(
        'label'                 => __( 'Roll Table', 'ttrpg-roll-tables' ),
        'description'           => __( 'Custom roll tables for TTRPGs', 'ttrpg-roll-tables' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail', 'editor' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-editor-table',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type( 'roll_table', $args );

}

// Register Custom Taxonomy
function trt_register_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Roll Table Groups', 'Taxonomy General Name', 'ttrpg-roll-tables' ),
        'singular_name'              => _x( 'Roll Table Group', 'Taxonomy Singular Name', 'ttrpg-roll-tables' ),
        'menu_name'                  => __( 'Roll Table Groups', 'ttrpg-roll-tables' ),
        'all_items'                  => __( 'Roll Table Groups', 'ttrpg-roll-tables' ),
        'parent_item'                => __( 'Parent Roll Table Group', 'ttrpg-roll-tables' ),
        'parent_item_colon'          => __( 'Parent Roll Table Group:', 'ttrpg-roll-tables' ),
        'new_item_name'              => __( 'New Roll Table Group Name', 'ttrpg-roll-tables' ),
        'add_new_item'               => __( 'Add Roll Table Group', 'ttrpg-roll-tables' ),
        'edit_item'                  => __( 'Edit Roll Table Group', 'ttrpg-roll-tables' ),
        'update_item'                => __( 'Update Roll Table Group', 'ttrpg-roll-tables' ),
        'view_item'                  => __( 'View Roll Table Group', 'ttrpg-roll-tables' ),
        'separate_items_with_commas' => __( 'Separate groups with commas', 'ttrpg-roll-tables' ),
        'add_or_remove_items'        => __( 'Add or remove groups', 'ttrpg-roll-tables' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'ttrpg-roll-tables' ),
        'popular_items'              => __( 'Popular Roll Table Groups', 'ttrpg-roll-tables' ),
        'search_items'               => __( 'Search Roll Table Group', 'ttrpg-roll-tables' ),
        'not_found'                  => __( 'Not Found', 'ttrpg-roll-tables' ),
        'no_terms'                   => __( 'No Roll Table Groups', 'ttrpg-roll-tables' ),
        'items_list'                 => __( 'Roll Table Group list', 'ttrpg-roll-tables' ),
        'items_list_navigation'      => __( 'Roll Table Group list navigation', 'ttrpg-roll-tables' ),
    );

    $rewrite = array(
        'slug'                       => 'roll-table-group',
        'with_front'                 => true,
        'hierarchical'               => false,
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => $rewrite,
        'show_in_rest'               => true,
    );

    register_taxonomy( 'roll_table_group', array( 'roll_table' ), $args );

}

// Register the meta fields used on the Roll Table post type
function trt_register_post_meta () {

    register_post_meta( 'roll_table', 'trt_table_size', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'number',
        )
    );

    register_post_meta( 'roll_table', 'trt_table_options', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'array',
        )
    );

}

// Limit blocks on Roll Table post type
add_filter( 'allowed_block_types_all', 'trt_allowed_block_types', 25, 2 );
function trt_allowed_block_types( $allowed_blocks, $editor_context ) {

    if( 'roll_table' === $editor_context->post->post_type ) {
        $allowed_blocks = array(
            'core/paragraph',
        );
    }

    return $allowed_blocks;
}

// Modify columns on the Roll Table list table
function trt_add_admin_columns ( $columns ) {
    return array_merge ( $columns, array ( 
        'shortcode' => __ ( 'Shortcode', 'ttrpg-roll-tables' ),
        'table_size' => __ ( 'Table Size', 'ttrpg-roll-tables' ),
    ) );
 }
 add_filter ( 'manage_roll_table_posts_columns', 'trt_add_admin_columns' );

// Display custom data in Roll Table list table
function trt_custom_admin_columns ( $column, $post_id ) {
    switch ( $column ) {
        case 'shortcode':
            echo '<code>[roll_table table=' . esc_attr( $post_id ) . ']</code>';
            break;
        case 'table_size':
            echo intval( get_post_meta( $post_id, 'trt_table_size', true ) );
            break;
        default: break;
    }
}
add_action ( 'manage_roll_table_posts_custom_column', 'trt_custom_admin_columns', 10, 2 );

//Add column to the Roll Table Group taxonomy
function trt_add_taxonomy_column ( $columns ) {
    $columns['shortcode'] = __ ( 'Shortcode', 'ttrpg-roll-tables' );
    return $columns;
}
add_filter( 'manage_edit-roll_table_group_columns', 'trt_add_taxonomy_column' );

// Display custom data in the Roll Table Group taxonomy table
function trt_custom_taxonomy_column ( $content, $column_name, $term_id ) {
    switch ( $column_name ) {
        case 'shortcode':
            $content = '<code>[roll_table group=' . esc_attr( $term_id ) . ']</code>';
            break;
    }

    return $content;

}
add_filter( 'manage_roll_table_group_custom_column', 'trt_custom_taxonomy_column', 10, 3 );

// Add roll table to the single Roll Table post view
function trt_extend_post_content ( $content = '' ) {
    global $post;

    if( 'roll_table' == $post->post_type && is_single() && is_main_query() ) {
        $content .= do_shortcode( '[roll_table table=' . esc_attr( $post->ID ) . ']' );
    }

    return $content;
}
add_filter( 'the_content', 'trt_extend_post_content' );
