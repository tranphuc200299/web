$( document ).ready(function() {
    $('#optional_popup_btn').on('click', function(){
        var indexCount =  $('#index_count').val();
        console.log(indexCount);
        if (indexCount > 17) {
            $('#optional_popup').modal('hide');
            Swal.fire({
                type: 'warning',
                text: "属性設定の任意項目の追加の数は10個までに制限してください。",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確認',
            });
        } else {
            $('#optional_popup').modal('show');
        }
    });
    $('#plus_attribute').on('click', function(){
        var index =  $('#index_max').val();
        var indexCount =  $('#index_count').val();
        
            /* convert content on modal into table */
            var type = $('input[name="inputOption"]:checked').val();

        /* convert content on modal into table */
        var type = $('input[name="inputOption"]:checked').val();

        var result = $("#input_"+ type +" input[required]").filter(function () {
            return $.trim($(this).val()).length == 0
        }).length == 0;
        if (!result) {
            $('.alert_attribute').removeClass("hide");
            $('#submit_btn').prop('disabled', true);
        } else {
            $('.alert_attribute').addClass("hide");
        }
        var inputContent = $('#input_' + type).html();
        var inputRemoveCorrect = inputContent.replace(/default_value/g, 'default_value_' + index);
        var inputRemoveName = inputRemoveCorrect.replace(/name_option/g, 'input_' + index);
        var inputRemoveLabel = inputRemoveName.replace(/radio_label/g, 'radio_label_' + index);
        var inputRemoveSpanAlert = inputRemoveLabel.replace(/alert_attribute/g, 'alert_attribute_' + index);
        var inputRemoveDataIndex = inputRemoveSpanAlert.replace(/data_index_value/g, index);
        var inputRemoveITag = inputRemoveDataIndex.replace(/fa fa-minus/g, '');
        var finalInput = inputRemoveITag.replace(/fa fa-plus/g, '');

        var listIndex =  $('#list_index').val();
        var html = '';
        html += '<tr id = '+ index +'>';
        html += '<td><i style="color: red; font-size: 20px;" class="fa fa-trash delete_attribute" aria-hidden="true"></i><label class="control-label">'+ finalInput +'</label></td>';
        html += '<input name="id_'+ index +'" type="hidden">';
        html += '<td><input name="type_1['+ index +'][]" type="checkbox"></td>';
        html += '<td><input name="type_2['+ index +'][]" type="checkbox"></td>';
        html += '<td><input name="type_3['+ index +'][]" type="checkbox"></td>';
        html += '<td><input name="required['+ index +'][]" type="checkbox"></td>';
        html += '<td><input name="required['+ index +'][]" type="checkbox"></td>';
        html += '<td><input name="required['+ index +'][]" type="checkbox"></td>';
        html += '</tr>';
        $('#setting_attr').append(html);
        listIndex = listIndex.concat(',' + index);
        $('#list_index').val(listIndex);
        index = Number(index) + Number(1);
        indexCount = Number(indexCount) + Number(1);
        $('#index_max').val(index);
        $('#index_count').val(indexCount);

        $('#optional_popup').on('hidden.bs.modal', function (e) {
            $(this)
            .find("input[type=text]")
            .val("")
            .end();
            $(this).find("span").addClass("hide").end();
        });
        $('#optional_popup').modal('toggle');
    });
    
    $('tbody').delegate('.delete_attribute', 'click', function(e){
        var dataIndex = $(this).attr('data-index');
        var indexCount =  $('#index_count').val();
        var title = $('#title_' + dataIndex).val();
        var currentDelete = $('#option_deleted').val();
        $('#option_deleted').val(currentDelete + ',' + title);
        $(this).parent().parent().remove();
        indexCount -= 1;
        $('#index_count').val(indexCount);
    });

    $('#inputOption1').on('click', function(){
        $('#input_radio').hide();
        $('#input_text').show();
    });

    $('#inputOption2').on('click', function(){
        $('#input_radio').show();
        $('#input_text').hide();
    });

    $('#plus_radio_option').on('click', function(){
        var keyRadio = $('#key_radio').val();
        let plusKey = Number(keyRadio) + Number(1);
        var html = '';
        html += '<div class="form-check ml-3 col-12 mt-1">';
        html += '<input class="form-check-input db-block mt-2 detect_input_radio" data-plus="'+plusKey+'" type="radio" name="default_value">';
        html += '<input type="text" class="form-control db-block detect_input" id="value_radio_'+plusKey+'" onclick="this.select()" style="width: 70% !important;" name="radio_label[]">';
        html += '<i class="fa fa-minus minus-radio db-block ml-2" aria-hidden="true"></i>';
        html += '</div>';
        $('#key_radio').val(plusKey);
        $('#input_radio').append(html);
    });

    $('.detect_input').keyup(function(){
        $(this).attr('value',$(this).val());
    });

    $('.modal-body').delegate('.detect_input_radio', 'click', function(e){
        var radioKey = $(this).attr('data-plus');
        var radioValue = $('#value_radio_'+radioKey).val();
        $(this).val(radioValue);
        $(this).attr('checked', 'checked');
    });
    
    $('.modal-body').delegate('.detect_input', 'keyup', function(e){
        $(this).attr('value',$(this).val());
    });

    $('.modal-body').delegate('.minus-radio', 'click', function(e){
        $(this).parent().remove();
    });
});