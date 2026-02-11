<?php
/**
 * Template Name: FAQ Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main py-5 bg-light">
	<div class="container">
		<header class="page-header text-center mb-5">
			<h1 class="display-4 fw-bold"><?php the_title(); ?></h1>
			<p class="lead text-muted"><?php _e( 'Find answers to common questions about our organization and membership.', 'org-ecosystem' ); ?></p>
		</header>

		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="accordion shadow-sm" id="faqAccordion">
					<?php
					$faqs = array(
						array(
							'q' => __( 'How do I join the organization?', 'org-ecosystem' ),
							'a' => __( 'You can join by clicking the "Join Now" button in the header and filling out the registration form. After submission, our team will review your application.', 'org-ecosystem' )
						),
						array(
							'q' => __( 'What are the membership levels?', 'org-ecosystem' ),
							'a' => __( 'We offer multiple levels: Free, Basic, Premium, Corporate, and Lifetime. Each level comes with different benefits and access to resources.', 'org-ecosystem' )
						),
						array(
							'q' => __( 'How can I list my business?', 'org-ecosystem' ),
							'a' => __( 'Once your membership is active, you can log in to your dashboard and navigate to the "My Business" section to create and manage your business listing.', 'org-ecosystem' )
						),
						array(
							'q' => __( 'Can I upgrade my plan later?', 'org-ecosystem' ),
							'a' => __( 'Yes, you can upgrade your plan at any time through the Billing section of your member dashboard.', 'org-ecosystem' )
						),
						array(
							'q' => __( 'Who do I contact for support?', 'org-ecosystem' ),
							'a' => __( 'Registered members can submit support tickets directly from their dashboard. Non-members can use our general contact form.', 'org-ecosystem' )
						)
					);

					foreach ( $faqs as $index => $faq ) :
						$id = 'faq-' . $index;
						?>
						<div class="accordion-item border-0 mb-3 rounded shadow-sm overflow-hidden">
							<h2 class="accordion-header" id="heading-<?php echo $id; ?>">
								<button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?> fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id; ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo $id; ?>">
									<?php echo esc_html( $faq['q'] ); ?>
								</button>
							</h2>
							<div id="collapse-<?php echo $id; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="heading-<?php echo $id; ?>" data-bs-parent="#faqAccordion">
								<div class="accordion-body bg-white py-4">
									<?php echo esc_html( $faq['a'] ); ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="mt-5 text-center p-5 bg-white border rounded shadow-sm">
					<h3><?php _e( 'Still have questions?', 'org-ecosystem' ); ?></h3>
					<p class="text-muted"><?php _e( 'We are here to help you. Reach out to our support team.', 'org-ecosystem' ); ?></p>
					<a href="<?php echo home_url( '/contact' ); ?>" class="btn btn-primary px-4"><?php _e( 'Contact Us', 'org-ecosystem' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
