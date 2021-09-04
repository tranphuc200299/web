$(document).ready(function () {
    $('[data-toggle=sortable]').each(function () {
        let _this = $(this);
        let remoteUrl = _this.data('remote');
        $(this).sortable({
            placeholder: "",
            update: function( event, ui ) {
                let sortedIDs = _this.sortable( "toArray" );
                let data = {};
                $(sortedIDs).each(function (sort, item) {
                    let itemId = '';
                    if (checkRouteSortTag()) {
                        itemId = $("span[id="+ item +"]").attr('tag');
                    } else {
                        itemId = item.replace("boxItem-", "");
                    }
                    data[itemId] = sort;
                });
                // increase array key 1 unit so `pin_sort` in `shop` table can start at 1 which gives correct results on search screen
                Object.keys(data).forEach(function (key) {
                    data[key]++;
                });

                $.get(remoteUrl, $.param(data)).done(function () {});
            }
        });
    });
});
function checkRouteSortTag(){
    let pathName = window.location.pathname;
    let arrayData = pathName.split('/');
    if (arrayData.pop() !== "tags") {
        return false;
    }
    return true;
}