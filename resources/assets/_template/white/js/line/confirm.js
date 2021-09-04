$(document).ready(function () {
    open_modal();

    $(document).on('click', "#cancel_event", function () {
        // Swal.closeModal();
        location.href = 'http://localhost:74/line/booking/complete';
    });
    $(document).on('click', "#agree_event", function () {
        location.href = this.getAttribute('data-href');
    });
});

function open_modal() {
    $('#open_modal').on('click', function () {
        console.log("fsdfsd");
        let confirm = "true";
        let href    = $(this).attr('data-href');
        let imgSrc  = $(this).attr('data-image-src');
        if (confirm === 'true') {
            console.log("fsdfsd");
            Swal.fire({
                html              : '<img style="width: 16px;height: 16px;margin-bottom: 5px;padding-top: 0" src="' + imgSrc + '"/>' +
                    "<p style='color: #fa6d88; font-size: 13px; font-weight: bold;'>登録を中断してトーク画面に戻りますか？</p>" +
                    "<p style='color: #fa6d88; font-size: 12px;font-weight: bold;'>※登録はまだ完了していません※</p>" +
                    '<button id="cancel_event" type="button" role="button" tabindex="0" class="btn btn-lg btn-full-width bg-color-primary">予約を続ける</button>' +
                    '<button id="agree_event" data-href="' + href + '" type="button" role="button" tabindex="0" class="btn btn-lg btn-full-width btn-back-screen-bot">トーク画面に戻る</button>',
                showCancelButton  : false,
                showConfirmButton : false
            });
        }
    });

}
