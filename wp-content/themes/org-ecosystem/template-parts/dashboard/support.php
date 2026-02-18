<?php
/**
 * Dashboard Support Tickets Part
 */
$user_id = get_current_user_id();
$tickets = new WP_Query( array(
	'post_type' => 'support_ticket',
	'author' => $user_id,
	'posts_per_page' => -1,
) );
?>
<?php
$view_id = isset($_GET['view_ticket']) ? intval($_GET['view_ticket']) : 0;
if ( $view_id ) :
    $ticket = get_post($view_id);
    if ( $ticket && (int) $ticket->post_author === (int) get_current_user_id() ) :
    ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">#<?php echo $view_id; ?>: <?php echo get_the_title($view_id); ?></h4>
                        <a href="?dash_page=support" class="btn btn-sm btn-outline-secondary">Back to Tickets</a>
            </div>
            <div class="mb-4 text-muted small">
                <strong>Status:</strong> <?php echo strtoupper(get_post_meta($view_id, '_ticket_status', true)); ?><br>
                <strong>Date Submitted:</strong> <?php echo get_the_date('', $view_id); ?>
            </div>
            <div class="ticket-description bg-light p-3 rounded mb-4">
                <?php echo wpautop(esc_html($ticket->post_content)); ?>
            </div>

            <div class="ticket-replies mt-5">
                <h5 class="fw-bold mb-4">Replies & Updates</h5>
                <?php
                $comments = get_comments(array('post_id' => $view_id, 'order' => 'ASC'));
                if ( $comments ) : ?>
                    <div class="list-group list-group-flush border rounded-4 overflow-hidden mb-4">
                        <?php foreach ( $comments as $comment ) : ?>
                            <div class="list-group-item p-3 <?php echo ($comment->user_id == 1) ? 'bg-primary-subtle' : ''; ?>">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong class="small"><?php echo ($comment->user_id == 1) ? 'Support Team' : 'You'; ?></strong>
                                    <span class="text-muted small"><?php echo comment_date('', $comment); ?></span>
                                </div>
                                <div class="small"><?php comment_text($comment); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="text-muted small">No replies yet. Our team will review your request shortly.</p>
                <?php endif; ?>

                <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" class="mt-4">
                    <input type="hidden" name="action" value="org_reply_ticket">
                    <input type="hidden" name="ticket_id" value="<?php echo $view_id; ?>">
                    <?php wp_nonce_field('org_reply_ticket', 'security'); ?>
                    <div class="mb-3">
                        <textarea name="reply_content" class="form-control" rows="3" placeholder="Add a reply..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Post Reply</button>
                </form>
            </div>
        </div>
    <?php
    else :
        echo '<div class="alert alert-danger">Ticket not found.</div>';
    endif;
endif;
?>

<div class="<?php echo $view_id ? 'd-none' : ''; ?>">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0"><?php _e( 'Support & Messaging', 'org-ecosystem' ); ?></h2>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newTicketModal">
            <i class="bi bi-plus-lg me-1"></i> <?php _e( 'New Ticket', 'org-ecosystem' ); ?>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover border">
            <thead class="table-light">
                <tr>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( $tickets->have_posts() ) : ?>
                    <?php while ( $tickets->have_posts() ) : $tickets->the_post(); ?>
                        <tr>
                            <td><strong><?php the_title(); ?></strong></td>
                            <td><?php echo get_the_date(); ?></td>
                            <td>
                                <?php
                                $status = get_post_meta( get_the_ID(), '_ticket_status', true ) ?: 'open';
                                $badge_class = ( $status === 'open' ) ? 'bg-warning text-dark' : 'bg-success';
                                ?>
                                <span class="badge <?php echo $badge_class; ?>"><?php echo esc_html( ucfirst( $status ) ); ?></span>
                            </td>
                            <td>
                                <a href="?dash_page=support&view_ticket=<?php the_ID(); ?>" class="btn btn-sm btn-outline-primary"><?php _e( 'View', 'org-ecosystem' ); ?></a>
                            </td>
                        </tr>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted"><?php _e( 'No tickets found.', 'org-ecosystem' ); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- New Ticket Modal -->
<div class="modal fade" id="newTicketModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
			<input type="hidden" name="action" value="org_submit_ticket">
			<?php wp_nonce_field( 'org_submit_ticket', 'org_ticket_nonce' ); ?>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php _e( 'Submit New Ticket', 'org-ecosystem' ); ?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label"><?php _e( 'Subject', 'org-ecosystem' ); ?></label>
						<input type="text" name="ticket_subject" class="form-control" required>
					</div>
					<div class="mb-3">
						<label class="form-label"><?php _e( 'Message', 'org-ecosystem' ); ?></label>
						<textarea name="ticket_message" class="form-control" rows="5" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php _e( 'Cancel', 'org-ecosystem' ); ?></button>
					<button type="submit" class="btn btn-primary"><?php _e( 'Submit Ticket', 'org-ecosystem' ); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>
