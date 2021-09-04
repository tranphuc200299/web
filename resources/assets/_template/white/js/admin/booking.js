$(document).ready(function () {
    $('.status_receipt').on('click', function () {
        let id = $(this).val();
        if ($(this).is(':checked')) {
            let statusCheck = 1;
            checkStatusReceipt(id, statusCheck);
        } else {
            let statusUnCheck = 0;
            checkStatusReceipt(id, statusUnCheck);
        }
    });

    function checkStatusReceipt(id, statusCheck) {
        $.ajax({
            url: ROUTES.CHECK_STATUS_RECEIPT + "?id=" + id + '&status_receipt=' + statusCheck,
            type: 'GET',
            success: function (response) {
                if (response.code === 400) {
                    $('.card-body').prepend(
                        ' <div class="alert alert-danger" role="alert">\n' +
                        '<button class="close" data-dismiss="alert"></button>\n' +
                        '<strong>' + response.data + '</strong>\n' +
                        '</div>');
                }
            },
            error: function (request) {
                $('.card-body').prepend(
                    ' <div class="alert alert-danger" role="alert">\n' +
                    '<button class="close" data-dismiss="alert"></button>\n' +
                    '<strong>変更に失敗しました。再度試してください。 </strong>\n' +
                    '</div>');
            }
        });
    }

    $('.status_inoculated').on('click', function () {
        let id = $(this).val();
        if ($(this).is(':checked')) {
            let statusCheck = 1;
            checkStatusInoculated(id, statusCheck)
        } else {
            let statusUnCheck = 0;
            checkStatusInoculated(id, statusUnCheck)
        }
    });

    function checkStatusInoculated(id, status) {
        $.ajax({
            url: ROUTES.CHECK_STATUS_INOCULATED + "?id=" + id + '&status_inoculated=' + status,
            type: 'GET',
            success: function(response) {
                if (response.code === 400) {
                    $('.card-body').prepend(
                        ' <div class="alert alert-danger" role="alert">\n' +
                        '<button class="close" data-dismiss="alert"></button>\n' +
                        '<strong>'+response.data+'</strong>\n' +
                        '</div>');
                }
            },
            error: function (request) {
                $('.card-body').prepend(
                    ' <div class="alert alert-danger" role="alert">\n' +
                    '<button class="close" data-dismiss="alert"></button>\n' +
                    '<strong>変更に失敗しました。再度試してください。 </strong>\n' +
                    '</div>');
            }
        });
    }

    $('body').on('shown.bs.modal', '#listBookingOnBox',function () {
        $('.status_receipt').on('click', function () {
            let id = $(this).val();
            if ($(this).is(':checked')) {
                let statusCheck = 1;
                checkStatusReceipt(id, statusCheck);
            } else {
                let statusUnCheck = 0;
                checkStatusReceipt(id, statusUnCheck);
            }
        });
    });

    $('body').on('shown.bs.modal', '#create_booking', function () {
        $(".form_validation").validate({
            unhighlight: function (element, errorClass, validClass) {
                var elem = $(element);
                elem.removeClass(errorClass);
            },
            errorPlacement: function (error, element) {
                if (element.prop('type') === 'select-one' && !element.hasClass('select-birthday')) {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    element.parent().append(error);
                }
            }
        });

        $.extend($.validator.messages, {
            minlength: $.validator.format("{0}桁で入力してください。"),
            number: $.validator.format("半角数字で入力してください。")
        });

        const code = $("#code");
        const birthday = $('#birthday');
        const date = $("#date");
        const time = $('#time_manual');
        const vaccine = $('#vaccine_id');

        const venue = $("#venue_id");

        date.datepicker({
            dateFormat : 'yy/mm/dd',
            firstDay   : 0,
            language   : 'ja',
        });

        if (venue.val()) {
            date.prop('disabled', false);
            time.prop('disabled', false);
            vaccine.prop('disabled', false);
            getVenue(venue.val());
            getHoursForTimeInput(venue.val());
            getVaccineWithVenue(venue.val());
        }

        venue.on('change', function () {
            let venue_id = $(this).val();
            let time = $('#time_manual');

            if (venue_id) {
                time.find('option').remove().end();
                vaccine.find('option').remove().end();
                date.prop('disabled', false);
                time.prop('disabled', false);
                vaccine.prop('disabled', false);
                // date.datepicker("destroy");
                getVenue(venue_id);
                getHoursForTimeInput(venue_id);
                getVaccineWithVenue(venue_id);
            } else {
                date.prop('disabled', true);
                time.prop('disabled', true);
                vaccine.prop('disabled', true);
                time.find('option').remove().end();
                vaccine.find('option').remove().end();
            }
        });

        function getVenue(venue_id) {
            $.ajax({
                url: ROUTES.GET_VENUE_AJAX + "?id=" + venue_id,
                type: 'GET',
                success: function (response) {
                    let dates = response;
                    let maxMonth = $('#max_booking_month').val();

                    date.datepicker("option", {
                        maxDate: maxMonth === '0' ? '1m' : '+' + (parseInt(maxMonth)) + 'm',
                    });
                }
            });
        }

        function getHoursForTimeInput(venue_id) {
            let time = $('#time_manual');
            $.ajax({
                url: ROUTES.GET_HOUR + "?id=" + venue_id,
                type: 'GET',
                success: function (response) {
                    if (response.data === 404) {
                        time.trigger('change');
                    } else {
                        $.each(response, function (index, value) {
                            time.append($("<option></option>").attr("value", value).text(value));
                        });
                        time.find('option').each(function () {
                            if ($('#time_booking').val() && $('#time_booking').val() === $(this).val()) {
                                $(this).attr('selected', true);
                            }
                        });
                    }
                }
            });
        }

        function getVaccineWithVenue(venue_id) {
            $.ajax({
                url: ROUTES.GET_VACCINE_AJAX + "?id=" + venue_id,
                type: 'GET',
                success: function (response) {
                    if (response.data === 404) {
                        vaccine.trigger('change');
                    } else {
                        $.each(response, function (index, value) {
                            $('#vaccine_id').append($("<option></option>").attr("value", value.vaccine_id).text(value.vaccine.name));
                        });
                        vaccine.find('option').each(function () {
                            if ($('#vaccine_booking').val() && $('#vaccine_booking').val() === $(this).val()) {
                                $(this).attr('selected', true);
                            }
                        });
                    }
                }
            });
        }

        code.autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'GET',
                    url: ROUTES.LIST_CUSTOMER_AJAX + '?ticket_number=' + $('#code').val(),
                    dataType: 'JSON',
                    success: function (data) {
                        try {
                            response($.map(data.data, function (item) {
                                var items = new Object();

                                items.label = item.ticket_number;
                                items.value = item.ticket_number;

                                items.birthday = item.birthday;
                                items.vaccine_id = item.vaccine_id;
                                items.fullname_kana = item.fullname_kana;
                                items.email = item.email;
                                items.phone = item.phone;
                                items.sex = item.sex;
                                items.is_sick = item.is_sick;
                                items.list_sick = item.sicks;
                                items.streets_address = item.streets_address;
                                items.option_1 = item.option_1;
                                items.option_2 = item.option_2;
                                items.option_3 = item.option_3;

                                return items;
                            }));
                        } catch (err) {}
                    }
                });
            },
            minLength: 1,
            focus: function (event, ui) {
                $('#code').val(ui.item.value);
                fillUpInfoAfterInsertCode(ui);
                return false;
            },
            select: function (event, ui) {
                fillUpInfoAfterInsertCode(ui);
                return false;
            }
        });

        function fillUpInfoAfterInsertCode(ui) {
            let birthdayValue = ui.item.birthday;
            birthday.val(birthdayValue);
            if (birthdayValue && birthdayValue.length === 8) {
                let year = birthdayValue.substring(0, 4);
                $("#age").text(year ? countAge(year) : 0);
            }

            $('#vaccine_id').val(ui.item.vaccine_id).trigger('change')
            $('#fullname_kana').val(ui.item.fullname_kana);
            $('#email').val(ui.item.email);
            $('#phone').val(ui.item.phone);
            $('#streets_address').val(ui.item.streets_address);
            $('#option_1').val(ui.item.option_1);
            $('#option_2').val(ui.item.option_2);
            $('#option_3').val(ui.item.option_3);
            if (ui.item.sex === "1") {
                $('#male').prop('checked', true);
            } else if (ui.item.sex === "2") {
                $('#female').prop('checked', true);
            } else {
                $('#other').prop('checked', true);
            }

            if (ui.item.is_sick == "1") {
                $('#yes').prop('checked', true);
            } else {
                $('#no').prop('checked', true);
            }

            fillSickToCheckBox(ui.item.list_sick);
        }

        function fillSickToCheckBox(listSicks) {
            let sicks = JSON.parse(listSicks);
            $(`.sick-data`).prop('checked', false);

            if (sicks !== null && sicks.length > 0) {
                sicks.forEach(function (val) {
                    $(`.sick-data[value=${val}]`).prop('checked', true);
                });
            }
        }

        function countAge(year) {
            let currentYear = new Date().getFullYear();
            return Number(currentYear - year);
        }

        birthday.on('change keyup', function () {
            let birth = $(this).val();
            if (birth.length === 8) {
                let year = birth.substring(0, 4);
                $('#age').text(countAge(year));
            } else {
                let year = new Date().getFullYear();
                $('#age').text(countAge(year));
            }
        });

        let year = birthday.val();
        $('#age').text(year && year.length === 8 ? countAge(year.substring(0, 4)) : 0);

        // submit form create
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit-second').on('click', function (e) {
            e.preventDefault();
            let type = 3;
            saveBooking(type, true);
        });

        $('#submit-reset').on('click', function (e) {
            e.preventDefault();
            let type = 1;
            saveBooking(type);
        });

        $('#submit-reload').on('click', function (e) {
            e.preventDefault();
            let type = 2;
            saveBooking(type);
        });

        $('#booking-update').on('click', function (e) {
            e.preventDefault();
            let type = 1;
            saveBooking(type);
        });

        function calculateTime() {
            let date = $('#date').val();
            let numWeek = 3;
            let now = new Date(date);
            now.setDate(now.getDate() + numWeek * 7);
            var nextTime = now.getFullYear() + '/' + ('0' + (now.getMonth() + 1)).slice(-2) + '/' + ('0' + now.getDate()).slice(-2);

            return nextTime;
        }

        function validTimeBooking(timeBooking, time, venueId, vaccineId, code, birthday) {
            var status = '';
            $.ajax({
                url: ROUTES.CHECK_BOOKING_AJAX,
                type: 'POST',
                async: false,
                data: {'new_date' : timeBooking, 'time' : time, 'venue_id' : venueId, 'vaccine_id' : vaccineId, 'code' : code, 'birthday' : birthday},
                success: function (response) {
                    var data = JSON.parse(response);
                    status = data.status;
                }
            });

            return status;
        }

        function showAlert(text) {
            Swal.fire({
                text: text,
                type: 'error',
                showConfirmButton: true,
                confirmButtonColor: '#2FBCD3',
                confirmButtonText: 'はい'
            }).then((result) => {
                if (result.value) {
                    location.reload();
                }
            });
        }

        function showSuccess(text) {
            Swal.fire({
                text: text,
                type: 'success',
                showConfirmButton: true,
                confirmButtonText: 'はい'
            }).then((result) => {
                if (result.value) {
                    location.reload();
                }
            });
        }

        function showAlertSecond(text) {
            Swal.fire({
                text: text,
                type: 'error',
                title: 'Oops...',
                showConfirmButton: true,
                confirmButtonColor: '#2FBCD3',
                confirmButtonText: 'はい'
            });
        }

        function showSuccessSecond(text) {
            Swal.fire({
                text: text,
                type: 'success',
                showConfirmButton: true,
                confirmButtonText: 'はい'
            });
        }

        function saveBooking(type, isAddDay = false) {
            let form = $('#create');
            let spinner = $('#loader');
            if ($('.form_validation').valid()) {
                spinner.show();
                $.ajax({
                    url: ROUTES.STORE_BOOKING_AJAX,
                    type: 'POST',
                    async: false,
                    data: form.serialize(),
                    success: function (response) {
                        spinner.hide();
                        if (response.code === 200 || response.code === 201) {
                            if (type === 1) {
                                showSuccess(response.message);
                            } else if (type === 3) {
                                showSuccessSecond(response.message);
                                if (isAddDay === true) {
                                    let timeBooking = calculateTime();
                                    $('#date').val(timeBooking);
                                    $("#submit-second").hide();
                                    $("#clear-reset").show();
                                }
                            } else {
                                location.reload();
                            }
                        } else if (response.code === 401) {
                            /*error: cannot create or update*/
                            showAlert(response.message);

                        } else if (response.code === 400) {
                            /*error: can create or update with confirmation*/
                            Swal.fire({
                                text: response.message,
                                type: 'warning',
                                showCancelButton: true,
                                showConfirmButton: true,
                                confirmButtonColor: '#2FBCD3',
                                cancelButtonColor: '#FF7D00',
                                confirmButtonText: 'はい',
                                cancelButtonText: 'いいえ'
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        url     : ROUTES.STORE_BOOKING_AJAX,
                                        type    : 'POST',
                                        async   : false,
                                        data    : form.serialize()+ "&confirmation=1",
                                        success : function (responseInsert) {
                                            if (responseInsert.code === 201) {
                                                if (type === 1) {
                                                    if (isAddDay === true) {
                                                        let timeBooking = calculateTime();
                                                        $('#date').val(timeBooking);
                                                        $("#submit-second").hide();
                                                        $("#clear-reset").show();
                                                    }
                                                    showSuccess(responseInsert.message);
                                                } else if (type === 3) {
                                                    if (isAddDay === true) {
                                                        let timeBooking = calculateTime();
                                                        $('#date').val(timeBooking);
                                                        $("#submit-second").hide();
                                                        $("#clear-reset").show();
                                                    }
                                                    showSuccessSecond(responseInsert.message);
                                                } else {
                                                    showSuccess(responseInsert.message);
                                                    location.reload();
                                                }
                                            } else {
                                                if (type === 1) {
                                                    showAlert(responseInsert.message);
                                                } else {
                                                    showAlertSecond(responseInsert.message);
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    Swal.closeModal();
                                }
                            });

                            return false;
                        }
                    },
                    error: function (response) {
                        spinner.hide();
                    }
                });
            }
        }

        $('#closeModal').on('click', function () {
            location.reload();
        });

        $('#clear-reset').on('click', function () {
            let form = $('#create');
            form.trigger('reset');
            form.find("select").val(null).trigger("change");
            $("#submit-second").show();
            $("#clear-reset").hide();
            $('.close-alert').click();
        });

        var titlePopup = "";
        var textMessage = "";
        var confirmButtonText = "";
        var cancelButtonText = "";
        $('#cancelBooking').on('click', function () {
            let linkCancel = $(this).data('url');
            let type = $(this).data('type');
            setDataPopupConfirm(type);

            Swal.fire({
                title: titlePopup,
                text: textMessage,
                showCancelButton: true,
                confirmButtonColor: '#2CCF6F',
                cancelButtonColor: '#AAAAAA',
                confirmButtonText: confirmButtonText,
                cancelButtonText: cancelButtonText
            }).then((result) => {
                if (result.value) {
                    window.location.href = linkCancel;
                }
            })
        });

        function setDataPopupConfirm(type) {
            if (type === 1) {
                titlePopup = "予約をキャンセルしますか？";
                textMessage = "２回目の予約もキャンセルされます";
                confirmButtonText = "キャンセル実行";
                cancelButtonText = "キャンセル";
            } else {
                titlePopup = "キャンセルしますがよろしいでしょうか？";
                confirmButtonText = "はい";
                cancelButtonText = "いいえ";
            }
        }
    });
});

$(document).ready(function () {
    checkValidationFilter();

    $(document).on('click', 'input[name=is_sick]', function () {
        if (parseInt($(this).val()) === 0) {
            $('.sick-data').each(function () {
                $(this).prop('checked', false);
                $(this).prop('disabled', true);
            });
        } else {
            $('.sick-data').each(function () {
                $(this).prop('disabled', false);
            });
        }
    });
});

require('../admin/export');

var currentDay = new Date();
var filterTime = document.getElementById('filter_month') ? document.getElementById('filter_month').value : null;
var currentMonth = currentDay.getMonth() + Number(1);
var currentYear = currentDay.getFullYear();
var maxTime = '2022-12';
var minTime = '2021-01';

$(document).on('click', '#detect_this_month', function () {
    detectThisMonth();
});

$(document).on('click', '#pre_month', function () {
    toPreMonth();
});

$(document).on('click', '#next_month', function () {
    toNextMonth();
});

$(document).on('change', '#filter_month', function () {
    filterMonth();
});

$(document).on('change', '#filter_venue', function () {
    filterVenue();
});

function filterVenue() {
    let venue = document.getElementById("filter_venue").value;
    let newUrl = new URL(window.location.href);
    newUrl.searchParams.set('venue', venue);

    window.location.href = newUrl;
}

function filterMonth() {
    let filter_month = document.getElementById("filter_month").value;
    goToUrl(filter_month);
}

function detectThisMonth() {
    let detectMonth = currentDay.getMonth() + Number(1);
    let detectYear  = currentDay.getFullYear();
    let dateFilter  = new Date(filterTime);
    let monthFilter = dateFilter.getMonth() + Number(1);
    if (detectMonth != monthFilter) {
        let time = getTime(detectYear, detectMonth);
        goToUrl(time);
    }
}

function toNextMonth() {
    checkFilter();

    let nextMonth = currentMonth;
    let nextYear  = currentYear;

    if (currentMonth == 12) {
        nextMonth = 1;
        nextYear  = currentYear + Number(1);
    } else {
        nextMonth = currentMonth + Number(1);
    }

    let time = getTime(nextYear, nextMonth);
    goToUrl(time);
}

function toPreMonth() {
    checkFilter();

    let preMonth = currentMonth;
    let preYear  = currentYear;

    if (currentMonth == 1) {
        preMonth = 12;
        preYear  = currentYear - Number(1);
    } else {
        preMonth = currentMonth - Number(1);
    }

    let time = getTime(preYear, preMonth);
    goToUrl(time);
}

function checkFilter() {
    if (filterTime != null) {
        let dateFilter = new Date(filterTime);
        currentMonth   = dateFilter.getMonth() + Number(1);
        currentYear    = dateFilter.getFullYear();
    }
}

function goToUrl(time) {
    let newUrl = new URL(window.location.href.split('?')[0]);
    newUrl.searchParams.set('month', time);

    let venue = document.getElementById("filter_venue").value;
    newUrl.searchParams.set('venue', venue);

    window.location.href = newUrl;
}

function getTime(year, month) {
    let time;
    if (month < 10) {
        time = year + '-0' + month;
    } else {
        time = year + '-' + month;
    }

    return time;
}

function checkValidationFilter() {
    if (filterTime != null) {
        let dateFilter = new Date(filterTime);
        currentMonth   = dateFilter.getMonth() + Number(1);
        currentYear    = dateFilter.getFullYear();
    }

    let dateMin = new Date(minTime);
    let minMonth = dateMin.getMonth() + Number(1);
    let minYear = dateMin.getFullYear();

    let dateMax = new Date(maxTime);
    let maxMonth = dateMax.getMonth() + Number(1);
    let maxYear = dateMax.getFullYear();

    if (currentMonth == minMonth && currentYear == minYear) {
        document.getElementById('pre_month').className += ' disabled';
    }

    if (currentMonth == maxMonth && currentYear == maxYear) {
        document.getElementById('next_month').className += ' disabled';
    }
}
