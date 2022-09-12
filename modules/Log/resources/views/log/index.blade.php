@extends('log::layout')
@section('title', trans('log::text.log management'))
@section('content')
    <div class="container-fluid bg-white">
        @include('log::log._partials.filter')
        <div class="card card-transparent pt-2">
            @include('core::_messages.flash')
            <div class="">
                <div class="d-flex justify-content-end">
                    <div class="">
                        <a href="{{ route('cp.logs.export') . str_replace('/cp/logs', '', request()->getRequestUri()) }}"
                           class="pull-right csv-export">
                            <button type="button" class="btn btn-success btn btn-secondary">
                                {{trans('log::text.csv')}}
                            </button>
                        </a>
                    </div>
                    @if(count($list) > 0)
                        <div class="m-l-5">
                            <a href="{{ route('cp.logs.download') . str_replace('/cp/logs', '', request()->getRequestUri()) }}"
                               class="pull-right">
                                <button type="button" class="btn btn-success btn btn-secondary">
                                    ダウンロード画像
                                </button>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="basicTable">
                        <thead>
                        @if(!empty($list) && count($list) > 0)
                            <div class="col-xs-12 col-sm-5 mb-2">
                                <nav class="mt-3">
                                    @include('core::_pagination.counting', ['paginator' => $list])
                                </nav>
                            </div>
                        @else
                            <div class="col-xs-12 col-sm-12 mt-2">
                                <div class="text-center top-20 pull-left mb-2">
                                    {{ trans('core::message.paging.No corresponding record') }}
                                </div>
                            </div>
                        @endif

                        <tr>
                            {!!  Html::renderHeader(
                             [
                             '' => ['name' => '<input type="checkbox" id="checkAll" > ', 'style' => 'width: 80px'],
                             'stt' => ['name' => trans('log::text.stt'), 'style' => 'width: 80px'],
                             'id' => ['name' => 'ID'],
                             'image' => ['name' => trans('log::text.image')],
                             'gender' => ['name' => trans('log::text.gender')],
                             'age' => ['name' => trans('log::text.age')],
                             'check_in_date' => ['name' => trans('log::text.check in date')],
                             'check_in_time' => ['name' => trans('log::text.check in time')],
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
                                <td class="v-align-middle text-center">ID{{$log->customer->id}}</td>
                                <td class="v-align-middle text-center"><a href="#" class="show-image image-log"
                                                                          data-image={{ env('URL_AI') . $log->face_image_url }}>画像閲覧</a>
                                </td>
                                <td class="v-align-middle text-center">{{$log->customer->gender ==  'Male' ? '男性' : '女性'}}</td>
                                <td class="v-align-middle text-center">{{$log->customer->age}}</td>
                                <td class="v-align-middle text-center">{{ \Carbon\Carbon::parse($log->created_at)->format('Y/m/d') }}</td>
                                <td class="v-align-middle text-center">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}</td>
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
{{--                                @include('core::_pagination.counting', ['paginator' => $list])--}}
                            </nav>
                        </div>
                    @else
                        <div class="col-xs-12 col-sm-12 mt-2">
                            <div class="text-center top-20 pull-left">
{{--                                {{ trans('core::message.paging.No corresponding record') }}--}}
                            </div>
                        </div>
                    @endif

                    <div class="col-xs-12 col-sm-7">
                        <nav class="mt-3">
                            @if(!empty($list))
                                {{ $list->appends($_GET)->links('vendor.pagination.custom') }}
                            @endif
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

            $('.time-filter').daterangepicker({
                timePicker : true,
                singleDatePicker:true,
                timePicker24Hour : true,
                timePickerIncrement : 1,
                // timePickerSeconds : true,
                autoUpdateInput: false,
                locale : {
                    format : 'HH:mm',
                    applyLabel: "申し込み",
                    cancelLabel: "キャンセル",
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
            });

            $('.date-filter').daterangepicker({
                singleDatePicker: true,
                // autoApply: true,
                showDropdowns: true,
                minYear: 2000,
                maxYear: 2030,
                autoUpdateInput: false,
                locale: {
                    format : 'yy/MM/DD',
                    "daysOfWeek": [
                        "日",
                        "月",
                        "火",
                        "水",
                        "木",
                        "金",
                        "土"
                    ],
                    "monthNames": [
                        "一月",
                        "二月",
                        "三月",
                        "四月",
                        "五月",
                        "六月",
                        "七月",
                        "八月",
                        "九月",
                        "十月",
                        "十一月",
                        "十二月"
                    ],
                    applyLabel: "申し込み",
                    cancelLabel: "キャンセル",
                }
            });

            $('.time-filter').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('HH:mm'));
            });

            $('.date-filter').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('yy/MM/DD'));
            });

            $('.date-filter, .time-filter').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $("input[name='deleteItem']").change(function () {
                let $this = $(this);
                if ($("input[name='deleteItem']").is(":checked")) {
                    $('.btn-delete-list').removeAttr('disabled');
                } else {
                    $('.btn-delete-list').attr('disabled', 'disabled');
                }
            });
            //handel delete checkbox log
            $(document).on('click', '#delete-check-log', function (e) {
                e.preventDefault();
                let dataId = [];
                $("input[name='deleteItem']").each(function () {
                    let $this = $(this);
                    if ($this.is(":checked")) {
                        dataId.push($this.val());
                    }
                });
                console.log(dataId);
                Swal.fire({
                    // title: '選択されているXXレコードを削除しても ',
                    text: `選択されている${dataId.length}レコードを削除してもよろしいですか。`,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'はい',
                    cancelButtonText: 'いいえ'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            "url": '{{ route('cp.logs.destroy') }}',
                            "method": "POST",
                            data: {
                                id: dataId,
                            },
                            success: function (data) {
                                console.log(data)
                                if (data.code == 200)
                                {
                                    Swal.fire(
                                        {
                                            type: 'success',
                                            text: `${data.message}`,
                                        }

                                    ).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    })
                                }
                            }, error: function (error) {
                                console.log(error);
                            }
                        });
                    }
                })
            })

            $('.show-image').on('click', function(e) {
                e.preventDefault()
                let image = $(this).attr('data-image');
                Swal.fire({
                    imageUrl: `${image}`,
                    imageHeight: '100%',
                    imageAlt: 'Image Logs',
                    showCloseButton: true,
                    showConfirmButton: false
                })
            })
            //handler for select all change
            $('#checkAll').change(function () {
                $("input[name='deleteItem']").prop('checked', $(this).prop('checked'));
                if ($('#checkAll').is(":checked")) {
                    $('.btn-delete-list').removeAttr('disabled');
                }else{
                    $('.btn-delete-list').attr('disabled', 'disabled');
                }
            })
            //handler for all checkboxes to refect selectAll status
            $("input[name='deleteItem']").change(function () {
                $("#checkAll").prop('checked', true)
                $("input[name='deleteItem']").each(function () {
                    if (!$(this).prop('checked')) {
                        $("#checkAll").prop('checked', $(this).prop('checked'));
                    }
                })
            })

            $(document).on('keypress', '.filter_age', function (event) {
                if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                    $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

            // delete all button
            $(document).on('click', '#delete-log', function (e) {
                e.preventDefault();
                let dataId = [];
                Swal.fire({
                    text: `全件を削除してもよろしいですか。`,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'はい',
                    cancelButtonText: 'いいえ'
                }).then((result) => {
                    if (result.value) {
                        $('#deleteLog').submit();
                    }
                })
            })

        });

        $('.csv-export').on('click', function (e) {
            setTimeout(function () {
                Swal.fire({
                    type: 'success',
                    title: 'ファイルが正常に抽出されました。',
                    showConfirmButton: false,
                    timer: 2000
                })
            }, 500);
        });

    </script>
@endpush
