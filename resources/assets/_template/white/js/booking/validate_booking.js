$(document).on('keyup', 'input', function () {
    let target = $(this);
    let targetParent = target.parents('.form-group');
    let targetCheckBlock = targetParent.find('.block-input-check');
    let errorHtml = '<i class="fa fa-remove check-input red-check-input" aria-hidden="true"></i>';
    let checkHtml = '<i class="fa fa-check check-input" aria-hidden="true"></i>';


    if (targetParent.hasClass('has-error')) {
        targetParent.find('input').removeClass('green-check');
        targetParent.find('input').addClass('red-check');
        targetCheckBlock.find('.check-input').remove();

        if (targetCheckBlock.find('.red-check-input').length === 0) {
            targetCheckBlock.append(errorHtml);
        }
    } else {
        targetParent.find('input').removeClass('red-check');
        targetParent.find('input').addClass('green-check');
        targetParent.find('.block-input-check').append(checkHtml);
        targetCheckBlock.find('.red-check-input').remove();

        if (targetCheckBlock.find('.check-input').length === 0) {
            targetCheckBlock.append(errorHtml);
        }
    }
});

$(document).on('click', 'input[name=is_sick]', function () {
    let parentCheck = $(this);
    let html = '<i class="fa fa-check check-input" aria-hidden="true"></i>';

    parentCheck.parents('.sick-block').find('.block-check').removeClass('green-check');
    parentCheck.parents('.sick-block').find('.block-check').find('.check-input').remove();
    parentCheck.parents('.block-check').addClass('green-check').append(html);
});

$(document).on('click', 'input[name=sex]', function () {
    let parentCheck = $(this);
    let html = '<i class="fa fa-check check-input top-sgroup" aria-hidden="true"></i>';

    parentCheck.parents('.sex-block').find('.block-check').removeClass('green-check');
    parentCheck.parents('.sex-block').find('.block-check').find('.check-input').remove();
    parentCheck.parents('.block-check').addClass('green-check').append(html);
});

$(document).on('click', '.option_radio', function () {
    let parentCheck = $(this);
    let html = '<i class="fa fa-check check-input top-sgroup" aria-hidden="true"></i>';

    parentCheck.parents('.option-block').find('.block-check').removeClass('green-check');
    parentCheck.parents('.option-block').find('.block-check').find('.check-input').remove();
    parentCheck.parents('.block-check').addClass('green-check').append(html);
});

$(document).on('keyup', '#code', function () {
    let code = parseInt($(this).val().length);
    let ticketLength = $(this).attr('ticket-length');
    if (typeof ticketLength !== 'undefined') {
        ticketLength = Number(ticketLength);
    }
    else {
        ticketLength = 10;
    }
    let count = ticketLength - code;


    $('.orange_color').text(`${count > 0 ? count : 0} ケタ`);
    $('.increase_number').text(code);
});
