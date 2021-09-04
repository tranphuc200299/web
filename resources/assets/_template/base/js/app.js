require('./plugin.js');
window.interact = require('interactjs');
window.moment = require('moment');
jQuery.validator.addMethod("images",
    function (value, element) {
        if (this.optional(element) || !element.files || !element.files[0]) {
            return true;
        } else {
            let fileType = element.files[0].type;
            return /^(image)\//i.test(fileType);
        }
    },
    'Sorry, we can only accept image files.'
);

FormValidation = function () {
    return {
        init: function () {
            $('form.form_validation').validate({
                errorElement: 'div',
                errorClass: 'help-block-error',
                focusInvalid: true,
                ignore: ".note-editor *",
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error help-block help-block-error');
                },
                errorPlacement: function (error, element) {
                    validateErrorPlacement(error, element, true);
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error help-block help-block-error');
                }
            });

            $('input[name^="p_images"]').each(function () {
                $(this).rules('add', {
                    extension: 'jpg|jpeg|png'
                });
            });

            function validateErrorPlacement(error, element, place) {
                if (!place || place == undefined) {
                    place = false;
                }
                if ($(element).attr('type') === 'radio') {
                    $(element).parent().parent().parent().append(error);
                    return true;
                }

                if ($(element).attr('type') === 'checkbox') {
                    $(element).parent().parent().parent().parent().append(error);
                    return true;
                }

                let parent = $(element).closest('.form-group');
                if (parent.hasClass('form-group-default')) {
                    parent.addClass('has-error');
                    error.insertAfter(parent);
                } else {
                    let cont = $(element).parent();
                    if (cont.hasClass('checkbox-inline') || cont.hasClass('date-calendar')) {
                        cont.parent().prepend(error);
                    } else if (cont.hasClass('input-group')) {
                        cont.parent().append(error);
                    } else {
                        if (!place) {
                            element.parent().prepend(error);
                        } else {
                            element.parent().append(error);
                        }
                    }
                }

            }

            $(document).on('click', 'button[type="submit"]', function (e) {
                e.preventDefault();
                let $this = $(this);
                let form = $this.parents('form');
                if (form.hasClass('has_validate') && !form.valid()) {
                    return false;
                }

                form.submit();

                return true;
            });

            setTimeout(function () {
                $(".time-out-message").fadeOut()
            }, 5000);
        }
    }
}();

DatePickerSetting = function () {
    return {
        init: function () {
            $('[data-toggle=date-picker]').each(function (k, v) {
                $(this).daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    timePicker : false,
                    timePicker24Hour : true,
                    timePickerIncrement : 1,
                    timePickerSeconds : true,
                    singleClasses: "picker_3",
                    locale : {
                        format : 'YYYY/MM/DD'
                    }
                }, function(start, end, label) {
                    //console.log(start.toISOString(), end.toISOString(), label);
                });
                $(this).on("apply.daterangepicker", function(e, picker) {
                    picker.element.val(picker.startDate.format(picker.locale.format));
                });
            });

            $('[data-toggle=datetime-picker]').each(function (k, v) {
                $(this).daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    timePicker : true,
                    timePicker24Hour : true,
                    timePickerIncrement : 1,
                    timePickerSeconds : true,
                    singleClasses: "picker_3",
                    locale : {
                        format : 'YYYY/MM/DD HH:mm:ss'
                    }
                }, function(start, end, label) {
                    //console.log(start.toISOString(), end.toISOString(), label);
                });
                $(this).on("apply.daterangepicker", function(e, picker) {
                    picker.element.val(picker.startDate.format(picker.locale.format));
                });
            });

            $('[data-toggle=time-picker]').each(function (k, v) {
                $(this).daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    timePicker : true,
                    timePicker24Hour : true,
                    timePickerIncrement : 1,
                    timePickerSeconds : true,
                    singleClasses: "picker_3",
                    locale : {
                        format : 'HH:mm:ss'
                    }
                }).on('show.daterangepicker', function(ev, picker) {
                    picker.container.find(".calendar-table").hide();
                });
                $(this).on("apply.daterangepicker", function(e, picker) {
                    picker.element.val(picker.startDate.format(picker.locale.format));
                });
            });
        }
    }
}();
ElementSetting = function () {
    return {
        init: function () {
            $('[data-toggle=select2-single]').select2({});
            $('[data-toggle=select2-group]').select2({});
            $('[data-toggle=select2-multi]').select2({
                allowClear: true
            });

            $.each($('[data-toggle=select2-ajax]'), function (i, select2) {
                let url = $(select2).data('url');
                let fieldName = $(select2).data('field');

                $(select2).select2({
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            if(params.page === undefined) {
                                params.page = 1;
                            }

                            let options = {
                                page: params.page
                            };
                            options[fieldName+''] = params.term;

                            return options;
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.data,
                                pagination: {
                                    more: (params.page * 30) < data.total
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Search',
                    minimumInputLength: 1,
                    templateResult: function(item){
                        if (item.loading) {
                            return item.text;
                        }
                        var $container = $(
                            "<div class='select2-result clearfix'>" +
                            "<div class='select2-result__meta'>" +
                            "<div class='select2-result__title'></div>" +
                            "</div>" +
                            "</div>"
                        );

                        $container.find(".select2-result__title").text(item[fieldName]);

                        return $container;
                    },
                    templateSelection: function(item){
                        return item[fieldName] || item.text;
                    }
                });
            });

            $('.checkbox-flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            if ($(".button-switch")[0]) {
                let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                elems.forEach(function (html) {
                    let switchery = new Switchery(html, {
                        color: '#26B99A'
                    });
                });
            }
        }
    }
}();
jQuery(document).ready(function () {
    FormValidation.init();
    DatePickerSetting.init();
    ElementSetting.init();
});
