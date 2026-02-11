<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main py-5">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header mb-5 text-center">
					<h1 class="display-4 fw-bold"><?php the_title(); ?></h1>
					<hr class="mx-auto" style="width: 60px; height: 4px; background-color: var(--bs-primary); border: 0; opacity: 1;">
				</header>

				<div class="entry-content bg-white p-4 p-md-5 shadow-sm border rounded">
					<?php
					the_content();

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'org-ecosystem' ),
						'after'  => '</div>',
					) );
					?>
				</div>

				<?php if ( comments_open() || get_comments_number() ) : ?>
					<div class="mt-5">
						<?php comments_template(); ?>
					</div>
				<?php endif; ?>
			</article>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
