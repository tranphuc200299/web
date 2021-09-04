$(document).ready(function () {
    $('#btn-cancel-booking').click(function (e) {
        e.preventDefault();

        let cancel_url_next = $("#cancel_link_next").val();
        let birthday = $("#birthday").val();
        let code = $("#code").val();
        let area_id = $("#area_id").val();
        let accept = $("#accept").val();
        let line_id = '';

        let formData = new FormData($('form')[0]);
        formData.append('area_id', area_id);
        formData.append('line_id', line_id);

        if (code.length > 0 && birthday.length > 0) {
            $('#btn-cancel-booking').prop('disabled', true);
            $.ajax({
                cache: false,
                headers: {"cache-control": "no-cache"},
                url: '/booking/cancel-customer',
                dataType: 'json',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        window.location.href = cancel_url_next + '?area_id=' + area_id + '&birthday=' + birthday + '&code=' + code + '&accept=' + accept;
                    } else {
                        $('#btn-cancel-booking').prop('disabled', false);
                        let html = $('#modal-input').html();
                        Swal.fire({
                            html: html,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (request) {
                    console.log("ajax call went wrong:" + request.responseText);
                }
            });
        }
    });

    let checkDisable = (obj) => {
        let status = true;
        if (obj.hasClass('disable')) {
            status = false;
        }

        return status;
    };

    $(".btn-cancel-status").on('click', function () {
        if (checkDisable($(this))) {
            let bookingId = $(this).data('id');
            let bookingStatus = $("#booking_status_" + bookingId).val();
            let countBooking = $("#count_booking").val();
            let messageText = "";
            if (Number(bookingStatus) === 1 && Number(countBooking) === 2) {
                messageText = "２回目の予約もキャンセルされます"
            }

            $('.modal-margin').attr('data-id', bookingId);
            $('.custom-warning').text(messageText);
            $('#confirm_dialog').modal('toggle');
        }
    })

    $('#confirm_dialog').on('click', '.btn-confirm-success', function () {
        let bookingId = $('.modal-margin').attr('data-id');
        handleAccept(bookingId);
    });

    let handleAccept = (bookingId) => {
        let spinner = $('#loader');
        let cancel_url_next = $("#cancel_link_next").val();
        const customer_id = $('#customer_id').val()
        let area_id = $("#area_id").val();
        let birthday = $("#birthday").val();
        let code = $("#code").val();

        let formData = new FormData($('form')[0]);

        formData.append('booking_id', bookingId);
        formData.append('customer_id', customer_id);
        formData.append('area_id', area_id);

        $.ajax({
            cache: false,
            headers: {"cache-control": "no-cache"},
            url: '/booking/save-customer',
            dataType: 'json',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend : function(){
                spinner.show();
            },
            success: function (response) {
                $('#confirm_dialog').modal('hide');
                spinner.hide();
                if (response.success) {
                    window.location.href = cancel_url_next + '?area_id=' + area_id + '&birthday=' + birthday + '&code=' + code;
                } else if (response.error_code === 400) {
                    let html = $('#modal-cancel-error').html();
                    Swal.fire({
                        html: html,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        titleText: response.message,
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonText: '閉じる'
                    });
                }
            },
            error: function (request) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });

    }
})
