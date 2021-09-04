$(document).scroll(function () {
    checkOffset();
});

function checkOffset() {
    let id = '.bottom-button';
    let footerTop = $('.footer').offset().top;

    if ($(id).offset().top + $('.bottom-button').height() >= footerTop - 150) {
        $(id).removeAttr('style');
        $(id).css('position', 'unset');
        $(id).css('box-shadow', 'none');
        $(id).removeClass('col-md-6 offset-md-3');
    }

    if ($(document).scrollTop() + window.innerHeight < footerTop - 150) {
        $(id).addClass('col-md-6 offset-md-3');
        $(id).css({
            'position': 'fixed',
            'z-index': '10',
            'left': '0',
            'bottom': '0',
            'padding': '15px',
            'box-shadow': '0pt 0pt 5pt'
        });
    }
}

$('body').on('click', '.table-schedule .fb', function () {
    if ($(this).parents('tbody').hasClass('open')) {
        $(this).parents('tbody').removeClass('open');
    } else {
        $(this).parents('tbody').addClass('open');
    }
});

$('[data-toggle=date-picker]').each(function (k, v) {
    var limitTimeNext = $('#limitTimeNext').val();
    var min_date  = $('#min_date').val();

    let configs = {
        dateFormat : 'yy-mm-dd',
        firstDay   : 0,
        maxDate    : limitTimeNext,
        minDate    : min_date,
        language   : 'ja',
    };
    $.each($(this).data(), function (key, value) {
        configs[key] = value;
    });

    $(this).datepicker(configs);
});

$(document).on('click', '.calendar-click', function () {
    $(this).parent().find('.zero-pixel').focus();
});

$(document).ready(function () {
    $('#submit-term').addClass('disabled');
});

$(document).on('click', '#check_term', function () {
    if ($(this).is(':checked')) {
        $('#submit-term').removeClass('disabled');
    } else {
        $('#submit-term').addClass('disabled');
    }
});
