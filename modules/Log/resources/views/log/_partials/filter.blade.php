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
                <option value="" disabled selected>Chọn...</option>
                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male </option>
                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="age">{{ trans('log::text.age') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5">
                    <input class="form-control" name="age_start" type="number" value="{{ request('age_start') }}">
                </div>
                <i class="fa fa-arrow-right"></i>
                <div class="col-5">
                    <input class="form-control" name="age_end" type="number" value="{{ request('age_end') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="age">{{ trans('log::text.check in date') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5">
                    <input class="form-control date-filter" name="start_date" type="text" value="{{ request('start_date') }}" readonly autocomplete="off">
                </div>
                <i class="fa fa-arrow-right col-"></i>
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
                <i class="fa fa-arrow-right"></i>
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
                    <i class="fa fa-search" aria-hidden="true"></i>
                    {{trans('core::common.search')}}
                </button>
                {{--<button class="btn btn-secondary">--}}
                    {{--<a href="{{route('cp.logs.index')}}">{{trans('core::common.clear filter')}}</a>--}}
                {{--</button>--}}
                <button class="btn btn-danger btn-delete-list" href="#" id="delete-log"
                        disabled="disabled">{{trans('core::common.delete')}}</button>
            </div>
        </div>
    </div>

</div>

{!! Form::close() !!}
