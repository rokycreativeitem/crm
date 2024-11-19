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
    th.dt-type-numeric.dt-orderable-asc.dt-orderable-desc, th.dt-orderable-asc.dt-orderable-desc {
        padding: 0;
    }
    th.dt-orderable-asc.dt-orderable-desc, th.dt-type-numeric.dt-orderable-asc.dt-orderable-desc {
        padding: 15px;
    }
    .dAdmin_profile_name {
        display: flex;
        justify-content: center;
    }
    table.dataTable>thead>tr>th, table.dataTable>thead>tr>td {
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
    div.dt-container div.dt-search label, div.dt-container div.dt-search input, div#basic-datatable_info {
        font-size: 12px;
    }
    li.dt-paging-button.page-item {
        padding: 0 !important;
    }
    table.dataTable thead > tr > th.dt-orderable-asc:hover, table.dataTable thead > tr > th.dt-orderable-desc:hover, table.dataTable thead > tr > td.dt-orderable-asc:hover, table.dataTable thead > tr > td.dt-orderable-desc:hover {
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
    .dt-search, .dt-length {
        display: none;
    }
    .dt-custom-search {
        width: 196px;
        height: 32px;
        margin-right: 10px;
    }
    .dt-custom-search input {
        border-radius: 6px;
        font-size: 12px;
        line-height: 12px;
        background-color: #F7F7F9;
        color: #6B708A;
        border: 0;
        padding-left: 0;
    }
    .dt-custom-search span {
        border: 0;
    }
    .note-editable, .form-control, .ol-form-control, .ol-form-control:focus, .form-control:focus {
        background-color: #F7F7F9;
        color: #6B708A;
    }


</style>


<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3">


                <div class="ol-card radius-8px print-d-none">
                    <div class="ol-card-body px-2">
                        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                            <h4 class="title fs-16px">
                                <i class="fi-rr-settings-sliders me-2"></i>
                                {{ get_phrase('Manage') }}
                            </h4>
                            <div class="top-bar d-flex align-items-center">
                                <div class="input-group dt-custom-search">
                                    <span class="input-group-text">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.733496 7.66665C0.733496 11.4885 3.84493 14.6 7.66683 14.6C11.4887 14.6 14.6002 11.4885 14.6002 7.66665C14.6002 3.84475 11.4887 0.733313 7.66683 0.733313C3.84493 0.733313 0.733496 3.84475 0.733496 7.66665ZM1.9335 7.66665C1.9335 4.50847 4.50213 1.93331 7.66683 1.93331C10.8315 1.93331 13.4002 4.50847 13.4002 7.66665C13.4002 10.8248 10.8315 13.4 7.66683 13.4C4.50213 13.4 1.9335 10.8248 1.9335 7.66665Z" fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2"/>
                                            <path d="M14.2426 15.0907C14.3623 15.2105 14.5149 15.2667 14.6666 15.2667C14.8184 15.2667 14.9709 15.2105 15.0907 15.0907C15.3231 14.8583 15.3231 14.475 15.0907 14.2426L12.7774 11.9293C12.545 11.6969 12.1617 11.6969 11.9293 11.9293C11.6969 12.1617 11.6969 12.545 11.9293 12.7774L14.2426 15.0907Z" fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2"/>
                                        </svg>                                            
                                    </span>
                                    <input type="text" class="form-control" id="project-custom-search-box" placeholder="Search">
                                </div>
                                <a href="{{ route('admin.projects', ['layout' => 'grid']) }}" class="grid-icon {{ request('layout') === 'grid' ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_185_2549)">
                                            <path
                                                d="M17.5 0.625H12.7087C12.2116 0.625529 11.735 0.823243 11.3835 1.17476C11.032 1.52628 10.8343 2.00288 10.8337 2.5V7.29187C10.8343 7.78899 11.032 8.2656 11.3835 8.61712C11.735 8.96863 12.2116 9.16635 12.7087 9.16687H17.5C17.9971 9.16631 18.4737 8.96859 18.8252 8.61708C19.1767 8.26557 19.3744 7.78898 19.375 7.29187V2.5C19.3744 2.00289 19.1767 1.5263 18.8252 1.1748C18.4737 0.823287 17.9971 0.625562 17.5 0.625ZM18.125 7.29187C18.1248 7.45757 18.0589 7.61643 17.9417 7.7336C17.8245 7.85077 17.6657 7.91668 17.5 7.91687H12.7087C12.543 7.91668 12.3842 7.85077 12.267 7.7336C12.1499 7.61643 12.0839 7.45757 12.0837 7.29187V2.5C12.0839 2.3343 12.1499 2.17544 12.267 2.05828C12.3842 1.94111 12.543 1.8752 12.7087 1.875H17.5C17.6657 1.8752 17.8245 1.94111 17.9417 2.05828C18.0589 2.17544 18.1248 2.3343 18.125 2.5V7.29187Z"
                                                fill="#99A1B7" />
                                            <path
                                                d="M2.5 19.375H7.29125C7.78837 19.3745 8.26497 19.1768 8.61649 18.8252C8.96801 18.4737 9.16572 17.9971 9.16625 17.5V12.7081C9.16572 12.211 8.96801 11.7344 8.61649 11.3829C8.26497 11.0314 7.78837 10.8337 7.29125 10.8331H2.5C2.00289 10.8337 1.5263 11.0314 1.1748 11.3829C0.823287 11.7344 0.625562 12.211 0.625 12.7081V17.5C0.625562 17.9971 0.823287 18.4737 1.1748 18.8252C1.5263 19.1767 2.00289 19.3744 2.5 19.375ZM1.875 12.7081C1.8752 12.5424 1.94111 12.3836 2.05828 12.2664C2.17544 12.1492 2.3343 12.0833 2.5 12.0831H7.29125C7.45695 12.0833 7.61581 12.1492 7.73297 12.2664C7.85014 12.3836 7.91605 12.5424 7.91625 12.7081V17.5C7.91605 17.6657 7.85014 17.8246 7.73297 17.9417C7.61581 18.0589 7.45695 18.1248 7.29125 18.125H2.5C2.3343 18.1248 2.17544 18.0589 2.05828 17.9417C1.94111 17.8246 1.8752 17.6657 1.875 17.5V12.7081Z"
                                                fill="#99A1B7" />
                                            <path
                                                d="M2.5 9.16687H7.29125C7.78837 9.16635 8.26497 8.96863 8.61649 8.61712C8.96801 8.2656 9.16572 7.78899 9.16625 7.29187V2.5C9.16572 2.00288 8.96801 1.52628 8.61649 1.17476C8.26497 0.823243 7.78837 0.625529 7.29125 0.625H2.5C2.00289 0.625562 1.5263 0.823287 1.1748 1.1748C0.823287 1.5263 0.625562 2.00289 0.625 2.5V7.29187C0.625562 7.78898 0.823287 8.26557 1.1748 8.61708C1.5263 8.96859 2.00289 9.16631 2.5 9.16687ZM1.875 2.5C1.8752 2.3343 1.94111 2.17544 2.05828 2.05828C2.17544 1.94111 2.3343 1.8752 2.5 1.875H7.29125C7.45695 1.8752 7.61581 1.94111 7.73297 2.05828C7.85014 2.17544 7.91605 2.3343 7.91625 2.5V7.29187C7.91605 7.45757 7.85014 7.61643 7.73297 7.7336C7.61581 7.85077 7.45695 7.91668 7.29125 7.91687H2.5C2.3343 7.91668 2.17544 7.85077 2.05828 7.7336C1.94111 7.61643 1.8752 7.45757 1.875 7.29187V2.5Z"
                                                fill="#99A1B7" />
                                            <path
                                                d="M15.1038 10.8331C14.2591 10.8332 13.4333 11.0837 12.731 11.553C12.0287 12.0224 11.4813 12.6894 11.1581 13.4698C10.8348 14.2502 10.7503 15.109 10.9151 15.9374C11.0799 16.7659 11.4867 17.5269 12.084 18.1242C12.6813 18.7215 13.4422 19.1282 14.2707 19.2931C15.0992 19.4579 15.9579 19.3733 16.7383 19.0501C17.5187 18.7268 18.1858 18.1795 18.6551 17.4771C19.1244 16.7748 19.375 15.9491 19.375 15.1044C19.374 13.9719 18.9237 12.886 18.1229 12.0852C17.3221 11.2844 16.2363 10.8341 15.1038 10.8331ZM15.1038 18.125C14.5063 18.125 13.9222 17.9477 13.4254 17.6157C12.9286 17.2837 12.5415 16.8119 12.3129 16.2598C12.0843 15.7078 12.0245 15.1004 12.1411 14.5143C12.2577 13.9283 12.5455 13.3901 12.9681 12.9676C13.3906 12.5452 13.9289 12.2575 14.515 12.141C15.101 12.0245 15.7084 12.0844 16.2604 12.3131C16.8124 12.5418 17.2842 12.9291 17.6161 13.4259C17.948 13.9228 18.1251 14.5069 18.125 15.1044C18.1241 15.9053 17.8055 16.6732 17.2391 17.2396C16.6727 17.8059 15.9047 18.1243 15.1038 18.125Z"
                                                fill="#99A1B7" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_185_2549">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.projects', ['layout' => 'list']) }}" class="grid-icon {{ request('layout') === 'list' || request('layout') == '' ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.55 4.66166H1.45C0.925273 4.66166 0.5 4.23629 0.5 3.71166C0.5 3.18702 0.925273 2.76166 1.45 2.76166H18.55C19.0747 2.76166 19.5 3.18702 19.5 3.71166C19.5 4.23629 19.0747 4.66166 18.55 4.66166Z" fill="#99A1B7" />
                                        <path d="M18.55 10.95H1.45C0.925273 10.95 0.5 10.5246 0.5 9.99999C0.5 9.47535 0.925273 9.04999 1.45 9.04999H18.55C19.0747 9.04999 19.5 9.47535 19.5 9.99999C19.5 10.5246 19.0747 10.95 18.55 10.95Z" fill="#99A1B7" />
                                        <path d="M11.61 17.2H0.990024C0.664142 17.2 0.400024 16.797 0.400024 16.3C0.400024 15.803 0.664142 15.4 0.990024 15.4H11.61C11.9359 15.4 12.2 15.803 12.2 16.3C12.2 16.797 11.9359 17.2 11.61 17.2Z" fill="#99A1B7" />
                                    </svg>
                                </a>            
                                <div class="custom-dropdown" id="export-btn">
                                
                                    <ul class="dropdown-list">
                                        <li>
                                            <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.print-table', 'course-list')"><i class="fi-rr-file-pdf"></i>
                                                {{ get_phrase('PDF') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i>
                                                {{ get_phrase('Print') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <button onclick="rightCanvas('{{ route(get_current_user_role() . '.project.create') }}', 'Create project')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                                    <span class="fi-rr-plus"></span>
                                    <span>{{ get_phrase('Add new') }}</span>
                                </button>
                            </div>
                        </div>
            
                    </div>
                </div>



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
                                        <div class="progress ms-2">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $project->progress }}%; "
                                            aria-valuenow="{{ $project->progress }}" aria-valuemin="0"
                                            aria-valuemax="100">
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
@include('components.datatable')
