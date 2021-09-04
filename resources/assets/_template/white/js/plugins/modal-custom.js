let flagShowModal = false;
let insertModalName = 'insertModal';

MODAL = {
    
    modal_error: 'error',
    modal_info: 'info',
    
    /**
     * Make modal
     *
     * @param url
     * @param parameters
     * @param callback
     * @returns {boolean}
     */
    render : function (url, parameters, callback) {
        if (flagShowModal)
            return false;
        if (!parameters) {
            parameters = {};
        }
        parameters.modal = true;
        $.get(url, parameters).done(function (data) {
            if (data.error === true) {
                throw data.message;
            }
            MODAL.create(data, true, callback);
            /* set background for parent input disable */
            $('input[disabled], textarea[disabled]').closest('.form-group-default').css('background', '#eee');
            
        }).fail(function (xhr) {
            let spinner = $('#loader');
            spinner.hide();
            return MODAL.alert(xhr.statusText, MODAL.modal_error );
        });
    },
    /**
     * Append modal to body and open
     *
     * @param data
     * @param isOpen
     * @param callback
     * @returns {*}
     */
    create: function (data, isOpen, callback) {
        
        let eModal = $('<div/>').appendTo('body').attr('id', insertModalName);
        $(data).appendTo(eModal);
        let modalName = MODAL.getName();
        
        if (isOpen === true) {
            MODAL.showModal(modalName);
        }
    
        if (callback != null && callback != undefined) {
            window[callback](modalName);
        }
    
        return modalName;
    },
    /**
     * Show modal
     *
     * @param modal jQuery Object
     */
    showModal: function(modal){
        var spinner = $('#loader');
        spinner.hide();
        MODAL.addBackdrop();
        modal.modal('show');
    
        GLOBAL_CONFIG.init();
    
        MODAL.remove(modal);
    },
    /**
     *
     */
    addBackdrop: function() {
        $('<div/>').appendTo('body').attr('class', 'modal-backdrop fade show').attr('id', 'modal-backdrop');
    },
    /**
     * Get modal name after open
     */
    getName: function () {
        let modalInserted = $('#' + insertModalName);
        let modalContent = modalInserted.children();
        
        return $('#' + modalContent.attr('id'));
    },
    /**
     * Remove modal available
     *
     * @returns {boolean}
     */
    remove : function (modal) {
        if (!modal || modal === undefined) {
            let modal = MODAL.getName();
        }
        modal.on('hidden.bs.modal', function (e) {
            $('#' + insertModalName).remove();
            $('#modal-backdrop').remove();
        });
    
        return true;
    },
    alert: function (message, type) {
        error(message);
        return false;
    }
};


jQuery(document).ready(function () {
    let spinner = $('#loader');
    $(document).on('click', '.make-modal', function (e) {
        spinner.show();
        e.preventDefault();
        let modalUrl = $(this).attr('href');
        if (modalUrl === undefined || modalUrl === '') {
            modalUrl = $(this).data('remote');
        }
        let callback = $(this).data('callback') || null;
        
        MODAL.render(modalUrl, false, callback);
    });
    
    $(document).on('click', '[data-modal="true"]', function () {
        MODAL.showModal($($(this).data('target')));
    });
});
