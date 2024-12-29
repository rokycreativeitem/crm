<div class="row">
    <div class="col-sm-12">
        <div class="card border-0">
            <div class="card-body p-3">
                <div class="row role-list">
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project access permission') }}</h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    // Fetch all permissions related to "project"
                                    $permissions = App\Models\Permission::where('route', 'like', '%project%')->get();
                                    $permission_array = App\Models\RolePermission::where('role_id', request()->query('role'))->pluck('permission_id')->toArray();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project milestone access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%milestone%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project task access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%task%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project gantt_chart access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%gantt_chart%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project file access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%file%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project meeting access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%meeting%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project invoice access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%invoice%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
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

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Project timesheet access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%timesheet%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Message access permission') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%message%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
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
@include('script')
