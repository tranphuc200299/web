{!! Form::open(['route' => 'cp.logs.index', 'class' => 'filter', 'method' => 'GET']) !!}

<div class="row p-4 bg-gray align-items-end">
    <div class="col-lg-1">
        <div class="form-group">
            <label for="id">ID</label>
            <input class="form-control color-text" name="id" type="text" value="{{ request('id') }}" autocomplete="off">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <label for="gender"> {{ trans('log::text.gender') }}</label>
            <select name="gender" class="form-control color-text select2-single" data-toggle="select2-single" data-minimum-results-for-search="Infinity">
                <option value="">{{trans('log::text.choose gender')}}</option>
                <option value="Male" class="color-text" {{ request('gender') == 'Male' ? 'selected' : '' }}>{{trans('log::text.gender male')}} </option>
                <option value="Female" class="color-text" {{ request('gender') == 'Female' ? 'selected' : '' }}>{{trans('log::text.gender female')}}</option>
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="age">{{ trans('log::text.age') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5">
                    <input class="form-control filter_age color-text" name="age_start" id="ageId" autocomplete="off"
                           value="{{ request('age_start') }}">
                </div>
                <img src="{{ asset('assets/img/tilde.png') }}" alt="logo" >                <div class="col-5">
                    <input class="form-control filter_age color-text" name="age_end" autocomplete="off" value="{{ request('age_end') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="age">{{ trans('log::text.check in date') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5 calendar-start">
                    <div class="input-group-addon-calendar">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control date-filter fa fa-calendar data-start color-text"  name="start_date" type="text" value="{{ request('start_date') }}" readonly autocomplete="off">
                </div>
                <img src="{{ asset('assets/img/tilde.png') }}" alt="logo" >
                <div class="col-5 calendar-end">
                    <div class="input-calendar-end">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control date-filter data-end color-text" name="end_date" type="text" value="{{ request('end_date') }}" readonly autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="time">{{ trans('log::text.check in time') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5 time-group-start">
                    <div class="input-clock-start">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </div>
                    <input class="form-control time-filter color-text" name="start_time" type="text" value="{{ request('start_time') }}" readonly autocomplete="off">
                </div>
                <img src="{{ asset('assets/img/tilde.png') }}" alt="logo" >
                <div class="col-5 time-group-end">
                    <div class="input-clock-end">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </div>
                    <input class="form-control time-filter color-text" name="end_time" type="text" value="{{ request('end_time') }}" readonly autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 text-center ">
        <div class="form-group d-flex">
            <div>
                <button type="submit" class="btn btn-yellow">
                    {{trans('core::common.search')}}
                </button>
                {{--<button class="btn btn-secondary">--}}
                    {{--<a href="{{route('cp.logs.index')}}">{{trans('core::common.clear filter')}}</a>--}}
                {{--</button>--}}
                <button class="btn btn-danger btn-delete-list" href="#" id="delete-check-log"
                        disabled="disabled">{{trans('log::text.delete')}}</button>
                <button class="btn btn-danger delete-all-log"
                        id="delete-log" {{(count($list) > 0 ? "" : "disabled")}}>{{trans('log::text.delete-all')}}</button>
            </div>
        </div>
    </div>

</div>

{!! Form::close() !!}
<form action="{{route('cp.logs.deleteAll')}}" method="post" id="deleteLog">
    @csrf
</form>
