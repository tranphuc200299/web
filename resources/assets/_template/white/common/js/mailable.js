$(document).ready(function () {
    $('.view_data_param').on('click', function () {
        let text = $('.mailable-content').val();
        
        if (typeof currentPosition === 'undefined') {
            window.currentPosition = text.length;
        }
        let param = $.trim($(this).text());
        
        // add variable to mail content
        let appending = '{{' + param +'}} ';
        text = text.slice(0, currentPosition) + appending + text.slice(currentPosition);
        window.currentPosition += appending.length;

        $('.mailable-content').val(text);
        $('.mailable-content').prop('selectionEnd', currentPosition);
        $('.mailable-content').focus();
    });

    $('.mailable-content').on('keyup', function () {
        window.currentPosition = this.selectionStart;
    });
    
    $('.mailable-content').on('mouseup', function () {
        window.currentPosition = this.selectionStart;
    });

    $('.view_subject_param').on('click', function () {
        let text = $('.mailable-subject').val();

        if (typeof currentSubjectPosition === 'undefined') {
            window.currentSubjectPosition = text.length;
        }
        let param = $.trim($(this).text());

        // add variable to mail content
        let appending = '{{' + param +'}} ';
        text = text.slice(0, currentSubjectPosition) + appending + text.slice(currentSubjectPosition);
        window.currentSubjectPosition += appending.length;

        $('.mailable-subject').val(text);
        $('.mailable-subject').prop('selectionEnd', currentSubjectPosition);
        $('.mailable-subject').focus();
    });

    $('.mailable-subject').on('keyup', function () {
        window.currentSubjectPosition = this.selectionStart;
    });

    $('.mailable-subject').on('mouseup', function () {
        window.currentSubjectPosition = this.selectionStart;
    });
});
