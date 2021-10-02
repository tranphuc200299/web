{!! Form::open(['route' => 'cp.users.index', 'class' => 'filter', 'method' => 'GET']) !!}

<div class="row p-4 bg-gray">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="name">{{ trans('auth::user.name') }}</label>
            {{ Form::text('name', request('name'), ['class' => 'form-control', 'id' => 'name']) }}
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="email">{{trans('core::common.email')}}</label>
            {{ Form::text('email', request('email'), ['class' => 'form-control', 'id' => 'email']) }}
        </div>
    </div>
</div>

<div class="col-12 text-center p-1 bg-light-yellow">
    <button type="submit" class="btn btn-yellow">
        <i class="fa fa-search" aria-hidden="true"></i>
        {{trans('core::common.search')}}
    </button>
    <button class="btn btn-secondary">
        <a href="{{route('cp.users.index')}}">{{trans('core::common.clear filter')}}</a>
    </button>
</div>

{!! Form::close() !!}
