<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3">
                <div class="d-flex justify-content-center align-items-center" id="spinnner-before-table">
                    <div class="spinner-border text-primary spinner-border-lg" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="table-responsive overflow-auto course_list d-none" id="project_list">
                    <table class="table eTable eTable-2" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">{{ get_phrase('Title') }}</th>
                                <th scope="col">{{ get_phrase('Code') }}</th>
                                <th scope="col">{{ get_phrase('Client') }}</th>
                                <th scope="col">{{ get_phrase('Staffs') }}</th>
                                <th scope="col">{{ get_phrase('Budget') }}</th>
                                <th scope="col">{{ get_phrase('Progress') }}</th>
                                <th scope="col">{{ get_phrase('Status') }}</th>
                                <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $key => $project)
                                <tr data-code="{{ $project->code }}" class="context-menu">
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td>
                                        <p class="row-number fs-12px">{{ ++$key }}</p>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                            <div class="dAdmin_profile_name">
                                                <h4 class="title fs-12px">{{ $project->title }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                            <div class="dAdmin_profile_name">
                                                <h4 class="title fs-12px">{{ $project->code }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                            <div class="dAdmin_profile_name">
                                                <h4 class="title fs-12px">{{ $project->user ? $project->user->name : '' }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                            <div class="dAdmin_profile_name">
                                                <h4 class="title fs-12px">
                                                    @php
                                                        $staffs = $project->staffs ? json_decode($project->staffs, true) : [];
                                                    @endphp
                                                    @foreach ($staffs as $staff)
                                                        @php
                                                            $user = get_user($staff);
                                                        @endphp
                                                        @if ($user)
                                                            {{ $user->name }}
                                                        @else
                                                            <span class="text-muted">User not found</span>
                                                        @endif
                                                    @endforeach
                                                </h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                            <div class="dAdmin_profile_name">
                                                <h4 class="title fs-12px">{{ $project->budget }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile d-block align-items-center min-w-200px">
                                            <span class="p-2 fs-12px">{{ $project->progress }}%</span>
                                            <div class="progress ms-2">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $project->progress }}%; " aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile_name">
                                            @if ($project->status == 'in_progress')
                                                <span class="in_progress ">{{ get_phrase('In Progress') }}</span>
                                            @elseif($project->status == 'not_started')
                                                <span class="not_started">{{ get_phrase('Not Started') }}</span>
                                            @elseif($project->status == 'completed')
                                                <span class="completed">{{ get_phrase('Completed') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="print-d-none">

                                        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="fi-rr-menu-dots-vertical"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" onclick="rightCanvas('{{ route(get_current_user_role() . '.project.edit', $project->code) }}', 'Edit project')" href="#">{{ get_phrase('Edit') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" onclick="confirmModal('{{ route(get_current_user_role() . '.project.delete', $project->code) }}')" href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', $project->code) }}">{{ get_phrase('view project') }}</a>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button id="delete-selected" class="btn btn-custom-danger d-none"><i class="fi fi-rr-trash"></i>{{ get_phrase('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
