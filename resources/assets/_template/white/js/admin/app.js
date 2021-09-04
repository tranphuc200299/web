$(document).ready(function () {
    GLOBAL_CONFIG.init();
});

window.GLOBAL_CONFIG = function () {
    return {
        toggleBuilder: function () {
            $('[data-toggle=file-manager-image]').filemanager('image');
            $('[data-toggle=file-manager-file]').filemanager('file');
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                title: trans('message.confirm delete') ? trans('message.confirm delete') : 'Are you sure?',
                btnOkLabel: trans('message.yes') ? trans('message.yes') : 'Yes',
                btnCancelLabel: trans('message.no') ? trans('message.no') : 'No'
            });
            $('.repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if (confirm(trans('message.confirm delete') ? trans('message.confirm delete') : 'Are you sure?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            });

            // enable validate input hidden
            $.validator.setDefaults({
                ignore: [],
            });

            //jquery input mask
            $.applyDataMask();

            //Summer note setup
            // Define function to open filemanager window
            let lfm = function (options, cb) {
                let route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
                window.open(route_prefix, 'FileManager', 'width=900,height=600');
                window.SetUrl = cb;
                window.SetUrlMultiple = cb;
            };
            // Define LFM summernote button
            let LFMButton = function (context) {
                let ui = $.summernote.ui;
                let button = ui.button({
                    contents: '<i class="fa fa-picture-o"></i> ',
                    tooltip: 'Insert image',
                    click: function () {
                        lfm({type: 'image', prefix: ROUTE.FILE_MANAGER}, function (lfmItems, path) {
                            context.invoke('insertImage', path);
                        });

                    }
                });
                return button.render();
            };

            $('[data-toggle=editor-mini]').summernote({
                height: 100,
                toolbar: [
                    ['style', ['highlight', 'bold', 'italic', 'underline', 'clear']]
                ]
            });

            $('[data-toggle=editor]').summernote({
                height: 100,
                toolbar: [
                    ['style', ['highlight', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview', 'fullscreen']],
                ]
            });

            $('[data-toggle=editor-adv]').summernote({
                height: 300,
                toolbar: [
                    ['style', ['highlight', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['bold', 'underline', 'clear'], ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['popovers', ['lfm']],
                    ['view', ['codeview', 'fullscreen']],
                ],
                buttons: {
                    lfm: LFMButton
                }
            });

            /*setup datepicker jquery-ui*/
            $('[data-toggle=select2-single]').select2({});
            $('[data-toggle=select2-group]').select2({});
            $('[data-toggle=select2-multi]').select2({
                maximumSelectionLength: 4,
                placeholder: "With Max Selection limit 4",
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
            $.Pages.initSelect2Plugin();
            $.Pages.initSelectFxPlugin();
        }
    };
}();

import './partials/full_page.js';

require('../plugins/modal-custom.js');
require('../plugins/jquery-sortable');
require('../plugins/toast-sweet');
require('../plugins/dropdown-custom');
require('../plugins/vacxin/script.js');
require('./inventory.js');
require('./setting_attribute.js');
