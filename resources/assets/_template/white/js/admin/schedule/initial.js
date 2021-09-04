$('.calendar-content').on('change', '#time', function () {
    let date = $(this).val();
    $('input[name=date]').val(date);

    prepareDataBeforeSubmit();
});

$('.calendar-content').on('change', 'select[name=area_id]', function (e) {
    prepareDataBeforeSubmit();
});

let prepareDataBeforeSubmit = () => {
    let form = $('#scheduleForm');
    form.submit();
};
