$(document).on('click', '.list-click-custom', function () {
    let optionSelect = $(this);
    let valueSelect = optionSelect.attr('attr-data');
    let originSelectedVenueId = $('.venue-list').find('.origin-selected').attr('attr-data');
    let areaId = $('#area_id').val();
    let venueType = $('#venue_type').val();
    let ym = $('#ym').val();
    if (valueSelect !== originSelectedVenueId) {
        let link = location.protocol + '//' + location.host + location.pathname + '?area_id=' + areaId + '&venue_id=' + valueSelect;
        if (venueType !== '') {
            link += '&venue_type=' + venueType;
        }
        if (ym !== '') {
            link += '&ym=' + ym;
        }
        window.location.href = link;
    }
});

$('#empty-status-calendar-datepicker').datepicker({
    firstDay: 1,
    dateFormat: 'yy-mm',
    onSelect: function(selectedDate){
        let areaId = $('#area_id').val();
        let venueId = $('#venue_id').val();
        let venueType = $('#venue_type').val();
        let link = location.protocol + '//' + location.host + location.pathname + '?area_id=' + areaId;
        if (venueId !== '') {
            link += '&venue_id=' + venueId;
        }
        if (venueType !== '') {
            link += '&venue_type=' + venueType;
        }
        link += '&ym=' + selectedDate;

        window.location.href = link;
    },
});

$('.empty-status-calendar').find('.calendar-icon').click(function() {
    $('#empty-status-calendar-datepicker').datepicker('show');
    let ym = $('#ym').val();
    if (ym !== '') {
        let ymSplit = ym.split('-');
        let y = ymSplit[0];
        let m = ymSplit[1];
        if (m.startsWith('0')) {
            m = m.substring(1);
        }
        m -= 1;
        $('#empty-status-calendar-datepicker').datepicker('setDate', new Date(y, m, 1));
    }
});

$(document).on('click', '.dropdown-select-custom', function () {
    if ($('.calendar-search-venue').is(':visible')) {
        $('.calendar-search-venue').hide();
    } else {
        $('.calendar-search-venue').show().focus();
    }
});

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

$(document).on('keyup', '.calendar-search-venue', delay(function (e) {
    let textSearch = $('.calendar-search-venue').val();
    let venues = $('.selected-list').find('.label-select');

    venues.each(function(i, e) {
        let venueName = $(e).text();
        if (!venueName.includes(textSearch)) {
            $(venues[i]).closest('li').attr('hidden', true);
        }
        else {
            $(venues[i]).closest('li').attr('hidden', false);
        }
    });
}, 500));
