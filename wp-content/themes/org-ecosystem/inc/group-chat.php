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

    wp_redirect( add_query_arg( array( 'action' => 'group-chat', 'sent' => 'true' ), org_ecosystem_get_page_url( 'templates/dashboard.php' ) ) );
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
        'order'          => 'ASC', // Changed to ASC for chat flow
    ) );
}

/**
 * AJAX Handler to Fetch New Group Messages
 */
function org_ajax_get_group_messages() {
    check_ajax_referer( 'org_group_chat_nonce', 'security' );

    $last_id = isset($_GET['last_id']) ? intval($_GET['last_id']) : 0;

    $args = array(
        'post_type'      => 'org_group_msg',
        'posts_per_page' => 20,
        'order'          => 'ASC',
        'post_status'    => 'publish'
    );

    if ( $last_id > 0 ) {
        $args['post__not_in'] = array($last_id);
        $args['date_query'] = array(
            array(
                'after' => get_the_date('c', $last_id),
                'inclusive' => false,
            ),
        );
        // Date query might be tricky if multiple messages have same timestamp.
        // Better to use ID comparison if possible, but WP_Query doesn't easily support ID > X.
        // Using a meta field for message ID or just filtering in PHP.
    }

    $query = new WP_Query($args);
    $messages = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            if ( get_the_ID() <= $last_id ) continue;

            $messages[] = array(
                'id'        => get_the_ID(),
                'content'   => get_the_content(),
                'author'    => get_the_author(),
                'avatar'    => get_avatar_url(get_the_author_meta('ID')),
                'time'      => get_the_date('H:i'),
                'is_mine'   => (get_the_author_meta('ID') == get_current_user_id())
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success($messages);
}
add_action( 'wp_ajax_org_get_group_messages', 'org_ajax_get_group_messages' );

/**
 * AJAX Handler to Send Group Message
 */
function org_ajax_send_group_msg() {
    check_ajax_referer( 'org_group_chat_nonce', 'security' );

    if ( ! is_user_logged_in() ) wp_send_json_error('Logged out');

    $user_id = get_current_user_id();
    $content = sanitize_textarea_field( $_POST['message'] );

    if ( ! empty( $content ) ) {
        $msg_id = wp_insert_post( array(
            'post_title'   => 'GroupMsg_' . time(),
            'post_content' => $content,
            'post_type'    => 'org_group_msg',
            'post_status'  => 'publish',
            'post_author'  => $user_id,
        ) );

        if ( $msg_id ) {
            wp_send_json_success( array(
                'id'        => $msg_id,
                'content'   => $content,
                'author'    => get_userdata($user_id)->display_name,
                'avatar'    => get_avatar_url($user_id),
                'time'      => date('H:i'),
                'is_mine'   => true
            ) );
        }
    }

    wp_send_json_error('Empty message');
}
add_action( 'wp_ajax_org_ajax_send_group_msg', 'org_ajax_send_group_msg' );
