<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $("select").select2({width: '100%'});
    var fieldIdArr = [];
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $("#drdCommandType").on("change", function () {
            if ($(this).val() == "infyom:scaffold") {
                $('#chSwag').hide();
                $('#chTest').hide();
            }
            else {
                $('#chSwag').show();
                $('#chTest').show();
            }
        });

        $(document).ready(function () {
            $.each($('#table tbody tr'), function(i,v){
                initializeCheckbox($(v));
            });
            var htmlStr = '<tr class="item" style="display: table-row;"></tr>';
            var commonComponent = $(htmlStr).filter("tr").load('{{ route('io_field_template') }}');
            var relationStr = '<tr class="relationItem" style="display: table-row;"></tr>';
            var relationComponent = $(relationStr).filter("tr").load('{{ route('io_relation_field_template') }}');

            $("#btnAdd").on("click", function () {
                var item = $(commonComponent).clone();
                initializeCheckbox(item);
                $("#container").append(item);
            });

            $("#btnTimeStamps").on("click", function () {
                if(!$('.txtFieldName').filter(function() { return this.value === 'created_at' }).length){
                    let item_created_at = $(commonComponent).clone();
                    $(item_created_at).find('.txtFieldName').val("created_at").prop('readonly', true);
                    renderTimeStampData(item_created_at);
                    initializeCheckbox(item_created_at);
                    $("#container").append(item_created_at);
                }

                if(!$('.txtFieldName').filter(function() { return this.value === 'updated_at' }).length){
                    let item_updated_at = $(commonComponent).clone();
                    $(item_updated_at).find('.txtFieldName').val("updated_at").prop('readonly', true);;
                    renderTimeStampData(item_updated_at);
                    initializeCheckbox(item_updated_at);
                    $("#container").append(item_updated_at);
                }
            });

            $("#btnPrimary").on("click", function () {
                if(!$('.txtFieldName').filter(function() { return this.value === 'id' }).length){
                    let item = $(commonComponent).clone();
                    renderPrimaryData(item);
                    initializeCheckbox(item);
                    $("#container").append(item);
                }
            });

            $("#btnCreatedBy").on("click", function () {
                if(!$('.txtFieldName').filter(function() { return this.value === 'created_by' }).length){
                    let item = $(commonComponent).clone();
                    renderCreatedByData(item);
                    initializeCheckbox(item);
                    $("#container").append(item);
                }
            });


            $("#btnRelationShip").on("click", function () {
                $("#relationShip").show();
                var item = $(relationComponent).clone();

                $(item).find("select").select2({ width: '100%' });

                var relationType = $(item).find('.drdRelationType');

                $("#rsContainer").append(item);
            });

            $("#btnModelReset").on("click", function () {
                $("#container").html("");
                $('input:text').val("");
                $('input:checkbox').iCheck('uncheck');

            });

            function getFormData(){
                var fieldArr = [];
                var relationFieldArr = [];
                $('.item').each(function () {
                    fieldArr.push({
                        name: $(this).find('.txtFieldName').val(),
                        dbType: $(this).find('.txtdbType').val(),
                        txtLabel: $(this).find('.txtLabel').val(),
                        txtFactoryFaker: $(this).find('.txtFactoryFaker').val(),
                        htmlType: $(this).find('.drdHtmlType').val(),
                        valueList: $(this).find('.txtHtmlValue').val(),
                        validations: $(this).find('.txtValidation').val(),
                        isForeign: $(this).find('.isForeign').prop('checked'),
                        nullable: $(this).find('.chkNullable').prop('checked'),
                        unique: $(this).find('.chkUnique').prop('checked'),
                        searchable: $(this).find('.chkSearchable').prop('checked'),
                        fillable: $(this).find('.chkFillable').prop('checked'),
                        primary: $(this).find('.chkPrimary').prop('checked'),
                        inForm: $(this).find('.chkInForm').prop('checked'),
                        inIndex: $(this).find('.chkInIndex').prop('checked')
                    });
                });

                $('.relationItem').each(function () {
                    relationFieldArr.push({
                        relationType: $(this).find('.drdRelationType').val(),
                        foreignModule: $(this).find('.txtForeignModule').val(),
                        foreignModel: $(this).find('.txtForeignModel').val(),
                        foreignTable: $(this).find('.txtForeignTable').val(),
                        foreignKey: $(this).find('.txtForeignKey').val(),
                        localKey: $(this).find('.txtLocalKey').val(),
                        displayName: $(this).find('.txtDisplayName').val(),
                        displayField: $(this).find('.txtDisplayField').val(),
                    });
                });

                return {
                    moduleName: $('#txtModuleName').val(),
                    modelName: $('#txtModelName').val(),
                    commandType: $('#drdCommandType').val(),
                    tableName: $('#txtCustomTblName').val(),
                    listView: $('#listView').val(),
                    childView: $('#childView').val(),
                    icon: $('#txtIcon').val(),
                    group: $('#txtGroup').val(),
                    userRelation: $('#userRelation').val(),
                    ownerRelation: $('#ownerRelation').val(),
                    fakerLanguage: $('#fakerLanguage').val(),
                    options: {
                        softDelete: $('#chkDelete').prop('checked'),
                        prefix: $('#txtPrefix').val(),
                        paginate: $('#txtPaginate').val(),
                    },
                    addOns: {
                        auth: $('#chkAuth').prop('checked')
                    },
                    fields: fieldArr,
                    relations: relationFieldArr
                }
            }

            $('#btnJsonDownload').on('click', function (e) {
                e.preventDefault();
                var data = getFormData();
                var json = JSON.stringify(data, null, 4);
                var modelName = 'NoName';
                if ($("#txtModelName").val()) {
                    modelName = $("#txtModelName").val();
                }

                json = [json];
                var blob1 = new Blob(json, {type: "text/plain;charset=utf-8"});

                //Check the Browser.
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob1, modelName + ".json");
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob1);
                    var a = document.createElement("a");
                    a.download = modelName + ".json";
                    a.href = link;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            });

            $("#form").on("submit", function (e) {
                e.preventDefault();
                var data = getFormData();
                data['_token'] = $('#token').val();
                $.ajax({
                    url: '{{ route('io_generator_builder_generate') }}',
                    method: "POST",
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function (result) {
                        var result = JSON.parse(JSON.stringify(result));
                        $("#info").html("");
                        $("#info").append('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' + result.message + '</strong></div>');
                        $("#info").show();
                        var $container = $("html,body");
                        var $scrollTo = $('#info');
                        $container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top, scrollLeft: 0},300);
                        setTimeout(function () {
                            $('#info').fadeOut('fast');
                        }, 2000);

                        window.location =  result.url;
                    },
                    error: function (result) {
                        var result = JSON.parse(JSON.stringify(result));
                        var errorMessage = '';
                        if (result.hasOwnProperty('responseJSON') && result.responseJSON.hasOwnProperty('message')) {
                            errorMessage = result.responseJSON.message;
                        }

                        $("#info").html("");
                        $("#info").append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Fail! </strong>' + errorMessage + '</div>');
                        $("#info").show();
                        var $container = $("html,body");
                        var $scrollTo = $('#info');
                        $container.animate({ scrollTop: $scrollTo.offset().top}, 300);
                        setTimeout(function () {
                            $('#info').fadeOut('fast');
                        }, 10000);
                    }
                });

                return false;
            });

            $('#schemaFile').change(function () {
                var ext = $(this).val().split('.').pop().toLowerCase();
                if (ext != 'json') {
                    $("#schemaInfo").html("");
                    $("#schemaInfo").append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Schema file must be json</strong></div>');
                    $("#schemaInfo").show();
                    $(this).replaceWith($(this).val('').clone(true));
                    setTimeout(function () {
                        $('div.alert').fadeOut('fast');
                    }, 3000);
                }
            });

            $(document).on('change keyup keydown', '.txtForeignKey', function () {
                let $select2 = $(this).closest('tr').find('.drdRelationType');
                let value = $select2.val();
                $select2.html('');
                $select2.select2({data: [
                    {id: '1t1_has_one', text : 'Has One (1-1)'},
                    {id: '1t1_belongs_to', text : 'BelongsTo (1-1)'},
                    {id: 'mt1_has_many', text : 'Has Many (1-n)'},
                    {id: 'mt1_belongs_to', text : 'BelongsTo (n-1)'},
                    {id: 'mtm_belongs_to_many', text : 'BelongsTo Many (n-n)'},
                ]});

                let foreignKey = $(this).val();
                if($('.txtFieldName').filter(function() { return this.value === foreignKey }).length){
                    $select2.html('').select2({data: [
                        {id: '1t1_belongs_to', text : 'BelongsTo (1-1)'},
                        {id: 'mt1_belongs_to', text : 'BelongsTo (n-1)'},
                    ]});
                }
                $select2.val(value);
                $select2.trigger('change');
            });

            $('.txtForeignKey').trigger('change');

            $('#schemaForm').on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('io_generator_builder_generate_from_file') }}',
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (result) {
                        var result = JSON.parse(JSON.stringify(result));
                        $("#schemaInfo").html("");
                        $("#schemaInfo").append('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' + result.message + '</strong></div>');
                        $("#schemaInfo").show();
                        var $container = $("html,body");
                        var $scrollTo = $('#schemaInfo');
                        $container.animate({
                            scrollTop: $scrollTo.offset().top - $container.offset().top,
                            scrollLeft: 0
                        }, 300);
                        setTimeout(function () {
                            $('#schemaInfo').fadeOut('fast');
                        }, 3000);
                        // location.reload();
                    },
                    error: function (result) {
                        var result = JSON.parse(JSON.stringify(result));
                        var errorMessage = '';
                        if (result.hasOwnProperty('responseJSON') && result.responseJSON.hasOwnProperty('message')) {
                            errorMessage = result.responseJSON.message;
                        }

                        $("#schemaInfo").html("");
                        $("#schemaInfo").append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Fail! </strong>' + errorMessage + '</div>');
                        $("#schemaInfo").show();
                        setTimeout(function () {
                            $('#schemaInfo').fadeOut('fast');
                        }, 3000);
                    }
                });
            });

            function renderPrimaryData(el) {

                $('.chkPrimary').iCheck(getiCheckSelection(false));

                $(el).find('.txtFieldName').val("id").prop('readonly', true);
                $(el).find('.txtdbType').val("increments");
                $(el).find('.chkNullable').attr('checked', false);
                $(el).find('.chkSearchable').attr('checked', false);
                $(el).find('.chkFillable').attr('checked', false);
                $(el).find('.chkPrimary').attr('checked', true);
                $(el).find('.chkInForm').attr('checked', false);
                $(el).find('.chkInIndex').attr('checked', false);
                $(el).find('.drdHtmlType').val('number').trigger('change');
            }

            function renderCreatedByData(el) {
                $(el).find('.txtFieldName').val("created_by").prop('readonly', true);
                $(el).find('.txtdbType').val("integer").prop('readonly', true);
                $(el).find('.chkNullable').attr('checked', false);
                $(el).find('.chkSearchable').attr('checked', false);
                $(el).find('.chkFillable').attr('checked', false);
                $(el).find('.chkPrimary').attr('checked', false);
                $(el).find('.chkInForm').attr('checked', false);
                $(el).find('.chkInIndex').attr('checked', false);
                $(el).find('.drdHtmlType').val('number').trigger('change');
            }

            function renderTimeStampData(el) {
                $(el).find('.txtdbType').val("timestamp");
                $(el).find('.chkNullable').attr('checked', false);
                $(el).find('.chkSearchable').attr('checked', false);
                $(el).find('.chkFillable').attr('checked', false);
                $(el).find('.chkPrimary').attr('checked', false);
                $(el).find('.chkInForm').attr('checked', false);
                $(el).find('.chkInIndex').attr('checked', false);
                $(el).find('.drdHtmlType').val('date').trigger('change');
            }
        });

        function initializeCheckbox(el) {
            $(el).find('input:checkbox').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue'
            });
            $(el).find("select").select2({width: '100%'});

            $(el).find(".chkPrimary").on("ifClicked", function () {
                $('.chkPrimary').each(function () {
                    $(this).iCheck('uncheck');
                });
            });

            $(el).find(".chkForeign").on("ifChanged", function () {
                if ($(this).prop('checked') == true) {
                    $(el).find('.txtdbType').val('integer').trigger('change');
                    $(el).find('.txtFactoryFaker').val('').trigger('change');
                    $(el).find(".chkInForm").iCheck('uncheck');
                }
            });

            $(el).find(".chkPrimary").on("ifChanged", function () {
                if ($(this).prop('checked') == true) {
                    $(el).find(".chkSearchable").iCheck('uncheck');
                    $(el).find(".chkFillable").iCheck('uncheck');
                    $(el).find(".chkInForm").iCheck('uncheck');
                }
            });

            var htmlType = $(el).find('.drdHtmlType');

            $(htmlType).select2().on('change', function () {
                if ($(htmlType).val() == "select" || $(htmlType).val() == "radio" || $(htmlType).val() == "checkbox")
                    $(el).find('.htmlValue').show();
                else
                    $(el).find('.htmlValue').hide();
            });

        }

    });

    function getiCheckSelection(value) {
        if (value == true)
            return 'checked';
        else
            return 'uncheck';
    }

    function removeItem(e) {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }

    $("#table").sortable({
        items: 'tbody tr',
        cursor: 'pointer',
        axis: 'y',
        handle: '.h-move',
        dropOnEmpty: false,
        start: function (e, ui) {
            ui.item.addClass("selected");
        },
        stop: function (e, ui) {
            ui.item.removeClass("selected");
            $(this).find("tr").each(function (index) {

            });
        }
    });

</script>
