/**
 * Navigation JS for Mobile Menu
 */

(function() {
	var container, button, menu, links, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav' ) ) {
		menu.classList.add( 'nav' );
	}

	button.addEventListener( 'click', function() {
		container.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
			menu.classList.add( 'd-none' );
			menu.classList.remove( 'd-flex', 'flex-column' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
			menu.classList.remove( 'd-none' );
			menu.classList.add( 'd-flex', 'flex-column' );
		}
	} );

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav' ) ) {
			if ( 'li' === self.tagName.toLowerCase() ) {
				self.classList.toggle( 'focus' );
			}

			self = self.parentElement;
		}
	}
})();
