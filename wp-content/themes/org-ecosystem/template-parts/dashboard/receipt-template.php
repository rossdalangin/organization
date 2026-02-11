<?php
/**
 * Simple Invoice/Receipt Template
 */
if ( ! isset( $invoice ) ) return;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Receipt - <?php echo esc_html( $invoice['invoice_no'] ); ?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<style>
		body { background-color: #f8f9fa; padding: 50px 0; }
		.receipt-container { background: #fff; border-radius: 8px; }
		@media print {
			body { background-color: #fff; padding: 0; }
			.receipt-container { border: none !important; shadow: none !important; }
			.no-print { display: none; }
		}
	</style>
</head>
<body>
<div class="container no-print mb-4 text-center">
	<button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print Receipt</button>
</div>
<div class="receipt-container p-5 border shadow-sm mx-auto" style="max-width: 800px;">
	<div class="row mb-5">
		<div class="col-6">
			<h2 class="fw-bold text-primary"><?php bloginfo( 'name' ); ?></h2>
			<p class="text-muted"><?php echo esc_html( get_theme_mod( 'org_address' ) ); ?></p>
		</div>
		<div class="col-6 text-end">
			<h1 class="display-6 fw-bold"><?php _e( 'RECEIPT', 'org-ecosystem' ); ?></h1>
			<p class="mb-0"><strong><?php _e( 'Invoice #:', 'org-ecosystem' ); ?></strong> <?php echo esc_html( $invoice['invoice_no'] ); ?></p>
			<p><strong><?php _e( 'Date:', 'org-ecosystem' ); ?></strong> <?php echo esc_html( $invoice['date'] ); ?></p>
		</div>
	</div>

	<div class="row mb-5">
		<div class="col-6">
			<h6 class="text-uppercase text-muted small fw-bold"><?php _e( 'Bill To:', 'org-ecosystem' ); ?></h6>
			<h5 class="fw-bold"><?php echo esc_html( $invoice['user'] ); ?></h5>
			<p class="text-muted"><?php echo esc_html( $invoice['email'] ); ?></p>
		</div>
	</div>

	<table class="table table-bordered mb-5">
		<thead class="table-light">
			<tr>
				<th>Description</th>
				<th class="text-end">Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo esc_html( $invoice['plan'] ); ?> Membership Subscription</td>
				<td class="text-end"><?php echo esc_html( $invoice['currency'] . ' ' . number_format( $invoice['amount'], 2 ) ); ?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th class="text-end">Total</th>
				<th class="text-end text-primary h4"><?php echo esc_html( $invoice['currency'] . ' ' . number_format( $invoice['amount'], 2 ) ); ?></th>
			</tr>
		</tfoot>
	</table>

	<div class="footer text-center mt-5 pt-5 border-top">
		<p class="text-muted small"><?php _e( 'Thank you for being a part of our organization!', 'org-ecosystem' ); ?></p>
	</div>
</div>
</body>
</html>
