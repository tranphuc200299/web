@extends('customer::layout')
@section('content')
    <div class="container-fluid bg-white">
        @include('customer::customer._partials.filter')
        <div class="card card-transparent pt-2">
            @include('core::_messages.flash')
            <div class="">
                <div class="d-flex justify-content-end">
                    <div class="">
                        <a href="#"
                           class="pull-right">
                            <button type="button" class="btn btn-success btn btn-secondary">
                                {{trans('log::text.csv')}}
                            </button>
                        </a>
                    </div>
{{--                    @if(count($list) > 0)--}}
                        <div class="m-l-5">
                            <a href="#"
                               class="pull-right">
                                <button type="button" class="btn btn-success btn btn-secondary">
                                    ダウンロード画像
                                </button>
                            </a>
                        </div>
{{--                    @endif--}}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="basicTable">
                        <thead>
                        <tr>
                            {!!  Html::renderHeader(
                             [
                             '' => ['name' => '<input type="checkbox" id="checkAll" > ', 'style' => 'width: 80px'],
                             'stt' => ['name' => trans('log::text.stt'), 'style' => 'width: 80px'],
                             'id' => ['name' => 'ID'],
                             'gender' => ['name' => trans('log::text.gender')],
                             'age' => ['name' => trans('log::text.age')],
                             ],'id', route(Route::currentRouteName()), false)  !!}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $k => $log)
                            <tr>
                                <td class="v-align-middle text-center">
                                    <input type="checkbox" name="deleteItem" id="checkBox_delete" value="{{$log->id}}">
                                </td>
                                <td class="v-align-middle text-center">{{($list->currentpage()-1)*$list->perpage()+ $k + 1}}</td>
                                <td class="v-align-middle text-center pr-5">ID{{$log->id}}</td>
                                <td class="v-align-middle text-center">{{$log->gender ==  'Male' ? '男性' : '女性'}}</td>
                                <td class="v-align-middle text-center">{{$log->age}}</td>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    @if(!empty($list) && count($list) > 0)
                        <div class="col-xs-12 col-sm-5">
                            <nav class="mt-3">
                                @include('core::_pagination.counting', ['paginator' => $list])
                            </nav>
                        </div>
                    @else
                        <div class="col-xs-12 col-sm-12">
                            <div class="text-center top-20 pull-left">
                                {{ trans('core::message.paging.No corresponding record') }}
                            </div>
                        </div>
                    @endif

                    <div class="col-xs-12 col-sm-7">
                        <nav class="mt-3">
{{--                            @if(!empty($list))--}}
{{--                                {{ $list->appends($_GET)->links('vendor.pagination.custom') }}--}}
{{--                            @endif--}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- END card -->
    </div>
@endsection
@push('custom-scripts')
    <script>
        $(function () {


        });

    </script>
@endpush
