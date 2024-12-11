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

    <div class="row">
        <div class="col-sm-12">
            <div class="card border-0">
                <div class="card-body p-3">
                    <h4 class="my-3"> {{ get_phrase('Permissions accessible by the Client') }} </h4>
                    <div class="row role-list">
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Project access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        // Fetch all permissions related to "project"
                                        $permissions = App\Models\Permission::where('route', 'like', '%project%')->get();
                                        $permission_array = App\Models\RolePermission::where('role_id', 2)
                                            ->pluck('permission_id')
                                            ->toArray();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('client', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Admin access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%admin%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('client', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Client access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%client%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('client', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Staff access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%staff%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('client', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Role access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%role%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('client', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Event access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%event%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('client', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <div class="card border-0">
                <div class="card-body p-3">
                    <h4 class="my-3"> {{ get_phrase('Permissions accessible by the Staff') }} </h4>
                    <div class="row role-list">
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Project permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        // Fetch all permissions related to "project"
                                        $permissions = App\Models\Permission::where('route', 'like', '%project%')->get();
                                        $permission_array = App\Models\RolePermission::where('role_id', 2)
                                            ->pluck('permission_id')
                                            ->toArray();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('staff', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Project categories permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        // Fetch all permissions related to "project"
                                        $permissions = App\Models\Permission::where('route', 'like', '%category%')->get();
                                        $permission_array = App\Models\RolePermission::where('role_id', 2)
                                            ->pluck('permission_id')
                                            ->toArray();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('staff', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Admin access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%admin%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('staff', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Client access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%client%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('staff', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Staff access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%staff%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('staff', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Role access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%role%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('staff', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                            <div class="role-card p-3 ">
                                <h4> {{ get_phrase('Event access permission') }} </h4>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $permissions = App\Models\Permission::where('route', 'like', '%event%')->get();
                                    @endphp
                                
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                                onclick="create_permission('staff', '{{ $permission->id }}')"
                                                {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row role-list">
        <div class="col-12 col-sm-6 col-lg-4 col-xl-4 pt-3">
            <div class="role-card p-3 ">
                <h4> {{ get_phrase('Client Permission') }} </h4>
                <div class="d-flex flex-column gap-2 pt-3">
                    @foreach ($permissions as $permission)
                        @php
                        $permissions = App\Models\Permission::get();
                            $permission_array = App\Models\RolePermission::where('role_id', 2)->pluck('permission_id')->toArray();
                        @endphp
                        <div class="form-check">
                            <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input"
                                onclick="create_permission('client','{{ $permission->id }}')" {{(in_array($permission->id, $permission_array)) ? 'checked':''}}>
                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 col-xl-4 pt-3">
            <div class="role-card p-3 ">
                <h4> {{ get_phrase('Staff Permission') }} </h4>
                <div class="d-flex flex-column gap-2 pt-3">
                    @foreach ($permissions as $permission)
                        @php
                            $permission_array = App\Models\RolePermission::where('role_id', 3)->pluck('permission_id')->toArray();
                        @endphp
                        <div class="form-check">
                            <input type="checkbox" id="staff-{{ $permission->id }}" class="form-check-input"
                                onclick="create_permission('staff','{{ $permission->id }}')" {{(in_array($permission->id, $permission_array)) ? 'checked':''}}>
                            <label class="form-check-label text-capitalize sub-title fw-medium w-100"
                                for="staff-{{ $permission->id }}">{{ $permission->title }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div> --}}

    <!-- Start Admin area -->
    {{-- <div id="role-list" class="row role-list">
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
    </div> --}}
    <!-- End Admin area -->
@endsection

@push('js')
    <script>
        function create_permission(role, permission) {
            var url = '{{ route(get_current_user_role() . '.store.permissions') }}';
            var csrfToken = '{{ csrf_token() }}';

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    role: role,
                    permission: permission
                },
                success: function(response) {
                    processServerResponse(response);
                }
            });
        }
    </script>
@endpush
