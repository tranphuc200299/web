$('#btn-next-step').click(function (e) {
    e.preventDefault();
    let termCheck = checkCookie();

    if (termCheck) {
        submitStep1();
    }
});

$(document).on('click', '#submit-term', function () {
    let areaId = $('.content_popup_term').attr('data-area-id');
    if ($('#check_term').is(':checked')) {
        setCookie(`term_verify_${areaId}`, 1, 365);
        $('#term_accept').modal('hide');

        submitStep1();
    }
});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function submitStep1() {
    let accept_type = $("#accept_type").val();
    let url_next = $("#link_next").val();
    let date_format = $("#date_format").val();
    let birthday = $("#birthday").val();
    let code = $("#code").val();
    let area_id = $("#area_id").val();
    let venue_type = $("#venue_type").val();
    let access_token = $("#access_token").val();

    let isSickBlock = $('.notice-sick');
    if (isSickBlock.length > 0) {
        let status = checkError();
        if (!status) {
            return false;
        }
    }

    let formData = new FormData($('form')[0]);
    formData.append('area_id', area_id);
    if ($("#line_id").val() !== undefined) {
        formData.append('line_id', $("#line_id").val());
    }
    if (accept_type == 1) {
        if ($("#choose_sick").val() == 1) {
            let is_sick = 1;
            if ($('#no_sick').is(":checked")) {
                is_sick = 0
            }

            formData.append('is_sick', is_sick);

            var list_sick = [];
            $('input[name="sick-name"]:checked').each(function () {
                list_sick.push($(this).val());
            });
            formData.append('list_sick', JSON.stringify(list_sick));
        } else {
            formData.append('is_sick', $('input[name="is_sick"]:checked').val());
        }
    }

    if (code.length > 0 && birthday.length > 0) {
        $('#btn-next-step').prop('disabled', true);
        $.ajax({
            cache: false,
            headers: {"cache-control": "no-cache"},
            url: '/booking/input-step2',
            dataType: 'json',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    var link_next_step = url_next + '?area_id=' + area_id + '&birthday=' + birthday + '&code=' + code;
                    if (venue_type !== '') {
                        link_next_step = link_next_step + '&venue_type=' + venue_type;
                    }
                    if (access_token !== '') {
                        link_next_step = link_next_step + '&access_token=' + access_token;
                    }
                    window.location.href = link_next_step;
                } else {
                    $('#btn-next-step').prop('disabled', false);
                    showPopupError(response.error_code, response.data);
                }
            },
            error: function (request) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
    }
}

function checkCookie() {
    let areaId = $('.content_popup_term').attr('data-area-id');
    var termStatus = $('#term_status').val();
    var termUrl = $('#term_url').val();
    let cookie = getCookie(`term_verify_${areaId}`);

    if (cookie == null && termStatus && termUrl != '') {
        $('#term_accept').modal('show');
        return false;
    }

    return true;
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

$(document).ready(function () {
    confirm();

    $(document).on('click', "#agree_event", function () {
        Swal.closeModal();
    });

    $(document).on('click', "#second-booking-cancel", function () {
        Swal.closeModal();
    });

    $(document).on('click', "#second-booking-confirm", function () {
        callAjaxConfirm();
    });
});
function confirm() {
    $('#confirm-booking').on('click', function () {
        let isShowPopup = $(this).attr('data-show-popup');
        if (isShowPopup) {
            let html = $('#modal-remind-auto-create-second-booking').html();

            Swal.fire({
                html: html,
                showCancelButton: false,
                showConfirmButton: false
            });
            return;
        }
        callAjaxConfirm();
    });
}

function callAjaxConfirm() {
    let href = $('#confirm-booking').attr('data-href');
    let link_confirm = $("#link_confirm").val();
    $('#confirm-booking').prop('disabled', true);
    var spinner = $('#loader');
    spinner.show();

    $.ajax({
        cache: false,
        headers: {"cache-control": "no-cache"},
        url: link_confirm,
        dataType: 'json',
        type: 'post',
        data: {},
        success: function (response) {
            if (response.success) {
                window.location.href = href;
            } else {
                let html = $('#modal-confirm').html();

                Swal.fire({
                    html: html,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
            spinner.hide();
        },
        error: function (request) {
            spinner.hide();
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
}

$('body').on('click', '.book-time-start', function () {
    let url_next = $("#link_next_step_3").val();
    let date_booking = $("#date_booking").val();
    let time = $(this).attr('time-data');
    let date_choosed = $(this).attr('date-data');
    let venueId = $('.venue-list').find('.origin-selected').attr('attr-data');
    let vaccineId = $('.vaccine-list').find('.origin-selected').attr('attr-data');
    let venue_type = $("#venue_type").val();
    let access_token = $("#access_token").val();

    window.location.href = url_next + "&start_time=" + time + "&date_booking=" + date_choosed
        + "&date_range=" + date_booking + "&venue_id=" + venueId + "&vaccine_id=" + vaccineId + "&venue_type=" + venue_type+ "&access_token=" + access_token;

    /*
    $.ajax({
        cache    : false,
        headers  : {"cache-control" : "no-cache"},
        url      : '/booking/select-time',
        dataType : 'json',
        type     : 'post',
        data     : {
            time      : time,
            date      : date,
            venueId   : venueId,
            vaccineId : vaccineId,
        },
        success  : function (response) {
            if (response.success) {
                window.location.href = url_next;
            }
        },
        error    : function (request) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
    */
});

$(document).on('click', '.dropdown-select-custom', function () {
    let listSelect = $(this).parents('.form-group').find('.selected-list');

    if ($(this).find('.search-venue').length > 0) {
        if (!$('.search-venue').is(':visible')) {
            $('.search-venue').show().focus();
        }
    }

    if ($('.venues-select').hasClass('active')) {
        if ($(this).find('.search-venue').length > 0) {
            $('.search-venue').hide();
        }
    } else {
        if ($(this).find('.search-venue').length > 0) {
            $('.search-venue').show().focus();
        }

        setTimeout(function(){
            $('.venues-select').animate({
                scrollTop: document.getElementById("venue-selected").offsetTop
            });
        }, 300)
    }

    if (!listSelect.hasClass('active')) {
        $('.dropdown-select-custom').removeClass('active');
        $(this).parents('.form-group').find('.selected-list').addClass('active');
    } else {
        $(this).parents('.form-group').find('.selected-list').removeClass('active');
    }
});

$(document).on('click', '.list-click', function () {
    let optionSelect = $(this);
    let valueSelect = optionSelect.attr('attr-data');
    let clickVenue = optionSelect.hasClass('venue');

    optionSelect.parents('.form-group').find('.origin-selected').attr('attr-data', valueSelect);

    fillText(optionSelect);

    let venueId = $('.venue-list').find('.origin-selected').attr('attr-data');
    let vaccineId = $('.vaccine-list').find('.origin-selected').attr('attr-data');

    $('#schedule_content').show();

    callAjax(venueId, vaccineId, clickVenue);
});


let fillText = (ele) => {
    ele.parents('.form-group').find('.origin-selected').find('.label-select')
        .text(ele.find('.label-select').text());
    ele.parents('.form-group').find('.origin-selected').find('.badge-pink-romantic')
        .text(ele.find('.badge-pink-romantic').text());
    ele.parents('.form-group').find('.origin-selected').find('.vaccine-text')
        .text(ele.find('.vaccine-text').text());
};

$(document).on('change', '#calendar-date', function () {
    let current = window.location.href;
    let venueId = $('.venue-list').find('.origin-selected').attr('attr-data');
    let vaccineId = $('.vaccine-list').find('.origin-selected').attr('attr-data');
    let area_id = $("#area_id").val();
    let date_booking = $("#date_booking").val();
    let birthday = $("#birthday").val();
    let code = $("#code").val();
    let venue_type = $("#venue_type").val();


    if (current.includes("&ymd")) {
        var n = current.indexOf("&ymd");

        // 15 is length of invalid date
        var res = current.substr(n, 15);
        var newHref = current.replace(res, '&ymd=' + $(this).val());
        window.location.href = `${newHref}&code=${code}&birthday=${birthday}&venue_id=${venueId}&vaccine_id=${vaccineId}
            &flag=1&venue_type=${venue_type}`;
    } else {
        window.location.href += `&ymd=` + $(this).val() + `&code=${code}&birthday=${birthday}&venue_id=${venueId}&vaccine_id=${vaccineId}&flag=1&venue_type=${venue_type}`;
    }
});

$('#next_date, #forward_date').click(function () {
    e.preventDefault();
    var url = this.href;
    var spinner = $('#loader');
    spinner.show();
    setTimeout(function () {
        window.location.href = url;
    }, 0);
});

let callAjax = (venue_id, vaccine_id, clickVenue) => {
    var spinner = $('#loader');
    spinner.show();

    let area_id = $("#area_id").val();
    let date_booking = $("#date_booking").val();
    let birthday = $("#birthday").val();
    let code = $("#code").val();
    let venue_type = $("#venue_type").val();
    $.ajax({
        cache: false,
        headers: {"cache-control": "no-cache"},
        url: '/booking/schedule',
        dataType: 'json',
        type: 'post',
        data: {
            venue_id: venue_id,
            clickVenue: clickVenue,
            vaccine_id: vaccine_id,
            date: date_booking,
            area_id: area_id,
            birthday: birthday,
            code: code,
            venue_type: venue_type,
        },
        success: function (response) {
            if (response.success) {
                $('.search-venue').hide();
                if (response.data['view-select'] !== "undefined") {
                    $('#vaccine-venue').html(response.data['view-select']);
                }

                $('#schedule_content').html(response.data['view-xo']);

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

                spinner.hide();
            } else {
                spinner.hide();
                showPopupError(response.error_code);
            }
        },
        error: function (request) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
};

function showPopupError(error_code, data) {
    if (error_code == 1) {
        if (typeof data != 'undefined') {
            console.log(data);
            $('#modal-greater-age .fill-year').text(data.year);
            $('#modal-greater-age .fill-month').text(data.month);
            $('#modal-greater-age .fill-date').text(data.date);
        }

        let html = $('#modal-greater-age').html();
        Swal.fire({
            html: html,
            showCancelButton: false,
            showConfirmButton: false
        });
    } else if (error_code == 2) {
        let html = $('#modal-enough-booking').html();
        Swal.fire({
            html: html,
            showCancelButton: false,
            showConfirmButton: false
        });
    } else if (error_code == 3) {
        let html = $('#modal-input').html();
        Swal.fire({
            html: html,
            showCancelButton: false,
            showConfirmButton: false
        });
    } else if (error_code == 4) {
        let html = $('#modal-sick-customer').html();

        Swal.fire({
            html: html,
            showCancelButton: false,
            showConfirmButton: false
        });
    } else if (error_code == 6) {
        let html = $('#diff_venue').html();
        Swal.fire({
            html: html,
            showCancelButton: false,
            showConfirmButton: false,
            onClose: reloadSchedule
        });
    } else if (error_code == 7) {
        let html = $('#is_banned').html();
        Swal.fire({
            html: html,
            showCancelButton: false,
            showConfirmButton: false,
        });
    } else {
        let html = $('#modal-60-to-64').html();

        Swal.fire({
            html: html,
            showCancelButton: false,
            showConfirmButton: false
        });
    }
}

function reloadSchedule() {
    location.reload();
}

$(document).on('click', '#no_sick', function () {
    if ($(this).is(':checked')) {
        $(this).parents('.form-group').addClass('success-check');
        $(this).parents('li').addClass('success-border-check');
        $('input[name=sick-name]').each(function () {
            $(this).prop('checked', false);
            $(this).parents('.form-group').removeClass('success-check');
            $(this).parents('li').removeClass('success-border-check');
        })
    } else {
        $(this).parents('.form-group').removeClass('success-check');
        $(this).parents('li').removeClass('success-border-check');
    }
    checkError();
});

$(document).on('click', 'input[name=sick-name]', function () {
    if ($(this).is(':checked')) {
        $(this).parents('.form-group').addClass('success-check');
        $(this).parents('li').addClass('success-border-check');
    } else {
        $(this).parents('.form-group').removeClass('success-check');
        $(this).parents('li').removeClass('success-border-check');
    }

    $('#no_sick').prop('checked', false);
    $('#no_sick').parents('.form-group').removeClass('success-check');
    $('#no_sick').parents('li').removeClass('success-border-check');
    checkError();
});

let checkError = () => {
    let status = false;
    if ($('#no_sick').is(':checked')) {
        status = true;
    }

    $('input[name=sick-name]').each(function () {
        if ($(this).is(':checked')) {
            status = true;
        }
    })

    if (status === false) {
        $('.sick-block ul li').addClass('red-check');
        $('#no_sick').prop('required', true);
    } else {
        $('.sick-block ul li').removeClass('red-check');
        $('#no_sick').prop('required', false);
    }

    return status;
}

function delay(callback, ms) {
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

$(document).on('keyup', '.search-venue', delay(function (e) {
    let textSearch = $('.search-venue').val();
    let area_id = $("#area_id").val();
    let birthday = $("#birthday").val();
    let code = $("#code").val();
    let venue_type = $("#venue_type").val();
    let venueId = $('.venue-list').find('.origin-selected').attr('attr-data');
    let vaccine_id = $('.vaccine-list').find('.origin-selected').attr('attr-data');

    var spinner = $('#loader');
    spinner.show();

    $.ajax({
        cache: false,
        headers: {"cache-control": "no-cache"},
        url: '/booking/get_venue',
        dataType: 'json',
        type: 'post',
        data: {
            area_id: area_id,
            text: textSearch,
            birthday: birthday,
            code: code,
            venue_id: venueId,
            venue_type: venue_type,
            vaccine_id: vaccine_id
        },
        success: function (response) {
            if (response.success && response.data != '') {
                $('.venues-select').empty().html(response.data);
            }
            spinner.hide();
        },
        error: function (request) {
            console.log("ajax call went wrong:" + request.responseText);
            spinner.hide();
        }
    });
}, 500));
