/**
 * Inintialize and Overide exsisting jquery-validate methods.
 *
 * @requires jquery-validate.js
 */
require('./i18n/jquery-validation');

jQuery.validator.addMethod("checktime", function (value, element) {
    return this.optional(element) || /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])?$/.test(value);
}, trans('message.validate.checktime'));

jQuery.validator.addMethod("checkPhoneNumber", function (value, element) {
    return this.optional(element) || /^[0-9-]{10,13}$/.test(value);
}, trans('message.validate.phone'));

jQuery.validator.addMethod("requiredby", function (value, element) {
    let field = $.trim($(element).attr('data-rule-requiredBy'));

    if (!$(field).is(":checked")) {
        return true;
    }

    if ($(field).is(":checked") && value) {
        return true;
    }

    return false;
}, trans('message.validate.required'));

jQuery.validator.addMethod("checkCode", function (value, element) {
    var ticketLength = $('#code').attr('ticket-length');
    if (typeof ticketLength !== "undefined") {
        ticketLength = Number(ticketLength);
    }
    else {
        ticketLength = 10;
    }
    var regex = RegExp(`^[0-9-]{${ticketLength}}$`);
    return this.optional(element) || regex.test(value);
}, trans('message.validate.code'));

jQuery.validator.addMethod("check8Digits", function (value, element) {
    return this.optional(element) || /^(19|20)\d\d(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/.test(value);
}, trans('message.validate.8digits'));

jQuery.validator.addMethod("check4Digits", function (value, element) {
    return this.optional(element) || /^[0-9-]{4}$/.test(value);
}, trans('message.validate.4digits'));

jQuery.validator.addMethod("compareHour", function (value, element) {
    let startTime = $('#start_time').val();
    let endTime = value;

    let dataStart = moment(startTime, 'hh:mm').valueOf();
    let dataEnd = moment(endTime, 'hh:mm').valueOf();

    if(dataStart > dataEnd){
        return false;
    }

    return true;
}, trans('message.validate.checkEndTime'));

jQuery.validator.addMethod("checkUrl", function (value, element) {
    return this.optional(element) || /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/.test(value);
}, trans('message.validate.checkUrl'));

jQuery.validator.addMethod("checkPhone", function (value, element) {
    return this.optional(element) || /^[0-9]{10,11}$/.test(value);
}, trans('message.validate.phoneCheck'));

jQuery.validator.addMethod("validKatagana", function (value, element) {
    return this.optional(element) || /^([ァ-ヶー]+)$/.test(value) || /^([ｧ-ﾝﾞﾟ]+)$/.test(value);
}, trans('message.validate.katakana'));

jQuery.validator.addMethod("validHiragana", function(value, element) {
        return this.optional(element) || /^[ぁ-ん 　]+$/.test(value);
}, trans('message.validate.hiragana'));

jQuery.validator.addMethod("validPassword", function (value, element) {
    return this.optional(element) || /^[A-Za-z\d!@#$%*?&]{6,50}$/.test(value) || !value;
}, trans('message.validate.password'));

jQuery.validator.addMethod('IP4Checker', function (value) {
    if (!value) {
        return true;
    }

    let split = value.split('.');

    if (split.length !== 4) {
        return false;
    }

    for (var i = 0; i < split.length; i++) {
        var s = split[i];
        if (s.length === 0 || isNaN(s) || s < 0 || s > 255)
            return false;
    }
    return true;
}, trans('message.validate.IPv4Check'));

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

let rules = ["withoutSpace", "requiredEmail", "requiredName", "requiredPhone", "requiredPassword", "requiredTypeParty"];
rules.forEach(function (rule) {
    jQuery.validator.addMethod(rule, function (value, element) {
        let count = $.trim(value).length;
        if (count > 0) {
            return true;
        }

        return false;
    });
});
FormValidation = function () {
    return {
        init: function () {
            $('form.form_validation').validate({
                errorElement: 'div',
                errorClass: 'form-control-feedback help-block help-block-error mb-2',
                focusInvalid: true,
                ignore: ".note-editor *",
                highlight: function (element) {
                    $(element).closest('.form-group').addClass(' has-error');
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
                if ($(element).attr('type') === 'radio' || $(element).attr('name') === 'g-recaptcha-response') {
                    $(element).parent().parent().append(error);
                    return true;
                }

                if ($(element).attr('type') === 'checkbox') {
                    $(element).parent().parent().append(error);
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

            $('form.form_submit_check input, form.form_submit_check select, form.form_submit_check textarea').on('keyup keydown change select2:close', function () {
                let $this = $(this);
                let form = $this.parents('form');
                form.validate().element($(this));
                if (form.hasClass('form_validation') && !form.validate().checkForm()) {
                    form.find('button[type="submit"]').prop('disabled', true);
                    form.find('#btn-next-step').prop('disabled', true);
                } else {
                    form.find('button[type="submit"]').prop('disabled', false);
                    form.find('#btn-next-step').prop('disabled', false);
                }
            });

            $(document).on('click', 'button[type="submit"]', function (e) {
                e.preventDefault();
                let $this = $(this);
                let form = $this.parents('form');
                if (form.hasClass('form_validation') && !form.validate().checkForm()) {
                    form.valid();
                    return false;
                }

                form.submit();
                form.find('button[type="submit"]').prop('disabled', true);
            });

            $.each($('form.form_submit_check'), function (i, v) {
                let form = $(v);
                if (form.hasClass('form_validation') && !form.validate().checkForm()) {
                    form.find('button[type="submit"]').prop('disabled', true);
                    form.find('#btn-next-step').prop('disabled', true);
                } else {
                    form.find('button[type="submit"]').prop('disabled', false);
                    form.find('#btn-next-step').prop('disabled', false);
                }
            });

            setTimeout(function () {
                $(".time-out-message").fadeOut()
            }, 5000);
        }
    }
}();
jQuery(document).ready(function () {
    FormValidation.init()
});

