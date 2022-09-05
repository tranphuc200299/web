@extends('auth::layout')
@section('content')
    <div class=" container-fluid bg-white">
{{--        @include('auth::user._partials.filter')--}}
        <div class="card card-transparent pt-2">
            @include('core::_messages.flash')
            <div class="">
                <div class="row bold">
                    <div class="col-12">
                        @can('create', Modules\Auth\Entities\Models\User::class)
                            <a href="{{ route('cp.users.create') }}" class="pull-right">
                                <button type="button" class="btn btn-success btn-xs">{{ trans('auth::user.create') }}</button>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                {!!  Html::renderHeader(
                                 [
                                 'id' => ['name' => trans('core::common.No'), 'style' => 'width: 80px'],
                                 'full_name' => ['name' => trans('auth::user.full_name')],
                                 'user_name' => ['name' => trans('auth::user.user_name')],
                                 'created_at' => ['name' => trans('core::common.created at')],
                                 'updated_at' => ['name' => trans('core::common.updated at')],
                                 'action' => ['name' => '','style' => "width: 270px"],
                                 ],'id', route(Route::currentRouteName()), false)  !!}
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td class="v-align-middle text-center">
                                    {{($users->currentpage()-1)*$users->perpage()+ $key + 1}}
                                </td>
                                <td class="v-align-middle  text-center">{{ $user->full_name }}</td>
                                <td class="v-align-middle">{{ $user->user_name }}</td>
                                <td class="v-align-middle  text-center">{{ $user->created_at }}</td>
                                <td class="v-align-middle  text-center">{{ $user->updated_at }}</td>
                                <td class="v-align-middle  text-center">
                                    @can('delete', $user)
                                        <form action="{{route('cp.users.destroy', $user->id)}}"
                                              class="d-inline form-delete" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-xs user-delete-disable" type="submit">
                                                {{ trans('core::common.delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                    @can('update', $user)
                                        <a class="btn btn-primary btn-xs"
                                           href="{{ route('cp.users.edit', [$user->id]) }}">
                                            {{ trans('core::common.edit') }}
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    @if(!empty($users) && count($users) > 0)
                        <div class="col-xs-12 col-sm-5">
                            <nav class="mt-3">
                                @include('core::_pagination.counting', ['paginator' => $users])
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
                            @if(!empty($users))
                                {{ $users->appends($_GET)->links('vendor.pagination.custom') }}
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
            var formMessages = $('#form-messages');
            //handel delete checkbox log
            $('.form-delete').one('submit', function (e) {
                let self = $(this);
                // var id = $(this).data('id');
                e.preventDefault();
                Swal.fire({
                    text: "を削除してもよろしいですか?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'はい',
                    cancelButtonText: 'いいえ'
                }).then((result) => {
                    if (result.value) {
                        self.submit();
                    }
                })
            })
            $(document).on('click', '.user-delete-disable', function (e) {
                e.preventDefault();
                let self = $(this);
                self.removeAttr("disabled");
            });
        });
    </script>
@endpush
