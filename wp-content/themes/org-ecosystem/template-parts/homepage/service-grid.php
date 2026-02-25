<?php
/**
 * Homepage Service Excellence Grid
 */
?>
<section class="section-services py-section bg-light-subtle">
    <div class="container">
        <div class="text-center mb-5 animate-on-scroll">
            <h6 class="text-primary text-uppercase fw-bold letter-spacing-2 mb-2"><?php echo esc_html( get_theme_mod( 'expertise_subtitle', __( 'Our Expertise', 'org-ecosystem' ) ) ); ?></h6>
            <h2 class="display-5 fw-bold"><?php echo esc_html( get_theme_mod( 'expertise_title', __( 'Service Excellence for Growth', 'org-ecosystem' ) ) ); ?></h2>
            <div class="mx-auto bg-primary rounded" style="width: 80px; height: 4px; margin-top: 20px;"></div>
        </div>

        <div class="service-grid">
            <?php for($i=1; $i<=4; $i++) :
                $title = get_theme_mod("expertise_{$i}_title");
                $text = get_theme_mod("expertise_{$i}_text");
                $icon = get_theme_mod("expertise_{$i}_icon");
                if(!$title && !$text) continue;
            ?>
            <div class="service-item animate-on-scroll delay-<?php echo $i; ?>">
                <div class="service-icon mb-4"><i class="bi bi-<?php echo esc_attr($icon); ?>"></i></div>
                <h4 class="fw-bold mb-3"><?php echo esc_html($title); ?></h4>
                <p class="text-muted"><?php echo esc_html($text); ?></p>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
