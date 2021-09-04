
FULL_PAGE = function() {
    return {
        show: function () {
            $('body').addClass('no-header');
            $('.page-container .header').hide();
            $('.page-content-wrapper .content .jumbotron').hide();
            
            return true;
        },
        reset: function () {
            $('body').removeClass('no-header');
            $('.page-container .header').show();
            $('.page-content-wrapper .content .jumbotron').show();
            
            return true;
        }
    };
}();
