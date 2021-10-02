@extends('r::layout')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <!-- START card -->
            <div class="card card-transparent">
                @include('core::_messages.flash')
                <div class="x_panel">
                    <div class="card-header ">
                        <div class="card-title">Entities table</div>
                        <a href="{{ route('r.builder.create') }}" class="pull-right btn btn-success btn-xs">Create
                            Entities <i class="fa fa-plus-circle"></i>
                        </a>
                        <a href="{{ route('cp') }}" class="pull-right btn btn-info btn-xs" target="_blank">App <i
                                    class="fa fa-table"></i>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive bulk_action jambo_table" style="display: table;">
                                <thead>
                                <tr class="headings">
                                    <th class="text-center">
                                        <input type="checkbox" name="check_all" id="check-all" class="flat">
                                    </th>
                                    <th>ID</th>
                                    <th>Module Name</th>
                                    <th>Model Name</th>
                                    <th>Namespace</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listEntities as $entity)
                                    <tr>
                                        <td class="text-center v-align-middle">
                                            <input type="checkbox" class="flat" name="table_records">
                                        </td>
                                        <td class="v-align-middle">{{ $entity->id }}</td>
                                        <td class="v-align-middle">{{ $entity->module_name }}</td>
                                        <td class="v-align-middle">{{ $entity->name }}</td>
                                        <td class="v-align-middle">{!! $entity->namespace !!}</td>
                                        <td class="v-align-middle">{{ $entity->created_at }}</td>
                                        <td class="v-align-middle">
                                            <a class="btn btn-primary btn-xs"
                                               href="{{ route('r.entities.edit', $entity->id) }}"
                                               target="_blank">Edit</a>
                                            <a class="btn btn-dark btn-xs"
                                               href="{{ route('cp.' . Str::plural(strtolower($entity->name)) . '.index') }}"
                                               target="_blank">View</a>
                                            @if($entity->status == \Develops\_R\Constants\EntityConst::NOT_MIGRATE)
                                                <a class="btn btn-success btn-xs"
                                                   href="{{ route('r.entities.migrate', $entity->id) }}">Migrate</a>
                                            @endif
                                            @if($entity->status == \Develops\_R\Constants\EntityConst::MIGRATED)
                                                <a class="btn btn-warning btn-xs"
                                                   href="{{ route('r.entities.rollback', $entity->id) }}">Rollback</a>
                                                <a class="btn btn-info btn-xs"
                                                   href="{{ route('r.entities.factory', $entity->id) }}">Create 20
                                                    items</a>
                                            @endif
                                            <a class="btn btn-danger btn-xs"
                                               href="{{ route('r.entities.destroy', $entity->id) }}">Destroy</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END card -->
        </div>
    </div>
@endsection
