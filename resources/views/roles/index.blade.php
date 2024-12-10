@extends('layouts.admin')
@push('title', get_phrase('Roles'))

@section('content')
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-3 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Manage role') }}
                </h4>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
    <div id="role-list" class="row role-list">
        @foreach ($roles as $role)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-4 pt-3">
                <div class="role-card p-3 ">
                    <h4>{{ $role->title }}</h4>
                    <div class="d-flex flex-column gap-2 pt-3">
                        @php
                            $assigned_permissions = $role->permissions ? json_decode($role->permissions, true) : [];
                            $permissions = \App\Models\Permission::get();
                        @endphp

                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input type="checkbox" id="{{ $role->id }}-{{ $permission->id }}" class="form-check-input" @if (in_array($permission->id, $assigned_permissions)) checked @endif onchange="ajaxCall('{{ route(get_current_user_role() . '.store.permissions', [$role->id, $permission->id]) }}')">

                                <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="{{ $role->id }}-{{ $permission->id }}">{{ $permission->title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- End Admin area -->
@endsection

@include('ajax')
