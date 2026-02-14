<?php
/**
 * Template part for displaying membership plans table
 *
 * @package OrgEcosystem
 */

$levels = org_ecosystem_get_membership_levels();
?>

<div class="row g-4 justify-content-center">
    <?php foreach ( $levels as $key => $level ) : ?>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 pricing-card">
                <div class="card-header bg-white py-4 text-center border-0">
                    <h3 class="fw-bold mb-0"><?php echo esc_html( $level['name'] ); ?></h3>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="price mb-4">
                        <h2 class="display-4 fw-bold text-primary mb-0">
                            <?php echo $level['price'] > 0 ? '₱' . number_format( $level['price'] ) : __( 'Free', 'org-ecosystem' ); ?>
                        </h2>
                        <span class="text-muted small text-uppercase fw-bold"><?php echo esc_html( ucfirst( $level['duration'] ) ); ?></span>
                    </div>

                    <ul class="list-unstyled mb-5 text-start">
                        <?php if ( isset($level['features']) ) : ?>
                            <?php foreach ( $level['features'] as $feature ) : ?>
                                <li class="mb-2 small"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php echo esc_html( $feature ); ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <div class="d-grid">
                        <a href="<?php echo esc_url( add_query_arg( 'plan', $key, org_ecosystem_get_page_url( 'page-join.php' ) ) ); ?>" class="btn btn-<?php echo ($key === 'vendor' || $key === 'professional') ? 'primary' : 'outline-primary'; ?> btn-lg fw-bold">
                            <?php _e( 'Select Plan', 'org-ecosystem' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
