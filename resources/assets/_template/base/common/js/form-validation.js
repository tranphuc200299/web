
/**
 * Inintialize and Overide exsisting jquery-validate methods.
 *
 * @requires jquery-validate.js
 */
require('./i18n/jquery-validation');

jQuery.validator.addMethod("checktime", function(value, element) {
    return this.optional( element ) || /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])?$/.test( value );
}, trans('message.validate.checktime'));

jQuery.validator.addMethod("checkPhone", function(value, element) {
    return this.optional( element ) || /^[0-9]{10,11}$/.test( value );
}, trans('message.validate.phoneCheck'));

jQuery.validator.addMethod("validKatagana", function (value, element) {
    return this.optional(element) || /^([ァ-ヶー]+)$/.test(value) || /^([ｧ-ﾝﾞﾟ]+)$/.test(value);
}, trans('message.validate.kataganaCheck'));


let rules = ["withoutSpace", "requiredEmail", "requiredName", "requiredPhone", "requiredPassword", "requiredTypeParty"];
rules.forEach(function(rule){
    jQuery.validator.addMethod(rule, function(value, element) {
        let count = $.trim(value).length;
        if (count > 0) {
            return true;
        }

        return false;
    });
});
FormValidation = function () {
    return {
        init : function () {
            $('form.has_validate').validate({
                errorElement: 'div',
                errorClass: 'help-block help-block-error mb-2',
                focusInvalid: true,
                ignore: ".note-editor *",
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('bad');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('bad help-block help-block-error');
                },
                errorPlacement: function (error, element) {
                    validateErrorPlacement(error, element, true);
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('bad help-block help-block-error');
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
                if ($(element).attr('type') == 'radio' || $(element).attr('name') == 'g-recaptcha-response') {
                    $(element).parent().parent().append(error);
                    return true;
                }
                let parent = $(element).closest('.form-group');
                if (parent.hasClass('form-group-default')) {
                    parent.addClass('bad');
                    error.insertAfter(parent);
                } else {
                    let cont = $(element).parent();
                    if (cont.hasClass('checkbox-inline') || cont.hasClass('date-calendar') ) {
                        cont.parent().prepend(error);
                    } else if(cont.hasClass('input-group')) {
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

            $(document).on('click', '.has_validate button[type="submit"]', function (e) {
                e.preventDefault();
                let $this = $(this);
                let form = $this.parents('form');
                if (form.hasClass('has_validate') && !form.valid()) {
                    return false;
                }

                form.submit();

                return true;
            });

            setTimeout(function() {
                $(".time-out-message").fadeOut()
            }, 5000);
        }
    }
}();
jQuery(document).ready(function () {
    FormValidation.init()
});

