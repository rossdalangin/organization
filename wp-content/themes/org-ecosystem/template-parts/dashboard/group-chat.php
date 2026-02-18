<?php
/**
 * Dashboard Group Chat Template Part
 */
$current_user_id = get_current_user_id();
$chat_nonce = wp_create_nonce('org_group_chat_nonce');
?>
<div class="group-chat-panel">
    <h3 class="fw-bold mb-4"><?php _e( 'Community Group Chat', 'org-ecosystem' ); ?></h3>

    <div id="chat-box" class="chat-container bg-light rounded-4 p-4 mb-4 shadow-sm" style="height: 500px; overflow-y: auto;">
        <?php
        $messages = org_ecosystem_get_group_messages(50);
        $last_id = 0;
        if ( $messages->have_posts() ) :
            while ( $messages->have_posts() ) : $messages->the_post();
                $last_id = get_the_ID();
                $is_me = ( get_the_author_meta('ID') == $current_user_id );
            ?>
                <div class="chat-message mb-3 <?php echo $is_me ? 'ms-auto text-end' : 'me-auto'; ?>" style="max-width: 80%;" data-id="<?php the_ID(); ?>">
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
            <div id="empty-chat" class="text-center py-5 text-muted">
                <i class="bi bi-chat-dots display-1 opacity-25"></i>
                <p><?php _e( 'Start the conversation!', 'org-ecosystem' ); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <form id="chat-form" class="chat-input-area">
        <div class="input-group">
            <textarea id="chat-message-input" name="message" class="form-control rounded-start-4 border-0 shadow-sm" placeholder="<?php _e( 'Type your message...', 'org-ecosystem' ); ?>" rows="2" required></textarea>
            <button class="btn btn-primary rounded-end-4 px-4 shadow-sm" type="submit">
                <i class="bi bi-send-fill fs-5"></i>
            </button>
        </div>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    const chatBox = $('#chat-box');
    let lastId = <?php echo $last_id; ?>;
    const currentUserId = <?php echo $current_user_id; ?>;

    // Scroll to bottom
    chatBox.scrollTop(chatBox[0].scrollHeight);

    function appendMessage(msg) {
        if ($('.chat-message[data-id="'+msg.id+'"]').length > 0) return;

        $('#empty-chat').remove();

        const isMe = msg.is_mine;
        const msgHtml = `
            <div class="chat-message mb-3 ${isMe ? 'ms-auto text-end' : 'me-auto'}" style="max-width: 80%;" data-id="${msg.id}">
                <div class="message-meta small text-muted mb-1">
                    ${!isMe ? '<strong>'+msg.author+'</strong> &middot; ' : ''}
                    ${msg.time}
                </div>
                <div class="message-bubble p-3 rounded-4 ${isMe ? 'bg-primary text-white' : 'bg-white border'} shadow-sm">
                    ${msg.content}
                </div>
            </div>
        `;
        chatBox.append(msgHtml);
        chatBox.scrollTop(chatBox[0].scrollHeight);
        lastId = msg.id;
    }

    // Polling
    setInterval(function() {
        $.ajax({
            url: org_ajax.ajaxurl,
            data: {
                action: 'org_get_group_messages',
                security: '<?php echo $chat_nonce; ?>',
                last_id: lastId
            },
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    response.data.forEach(appendMessage);
                }
            }
        });
    }, 3000);

    // Sending
    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        const msgInput = $('#chat-message-input');
        const message = msgInput.val();
        if (!message.trim()) return;

        $.ajax({
            url: org_ajax.ajaxurl,
            method: 'POST',
            data: {
                action: 'org_ajax_send_group_msg',
                security: '<?php echo $chat_nonce; ?>',
                message: message
            },
            success: function(response) {
                if (response.success) {
                    msgInput.val('');
                    appendMessage(response.data);
                }
            }
        });
    });

    // Enter to send
    $('#chat-message-input').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#chat-form').submit();
        }
    });
});
</script>

<style>
    #chat-box { scroll-behavior: smooth; }
    .chat-message { animation: fadeIn 0.3s ease-in; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
