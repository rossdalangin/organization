<?php
/**
 * Additional Meta Fields for CPTs
 *
 * @package OrgEcosystem
 */

function org_ecosystem_register_custom_meta_boxes() {
    // Product Meta
    add_meta_box( 'product_details', __( 'Product/Service Details', 'org-ecosystem' ), 'org_ecosystem_product_meta_callback', 'product', 'normal', 'high' );

    // Event Meta
    add_meta_box( 'event_details', __( 'Event Details', 'org-ecosystem' ), 'org_ecosystem_event_meta_callback', 'event', 'normal', 'high' );

    // Message Meta (Admin Reply)
    add_meta_box( 'message_reply', __( 'Send a Reply', 'org-ecosystem' ), 'org_ecosystem_message_reply_callback', 'org_message', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'org_ecosystem_register_custom_meta_boxes' );

/**
 * Product Meta Callback
 */
function org_ecosystem_product_meta_callback( $post ) {
    wp_nonce_field( 'org_save_product_meta', 'org_product_nonce' );
    $price = get_post_meta( $post->ID, '_product_price', true );
    $is_featured = get_post_meta( $post->ID, '_product_is_featured', true );
    $is_solution = get_post_meta( $post->ID, '_product_is_solution', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="product_price">Price (₱)</label></th>
            <td><input type="text" id="product_price" name="product_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th>Flags</th>
            <td>
                <label><input type="checkbox" name="product_is_featured" value="1" <?php checked( $is_featured, '1' ); ?>> Featured Product</label><br>
                <label><input type="checkbox" name="product_is_solution" value="1" <?php checked( $is_solution, '1' ); ?>> Official Solution</label>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Message Reply Callback (Admin UI)
 */
function org_ecosystem_message_reply_callback( $post ) {
    $sender_id = $post->post_author;
    $receiver_id = get_post_meta( $post->ID, '_msg_receiver_id', true );
    ?>
    <div class="message-reply-admin">
        <p><strong>Sender:</strong> <?php echo get_userdata($sender_id)->display_name; ?> (<?php echo get_userdata($sender_id)->user_email; ?>)</p>
        <div class="reply-field mt-3">
            <textarea name="admin_msg_reply" rows="5" style="width:100%" placeholder="Type your reply to the member..."></textarea>
        </div>
        <p class="description"><?php _e( 'Click "Update" to send this reply to the member\'s dashboard inbox.', 'org-ecosystem' ); ?></p>
        <input type="hidden" name="org_msg_reply_nonce" value="<?php echo wp_create_nonce('org_msg_reply_action'); ?>">
    </div>
    <?php
}

/**
 * Event Meta Callback
 */
function org_ecosystem_event_meta_callback( $post ) {
    wp_nonce_field( 'org_save_event_meta', 'org_event_nonce' );
    $date = get_post_meta( $post->ID, '_event_date', true );
    $venue = get_post_meta( $post->ID, '_event_venue', true );
    $is_upcoming = get_post_meta( $post->ID, '_event_is_upcoming', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="event_date">Event Date</label></th>
            <td><input type="date" id="event_date" name="event_date" value="<?php echo esc_attr( $date ); ?>"></td>
        </tr>
        <tr>
            <th><label for="event_venue">Venue</label></th>
            <td><input type="text" id="event_venue" name="event_venue" value="<?php echo esc_attr( $venue ); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th>Flags</th>
            <td>
                <label><input type="checkbox" name="event_is_upcoming" value="1" <?php checked( $is_upcoming, '1' ); ?>> Mark as Upcoming</label>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Meta Logic
 */
function org_ecosystem_save_custom_meta( $post_id ) {
    // Product
    if ( isset( $_POST['org_product_nonce'] ) && wp_verify_nonce( $_POST['org_product_nonce'], 'org_save_product_meta' ) ) {
        update_post_meta( $post_id, '_product_price', sanitize_text_field( $_POST['product_price'] ) );
        update_post_meta( $post_id, '_product_is_featured', isset( $_POST['product_is_featured'] ) ? '1' : '0' );
        update_post_meta( $post_id, '_product_is_solution', isset( $_POST['product_is_solution'] ) ? '1' : '0' );
    }

    // Event
    if ( isset( $_POST['org_event_nonce'] ) && wp_verify_nonce( $_POST['org_event_nonce'], 'org_save_event_meta' ) ) {
        update_post_meta( $post_id, '_event_date', sanitize_text_field( $_POST['event_date'] ) );
        update_post_meta( $post_id, '_event_venue', sanitize_text_field( $_POST['event_venue'] ) );
        update_post_meta( $post_id, '_event_is_upcoming', isset( $_POST['event_is_upcoming'] ) ? '1' : '0' );
    }

    // Message Reply
    if ( isset( $_POST['admin_msg_reply'] ) && !empty( $_POST['admin_msg_reply'] ) && wp_verify_nonce( $_POST['org_msg_reply_nonce'], 'org_msg_reply_action' ) ) {
        $parent_msg = get_post( $post_id );
        $member_id = $parent_msg->post_author;
        $content = sanitize_textarea_field( $_POST['admin_msg_reply'] );

        // Insert new message
        $reply_id = wp_insert_post( array(
            'post_title'   => 'Re: ' . $parent_msg->post_title,
            'post_content' => $content,
            'post_type'    => 'org_message',
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
        ) );

        if ( $reply_id ) {
            update_post_meta( $reply_id, '_msg_receiver_id', $member_id );
            update_post_meta( $reply_id, '_msg_read', '0' );
        }

        // Mark original as read
        update_post_meta( $post_id, '_msg_read', '1' );
    }
}
add_action( 'save_post', 'org_ecosystem_save_custom_meta' );
