<?php
/**
 * Dashboard GDPR & Privacy Part
 */
?>
<h2 class="h4 mb-4"><?php _e( 'Privacy & GDPR Compliance', 'org-ecosystem' ); ?></h2>
<p class="text-muted mb-4"><?php _e( 'Manage your data and privacy settings according to GDPR regulations.', 'org-ecosystem' ); ?></p>

<div class="row g-4">
	<div class="col-md-6">
		<div class="card border h-100 shadow-sm">
			<div class="card-body p-4">
				<h5 class="fw-bold mb-3"><?php _e( 'Export My Data', 'org-ecosystem' ); ?></h5>
				<p class="small text-muted mb-4"><?php _e( 'Request a full export of all your personal information stored on this platform.', 'org-ecosystem' ); ?></p>
				<button type="button" class="btn btn-outline-primary" onclick="alert('Export request submitted. You will receive an email shortly.')"><?php _e( 'Request Data Export', 'org-ecosystem' ); ?></button>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card border h-100 shadow-sm">
			<div class="card-body p-4">
				<h5 class="fw-bold mb-3"><?php _e( 'Account Deletion', 'org-ecosystem' ); ?></h5>
				<p class="small text-muted mb-4"><?php _e( 'Permanently delete your account and all associated data from our systems.', 'org-ecosystem' ); ?></p>
				<button type="button" class="btn btn-outline-danger" onclick="confirm('Are you absolutely sure? This action cannot be undone.')"><?php _e( 'Request Deletion', 'org-ecosystem' ); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="card mt-4 border shadow-sm">
	<div class="card-body p-4">
		<h5 class="fw-bold mb-3"><?php _e( 'Privacy Preferences', 'org-ecosystem' ); ?></h5>
		<div class="form-check form-switch mb-3">
			<input class="form-check-input" type="checkbox" id="prefEmail" checked>
			<label class="form-check-input-label fw-bold" for="prefEmail"><?php _e( 'Receive monthly newsletters', 'org-ecosystem' ); ?></label>
		</div>
		<div class="form-check form-switch mb-3">
			<input class="form-check-input" type="checkbox" id="prefProfile" checked>
			<label class="form-check-input-label fw-bold" for="prefProfile"><?php _e( 'Show my profile in public directory', 'org-ecosystem' ); ?></label>
		</div>
		<button type="button" class="btn btn-primary btn-sm mt-2"><?php _e( 'Save Preferences', 'org-ecosystem' ); ?></button>
	</div>
</div>
