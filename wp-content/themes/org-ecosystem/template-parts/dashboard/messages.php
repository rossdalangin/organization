<?php
/**
 * Dashboard Messages Template Part
 */
?>
<div class="messages-panel">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><?php _e( 'Communication Hub', 'org-ecosystem' ); ?></h3>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#newMessageModal">
            <i class="bi bi-pencil-square me-2"></i> <?php _e( 'Compose', 'org-ecosystem' ); ?>
        </button>
    </div>

    <ul class="nav nav-tabs mb-4 border-0 bg-light p-1 rounded-3" id="msgTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active border-0 rounded-3" data-bs-toggle="tab" data-bs-target="#inbox"><?php _e( 'Inbox', 'org-ecosystem' ); ?></button>
        </li>
        <li class="nav-item">
            <button class="nav-link border-0 rounded-3" data-bs-toggle="tab" data-bs-target="#sent"><?php _e( 'Sent', 'org-ecosystem' ); ?></button>
        </li>
    </ul>

    <div class="tab-content" id="msgTabContent">
        <?php if ( isset($_GET['error']) && $_GET['error'] === 'upgrade_required' ) : ?>
            <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-lock-fill me-2"></i> <?php _e( 'Direct messaging between members is a Professional feature. You can still message the Organization Admin.', 'org-ecosystem' ); ?>
                <a href="?action=billing" class="alert-link ms-2"><?php _e( 'Upgrade Now', 'org-ecosystem' ); ?></a>
            </div>
        <?php endif; ?>

        <?php
        $view_id = isset($_GET['view_msg']) ? intval($_GET['view_msg']) : 0;
        if ( $view_id ) :
            $msg = get_post($view_id);
            $is_admin = current_user_can('manage_options');
            $msg_rec_id = get_post_meta($view_id, '_msg_receiver_id', true);

            if ( $msg && (
                $msg->post_author == get_current_user_id() ||
                $msg_rec_id == get_current_user_id() ||
                ($is_admin && $msg_rec_id == 0)
            ) ) :
                update_post_meta($view_id, '_msg_read', '1');
            ?>
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0"><?php echo get_the_title($view_id); ?></h4>
                        <a href="?dash_page=messages" class="btn btn-sm btn-outline-secondary">Back to Inbox</a>
                    </div>
                    <div class="mb-4 text-muted small">
                        <strong>From:</strong> <?php echo get_the_author_meta('display_name', $msg->post_author); ?><br>
                        <strong>To:</strong> <?php
                            $to_id = get_post_meta($view_id, '_msg_receiver_id', true);
                            echo ($to_id == 0) ? 'Organization Admin' : get_userdata($to_id)->display_name;
                        ?><br>
                        <strong>Date:</strong> <?php echo get_the_date('', $view_id); ?>
                    </div>
                    <div class="message-content border-top pt-4">
                        <?php echo wpautop(esc_html($msg->post_content)); ?>
                    </div>

                    <div class="reply-form mt-5">
                        <h5 class="fw-bold mb-3"><?php _e( 'Send a Reply', 'org-ecosystem' ); ?></h5>
                        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                            <input type="hidden" name="action" value="org_send_message">
                            <?php
                            $receiver_id = ($msg->post_author == get_current_user_id()) ? get_post_meta($view_id, '_msg_receiver_id', true) : $msg->post_author;
                            ?>
                            <input type="hidden" name="receiver_id" value="<?php echo esc_attr($receiver_id); ?>">
                            <input type="hidden" name="msg_subject" value="Re: <?php echo esc_attr($msg->post_title); ?>">
                            <?php wp_nonce_field( 'org_send_message', 'org_message_nonce' ); ?>
                            <textarea name="msg_content" class="form-control bg-light border-0 py-3 mb-3" rows="4" placeholder="<?php _e( 'Type your reply here...', 'org-ecosystem' ); ?>" required></textarea>
                            <button type="submit" class="btn btn-primary px-4 fw-bold"><?php _e( 'Send Reply', 'org-ecosystem' ); ?></button>
                        </form>
                    </div>
                </div>
            <?php else : ?>
                <div class="alert alert-danger">Message not found or access denied.</div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Inbox -->
        <div class="tab-pane fade <?php echo !$view_id ? 'show active' : ''; ?>" id="inbox">
            <?php
            $user_id = get_current_user_id();
            $is_admin = current_user_can('manage_options');

            $inbox_args = array(
                'post_type'   => 'org_message',
                'post_status' => array('publish', 'pending', 'private'),
                'orderby'     => 'date',
                'order'       => 'DESC'
            );

            if ( $is_admin ) {
                // Admins see ALL messages in their "Management Inbox"
                // No meta_query needed if they see everything
            } else {
                $inbox_args['meta_query'] = array(
                    array( 'key' => '_msg_receiver_id', 'value' => $user_id ),
                );
            }

            $inbox = new WP_Query( $inbox_args );

            if ( $inbox->have_posts() ) : ?>
                <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden border">
                    <?php while ( $inbox->have_posts() ) : $inbox->the_post();
                        $is_read = get_post_meta( get_the_ID(), '_msg_read', true );
                    ?>
                        <div class="list-group-item p-4 <?php echo $is_read ? '' : 'bg-light-subtle border-start border-primary border-4'; ?>">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold"><?php the_title(); ?></h6>
                                <span class="small text-muted"><?php echo get_the_date(); ?></span>
                            </div>
                            <p class="mb-2 text-muted small"><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <?php echo get_avatar( get_the_author_meta('ID'), 24, '', '', array('class' => 'rounded-circle') ); ?>
                                    <span class="small">From: <strong><?php echo get_the_author(); ?></strong></span>
                                    <?php if($is_admin) :
                                        $to_id = get_post_meta(get_the_ID(), '_msg_receiver_id', true);
                                        $to_name = ($to_id == 0) ? 'Organization' : get_userdata($to_id)->display_name;
                                    ?>
                                        <span class="badge bg-secondary ms-2">To: <?php echo esc_html($to_name); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="?dash_page=messages&view_msg=<?php the_ID(); ?>" class="btn btn-sm btn-primary">View & Reply</a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                    <i class="bi bi-envelope-open display-4 text-light d-block mb-3"></i>
                    <p class="text-muted"><?php _e( 'No incoming messages.', 'org-ecosystem' ); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sent -->
        <div class="tab-pane fade" id="sent">
            <?php
            $sent = new WP_Query( array(
                'post_type' => 'org_message',
                'post_status' => array('publish', 'pending', 'private'),
                'author'    => $user_id,
            ) );

            if ( $sent->have_posts() ) : ?>
                <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden border">
                    <?php while ( $sent->have_posts() ) : $sent->the_post();
                        $rec_id = get_post_meta( get_the_ID(), '_msg_receiver_id', true );
                        $rec_name = ($rec_id == 0) ? 'Admin' : get_userdata($rec_id)->display_name;
                    ?>
                        <div class="list-group-item p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold"><?php the_title(); ?></h6>
                                <span class="small text-muted"><?php echo get_the_date(); ?></span>
                            </div>
                            <p class="mb-2 text-muted small"><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>
                            <span class="small text-muted">To: <strong><?php echo esc_html($rec_name); ?></strong></span>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                    <p class="text-muted"><?php _e( 'You haven\'t sent any messages yet.', 'org-ecosystem' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4 shadow-lg" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
      <input type="hidden" name="action" value="org_send_message">
      <?php wp_nonce_field( 'org_send_message', 'org_message_nonce' ); ?>
      <div class="modal-header border-0 p-4">
        <h5 class="modal-title fw-bold"><?php _e( 'New Connection', 'org-ecosystem' ); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4 pt-0">
        <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase"><?php _e( 'Recipient', 'org-ecosystem' ); ?></label>
            <select name="receiver_id" class="form-select bg-light border-0 py-2">
                <?php if ( ! current_user_can('manage_options') ) : ?>
                    <option value="0"><?php _e( 'Organization Admin', 'org-ecosystem' ); ?></option>
                <?php endif; ?>
                <?php
                if ( org_ecosystem_can_user_do( 'send_messages' ) ) :
                    $user_args = array( 'fields' => array('ID', 'display_name') );
                    if ( ! current_user_can('manage_options') ) {
                        $user_args['role__in'] = array('member', 'vendor');
                    }
                    $members = get_users( $user_args );
                    foreach ( $members as $m ) : if($m->ID == $user_id) continue; ?>
                        <option value="<?php echo $m->ID; ?>"><?php echo esc_html( $m->display_name ); ?></option>
                    <?php endforeach;
                endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase"><?php _e( 'Subject', 'org-ecosystem' ); ?></label>
            <input type="text" name="msg_subject" class="form-control bg-light border-0 py-2" placeholder="Brief topic..." required>
        </div>
        <div class="mb-0">
            <label class="form-label small fw-bold text-uppercase"><?php _e( 'Your Message', 'org-ecosystem' ); ?></label>
            <textarea name="msg_content" class="form-control bg-light border-0 py-2" rows="6" placeholder="Write your message here..." required></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 p-4 pt-0">
        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold"><?php _e( 'Send Message', 'org-ecosystem' ); ?></button>
      </div>
    </form>
  </div>
</div>
