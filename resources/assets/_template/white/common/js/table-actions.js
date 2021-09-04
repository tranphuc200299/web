
jQuery(document).ready(function () {
    $(document).on('change', 'input.chk-all', function (e) {
        var parentTable = $(this).parent().closest('table');
        parentTable.find("input.chk-row").prop('checked', $(this).is(':checked'));
        if ($(this).is(':checked')) {
            parentTable.find('tbody').find('tr').addClass('selected');
        } else {
            parentTable.find('tbody').find('tr').removeClass('selected');
        }
    });
    $(document).on('click', 'input.chk-row', function (e) {
        var parentTable = $(this).parent().closest('table');
        if (!$(this).is(':checked')) {
            parentTable.find('input.chk-all').prop('checked', false);
            return;
        }
        var parentTbody = $(this).parent().closest('tbody');
        var allChecked = true;
        parentTbody.find("input.chk-row").each(function () {
            if (!$(this).is(':checked')) {
                allChecked = false;
            }
        });
        if (allChecked) {
            parentTable.find('input.chk-all').prop('checked', true);
        }
    });
    
    $(document).on('click', '.col_tbl_sort', function (e) {
        var url = $(this).data('href');
        if (url) {
            window.location = url;
        }
    });
    
    $('.clickable-row').click(function () {
        window.location = $(this).data("href");
    });
});
