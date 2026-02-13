/**
 * Customizer Live Preview
 */
(function($) {
    // Hero Title
    wp.customize('hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero-section h1').text(newval);
        });
    });

    // Hero Subtitle
    wp.customize('hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero-section .lead').text(newval);
        });
    });

    // Colors
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--primary-color', newval);
        });
    });

    wp.customize('header_bg_color', function(value) {
        value.bind(function(newval) {
            $('.site-header').css('background-color', newval);
        });
    });

})(jQuery);
