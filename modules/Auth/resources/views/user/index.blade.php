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
                                <button type="button" class="btn btn-success btn-xs">{{ trans('auth::user.create') }} <i
                                            class="fa fa-plus-circle"></i></button>
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
                                 'full_name' => ['name' => trans('auth::user.full_name'), 'sortable' => true],
                                 'user_name' => ['name' => trans('auth::user.user_name'), 'sortable' => true],
                                 'created_at' => ['name' => trans('core::common.created at'), 'sortable' => true],
                                 'updated_at' => ['name' => trans('core::common.updated at'), 'sortable' => true],
                                 'action' => ['name' => '', 'sortable' => false, 'style' => "width: 270px"],
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
                                              class="d-inline" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-xs" type="submit"
                                                    data-toggle="confirmation"
                                                    data-original-title="{{ trans('core::message.delete message confirmed') }}">
                                                <i class="fa fa-remove"></i> {{ trans('core::common.delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                    @can('update', $user)
                                        <a class="btn btn-primary btn-xs"
                                           href="{{ route('cp.users.edit', [$user->id]) }}">
                                            <i class="fa fa-pencil"></i>
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
                    <div class="col-xs-12 col-sm-5">
                        <nav class="mt-3">
                            @include('core::_pagination.counting', ['paginator' => $users])
                        </nav>
                    </div>
                    <div class="col-xs-12 col-sm-7">
                        <nav class="mt-3">
                            @if(!empty($users))
                                {{ $users->appends(request()->input())->links() }}
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
{{--    <script>--}}
{{--        $(function () {--}}
{{--            //handel delete checkbox log--}}
{{--            $(document).on('click', '.btn-delete-user', function (e) {--}}
{{--                e.preventDefault();--}}
{{--                Swal.fire({--}}
{{--                    // title: 'Có X bản ghi được chọn ',--}}
{{--                    text: "X を削除してもよろしいですか ?",--}}
{{--                    type: 'warning',--}}
{{--                    showCancelButton: true,--}}
{{--                    confirmButtonColor: '#3085d6',--}}
{{--                    cancelButtonColor: '#d33',--}}
{{--                    confirmButtonText: 'はい',--}}
{{--                    cancelButtonText: 'いいえ'--}}
{{--                }).then((result) => {--}}
{{--                    if (result.value) {--}}
{{--                        Swal.fire(--}}
{{--                            'Deleted!',--}}
{{--                            'Your file has been deleted.',--}}
{{--                            'success'--}}
{{--                        )--}}
{{--                    }--}}
{{--                })--}}
{{--            })--}}
{{--        });--}}
{{--    </script>--}}
@endpush
