require('../../js/plugins/jquery.blockUi.js');
LOADING = function () {
    let params = {
        message: '<i class="fa fas fa-spinner fa-spin"></i>',
        css: { border: 0, backgroundColor: 'transparent', color: '#fff', fontSize: '30px' },
        overlayCSS:  {
            backgroundColor: '#000',
            opacity:         0.3
        },
    };
    return {
        block: function (target) {
            $(target).block(params);
        },
        page: function(){
            $.blockUI(params);
        },
        unblock: function (target) {
            if (target && target != 'body') {
                $(target).unblock();
            } else {
                $.unblockUI();
            }
        }
    }
}();
