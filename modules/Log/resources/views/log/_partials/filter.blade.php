{!! Form::open(['route' => 'cp.logs.index', 'class' => 'filter', 'method' => 'GET']) !!}

<div class="row p-4 bg-gray align-items-end">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="id">ID</label>
            <input class="form-control" name="id" type="text" value="{{ request('id') }}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" class="form-control" data-toggle="select2-single">
                <option value="" disabled selected>Chọn...</option>
                <option value="Male">Male </option>
                <option value="Female">Female</option>
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="age">Age</label>
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
            <label for="age">Check in date</label>
            <input class="form-control date-filter" name="date_start" type="text" value="{{ request('date_start') }}">
        </div>
    </div>

    <div class="col-lg-3 text-center ">
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-yellow">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    {{trans('core::common.search')}}
                </button>
                <button class="btn btn-secondary">
                    <a href="{{route('cp.logs.index')}}">{{trans('core::common.clear filter')}}</a>
                </button>
                    <button class="btn btn-danger btn-delete-list" href="#" id="delete-log" disabled="disabled">{{trans('core::common.delete')}}</button>
            </div>
        </div>
    </div>

</div>

{!! Form::close() !!}
