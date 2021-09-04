
$(document).ready(function () {
    $('.input-to-tag').each(function () {
        let _this = $(this);
        _this.hide();
        let value = _this.val();
        let htmlTag = '<span class="tag input-tag">'+value+'</span>';
        $(htmlTag).insertAfter(_this);
        
    });
});
