@extends('log::layout')
@section('content')
    <div class="container-fluid bg-white">
        @include('log::log._partials.filter')
        <div class="card card-transparent pt-2">
            @include('core::_messages.flash')
            <div class="">
                <div class="row bold">
                    <div class="col-12">
                    </div>
                </div>

                <div class="row bold">
                    <div class="col-12">
                        @if(count($list) > 0)
                        <div class="col-12">
                            <a href="{{ route('cp.logs.download') . str_replace('/cp/logs', '', request()->getRequestUri()) }}" class="pull-right">
                                <button type="button" class="btn btn-success btn btn-secondary" >
                                    Download
                                </button>
                            </a>
                        </div>
                        @endif
                        <div class="col-11">
                            <a href="{{ route('cp.logs.export') . str_replace('/cp/logs', '', request()->getRequestUri()) }}" class="pull-right">
                                <button type="button" class="btn btn-success btn btn-secondary" >
                                    Export Csv
                                </button>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover" id="basicTable">
                        <thead>
                        <tr>
                            {!!  Html::renderHeader(
                             [
                             '' => ['style' => 'width: 80px'],
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
                        @foreach($list as $log)
                            <tr>
                                <td class="v-align-middle text-center">
                                    <input type="checkbox" id="checkBox_delete" value="{{$log->id}}">
                                </td>
                                <td class="v-align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="v-align-middle text-center" id="UserId">{{$log->customer->id}}</td>
                                <td class="v-align-middle text-center"><a href="#">Xem ảnh</a></td>
                                <td class="v-align-middle text-center">{{$log->customer->gender}}</td>
                                <td class="v-align-middle text-center">{{$log->customer->age}}</td>
                                <td class="v-align-middle text-center">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d') }}</td>
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
                timePickerSeconds : true,
                autoUpdateInput: false,
                locale : {
                    format : 'HH:mm:ss'
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
            });

            $('.date-filter').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2000,
                maxYear: parseInt(moment().format('YYYY'),10),
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format : 'yy/MM/DD'
                }
            });

            $('.time-filter').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('HH:mm:ss'));
            });

            $('.date-filter').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('yy/MM/DD'));
            });

            $('.date-filter, .time-filter').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $("input:checkbox").change(function () {
                let $this = $(this);
                if ($this.is(":checked")) {
                    $('.btn-delete-list').removeAttr('disabled');
                } else {
                    $('.btn-delete-list').attr('disabled', 'disabled');
                }
            });
            //handel delete checkbox log
            $(document).on('click', '#delete-log', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '選択されているXXレコードを削除しても ',
                    text: "よろしいですか。",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'はい',
                    cancelButtonText: 'いいえ'
                }).then((result) => {
                    if (result.value) {
                        let dataId = [];
                        $("input:checkbox").each(function () {
                            let $this = $(this);
                            if ($this.is(":checked")) {
                                dataId.push($this.val());
                            }
                        });
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
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success',
                                ).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                })
                            }, error: function (error) {
                                console.log(error);
                            }
                        });
                    }
                })
            })
        });
    </script>
@endpush
