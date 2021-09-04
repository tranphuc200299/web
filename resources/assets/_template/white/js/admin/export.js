$(document).on('click', '#check_all', function () {
    if ($(this).is(':checked'))
        setChildCheckBox(true);
    else
        setChildCheckBox(false)

    rewriteListId();
});

$(document).on('click', '.each-checkbox', function () {
    let check = true;
    $('.popup-export-box input').map((key, element) => {
        if (!$(element).is(':checked'))
            check = false;
        $('#check_all').prop('checked', check);
    });

    rewriteListId();
});

let setChildCheckBox = (command) => {
    let listCheckBox = $('.popup-export-box input');

    listCheckBox.map((key, value) => {
        $(value).prop('checked', command);
    });
}

let rewriteListId = () => {
    let listIdRewrite = [];
    $('.popup-export-box input').map((key, element) => {
        if ($(element).is(':checked'))
            listIdRewrite.push($(element).attr('data-id'));
    });

    $('input[name=list_id]').val(listIdRewrite.join(','));
}

$("#sortable-box").sortable({
    update: function () {
        rewriteListId();
    }
});

$(document).on('click', '#submit-csv-btn', function () {
    let ids = $('input[name=list_id]').val();

    if (ids !== '') {
        let url = window.location.href;
        let stringParams = `list_id=${ids}&export=csv`;

        if (url.indexOf('?') > -1) {
            url += `&${stringParams}`;
        } else {
            url += `?${stringParams}`
        }
        window.location.href = url;
    } else {
        alert('項目を選択しないとダウンロードできません。');
    }
});



