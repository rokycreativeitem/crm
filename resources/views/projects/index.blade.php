@extends('layouts.admin')
@push('title', get_phrase('Projects'))
@push('meta')@endpush
@push('css')@endpush

@section('content')
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-3 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Manage') }}
                </h4>
                <div class="top-bar d-flex align-items-center">
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
                        <button class="dropdown-header btn ol-btn-light">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.92958 5.39015L4.92958 5.39014L4.92862 5.39023C3.61385 5.51433 2.6542 5.93624 2.02459 6.70756C1.39588 7.47776 1.10332 8.58789 1.10332 10.0733V10.16C1.10332 11.8024 1.45436 12.9868 2.22713 13.7595C2.99991 14.5323 4.18424 14.8833 5.82665 14.8833H10.1733C11.8157 14.8833 13 14.5323 13.7728 13.7612C14.5456 12.9901 14.8967 11.8091 14.8967 10.1733V10.0867C14.8967 8.59116 14.5991 7.47422 13.9602 6.70229C13.3204 5.92935 12.3457 5.51093 11.0111 5.39688C10.7022 5.36759 10.4461 5.59609 10.4169 5.89515C10.3874 6.19728 10.6157 6.46055 10.9151 6.48977L10.9158 6.48983C11.9763 6.57931 12.6917 6.86834 13.1444 7.43134C13.5984 7.99607 13.7967 8.84666 13.7967 10.08V10.1667C13.7967 11.5199 13.5567 12.4209 12.9921 12.9855C12.4275 13.5501 11.5265 13.79 10.1733 13.79H5.82665C4.47345 13.79 3.57245 13.5501 3.00784 12.9855C2.44324 12.4209 2.20332 11.5199 2.20332 10.1667V10.08C2.20332 8.85329 2.39823 8.00581 2.84423 7.44099C3.28876 6.87803 3.99097 6.58587 5.03125 6.4898L5.03139 6.48978C5.33896 6.46049 5.5591 6.18931 5.52975 5.88849C5.50032 5.58677 5.22199 5.36822 4.92958 5.39015Z"
                                    fill="#99A1B7" stroke="#99A1B7" stroke-width="0.1" />
                                <path d="M7.45 9.92001C7.45 10.221 7.69905 10.47 8 10.47C8.30051 10.47 8.55 10.2281 8.55 9.92001V1.33334C8.55 1.0324 8.30095 0.783344 8 0.783344C7.69905 0.783344 7.45 1.0324 7.45 1.33334V9.92001Z" fill="#99A1B7" stroke="#99A1B7" stroke-width="0.1" />
                                <path
                                    d="M7.61129 11.0554C7.72116 11.1652 7.86077 11.2167 7.99998 11.2167C8.13919 11.2167 8.27879 11.1652 8.38867 11.0554L10.622 8.82202C10.8349 8.60916 10.8349 8.2575 10.622 8.04464C10.4091 7.83178 10.0575 7.83178 9.84462 8.04464L7.99998 9.88929L6.15533 8.04464C5.94247 7.83178 5.59081 7.83178 5.37796 8.04464C5.1651 8.2575 5.1651 8.60916 5.37796 8.82202L7.61129 11.0554Z"
                                    fill="#99A1B7" stroke="#99A1B7" stroke-width="0.1" />
                            </svg>
                            {{ get_phrase('Export') }}
                        </button>
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


    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            @if (request()->query('layout') == 'grid')
                @include('projects.grid')
            @else
                @include('projects.list')
            @endif
        </div>
    </div>
    <!-- End Admin area -->
@endsection

@include('ajax')


@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            // Initialize context menu
            $.contextMenu({
                selector: '.context-menu',
                autoHide: false,
                items: {
                    Edit: {
                        name: "Edit",
                        callback: function(itemKey, opt, e) {
                            const code = opt.$trigger.attr("data-code");
                            rightCanvas("{{ url(get_current_user_role() . '/project/edit/') }}" + '/' +
                                code,
                                'Edit project')
                        }
                    },
                    Delete: {
                        name: "Delete",
                        callback: function(itemKey, opt, e) {
                            const code = opt.$trigger.attr("data-code");
                            confirmModal("{{ url(get_current_user_role() . '/project/delete/') }}" +
                                '/' + code)
                        }
                    },
                    View_Project: {
                        name: "View Project",
                        items: {
                            Milestone: {
                                name: "Milestone",
                                callback: function(itemKey, opt, e) {
                                    const code = opt.$trigger.attr("data-code");
                                    window.location.href =
                                        "{{ url(get_current_user_role() . '/project/') }}" + '/' +
                                        code +
                                        '/milestone'
                                }
                            },
                            Task: {
                                name: "Task",
                                callback: function(itemKey, opt, e) {
                                    const code = opt.$trigger.attr("data-code");
                                    window.location.href =
                                        "{{ url(get_current_user_role() . '/project/') }}" + '/' +
                                        code +
                                        '/task'
                                }
                            },
                            File: {
                                name: "File",
                                callback: function(itemKey, opt, e) {
                                    const code = opt.$trigger.attr("data-code");
                                    window.location.href =
                                        "{{ url(get_current_user_role() . '/project/') }}" + '/' +
                                        code +
                                        '/file'
                                }
                            },
                            Meeting: {
                                name: "Meeting",
                                callback: function(itemKey, opt, e) {
                                    const code = opt.$trigger.attr("data-code");
                                    window.location.href =
                                        "{{ url(get_current_user_role() . '/project/') }}" + '/' +
                                        code +
                                        '/meeting'
                                }
                            },
                            Invoice: {
                                name: "Invoice",
                                callback: function(itemKey, opt, e) {
                                    const code = opt.$trigger.attr("data-code");
                                    window.location.href =
                                        "{{ url(get_current_user_role() . '/project/') }}" + '/' +
                                        code +
                                        '/invoice'
                                }
                            },
                            Timesheet: {
                                name: "Timesheet",
                                callback: function(itemKey, opt, e) {
                                    const code = opt.$trigger.attr("data-code");
                                    window.location.href =
                                        "{{ url(get_current_user_role() . '/project/') }}" + '/' +
                                        code +
                                        '/timesheet'
                                }
                            },
                            Gantt_Chart: {
                                name: "Gantt Chart",
                                callback: function(itemKey, opt, e) {
                                    window.location.href =
                                        "{{ url(get_current_user_role() . '/project/') }}" +
                                        '/gantt_chart'
                                }
                            },

                        }
                    }
                }
            });

            // Handle multi-deletion
            $('#delete-selected').click(function() {
                const selectedIds = $('.checkbox-item:checked').map(function() {
                    return $(this).closest('tr').data('code');
                }).get();

                if (selectedIds.length > 0) {
                    multiDelete("{{ route(get_current_user_role() . '.project.multi-delete') }}",
                        selectedIds);
                    $('#delete-selected').addClass('d-none');
                } else {
                    alert('Please select at least one file to delete.');
                }
            });
        });
    </script>
@endpush
