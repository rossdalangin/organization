/**
 * Navigation JS for Mobile Menu and Accessibility
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		// Close offcanvas when a link is clicked (useful for anchor links)
		$('.mobile-nav-list a').on('click', function() {
			var offcanvasElement = document.getElementById('mobileMenu');
			var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
			if (offcanvas) {
				offcanvas.hide();
			}
		});

		// Add active class to current menu items
		$('.nav-list .current-menu-item').addClass('active');
	});

})(jQuery);
