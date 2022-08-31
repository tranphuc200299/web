{!! Form::open(['route' => 'cp.logs.index', 'class' => 'filter', 'method' => 'GET']) !!}

<div class="row p-4 bg-gray align-items-end">
    <div class="col-lg-1">
        <div class="form-group">
            <label for="id">ID</label>
            <input class="form-control" name="id" type="text" value="{{ request('id') }}">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <label for="gender"> {{ trans('log::text.gender') }}</label>
            <select name="gender" class="form-control" data-toggle="select2-single">
                <option value="" disabled selected>{{trans('log::text.choose gender')}}</option>
                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>{{trans('log::text.gender male')}} </option>
                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>{{trans('log::text.gender female')}}</option>
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="age">{{ trans('log::text.age') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5">
                    <input class="form-control filter_age" name="age_start" id="ageId" autocomplete="off"
                           value="{{ request('age_start') }}">
                </div>
                <img src="{{ asset('assets/img/tilde.png') }}" alt="logo" >                <div class="col-5">
                    <input class="form-control filter_age" name="age_end" autocomplete="off" value="{{ request('age_end') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="age">{{ trans('log::text.check in date') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5">
                    <input class="form-control date-filter fa fa-calendar" name="start_date" type="text" value="{{ request('start_date') }}" readonly autocomplete="off">
                </div>
                <img src="{{ asset('assets/img/tilde.png') }}" alt="logo" >
                <div class="col-5">
                    <input class="form-control date-filter" name="end_date" type="text" value="{{ request('end_date') }}" readonly autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="time">{{ trans('log::text.check in time') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5">
                    <input class="form-control time-filter" name="start_time" type="text" value="{{ request('start_time') }}" readonly autocomplete="off">
                </div>
                <img src="{{ asset('assets/img/tilde.png') }}" alt="logo" >
                <div class="col-5">
                    <input class="form-control time-filter" name="end_time" type="text" value="{{ request('end_time') }}" readonly autocomplete="off">
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
                <button class="btn btn-danger btn-delete-list" href="#" id="delete-log"
                        disabled="disabled">{{trans('log::text.delete')}}</button>
            </div>
        </div>
    </div>

</div>

{!! Form::close() !!}
