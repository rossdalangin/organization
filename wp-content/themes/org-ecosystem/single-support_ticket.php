<?php
/**
 * The template for displaying single support tickets
 *
 * @package OrgEcosystem
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( wp_login_url() );
	exit;
}

$user_id = get_current_user_id();
$post_author = get_post_field( 'post_author', get_the_ID() );

// Only author or admin can view
if ( (int) $user_id !== (int) $post_author && ! current_user_can( 'manage_options' ) && ! current_user_can( 'manage_tickets' ) ) {
	wp_redirect( org_ecosystem_get_page_url( 'page-dashboard.php' ) );
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$status = get_post_meta( get_the_ID(), '_ticket_status', true ) ?: 'open';
    $dash_url = org_ecosystem_get_page_url( 'page-dashboard.php' );
	?>

	<main id="primary" class="site-main py-5 bg-light">
		<div class="container">
			<nav aria-label="breadcrumb" class="mb-4">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url($dash_url); ?>"><?php _e( 'Dashboard', 'org-ecosystem' ); ?></a></li>
					<li class="breadcrumb-item"><a href="<?php echo esc_url( add_query_arg( 'action', 'support', $dash_url ) ); ?>"><?php _e( 'Support Tickets', 'org-ecosystem' ); ?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
				</ol>
			</nav>

			<div class="card shadow-sm border-0 mb-4">
				<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
					<div>
						<a href="<?php echo esc_url( add_query_arg( 'action', 'support', $dash_url ) ); ?>" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i></a>
						<h1 class="h4 d-inline-block mb-0"><?php the_title(); ?></h1>
					</div>
					<span class="badge <?php echo $status === 'open' ? 'bg-warning text-dark' : 'bg-success'; ?>">
						<?php echo esc_html( ucfirst( $status ) ); ?>
					</span>
				</div>
				<div class="card-body p-4">
					<div class="ticket-message mb-4 p-3 bg-light rounded">
						<div class="d-flex justify-content-between mb-2">
							<strong><?php echo get_the_author(); ?></strong>
							<span class="text-muted small"><?php echo get_the_date( 'M d, Y H:i' ); ?></span>
						</div>
						<div class="content">
							<?php the_content(); ?>
						</div>
					</div>

					<hr class="my-4">

					<div class="ticket-replies">
						<h5 class="fw-bold mb-4"><?php _e( 'Conversation', 'org-ecosystem' ); ?></h5>
						<?php
						// Support tickets use standard comments for replies
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</main>

<?php
endwhile;

get_footer();
