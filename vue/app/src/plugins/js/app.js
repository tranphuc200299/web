window.$ = window.jQuery = require('jquery');

$(document).ready(function () {
    window.GLOBAL_CONFIG.init();
});

window.GLOBAL_CONFIG = function () {
    return {
        toggleBuilder: function () {
            /*setup datepicker jquery-ui*/
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
                            if (params.page === undefined) {
                                params.page = 1;
                            }

                            let options = {
                                page: params.page
                            };
                            options[fieldName + ''] = params.term;

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
                    templateResult: function (item) {
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
                    templateSelection: function (item) {
                        return item[fieldName] || item.text;
                    }
                });
            });

            $('.select-loading').on('change', function () {
                if ($(this).find('option:selected').data('href') !== undefined) {
                    window.location = $(this).find('option:selected').data('href')
                }
            });

            /*setup datepicker jquery-ui*/
            $('[data-toggle=date-picker]').each(function (k, v) {
                let configs = {
                    dateFormat: 'yy-mm-dd',
                    firstDay: 0,
                    language: 'ja',
                };
                $.each($(this).data(), function (key, value) {
                    configs[key] = value;
                });

                $(this).datepicker(configs);
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
                    timePicker: true,
                    timePicker24Hour: true,
                    timePickerIncrement: 1,
                    timePickerSeconds: true,
                    singleClasses: "picker_3",
                    locale: {
                        format: 'HH:mm:ss'
                    }
                }).on('show.daterangepicker', function (ev, picker) {
                    picker.container.find(".calendar-table").hide();
                });
                $(this).on("apply.daterangepicker", function (e, picker) {
                    picker.element.val(picker.startDate.format(picker.locale.format));
                });
            });

            $('[data-toggle=time-minute-picker]').each(function (k, v) {
                $(this).daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    timePicker: true,
                    timePicker24Hour: true,
                    timePickerIncrement: 1,
                    timePickerSeconds: false,
                    singleClasses: "picker_3",
                    locale: {
                        format: 'HH:mm'
                    }
                }).on('show.daterangepicker', function (ev, picker) {
                    picker.container.find(".calendar-table").hide();
                });
                $(this).on("apply.daterangepicker", function (e, picker) {
                    $('#' + picker.element.attr('id') + '-error').remove();
                    picker.element.val(picker.startDate.format(picker.locale.format));
                });
            });

            $(".toggle-password").click(function () {
                $(this).toggleClass("fa-eye fa-eye-slash");
                let input = $($(this).attr("toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $('.unmask-button').click(function () {
                $('.unmask').unmask();
                $('.unmask-form').submit();
            });

            $('[data-toggle=btn-back]').click(function () {
                window.history.back();
            });

            $('#btn-reset').click(function (e){
                e.preventDefault();
                let form = $('.filter');
                form[0].reset();
                form.find("select").val(null).trigger("change");
            });
            $('#pageNumber').on('change', function (){
                $('#search_form').submit();
            });
        },
        init: function () {
            this.toggleBuilder();
            // $.Pages.initSelect2Plugin();
            // $.Pages.initSelectFxPlugin();
        }
    };
}();
