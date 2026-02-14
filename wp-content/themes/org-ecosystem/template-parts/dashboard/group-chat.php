<?php
/**
 * Dashboard Group Chat Template Part
 */
?>
<div class="group-chat-panel">
    <h3 class="fw-bold mb-4"><?php _e( 'Community Group Chat', 'org-ecosystem' ); ?></h3>

    <div class="chat-container bg-light rounded-4 p-4 mb-4 shadow-sm" style="height: 500px; overflow-y: auto; display: flex; flex-direction: column-reverse;">
        <?php
        $messages = org_ecosystem_get_group_messages(30);
        if ( $messages->have_posts() ) :
            while ( $messages->have_posts() ) : $messages->the_post();
                $is_me = ( get_the_author_meta('ID') == get_current_user_id() );
            ?>
                <div class="chat-message mb-3 <?php echo $is_me ? 'ms-auto text-end' : 'me-auto'; ?>" style="max-width: 80%;">
                    <div class="message-meta small text-muted mb-1">
                        <?php if(!$is_me) : ?><strong><?php echo get_the_author(); ?></strong> &middot; <?php endif; ?>
                        <?php echo get_the_date('H:i'); ?>
                    </div>
                    <div class="message-bubble p-3 rounded-4 <?php echo $is_me ? 'bg-primary text-white' : 'bg-white border'; ?> shadow-sm">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-chat-dots display-1 opacity-25"></i>
                <p><?php _e( 'Start the conversation!', 'org-ecosystem' ); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <form class="chat-input-area" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="org_send_group_msg">
        <?php wp_nonce_field( 'org_send_group_msg', 'org_group_msg_nonce' ); ?>
        <div class="input-group">
            <textarea name="chat_message" class="form-control rounded-start-4 border-0 shadow-sm" placeholder="<?php _e( 'Type your message...', 'org-ecosystem' ); ?>" rows="2" required></textarea>
            <button class="btn btn-primary rounded-end-4 px-4 shadow-sm" type="submit">
                <i class="bi bi-send-fill fs-5"></i>
            </button>
        </div>
    </form>
</div>
