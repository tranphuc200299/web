@extends('r::layout')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Permission table</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form action="{{ route('r.permissions.sync') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="send" type="submit" class="btn btn-success" style="float: right">Save</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                            <td>Entities</td>
                                            @foreach($listRoles as $role)
                                                <th>
                                                    {{ $role->name }}
                                                    <input type="checkbox" class="flat ckAll" data-value="{{$role->id}}"
                                                        @if($listPermissions->count() == $role->permissions->count()) checked @endif
                                                    >
                                                </th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($listPermissions as $permission)
                                            <tr>
                                                <td>{{ $permission->name }}</td>
                                                @foreach($listRoles as $role)
                                                    <td class="a-center ">
                                                        <input type="checkbox" class="flat role_ck_{{$role->id}}"
                                                               name="roles[{{$role->id}}][]" value="{{$permission->id}}"
                                                            @if(in_array($permission->id, $role->permissions->pluck('id')->toArray()))
                                                               checked
                                                            @endif>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="send" type="submit" class="btn btn-success" style="float: right">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('ready', function(){
            $(document).on('ifChecked', '.ckAll', function () {
                let value = $(this).data('value');
                $('.role_ck_' + value).iCheck('check');
            });
            $(document).on('ifUnchecked', '.ckAll', function () {
                let value = $(this).data('value');
                    $('.role_ck_' + value).iCheck('uncheck');
              });
        });

    </script>
@endsection
