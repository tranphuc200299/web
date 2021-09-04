$(document).ready(function () {
    var day = new Date();
    var today = day.getDate();
    var nextDay = 0;
    var preDay = 0;
    var currentDay = 0;
    var currentMonth = document.getElementById('filter_month') ? document.getElementById('filter_month').value : null;
    var firstDay = document.getElementById('detect_first_day')? document.getElementById('detect_first_day').value - 1 : null;

    checkTodayUrl();

    $(document).on('click', '#detect_today', function () {
        detectToday();
    });

    $(document).on('click', '#pre_today', function () {
        preToDay();
    });

    $(document).on('click', '#next_today', function () {
        nextToDay();
    });

    $(document).on('change', '#filter_month', function () {
        filterMonth();
    });

    $(document).on('change', '#filter_venue', function () {
        filterVenue();
    });

    function detectToday() {
        var detectMonth = day.getMonth() + Number(1);
        var detectYear = day.getFullYear();
        var dateFilter = new Date(currentMonth);
        var monthFilter = dateFilter.getMonth() + Number(1);
        if (detectMonth != monthFilter) {
            var time = detectYear + '-0' + detectMonth + '-01';
            var newUrl = makeFilter('month', time);
            var url = new URL(newUrl);
            url.searchParams.set('today', true);
            window.location.href = url;
        } else {
            let thisDay = today + Number(firstDay);
            var tdChange = document.getElementsByClassName('day_' + currentDay);
            for (let i = 0; i < tdChange.length; i++) {
                if (i == 2) {
                    tdChange[i].style.backgroundColor = "#e6f7eb";
                } else {
                    tdChange[i].style.backgroundColor = "white";
                }
            }
            /* calculate day not time */
            var tdChange = document.getElementsByClassName('day_' + thisDay);
            for (let i = 0; i < tdChange.length; i++) {
                tdChange[i].style.cssText = "background-color: #FFEDA7 !important";
            }
            nextDay = 0;
            currentDay = 0;
        }
    }

    function nextToDay() {
        var totalDay = Number(daysInMonth()) + Number(firstDay);
        if (currentDay == 0) {
            currentDay = today + Number(firstDay);
        }

        nextDay = currentDay + Number(1);

        if (nextDay <= totalDay) {
            changeBackGround('next');
            /* set currentDay is nextday */
            currentDay = nextDay;
        } else {
            // var date = new Date(currentMonth);
            // var month = date.getMonth() + Number(2);
            // var year = date.getFullYear();
            // if (month == 12) {
            //     year = year + Number(1);
            // }
            //
            // var time = getTime(year, month, '1');
            // addParam('select-date=true');
            // var newUrl = makeFilter('month', time);
            // window.location.href = newUrl;
        }
    }

    function daysInMonth() {
        var date = new Date(currentMonth);
        var month = date.getMonth() + Number(1);
        var year = date.getFullYear();

        return new Date(year, month, 0).getDate();
    }

    function preToDay() {
        if (currentDay == 0) {
            currentDay = today + Number(firstDay);
        }

        preDay = currentDay - Number(1);

        if (preDay > firstDay) {
            changeBackGround('pre');
            /* set currentDay is preday */
            currentDay = preDay;
        } else {
            // var date = new Date(currentMonth);
            // var currentMonthCal = date.getMonth() + 1;
            // var month = 0;
            // if (currentMonthCal > 1) {
            //     month = currentMonthCal - 1
            // } else {
            //     month = 1;
            // }
            //
            // var year = date.getFullYear();
            // if (month == 1) {
            //     year = year - 1;
            // }
            //
            // let lastDate = new Date(year, month, 0);
            //
            // let time = getTime(year, month, lastDate.getDate());
            // addParam('select-date=true');
            // var newUrl = makeFilter('month', time);
            // window.location.href = newUrl;
        }
    }

    function changeBackGround(type) {
        if (type == 'next') {
            var effectTd = nextDay;
        } else {
            var effectTd = preDay;
        }

        /* set current day background to default */
        var tdChange = document.getElementsByClassName('day_' + currentDay);
        for (var i = 0; i < tdChange.length; i++) {
            if (i == 2) {
                tdChange[i].style.backgroundColor = "#e6f7eb";
            } else {
                tdChange[i].style.backgroundColor = "white";
            }

        }
        /* set pre/next day background */
        var tdChange = document.getElementsByClassName('day_' + effectTd);
        for (var i = 0; i < tdChange.length; i++) {
            tdChange[i].style.cssText = "background-color: #FFEDA7 !important";
        }
    }

    function filterMonth() {
        var time = document.getElementById("filter_month").value;
        var newUrl = makeFilter('month', time);

        let nurl = new URL(newUrl);
        nurl.searchParams.delete('select-date');

        window.location.href = nurl;
    }

    function filterVenue() {
        var venue = document.getElementById("filter_venue").value;
        var newUrl = makeFilter('venue', venue);
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

    function addParam(param) {
        window.history.replaceState(null, null, "?" + param);
    }

    function checkTodayUrl() {
        var currenUrl = window.location.href;
        var check = currenUrl.search('today', currenUrl);
        let checkSelectDate = currenUrl.search('month', currenUrl);
        let checkSelect = currenUrl.search('select-date', currenUrl);

        if (check >= 0) {
            currentDay = today + Number(firstDay);
        } else {
            if (checkSelectDate > 0 && checkSelect > 0) {
                currentDay = day_request + Number(firstDay);
            }
            currentMonth = document.getElementById('filter_month') ? document.getElementById('filter_month').value : '';
        }

        var tdChange = document.getElementsByClassName('day_' + currentDay);
        for (var i = 0; i < tdChange.length; i++) {
            tdChange[i].style.cssText = "background-color: #FFEDA7 !important";
        }
    }

    function getTime(year, month, day) {
        let time;

        if (day < 10) {
            day = '0' + day;
        }

        if (month < 10) {
            time = year + '-0' + month + '-' + day;
        } else {
            time = year + '-' + month + '-' + day;
        }

        return time;
    }
});
