$(document).ready(function () {

    const day = $('#filter_day');
    let maxMonth = $('#max_booking_month').val();
    day.datepicker({
        minDate: new Date(),
        maxDate: maxMonth === '0' ? '' : '+'+maxMonth+'m',
        onSelect: function(dateText, inst) {
            filterDay(dateText);
        }
    });

    $(document).on('change', '#filter_venue',function(){
        filterVenue();
    });

    function filterVenue() {
        var venue = document.getElementById("filter_venue").value;
        var newUrl = makeFilter('venue', venue);
        window.location.href = newUrl;
    }

    function filterDay(currentDay) {
        var newUrl = makeFilter('current_day', currentDay);
        window.location.href = newUrl;
    }

    function makeFilter(param, value) {
        var currenUrl = window.location.href;
        if (currenUrl.search('today', currenUrl)) {
            currenUrl = currenUrl.replace('&today=true', '');
        }
        var url = new URL(currenUrl);
        url.searchParams.set(param, value);

        return url.href;
    }
})
