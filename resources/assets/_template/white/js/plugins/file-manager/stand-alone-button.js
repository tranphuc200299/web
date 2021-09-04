(function( $ ){
    
    $.fn.filemanager = function(type, options) {
        type = type || 'file';
        
        this.on('click', function(e) {
            let route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            let dir = '';
            if ($(this).data('admin') === true || $(this).data('admin') === 'true') {
                dir = '&admin=true';
            }
            if ($(this).data('chain') === true || $(this).data('chain') === 'true') {
                dir = '&chain=true';
            }
            if ($(this).data('shop') === true || $(this).data('shop') === 'true') {
                dir = '&store=true';
            }
            localStorage.setItem('target_input', $(this).data('input'));
            localStorage.setItem('target_preview', $(this).data('preview'));
            window.open(route_prefix + '?type=' + type + dir, 'FileManager', 'width=900,height=600');
            window.SetUrl = function (url, file_path) {
                //set the value of the desired input to image url
                var target_input = $('#' + localStorage.getItem('target_input'));
                target_input.val(file_path).trigger('change');
                
                //set or change the preview image src
                var target_preview = $('#' + localStorage.getItem('target_preview'));
                target_preview.attr('src', url).trigger('change');
            };
            window.SetUrlMultiple = function (url_files) {
                //set the value of the desired input to image url
                var target_input = $('#' + localStorage.getItem('target_input'));
                target_input.val(url_files).trigger('change');
        
                //set or change the preview image src
                var target_preview = $('#' + localStorage.getItem('target_preview'));
                target_preview.attr('src', url_files).trigger('change');
            };
            return false;
        });
    }
    
})(jQuery);
