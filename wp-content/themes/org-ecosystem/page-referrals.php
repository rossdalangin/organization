<?php
/**
 * Template Name: Referral Program
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="referral-page py-5">
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4"><?php _e( 'Earn While You Grow', 'org-ecosystem' ); ?></h1>
                <div class="lead text-muted mb-5">
                    <?php
                    $referral_intro = get_option( 'org_referral_intro' );
                    if ( $referral_intro ) {
                        echo wp_kses_post( $referral_intro );
                    } else {
                        _e( 'Our Referral Program allows you to earn 10% commission on every product or service sale made by members you bring into the ecosystem.', 'org-ecosystem' );
                    }
                    ?>
                </div>
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo add_query_arg( 'action', 'referrals', org_ecosystem_get_page_url( 'templates/dashboard.php' ) ); ?>" class="btn btn-primary btn-lg px-5 rounded-pill shadow"><?php _e( 'Get Your Code', 'org-ecosystem' ); ?></a>
                <?php else : ?>
                    <a href="<?php echo org_ecosystem_get_page_url( 'page-join.php' ); ?>" class="btn btn-primary btn-lg px-5 rounded-pill shadow"><?php _e( 'Join & Start Earning', 'org-ecosystem' ); ?></a>
                <?php endif; ?>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="card border-0 shadow-lg rounded-4 p-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    <h3 class="fw-bold mb-4 text-center"><?php _e( 'How it Works', 'org-ecosystem' ); ?></h3>
                    <div class="d-flex mb-4">
                        <div class="badge bg-primary rounded-circle p-3 me-4" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 20px;">1</div>
                        <div>
                            <h5 class="fw-bold mb-1"><?php _e( 'Share Your Code', 'org-ecosystem' ); ?></h5>
                            <p class="text-muted small mb-0"><?php _e( 'Every member gets a unique referral ID in their dashboard.', 'org-ecosystem' ); ?></p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="badge bg-primary rounded-circle p-3 me-4" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 20px;">2</div>
                        <div>
                            <h5 class="fw-bold mb-1"><?php _e( 'Invite Professionals', 'org-ecosystem' ); ?></h5>
                            <p class="text-muted small mb-0"><?php _e( 'When they sign up using your link, they are locked to your network.', 'org-ecosystem' ); ?></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="badge bg-primary rounded-circle p-3 me-4" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 20px;">3</div>
                        <div>
                            <h5 class="fw-bold mb-1"><?php _e( 'Collect Commissions', 'org-ecosystem' ); ?></h5>
                            <p class="text-muted small mb-0"><?php _e( 'Get 10% of their sales instantly credited to your earnings.', 'org-ecosystem' ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
