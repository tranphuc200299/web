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

// window.pace = require('pace-js');
// import '../plugins/pace.min';

window.classie = require('desandro-classie');
window.Swal = require('sweetalert2');
window.moment = require('moment');

import 'jquery-ui/ui/widgets/sortable';
import 'jquery-ui/ui/widgets/draggable';
import 'jquery-ui/ui/widgets/droppable';
import 'jquery-ui/ui/widgets/resizable';
import 'jquery-ui/ui/widgets/datepicker.js';

require('jquery.easing');
require('jquery-unveil');
require('jquery.actual');
require('jquery.scrollbar');
require('jquery-mask-plugin');
require('select2');
require('select2/dist/js/i18n/ja');
require('switchery');
require('slick-carousel');
require('bootstrap-colorpicker/dist/js/bootstrap-colorpicker');
require('jquery-validation');
require('bootstrap-confirmation2');
require('jquery.repeater');
require('jquery-ui/ui/i18n/datepicker-ja.js');
require('jquery-ui/ui/widgets/autocomplete');
require('tagmanager');
require('selectize');
require('bootstrap-daterangepicker');
require('selectize/dist/css/selectize.default.css');

require('../plugins/file-manager/stand-alone-button');
// require('../plugins/summernote-fontawesome');
require('../plugins/jquery.ioslist.min');
require('../plugins/jquery.schedule/pages.calendar');

require('../../common/js/lodash-install');
require('../../common/js/translator');
require('../../common/js/form-validation');
require('../../common/js/blockUI');
require('../../common/js/table-actions');

