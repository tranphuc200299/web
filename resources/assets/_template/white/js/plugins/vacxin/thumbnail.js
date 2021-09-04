$(document).on('change', '.thumbnail_input', function () {
    let currentObj = $(this);
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        currentObj.parent().find('#thumbnail_output').html('');
        let data = $(this)[0].files;
        $('#overlay').fadeIn();

        $.each(data, function (index, file) {
            if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
                let fRead = new FileReader();
                fRead.onload = (function (file) {
                    return function (e) {
                        let img = $('<img/>').addClass('thumb mt-2').attr('src', e.target.result)
                            .attr('height', 100);
                        currentObj.parent().find('#thumbnail_output').append(img);
                    };
                })(file);
                fRead.readAsDataURL(file);
            }
        });

        $('#overlay').fadeOut();
    } else {
        alert("Your browser doesn't support File API!");
    }
});
