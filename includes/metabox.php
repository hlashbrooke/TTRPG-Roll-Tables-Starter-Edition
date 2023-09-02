<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Add new metabox to Roll Table post type
function trt_register_meta_boxes() {
    add_meta_box( 'roll-table-options', __( 'Roll Table Options', 'ttrpg-roll-tables' ), 'trt_options_metabox_display', 'roll_table', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'trt_register_meta_boxes' );

// Display meta box on Roll Table posts 
// Kudos to Helen Hou-Sandi for the code snippet for repeatable fields: https://gist.github.com/helen/1593065
function trt_options_metabox_display ( $post ) {

    $table_options = get_post_meta( $post->ID, 'trt_table_options', true );

    $table_size = 1;
    if( is_array( $table_options ) ) {
        $table_size = count( $table_options );
    }

    $dice_notation = get_post_meta( $post->ID, 'trt_dice_notation', true );

    wp_nonce_field( 'trt_table_options_nonce', 'trt_table_options_nonce' );
    ?>

    <script type="text/javascript">
    jQuery(document).ready(function( $ ){
        $( '#add-row' ).on('click', function() {
            var row = $( '.empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#trt-table-options-one tbody>tr:last' );

            var count = parseInt( $( '#trt_table_size' ).val() );
            count++;
            $( '#trt_table_size' ).val( count );
            $( '#trt_table_size_display' ).text( count );

            return false;
        });
    
        $( '.remove-row' ).on('click', function() {
            $(this).parents('tr').remove();

            var count = parseInt( $( '#trt_table_size' ).val() );
            count--;
            $( '#trt_table_size' ).val( count );
            $( '#trt_table_size_display' ).text( count );
            
            return false;
        });

    });
    </script>

    <input type="hidden" name="trt_table_size" id="trt_table_size" value="<?php echo intval( $table_size ); ?>" />
    <p>
        <strong><?php _e( 'Total items in table:', 'ttrpg-roll-tables' ); ?> <span id="trt_table_size_display"><?php echo intval( $table_size ); ?></span></strong>
    </p>
    <p>
        <label for="trt_dice_notation"><strong><?php _e( 'Dice notation:', 'ttrpg-roll-tables' ); ?></strong></label> <input type="text" name="trt_dice_notation" id="trt_dice_notation" value="<?php esc_attr_e( $dice_notation, 'ttrpg-roll-tables' ); ?>" class="small-text" /><br/>
        <em><?php _e( 'Notation is based on the number of items in your table. Examples are d6, d20, 2d10, d66, etc.', 'ttrpg-roll-tables' ); ?></em><br/>
        <em><?php _e( 'If you leave this blank the notation will be calculated automatically if possible, otherwise none will be shown.', 'ttrpg-roll-tables' ); ?></em>
    </p>
    <table id="trt-table-options-one" width="100%">
    <thead>
        <tr>
            <th width="90%"><?php _e( 'Table item', 'ttrpg-roll-tables' ); ?></th>
            <th width="10%">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php

    if ( $table_options ) :
    
    foreach ( $table_options as $option ) {
    ?>
    <tr>
        <td class="trt_text_input_cell">
            <span class="trt_input_container_text">
                <input type="text" class="components-text-control__input trt_option_input" name="trt_table_option[]" value="<?php if($option['trt_table_option'] != '') echo esc_attr( $option['trt_table_option'] ); ?>" title="<?php _e( 'The text that will appear in the table.', 'ttrpg-roll-tables' ) ?>" />
            </span>
        </td>
 
        <td><a class="components-button is-secondary is-destructive remove-row" href="#"><?php _e( 'Remove', 'ttrpg-roll-tables' ) ?></a></td>
    </tr>
    <?php
    }
    else :
    // show a blank one
    ?>
    <tr>
        <td class="trt_text_input_cell">
            <span class="trt_input_container_text">
                <input type="text" class="components-text-control__input trt_option_input" name="trt_table_option[]" title="<?php _e( 'The text that will appear in the table.', 'ttrpg-roll-tables' ) ?>" />
            </span>
        </td>
    
        <td><a class="components-button is-secondary is-destructive remove-row" href="#"><?php _e( 'Remove', 'ttrpg-roll-tables' ) ?></a></td>
    </tr>
    <?php endif; ?>
    
    <!-- empty hidden one for jQuery -->
    <tr class="empty-row screen-reader-text">
        <td class="trt_text_input_cell">
            <span class="trt_input_container_text">
                <input type="text" class="components-text-control__input trt_option_input" name="trt_table_option[]" title="<?php _e( 'The text that will appear in the table.', 'ttrpg-roll-tables' ) ?>" />
            </span>
        </td>

        <td><a class="components-button is-secondary is-destructive remove-row" href="#"><?php _e( 'Remove', 'ttrpg-roll-tables' ) ?></a></td>
    </tr>
    </tbody>
    </table>
    
    <p><a id="add-row" class="components-button is-secondary" href="#"><?php _e( 'Add another', 'ttrpg-roll-tables' ) ?></a></p>
    <?php
}

// Save custom post meta
add_action( 'save_post', 'trt_options_metabox_save', 10, 2 );
function trt_options_metabox_save ( $post_id, $post ) {

    // Security check
    if ( ! isset( $_POST['trt_table_options_nonce'] ) || ! wp_verify_nonce( $_POST['trt_table_options_nonce'], 'trt_table_options_nonce' ) ) {
        return;
    }

    // Make sure we're on the right post type
    if( 'roll_table' != $post->post_type ) {
        return;
    }

    // Don't do anything if this is an auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Make sure the current user is allowed to be here
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Get the previously saved table options (if any)
    $old_options = get_post_meta($post_id, 'trt_table_options', true);
    $new_options = array();

    // Get the submitted data
    $dice_notation = $_POST['trt_dice_notation'];
    $table_options = $_POST['trt_table_option'];

    // Update the submitted dice notation
    update_post_meta( $post_id, 'trt_dice_notation', $dice_notation );
        
    // Get the total number of submitted options
    $count = $_POST['trt_table_size'];
    
    // Build up an array of submitted data
    for ( $i = 0; $i < $count; $i++ ) {
        if ( $table_options[$i] != '' ) {
            $new_options[$i]['trt_table_option'] = stripslashes( strip_tags( $table_options[$i] ) );

            // Save the text option to ensure compatilbility when upgrading to the full version
            $new_options[$i]['trt_text_or_math'] = 'text';
        }
    }

    // Count the total of items to be saved (this is different from the previous count beause empty options are left out)
    $total_items = count( $new_options );
    update_post_meta( $post_id, 'trt_table_size', $total_items );

    // Save or delete the data
    if ( ! empty( $new_options ) && $new_options != $old_options ) {
        update_post_meta( $post_id, 'trt_table_options', $new_options );
    } elseif ( empty($new_options) && $old_options ) {
        delete_post_meta( $post_id, 'trt_table_options', $old_options );
        update_post_meta( $post_id, 'trt_table_size', 0 );
    }

}
