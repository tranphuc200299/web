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
                <div class="table-responsive">
                    <table class="table table-hover" id="basicTable">
                        <thead>
                        <tr>
                            {!!  Html::renderHeader(
                             [
                             '' => ['style' => 'width: 80px'],
                             'stt' => ['name' => 'STT', 'style' => 'width: 80px'],
                             'id' => ['name' => 'ID'],
                             'image' => ['name' => 'image'],
                             'gender' => ['name' => 'gender' , 'sortable' => true],
                             'age' => ['name' => 'Age' , 'sortable' => true],
                             'check_in_date' => ['name' => 'Check in date' ],
                             'check_in_time' => ['name' => 'Check in time'],
                             ],'id', route(Route::currentRouteName()), false)  !!}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $log)
                            <tr>
                                <td class="v-align-middle text-center">
                                    <input type="checkbox">
                                </td>
                                <td class="v-align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="v-align-middle text-center">{{$log->id}}</td>
                                <td class="v-align-middle text-center"><a href="#">Xem ảnh</a></td>
                                <td class="v-align-middle text-center">{{$log->customer->gender}}</td>
                                <td class="v-align-middle text-center">{{$log->customer->age}}</td>
                                <td class="v-align-middle text-center">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d') }}</td>
                                <td class="v-align-middle text-center">{{ \Carbon\Carbon::parse($log->created_at)->format('h:i:s') }}</td>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <nav class="mt-3">
                            @include('core::_pagination.counting', ['paginator' => $list])
                        </nav>
                    </div>
                    <div class="col-xs-12 col-sm-7">
                        <nav class="mt-3">
                            @if(!empty($list))
                                {{ $list->appends(request()->input())->links() }}
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
    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>--}}
    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>--}}
    <script>
        $(function() {

            $('.date-filter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('.date-filter').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('.date-filter').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });
    </script>
@endpush
