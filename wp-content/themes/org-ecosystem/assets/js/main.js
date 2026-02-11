(function($) {
    'use strict';

    $(document).ready(function() {
        // Directory Filtering
        $('#directory-filter-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var resultsContainer = $('#directory-results');
            var paginationArea = $('.pagination-area');

            $.ajax({
                url: org_ajax.ajaxurl,
                type: 'POST',
                data: form.serialize() + '&action=directory_filter',
                beforeSend: function() {
                    resultsContainer.fadeTo('slow', 0.5);
                },
                success: function(data) {
                    resultsContainer.fadeTo('slow', 1);
                    // The backend now returns both items and pagination
                    // We wrap the items in col-lg-9 parent in archive-member.php
                    // but AJAX returns just the inner rows.
                    // Let's refine archive-member.php too if needed.
                    resultsContainer.html(data);
                    // Hide original pagination as new one is included in AJAX response
                    paginationArea.hide();
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
