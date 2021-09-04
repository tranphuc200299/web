<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if(!empty($entity)) L7 - {{ $entity->name }} @else L7 - New Entity @endif</title>
    <link rel="icon" type="image/png" href="/vendor/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/vendor/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/vendor/favicon/favicon-32x32.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.2/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<style>.chk-align{padding-right:10px}.chk-label-margin{margin-left:5px}.required{color:red;padding-left:5px}.btn-green{background-color:#00a65a!important}.btn-blue{background-color:#2489c5!important}.h-move{text-align: center; cursor: pointer}.w-100{width: 100% !important;}</style>
<body class="skin-blue" style="background-color: #ecf0f5">
<div class="col-md-12 col-lg-12">
    <section class="content">
        @include('core::_messages.flash')
        <div id="schemaInfo" style="display: none"></div>
        <div class="box box-primary col-lg-12">
            <div class="box-header" style="margin-top: 10px">
                <h1 class="box-title" style="font-size: 30px">Preview From Json</h1>
            </div>
            <div class="box-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('r.builder.preview') }}">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                    <div class="form-group col-md-6">
                        <label for="schemaFile">Json File<span class="required">*</span></label>
                        <input type="file" name="schemaFile" class="form-control" required accept=".json,application/json">
                    </div>
                    <div class="form-inline col-md-12" style="padding:15px 15px;text-align: right">
                        <a class="btn btn-flat btn-primary btn-blue" href="{{ route('r.index') }}" style="float:left">Back</a>
                        <div class="form-group" style="border-color: transparent;padding-left: 10px">
                            <button type="submit" class="btn btn-flat btn-primary btn-blue" id="btnSmPreview">Preview
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<div class="col-md-12 col-lg-12">
    <section class="content">
        <div class="box box-primary col-lg-12">
            <div class="box-header" style="margin-top: 10px">
                <h1 class="box-title" style="font-size: 30px">Laravel Generator Builder</h1>
            </div>
            <div class="box-body">
                <form id="form">
                    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}"/>
                    <div class="row">
                        <div class="form-group col-md-12" style="margin-top: 7px">
                            <div class="form-control" style="border-color: transparent;padding-left: 0px">
                                <label style="font-size: 18px;color: #f50057">Entities</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="txtModuleName">ModuleName (a-zA-Z0-9_ : CamelCase)<span class="required">*</span></label>
                            <input type="text" value="{{ $config['moduleName']?? ''}}" class="form-control" required id="txtModuleName" placeholder="Enter name" pattern="[a-zA-Z0-9_]+" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtModelName">Model Name (a-zA-Z0-9_ : CamelCase)<span class="required">*</span></label>
                            <input type="text" value="{{ $config['modelName']?? ''}}" class="form-control" required id="txtModelName" placeholder="Enter name" pattern="[a-zA-Z0-9_]+" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtPrefix">Prefix Table (a-zA-Z0-9_)</label>
                            <input type="text"  value="{{ $config['options']['prefix']?? ''}}" class="form-control" id="txtPrefix" placeholder="Enter prefix" pattern="[a-zA-Z0-9]+" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtCustomTblName">Table Name (a-zA-Z0-9_)</label>
                            <input type="text" value="{{ $config['tableName']?? ''}}" class="form-control" id="txtCustomTblName" placeholder="Enter table name" pattern="[a-zA-Z0-9]+">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="txtIcon">Menu Icon</label>
                            <input type="text" value="{{ $config['icon']?? ''}}" class="form-control" id="txtIcon" placeholder="ex: if `fa-user` enter `user`, default fa-table : `table`">
                            <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">https://fontawesome.com/v4.7.0/icons/</a>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtGroup">Group Menu</label>
                            <input type="text" value="{{ $config['group']?? ''}}" class="form-control" id="txtGroup" placeholder="Enter group name">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Options</label>
                            <div class="form-inline form-group" style="border-color: transparent">
                                <div class="checkbox chk-align">
                                    <label>
                                        <input type="checkbox"
                                               @if(!empty($config['options']['softDelete'])) checked @endif
                                               class="flat-red" id="chkDelete"><span
                                                class="chk-label-margin"> Soft Delete </span>
                                    </label>
                                </div>
                                <div class="checkbox chk-align" id="chAuth">
                                    <label>
                                        <input type="checkbox"
                                               @if(!empty($config['addOns']['auth'])) checked @endif
                                               class="flat-red" id="chkAuth"> <span
                                                class="chk-label-margin">Auth</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="listView">List View</label>
                            <select class="form-control" id="listView" style="width: 100%">
                                @php $listView = ['Table', 'Article', 'Gallery'] @endphp
                                @foreach($listView as $view)
                                    <option value="{{$view}}" @if(!empty($config['listView']) && $config['listView'] == $view) selected @endif>{{ $view }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="childView">Relation View</label>
                            <select class="form-control" id="childView" style="width: 100%">
                                @php $listView = ['None', 'Tab'] @endphp
                                @foreach($listView as $view)
                                    <option value="{{$view}}" @if(!empty($config['childView']) && $config['childView'] == $view) selected @endif>{{ $view }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="fakerLanguage">Language</label>
                            <select class="form-control" id="fakerLanguage" style="width: 100%">
                                @php $langs = ['en_US', 'ja_JP', 'vi_VN', 'zh_CN'] @endphp
                                @foreach($langs as $lang)
                                <option value="{{$lang}}" @if(!empty($config['fakerLanguage']) && $config['fakerLanguage'] == $lang) selected @endif>{{ $lang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="txtPaginate">Paginate</label>
                            <input type="number"
                                   value="{{ $config['options']['paginate']?? '10'}}"
                                   class="form-control" id="txtPaginate" placeholder="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12" style="margin-top: 7px">
                            <div class="form-control" style="border-color: transparent;padding-left: 0px">
                                <label style="font-size: 18px;color: #f50057">Fields</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="table-responsive col-md-12">
                        <table class="table table-striped table-bordered" id="table">
                            <thead class="no-border">
                            <tr>
                                <th style="width: 40px"></th>
                                <th style="width: 150px">Field Name</th>
                                <th style="width: 150px">DB Type</th>
                                <th style="width: 130px">Label</th>
                                <th style="width: 160px">Html Type</th>
                                <th style="width: 168px">Faker</th>
                                <th style="width: 108px">Validations</th>
                                <th style="width: 68px">Primary</th>
                                <th style="width: 80px">Nullable</th>
                                <th style="width: 80px">Unique</th>
                                <th style="width: 80px">Is Foreign</th>
                                <th style="width: 87px">Searchable</th>
                                <th style="width: 65px">Editable</th>
                                <th style="width: 67px">In List</th>
                                <th style="width: 50px"></th>
                            </tr>
                            </thead>
                            <tbody id="container" class="no-border-x no-border-y ui-sortable">
                                @if(!empty($config['fields']))
                                    @foreach($config['fields'] as $field)
                                        <tr class="item" style="display: table-row">
                                            @include('r::builder.field-template', ['field' => $field])
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="row">
                        <div class="form-inline col-md-12" style="padding-top: 10px">
                            <div class="form-group chk-align" style="border-color: transparent;">
                                <button type="button" class="btn btn-success btn-flat btn-green" id="btnPrimary"> Add
                                    Primary
                                </button>
                            </div>
                            <div class="form-group chk-align" style="border-color: transparent;">
                                <button type="button" class="btn btn-success btn-flat btn-green" id="btnAdd"> Add Field
                                </button>
                            </div>
                            <div class="form-group chk-align" style="border-color: transparent;">
                                <button type="button" class="btn btn-success btn-flat btn-green" id="btnCreatedBy"> Add Created By
                                </button>
                            </div>
                            <div class="form-group chk-align" style="border-color: transparent;">
                                <button type="button" class="btn btn-success btn-flat btn-green" id="btnTimeStamps"> Add
                                    Timestamps
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12" style="margin-top: 7px">
                            <div class="form-control" style="border-color: transparent;padding-left: 0px">
                                <label style="font-size: 18px; color: #f50057">Model Relationship</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive col-md-12" id="relationShip" style="@if(empty($config['relations'])) display: none @endif">
                            <table class="table table-striped table-bordered" id="table">
                                <thead class="no-border">
                                <tr>
                                    <th width="15%">Foreign Module<span class="required">*</span></th>
                                    <th width="15%">Foreign Model<span class="required">*</span></th>
                                    <th width="15%">Foreign Key<span class="required">*</span></th>
                                    <th width="15%">Relation Type<span class="required">*</span></th>
                                    <th width="15%">Local Key<span class="required">*</span></th>
                                    <th width="15%">Display Name<span class="required">*</span></th>
                                    <th width="15%">Display Field<span class="required">*</span></th>
                                    <th width="5%"></th>
                                </tr>
                                </thead>
                                <tbody id="rsContainer" class="no-border-x no-border-y ui-sortable">
                                    @if(!empty($config['relations']))
                                        <?php $entities = \Develops\_R\Entities\Models\Entities::all(); ?>
                                        @foreach($config['relations'] as $relation)
                                            <tr class="relationItem" style="display: table-row">
                                                @include('r::builder.relation-field-template', [
                                                'relation' => $relation,
                                                'entities' => $entities
                                                ])
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="form-inline col-md-12" style="padding-top: 10px">
                            <div class="form-group" style="border-color: transparent;">
                                <button type="button" class="btn btn-success btn-flat btn-green" id="btnRelationShip"> Add
                                    RelationShip
                                </button>
                            </div>
                        </div>
                        {{--@include('r::builder.options')--}}
                    </div>
                    <div class="row">
                        <div class="form-inline col-md-12">
                            <div id="info" style="display: none;margin-top:15px;"></div>
                        </div>
                    </div>
                    <div class="row" id="control">
                        <div class="form-inline col-md-12" style="padding:15px 15px;text-align: right; margin-bottom: 200px">
                        <div class="form-group" style="border-color: transparent;padding-left: 10px">
                            <a class="btn btn-flat btn-primary btn-blue" href="{{ route('r.index') }}" style="float:left">Back</a>
                        </div>
                        @if(!empty($entity))
                            <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                <a class="btn btn-flat btn-info" href="{{ route('cp.' . Str::plural(strtolower($entity->name)) . '.index') }}" target="_blank">View</a>
                            </div>
                            @if($entity->status == \Develops\_R\Constants\EntityConst::NOT_MIGRATE)
                            <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                <a class="btn btn-flat btn-success" href="{{ route('r.entities.migrate', $entity->id) }}">Migrate</a>
                            </div>
                            @endif
                            @if($entity->status == \Develops\_R\Constants\EntityConst::MIGRATED)
                            <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                <a class="btn btn-flat btn-warning" href="{{ route('r.entities.rollback', $entity->id) }}">Rollback</a>
                            </div>
                            <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                <a class="btn btn-flat btn-info" href="{{ route('r.entities.factory', $entity->id) }}">Make 20 items</a>
                            </div>
                            @endif
                        @endif

                        <div class="form-group" style="border-color: transparent;padding-left: 10px">
                            <button type="button" class="btn btn-flat btn-primary btn-blue" id="btnJsonDownload">Json <i class="fa fa-download" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="form-group" style="border-color: transparent;padding-left: 10px">
                            <button type="submit" class="btn btn-flat btn-primary btn-success" id="btnGenerate">Generate
                            </button>
                        </div>
                        <div class="form-group" style="border-color: transparent;padding-left: 10px">
                            <button type="button" class="btn btn-default btn-flat" id="btnReset" data-toggle="modal"
                                    data-target="#confirm-delete"> Reset
                            </button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Reset</h4>
            </div>

            <div class="modal-body">
                <p style="font-size: 16px">This will reset all of your fields. Do you want to proceed?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">No
                </button>
                <a id="btnModelReset" class="btn btn-flat btn-danger btn-ok" data-dismiss="modal">Yes</a>
            </div>
        </div>
    </div>
</div>
{{--<div class="col-md-12 col-lg-12">--}}
    {{--<section class="content">--}}
        {{--<div id="schemaInfo" style="display: none"></div>--}}
        {{--<div class="box box-primary col-lg-12">--}}
            {{--<div class="box-header" style="margin-top: 10px">--}}
                {{--<h1 class="box-title" style="font-size: 30px">Generate CRUD From Json</h1>--}}
            {{--</div>--}}
            {{--<div class="box-body">--}}
                {{--<form method="post" id="schemaForm" enctype="multipart/form-data">--}}
                    {{--<input type="hidden" name="_token" id="smToken" value="{!! csrf_token() !!}"/>--}}
                    {{--<div class="form-group col-md-6">--}}
                        {{--<label for="schemaFile">Json File<span class="required">*</span></label>--}}
                        {{--<input type="file" name="schemaFile" class="form-control" required id="schemaFile" accept=".json,application/json">--}}
                    {{--</div>--}}
                    {{--<div class="form-inline col-md-12" style="padding:15px 15px;text-align: right">--}}
                        {{--<div class="form-group" style="border-color: transparent;padding-left: 10px">--}}
                            {{--<button type="submit" class="btn btn-flat btn-primary btn-blue" id="btnSmGenerate">Generate--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
{{--</div>--}}

</body>
@include('r::builder.script')
</html>
