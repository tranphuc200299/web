{!! Form::open(['route' => 'cp.customers.index', 'class' => 'filter', 'method' => 'GET']) !!}

<div class="row p-4 bg-gray align-items-end">
    <div class="col-lg-1 mr-lg-4">
        <div class="form-group">
            <label for="id">ID</label>
            <input class="form-control color-text" name="id" type="text" value="{{ request('id') }}" autocomplete="off">
        </div>
    </div>
    <div class="col-lg-1 mr-lg-4">
        <div class="form-group">
            <label for="gender"> {{ trans('log::text.gender') }}</label>
            <select name="gender" class="form-control color-text" data-toggle="select2-single" data-minimum-results-for-search="Infinity">
                <option value="">{{trans('log::text.choose gender')}}</option>
                <option value="Male"
                        class="color-text" {{ request('gender') == 'Male' ? 'selected' : '' }}>{{trans('log::text.gender male')}} </option>
                <option value="Female"
                        class="color-text" {{ request('gender') == 'Female' ? 'selected' : '' }}>{{trans('log::text.gender female')}}</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3 mr-lg-4">
        <div class="form-group">
            <label for="age">{{ trans('log::text.age') }}</label>
            <div class="d-flex align-items-center">
                <div class="col-5">
                    <input class="form-control filter_age color-text" name="age_start" id="ageId" autocomplete="off"
                           value="{{ request('age_start') }}">
                </div>
                <img src="{{ asset('assets/img/tilde.png') }}" alt="logo">
                <div class="col-5">
                    <input class="form-control filter_age color-text" name="age_end" autocomplete="off"
                           value="{{ request('age_end') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 d-flex justify-content-end mr-lg-4">
        <div class="form-group d-flex">
            <div>
                <button type="submit" class="btn btn-yellow pl-lg-4 pr-lg-4 ml-lg-2">
                    {{trans('core::common.search')}}
                </button>
                <button class="btn btn-danger btn-delete-list ml-lg-2" id="delete-customer"
                        disabled="disabled">{{trans('log::text.delete')}}</button>
                <button class="btn btn-danger btn-delete-all ml-lg-2"
                        id="delete-cutomer-button">{{trans('log::text.delete-all')}}</button>
            </div>
        </div>
    </div>

</div>

{!! Form::close() !!}
<form action="{{route('cp.customers.deleteAll')}}" method="post" id="deleteCustomer">
    @csrf
</form>
