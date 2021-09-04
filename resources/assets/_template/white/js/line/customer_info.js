$(document).ready(function () {
    $(document).on('keyup', '.input-name', function () {
        changeDisable();
    });

    $(document).on('change', '.input-name', function () {
        changeDisable();
    });

    $(document).on('click', '.customer', function () {
        $('.btn-next-step').removeAttr("disabled");
        $('.btn-next-step').removeClass("btn-disable");
        cleanInput();
    });
});

function cleanInput() {
    $(".input-name").each(function () {
        $(this).val("");
    })
}

function uncheckRadio() {
    $(".customer").each(function () {
        $(this).prop('checked', false);
    })
}

let changeDisable = () => {
    let isValid = true;

    $('.input-name').each(function () {
        var element = $(this);
        if (element.val() == "") {
            isValid = false;
        }
    });

    if (isValid) {
        uncheckRadio();
        $('.btn-next-step').removeAttr("disabled");
        $('.btn-next-step').removeClass("btn-disable");
    } else {
        $('.btn-next-step').attr("disabled", true);
        $('.btn-next-step').addClass("btn-disable");
    }
};

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

$('#year, #month').change(function () {
    console.log("asdf");
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

$('#btn-next-step').click(function () {
    let next        = $("#link-next").val();
    let code        = $("#code").val();
    let year        = $("#year").val();
    let month       = $("#month").val();
    let day         = $("#day").val();
    let area_id     = $("#area_id").val();
    let line_id     = $("#line_id").val();
    let customer_id = $("input:radio.customer:checked").val();

    if (typeof (customer_id) === 'undefined') {
        customer_id = 0;
    }

    let birthday = '';
    if (year != '') {
        birthday = year + '-' + month + '-' + day;
    }

    $.ajax({
        cache    : false,
        headers  : {"cache-control" : "no-cache"},
        url      : '/line/booking/customer',
        dataType : 'json',
        type     : 'post',
        data     : {
            birthday    : birthday,
            code        : code,
            customer_id : customer_id,
            area_id     : area_id,
            line_id     : line_id,
        },
        success  : function (response) {
            if (response.success) {
                window.location.href = next;
            }
        },
        error    : function (request) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });

});
