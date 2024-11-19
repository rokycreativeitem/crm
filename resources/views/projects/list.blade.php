<style>
    .basic-datatable tr td {
        padding: 15px !important;
        border-bottom: 0;
    }

    div.dt-container.dt-empty-footer tbody>tr:last-child>* {
        border-bottom: 0;
    }

    .context-menu {
        border-bottom: 2px dashed #DBDFEB !important
    }

    .context-menu-header {
        border-bottom: 2px solid #DBDFEB !important
    }

    .context-menu-header th {
        text-transform: uppercase;
        padding: 15px;
    }

    .dt-column-title {
        align-items: center;
        justify-content: center;
        display: flex;
    }

    .dAdmin_profile.d-flex.align-items-center.min-w-200px {
        display: flex !important;
        align-items: center !important;
        justify-content: center;
    }

    th.dt-type-numeric.dt-orderable-asc.dt-orderable-desc,
    th.dt-orderable-asc.dt-orderable-desc {
        padding: 0;
    }

    th.dt-orderable-asc.dt-orderable-desc,
    th.dt-type-numeric.dt-orderable-asc.dt-orderable-desc {
        padding: 15px;
    }

    .dAdmin_profile_name {
        display: flex;
        justify-content: center;
    }

    table.dataTable>thead>tr>th,
    table.dataTable>thead>tr>td {
        border-bottom: 0 !important;
    }

    td.print-d-none {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    div.dt-container div.dt-length label {
        font-size: 12px;
        text-transform: capitalize;
    }

    select#dt-length-0 {
        font-size: 12px;
    }

    div.dt-container div.dt-search label,
    div.dt-container div.dt-search input,
    div#basic-datatable_info {
        font-size: 12px;
    }

    li.dt-paging-button.page-item {
        padding: 0 !important;
    }

    table.dataTable thead>tr>th.dt-orderable-asc:hover,
    table.dataTable thead>tr>th.dt-orderable-desc:hover,
    table.dataTable thead>tr>td.dt-orderable-asc:hover,
    table.dataTable thead>tr>td.dt-orderable-desc:hover {
        outline: 0 !important;
    }

    .dAdmin_profile.d-block.align-items-center.min-w-200px {
        display: flex !important;
        align-items: center !important;
        justify-content: center;
    }

    th.d-flex.align-items-center.dt-orderable-none {
        padding: 15px;
    }
</style>


<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3">

                <table id="basic-datatable" class="table basic-datatable" id="project_list">
                    <thead>
                        <tr class="context-menu-header">
                            <th scope="col" class="d-flex align-items-center">
                                <input type="checkbox" id="select-all" class="me-2">
                                <span> # </span>
                            </th>
                            <th scope="col">{{ get_phrase('Title') }}</th>
                            <th scope="col">{{ get_phrase('Code') }}</th>
                            <th scope="col">{{ get_phrase('Client') }}</th>
                            <th scope="col">{{ get_phrase('Staff') }}</th>
                            <th scope="col">{{ get_phrase('Budget') }}</th>
                            <th scope="col">{{ get_phrase('Progress') }}</th>
                            <th scope="col">{{ get_phrase('Status') }}</th>
                            <th scope="col">{{ get_phrase('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                            <tr data-code="{{ $project->code }}" class="context-menu">
                                <td class="d-flex align-items-center">
                                    <input type="checkbox" class="checkbox-item me-2">
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
                                                    $staffs = $project->staffs ? json_decode($project->staffs, true) : [];
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
                                        <div class="progress ms-2">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $project->progress }}%; " aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="p-2 fs-12px">{{ $project->progress }}%</span>
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

                                    <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
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
            </div>
        </div>
    </div>
</div>
@include('components.datatable')
