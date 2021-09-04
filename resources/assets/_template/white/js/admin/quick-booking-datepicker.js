$(document).ready(function () {
    hightLightSelectedDate();
});

var currenUrl = window.location.href;
var url = new URL(currenUrl);
var selectedDate1 = url.searchParams.get('selected_date_1');
var selectedDate2 = url.searchParams.get('selected_date_2');

$('#quick-booking-date-picker').datepicker({
    minDate: new Date(),
    firstDay: 1,
    stepMonths: 2,
    navigationAsDateFormat: true,
    prevText: '<i class="fa fa-caret-left" aria-hidden="true"></i>前々月',
    nextText: '翌々月<i class="fa fa-caret-right" aria-hidden="true"></i>',
    onSelect: function(selectedDate){
        var currenUrl = location.protocol + '//' + location.host + location.pathname;
        window.location.href = currenUrl + '?selected_date_1=' + selectedDate;
    },
    onChangeMonthYear: function(year, month, inst) {
        $('#quick-booking-date-picker-2').datepicker('setDate', new Date(year, month, 1));
        if (selectedDate1 || (!selectedDate1 && !selectedDate2)) {
            $('#quick-booking-date-picker-2 .ui-state-active').addClass('background-white');
        }
        if (selectedDate2) {
            $('#quick-booking-date-picker .ui-state-active').addClass('background-white');
        }
    }
});

$('#quick-booking-date-picker-2').datepicker({
    minDate: new Date(),
    firstDay: 1,
    stepMonths: 2,
    // defaultDate: defaultDate,
    navigationAsDateFormat: true,
    prevText: '<i class="fa fa-caret-left" aria-hidden="true"></i>前々月',
    nextText: '翌々月<i class="fa fa-caret-right" aria-hidden="true"></i>',
    onSelect: function(selectedDate){
        var currenUrl = location.protocol + '//' + location.host + location.pathname;
        window.location.href = currenUrl + '?selected_date_2=' + selectedDate;
    },
});

$('.o-mark').click(function() {
    var venue = $(this).attr('venue-id');
    var date = $(this).attr('date-data');
    var currenUrl = location.protocol + '//' + location.host + location.pathname;
    window.location.href = currenUrl + '/detail?current_day=' + date + '&venue=' + venue;
});

function hightLightSelectedDate() {
    var currenUrl = window.location.href;
    var url = new URL(currenUrl);
    var selectedDate1 = url.searchParams.get('selected_date_1');
    var selectedDate2 = url.searchParams.get('selected_date_2');
    $('#quick-booking-date-picker').find('.ui-state-highlight').removeClass('ui-state-highlight');
    if (!selectedDate1 && !selectedDate2) {
        var date = new Date();
        var currentYear = date.getFullYear();
        var currentMonth = date.getMonth() + 1;
        $('#quick-booking-date-picker-2').datepicker('setDate', new Date(currentYear, currentMonth, 1));
        $('#quick-booking-date-picker-2 .ui-state-active').addClass('background-white');
    }
    if (selectedDate1) {
        var day = selectedDate1.substring(8);
        var month = selectedDate1.substring(5, 7);
        var year = selectedDate1.substring(0, 4);
        if (day.startsWith('0')) {
            day = day.substring(1);
        }
        if (month.startsWith('0')) {
            month = month.substring(1);
        }
        day = Number(day);

        month = Number(month) - 1;

        year = Number(year);

        $('#quick-booking-date-picker').find('.ui-state-active').removeClass('ui-state-active');
        $('#quick-booking-date-picker').datepicker('setDate', new Date(year, month, day));
        $('#quick-booking-date-picker-2').datepicker('setDate', new Date(year, month + 1, day));
        $('#quick-booking-date-picker-2 .ui-state-active').addClass('background-white');
    }
    if (selectedDate2) {
        var day = selectedDate2.substring(8);
        var month = selectedDate2.substring(5, 7);
        var year = selectedDate2.substring(0, 4);
        if (day.startsWith('0')) {
            day = day.substring(1);
        }
        if (month.startsWith('0')) {
            month = month.substring(1);
        }
        day = Number(day);

        month = Number(month) - 1;

        year = Number(year);

        $('#quick-booking-date-picker-2').find('.ui-state-active').removeClass('ui-state-active');
        $('#quick-booking-date-picker-2').datepicker('setDate', new Date(year, month, day));
        $('#quick-booking-date-picker').datepicker('setDate', new Date(year, month - 1, day));
        $('#quick-booking-date-picker .ui-state-active').addClass('background-white');
    }
}


$(document).ready(function () {
    var $loading = $('.data-loading');
    var date = $('#activeDate').data('date');
    var v_ids = [];
    $.each($loading, function (i, td) {
        var v_id = $(td).data('id');
        // var url = $(td).data('fetch');
        // loadVenue(v_id, url);
        v_ids.push(v_id);
        if(v_ids.length === 5){
            loadVenues(v_ids, date);
            v_ids = [];
        }
    });
    if(v_ids.length){
        loadVenues(v_ids, date);
    }
});

function loadVenues(ids, date) {
    $.ajax({
        url: '/cp/quick-booking/schedules',
        type: 'GET',
        data: {
            'ids': ids,
            'date': date
        },
        success: function (response) {
            $.each(ids, function (i, id) {
                var schedule = response.schedule[id];
                $.each(schedule, function (date, inventory) {
                    var $slotWeb = $('.date-slot-web[data-id=' + id + '][data-date="' + date + '"]');
                    var $slotCC = $('.date-slot-cc[data-id=' + id + '][data-date="' + date + '"]');
                    if (inventory.web <= 0) {
                        $slotWeb.addClass('x-mark');
                    }

                    if (inventory.cc <= 0) {
                        $slotCC.addClass('x-mark');
                    }
                    $('.progress-circle-indeterminate[data-id=' + id + '][data-date="' + date + '"]').remove();
                    $slotWeb.html(makeView(id, date, inventory.web));
                    $slotCC.html(makeView(id, date, inventory.cc));
                });
            });


        },
        error: function (request) {
            $.each(ids, function (id) {
                var $slotWeb = $('.date-slot-web[data-id=' + id + ']');
                var $slotCC = $('.date-slot-cc[data-id=' + id + ']');
                $slotWeb.addClass('x-mark');
                $slotCC.addClass('x-mark');
                $('.progress-circle-indeterminate[data-id=' + id + ']').remove();
            });
        }
    });
}

function loadVenue(id, url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            var schedule = response.schedule[id];
            $.each(schedule, function (date, inventory) {
                var $slotWeb = $('.date-slot-web[data-id='+id+'][data-date="' + date + '"]');
                var $slotCC = $('.date-slot-cc[data-id='+id+'][data-date="' + date + '"]');
                if(inventory.web <=0) {
                    $slotWeb.addClass('x-mark');
                }

                if(inventory.cc <=0) {
                    $slotCC.addClass('x-mark');
                }
                $('.progress-circle-indeterminate[data-id='+id+'][data-date="' + date + '"]').remove();
                $slotWeb.html(makeView(id, date, inventory.web));
                $slotCC.html(makeView(id, date, inventory.cc));
            });

        },
        error: function (request) {
            var $slotWeb = $('.date-slot-web[data-id='+id+']');
            var $slotCC = $('.date-slot-cc[data-id='+id+']');
            $slotWeb.addClass('x-mark');
            $slotCC.addClass('x-mark');
            $('.progress-circle-indeterminate[data-id='+id+']').remove();
        }
    });
}

function makeView(id, date, number){
    var html = '<a class="quick-detail">';
    if (number > 0){
        var href = '/cp/quick-booking/detail?current_day='+date+'&venue='+id;
        html = '<a class="quick-detail" href="'+href+'" target="_blank">';
    }

    if (number <= 0) {
        html += '<i class="fa fa-times"></i>';
    }

    if (number > 0 && number <= 5) {
        html += '<span class="icon-20x-gre pink-color">';
        html += '<i class="ika-triangle text-red fonts-17"></i>';
        html += '<br>';
        html += '<strong class="number-remaining">残 ' + number + '</strong>';
    }

    if (number > 5) {
        html += '<i class="fa fa-circle-o"></i>';
        html += '<br>';
        html += '<strong class="number-remaining">残 '+number+'</strong>';
    }

    html += '</a>';

    return html;
}