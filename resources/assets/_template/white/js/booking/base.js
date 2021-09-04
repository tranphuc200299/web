try {
    window.Popper = require('popper.js').default;
    window.interact = require('../plugins/interact.min');
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
window.Swal = require('sweetalert2');
require('jquery-ui/ui/i18n/datepicker-ja.js');
require('../booking/init')
require('../booking/validate_booking')
require('jquery-validation');
require('jquery-ui/ui/widgets/autocomplete');
require('summernote');
require('../plugins/summernote-fontawesome');
require('../../common/js/lodash-install');
require('../../common/js/translator');
require('../../common/js/form-validation');

