<?php
/**
 * Homepage Stats Section
 */
?>
<section class="section-stats stats-section py-5 bg-white border-bottom">
	<div class="container">
		<?php if ( $title = get_theme_mod('stats_title') ) : ?>
			<div class="text-center mb-5 animate-on-scroll">
				<h2 class="fw-bold"><?php echo esc_html($title); ?></h2>
				<?php if ( $subtitle = get_theme_mod('stats_subtitle') ) : ?>
					<p class="text-muted"><?php echo esc_html($subtitle); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="row g-4 text-center">
			<?php for($i=1; $i<=4; $i++) :
				$label = get_theme_mod("stat_{$i}_label");
				$value = get_theme_mod("stat_{$i}_value");
				if(!$label && !$value) continue;
			?>
			<div class="col-6 col-md-3 animate-on-scroll delay-<?php echo $i; ?>">
				<div class="stat-item p-4">
					<span class="impact-counter counter" data-target="<?php echo esc_attr($value); ?>">0</span>
					<p class="text-muted text-uppercase small fw-bold mb-0"><?php echo esc_html($label); ?></p>
				</div>
			</div>
			<?php endfor; ?>
		</div>
	</div>
</section>
