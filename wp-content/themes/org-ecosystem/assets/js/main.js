(function($) {
    'use strict';

    $(document).ready(function() {
        // Header Scroll Effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.site-header').addClass('scrolled shadow-sm');
            } else {
                $('.site-header').removeClass('scrolled shadow-sm');
            }
        });

        // Directory Filtering
        function loadDirectory(paged = 1) {
            var form = $('#directory-filter-form');
            var resultsContainer = $('#directory-results');
            var paginationArea = $('.pagination-area');

            var formData = form.serialize();
            formData += '&action=directory_filter&paged=' + paged;

            $.ajax({
                url: org_ajax.ajaxurl,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    resultsContainer.fadeTo('slow', 0.5);
                    // Scroll to top of results
                    $('html, body').animate({
                        scrollTop: resultsContainer.offset().top - 100
                    }, 500);
                },
                success: function(data) {
                    resultsContainer.fadeTo('slow', 1);
                    resultsContainer.html(data);
                    // Original pagination is inside resultsContainer if it's the AJAX result
                    // so we might need to hide the initial one on first load
                    paginationArea.first().hide();
                }
            });
        }

        $('#directory-filter-form').on('submit', function(e) {
            e.preventDefault();
            loadDirectory(1);
        });

        $(document).on('click', '#directory-results .pagination a', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var paged = 1;
            if (href.indexOf('paged=') > -1) {
                paged = href.split('paged=')[1].split('&')[0];
            }
            loadDirectory(paged);
        });

        // Stats Counter Animation
        $('.counter').each(function() {
            var $this = $(this);
            var countTo = $this.attr('data-target');

            $({ countNum: $this.text() }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(this.countNum);
                }
            });
        });
    });

})(jQuery);
