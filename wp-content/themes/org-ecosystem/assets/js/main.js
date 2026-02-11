(function($) {
    'use strict';

    $(document).ready(function() {
        // Directory Filtering
        $('#directory-filter-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var resultsContainer = $('#directory-results');

            $.ajax({
                url: org_ajax.ajaxurl,
                type: 'POST',
                data: form.serialize() + '&action=directory_filter',
                beforeSend: function() {
                    resultsContainer.fadeTo('slow', 0.5);
                },
                success: function(data) {
                    resultsContainer.fadeTo('slow', 1);
                    resultsContainer.html(data);
                }
            });
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
