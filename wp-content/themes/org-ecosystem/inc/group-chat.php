<?php
/**
 * Community Group Chat Logic
 *
 * @package OrgEcosystem
 */

/**
 * Handle sending a group message
 */
function org_ecosystem_handle_group_msg() {
    if ( ! isset( $_POST['org_group_msg_nonce'] ) || ! wp_verify_nonce( $_POST['org_group_msg_nonce'], 'org_send_group_msg' ) ) {
        return;
    }

    if ( ! is_user_logged_in() ) return;

    $user_id = get_current_user_id();
    $content = sanitize_textarea_field( $_POST['chat_message'] );

    if ( ! empty( $content ) ) {
        wp_insert_post( array(
            'post_title'   => 'GroupMsg_' . time(),
            'post_content' => $content,
            'post_type'    => 'org_group_msg',
            'post_status'  => 'publish',
            'post_author'  => $user_id,
        ) );
    }

    wp_redirect( add_query_arg( array( 'action' => 'group-chat', 'sent' => 'true' ), home_url( '/dashboard' ) ) );
    exit;
}
add_action( 'admin_post_org_send_group_msg', 'org_ecosystem_handle_group_msg' );

/**
 * Fetch latest group messages
 */
function org_ecosystem_get_group_messages( $limit = 20 ) {
    return new WP_Query( array(
        'post_type'      => 'org_group_msg',
        'posts_per_page' => $limit,
        'order'          => 'DESC',
    ) );
}
