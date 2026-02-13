/**
 * Customizer Live Preview
 */
(function($) {
    // Global Colors
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--primary-color', newval);
        });
    });

    // Sections Loop for Live Preview
    var sections = ['header', 'footer', 'hero', 'stats', 'about', 'featured_members', 'featured_products', 'events', 'testimonials', 'announcements', 'news', 'partners'];
    var selectors = {
        'header': '.site-header',
        'footer': '.site-footer',
        'hero': '.section-hero',
        'stats': '.section-stats',
        'about': '.section-about',
        'featured_members': '.section-featured-members',
        'featured_products': '.section-featured-products',
        'events': '.section-events',
        'testimonials': '.section-testimonials',
        'announcements': '.section-announcements',
        'news': '.section-news',
        'partners': '.section-partners'
    };

    sections.forEach(function(sec) {
        // BG Color
        wp.customize(sec + '_bg_color', function(value) {
            value.bind(function(newval) {
                $(selectors[sec]).css('background-color', newval);
            });
        });

        // Text Color
        wp.customize(sec + '_text_color', function(value) {
            value.bind(function(newval) {
                $(selectors[sec]).css('color', newval);
            });
        });

        // Heading Color
        wp.customize(sec + '_h_color', function(value) {
            value.bind(function(newval) {
                $(selectors[sec] + ' h1,' + selectors[sec] + ' h2,' + selectors[sec] + ' h3,' + selectors[sec] + ' h4').css('color', newval);
            });
        });

        // Padding
        wp.customize(sec + '_padding_top', function(value) {
            value.bind(function(newval) {
                $(selectors[sec]).css('padding-top', newval + 'px');
            });
        });

        wp.customize(sec + '_padding_bottom', function(value) {
            value.bind(function(newval) {
                $(selectors[sec]).css('padding-bottom', newval + 'px');
            });
        });
    });

    // Content
    wp.customize('hero_title', function(value) {
        value.bind(function(newval) {
            $('.section-hero h1').text(newval);
        });
    });

})(jQuery);
