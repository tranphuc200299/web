(function ($) {

    'use strict';

    $(document).ready(function () {
        // Initializes search overlay plugin.
        // Replace onSearchSubmit() and onKeyEnter() with
        // your logic to perform a search and display results
        $(".list-view-wrapper").scrollbar();
    });


    $('.panel-collapse label').on('click', function (e) {
        e.stopPropagation();
    });

    $('.copy-clipboard').on('click', function () {

        let id = $(this).data('target');
        let copyText = $('' + id);

        let input = document.createElement("input");
        input.value = copyText.text();

        if (copyText.is(':input') === true) {
            input.value = copyText.val();
        }

        document.body.appendChild(input);
        input.select();

        $(this).tooltip('hide')
            .attr('data-original-title', 'コピー')
            .tooltip('show');

        document.execCommand("Copy");
        input.remove();
    })

})(window.jQuery);
