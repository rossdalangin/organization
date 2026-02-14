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
			<div class="lead text-muted">
                <?php
                $faq_intro = get_option( 'org_faq_intro' );
                if ( $faq_intro ) {
                    echo wp_kses_post( $faq_intro );
                } else {
                    _e( 'Find answers to common questions about our organization and membership.', 'org-ecosystem' );
                }
                ?>
            </div>
		</header>

		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="accordion shadow-sm" id="faqAccordion">
					<?php
					$faqs_query = new WP_Query( array(
                        'post_type'      => 'faq',
                        'posts_per_page' => -1,
                    ) );

                    if ( $faqs_query->have_posts() ) :
                        $index = 0;
                        while ( $faqs_query->have_posts() ) : $faqs_query->the_post();
						    $id = 'faq-' . get_the_ID();
						?>
						<div class="accordion-item border-0 mb-3 rounded shadow-sm overflow-hidden">
							<h2 class="accordion-header" id="heading-<?php echo $id; ?>">
								<button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?> fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id; ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo $id; ?>">
									<?php the_title(); ?>
								</button>
							</h2>
							<div id="collapse-<?php echo $id; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="heading-<?php echo $id; ?>" data-bs-parent="#faqAccordion">
								<div class="accordion-body bg-white py-4">
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					<?php
                        $index++;
                        endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <div class="text-center py-5 text-muted">
                            <p><?php _e( 'No FAQs found. Please check back later.', 'org-ecosystem' ); ?></p>
                        </div>
                    <?php endif; ?>
				</div>

				<div class="mt-5 text-center p-5 bg-white border rounded shadow-sm">
					<h3><?php _e( 'Still have questions?', 'org-ecosystem' ); ?></h3>
					<p class="text-muted"><?php _e( 'We are here to help you. Reach out to our support team.', 'org-ecosystem' ); ?></p>
					<a href="<?php echo org_ecosystem_get_page_url( 'page-contact.php' ); ?>" class="btn btn-primary px-4"><?php _e( 'Contact Us', 'org-ecosystem' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
