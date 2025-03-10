@extends('layouts.admin')
@push('title', get_phrase('Roles'))
@section('content')

<div class="position-relative h-500px">
    <div class="row d-none" id="table-body">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3 mb-10 position-relative" id="filters-container">
                    <div class="ol-card radius-8px print-d-none">
                        <div class="ol-card-body px-2">
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                                <h4 class="title fs-16px">
                                    <i class="fi-rr-settings-sliders me-2"></i>
                                    {{ get_phrase('Roles & Permission') }}
                                </h4>
                                <div class="top-bar d-flex align-items-center">
                                    <div class="input-group dt-custom-search">
                                        <span class="input-group-text">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.733496 7.66665C0.733496 11.4885 3.84493 14.6 7.66683 14.6C11.4887 14.6 14.6002 11.4885 14.6002 7.66665C14.6002 3.84475 11.4887 0.733313 7.66683 0.733313C3.84493 0.733313 0.733496 3.84475 0.733496 7.66665ZM1.9335 7.66665C1.9335 4.50847 4.50213 1.93331 7.66683 1.93331C10.8315 1.93331 13.4002 4.50847 13.4002 7.66665C13.4002 10.8248 10.8315 13.4 7.66683 13.4C4.50213 13.4 1.9335 10.8248 1.9335 7.66665Z"
                                                    fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2" />
                                                <path
                                                    d="M14.2426 15.0907C14.3623 15.2105 14.5149 15.2667 14.6666 15.2667C14.8184 15.2667 14.9709 15.2105 15.0907 15.0907C15.3231 14.8583 15.3231 14.475 15.0907 14.2426L12.7774 11.9293C12.545 11.6969 12.1617 11.6969 11.9293 11.9293C11.6969 12.1617 11.6969 12.545 11.9293 12.7774L14.2426 15.0907Z"
                                                    fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2" />
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" id="custom-search-box" name="customSearch" placeholder="Search">
                                    </div>
                                    <div class="custom-dropdown" id="export-btn1">
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
                                        <ul class="dropdown-list dropdown-export">
                                            <li class="mb-1">
                                                <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.server-side-datatable', 'Role-list')"><i class="fi-rr-file-pdf"></i>
                                                    {{ get_phrase('PDF') }}</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i>
                                                    {{ get_phrase('Print') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table server-side-datatable" id="role_list">
                            <thead>
                                <tr class="context-menu-header">
                                    <th scope="col" class="d-flex align-items-center">
                                        <span>#</span>
                                    </th>
                                    <th scope="col">{{ get_phrase('Role') }}</th>
                                    <th scope="col" class="d-flex justify-content-center">{{ get_phrase('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="page-length-select fs-12px margin--40px d-flex align-items-center position-absolute">
                        <label for="page-length-select" class="pe-2">{{ get_phrase('Showing') }}:</label>
                        <select id="page-length-select" class="form-select ol-from-control fs-12px w-auto ol-niceSelect">
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="page-length-select" class="ps-2 w-100"> of {{ count($roles) }}</label>
                    </div>

                    <input type="hidden" value="role" id="datatable_type">
                    <button id="delete-selected" class="btn btn-custom-danger mt-3 d-none">
                        <i class="fi fi-rr-trash"></i>
                        {{ get_phrase('Delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('preloader')
</div>
@endsection

@push('js')
    <script>
        "use strict";
        server_side_datatable('["id","title","options"]', "{{ route(get_current_user_role() . '.roles') }}");
    </script>
@endpush
