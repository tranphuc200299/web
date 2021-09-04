(function ($) {
    $(document).ready(function () {
        $('#myCalendar').pagescalendar({
            events: dateBooking,
            ui: {
                year: {
                    visible: true,
                    format: 'YYYY',
                    startYear: '2021',
                    endYear: moment().add(10, 'year').format('YYYY'),
                    eventBubble: false
                },
                //Month Selector
                month: {
                    visible: true,
                    format: 'MMM',
                    eventBubble: true
                },
                dateHeader: {
                    format: 'D dddd',
                    visible: true,
                },
                //Mini Week Day Selector
                week: {
                    day: {
                        format: 'D'
                    },
                    header: {
                        format: 'dd'
                    },
                    eventBubble: true,
                    startOfTheWeek: '0',
                    endOfTheWeek: '6'
                },
                //Week view Grid Options
                grid: {
                    dateFormat: 'D dddd',
                    timeFormat: 'HH:mm',
                    eventBubble: false,
                    scrollToFirstEvent: false,
                    scrollToAnimationSpeed: 300,
                    scrollToGap: 20
                }
            },
            view: "week",
            minTime: settingStartTime,
            maxTime: settingEndTime,
            slotDuration: settingDuration,
            dateStartWeek: dateSettingWeek,
            widthTime: 60 * 5,
            slotDefault: 5,
            weekends: true,
            locale: 'ja',
            onViewRenderComplete: function () {

            },
            onEventClick: function (event) {
                if (!event.readOnly) {
                    editPopup(event);
                }
            },
            onTimeSlotDblClick: function (timeSlot) {

            }
        });
    });

    let editPopup = (event) => {
        let startTime = event.start;
        let endTime = event.end;
        let venueId = $('.select-area').val();

        $.ajax({
            method: 'POST',
            url: route,
            dataType: 'json',
            data: {start: startTime, end: endTime, venueId: venueId}
        }).done(function (response) {
            if (response.status) {
                $('.append-data').html(response.data);
                $('#listBookingOnBox').modal('show');
            }
        })
    };
})(window.jQuery);

require('../schedule/initial');
