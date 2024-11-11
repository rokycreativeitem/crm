<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3">

                <table id="example" class="table table-striped" id="project_list">
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
                            <th scope="col">{{ get_phrase('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                                <tr>
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
                                                <h4 class="title fs-12px">{{ $project->user->name }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                            <div class="dAdmin_profile_name">
                                                <h4 class="title fs-12px">
                                                    @php
                                                        $staffs = $project->staffs
                                                            ? json_decode($project->staffs, true)
                                                            : [];
                                                    @endphp
                                                    @foreach ($staffs as $staff)
                                                        {{ get_user($staff)->name }}
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
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: {{ $project->progress }}%; "
                                                    aria-valuenow="{{ $project->progress }}" aria-valuemin="0"
                                                    aria-valuemax="100">
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
                                            <button class="btn ol-btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="fi-rr-menu-dots-vertical"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        onclick="rightCanvas('{{ route(get_current_user_role() . '.project.edit', $project->code) }}', 'Edit project')"
                                                        href="#">{{ get_phrase('Edit') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        onclick="confirmModal('{{ route(get_current_user_role() . '.project.delete', $project->code) }}')"
                                                        href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route(get_current_user_role() . '.project.details', $project->code) }}">{{ get_phrase('view project') }}</a>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#example');
</script>
