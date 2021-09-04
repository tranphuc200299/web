$(document).ready(function () {
    open_modal();
    addMember();

    $(document).on('keyup', '.input-name', function () {
        changeDisable();
    });

    $(document).on('change', '.input-name', function () {
        changeDisable();
    });

    $(document).on('click', "#cancel_event", function () {
        Swal.closeModal();
    });
    $(document).on('click', "#agree_event", function () {
        location.href = this.getAttribute('data-href');
    });
});

let changeDisable = () => {
    let isValid = true;

    $('.input-name').each(function () {
        var element = $(this);
        if (element.val() == "") {
            isValid = false;
        }
    });

    if (isValid) {
        $('#confirm-button').removeAttr("disabled");
        $('#confirm-button').removeClass("btn-disable");
        $('.btn-add-new').removeAttr("disabled");
        $('.btn-add-new').removeClass("btn-disable");
    } else {
        $('#confirm-button').attr("disabled", true);
        $('#confirm-button').addClass("btn-disable");
        $('.btn-add-new').attr("disabled", true);
        $('.btn-add-new').addClass("btn-disable");
    }
};

function open_modal() {
    $('#open_modal').on('click', function () {
        let confirm = "true";
        let href    = $(this).attr('data-href');
        let imgSrc  = $(this).attr('data-image-src');
        if (confirm === 'true') {
            Swal.fire({
                html              : '<img style="width: 16px;height: 16px;margin-bottom: 5px;padding-top: 0" src="' + imgSrc + '"/>'+
                    "<p style='color: #fa6d88; font-size: 13px; font-weight: bold;'>登録を中断してトーク画面に戻りますか？</p>" +
                    "<p style='color: #fa6d88; font-size: 12px;font-weight: bold;'>※登録はまだ完了していません※</p>" +
                    '<button id="cancel_event" type="button" role="button" tabindex="0" class="btn btn-lg btn-full-width bg-color-primary">予約を続ける</button>' +
                    '<button id="agree_event" data-href="' + href + '" type="button" role="button" tabindex="0" class="btn btn-lg btn-full-width btn-back-screen-bot">トーク画面に戻る</button>',
                showCancelButton  : false,
                showConfirmButton : false
            });
        }
    });
}

function addMember() {
    let numberCusRegistered = $('#numberCusRegistered').val();

    $('.btn-add-new').on('click', function () {
        $('#confirm-button').prop("disabled", true);
        $('.btn-add-new').prop("disabled", true);
        $('#confirm-button').addClass("btn-disable");
        $('.btn-add-new').addClass("btn-disable");

        let html = $('#add-new').clone();

        let blockLength = $('.add-new').length;
        blockLength++;

        html.find('.button-toggle').attr('data-target', `#new-${ blockLength }`);
        html.find('.target').attr('id', `new-${ blockLength }`);
        html.find('#number-new-custom').text("家族" + Number(parseInt(numberCusRegistered) + parseInt(blockLength)));

        $('#form #form_register').append(html);
        cleanInput(html);
    });
}

$('.button-toggle').on("click", function () {
    $(this).find(".fa-chevron-down").toggleClass("hide");
    $(this).find(".fa-chevron-up").toggleClass("hide");
});

let cleanInput = (element) => {
    element.find('.input-name').val('');
}


function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

$('#year, #month').change(function () {
    if ($('#year').val().length > 0 && $('#month').val().length > 0) {
        $('#day').prop('disabled', false);
        $('#day').find('option').remove();

        var daysInSelectedMonth = daysInMonth($('#month').val(), $('#year').val());

        for (var i = 1; i <= daysInSelectedMonth; i++) {
            if (i < 10) {
                $('#day').append($("<option></option>").attr("value", i).text('0' + i));
            } else {
                $('#day').append($("<option></option>").attr("value", i).text(i));
            }
        }
    } else {
        $('#day').prop('disabled', true);
    }
});

