@extends('layouts.admin')
@push('title', get_phrase('Projects'))
@section('content')

<div class="position-relative h-500px">
    <div class="ol-card d-none" id="table-body">
        <div class="ol-card-body position-relative p-3">

            <div class="ol-card radius-8px print-d-none">
                <div class="ol-card-body px-2" id="filters-container">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                        <h4 class="title fs-16px">
                            <i class="fi-rr-settings-sliders me-2"></i>
                            {{ get_phrase('Manage Category') }}
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
                            @if (has_permission('project.category.create'))
                                <button onclick="rightCanvas('{{ route(get_current_user_role() . '.project.category.create') }}', 'Create category')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                                    <span class="fi-rr-plus"></span>
                                    <span>{{ get_phrase('Add new') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table class="table server-side-datatable" id="project_list">
                    <thead>
                        <tr class="context-menu-header">
                            <th scope="col" class="d-flex align-items-center">
                                <input type="checkbox" id="select-all" class="me-2 table-checkbox">
                                <span> # </span>
                            </th>
                            <th scope="col">{{ get_phrase('Category') }}</th>
                            <th scope="col">{{ get_phrase('parent category') }}</th>
                            <th scope="col">{{ get_phrase('status') }}</th>
                            <th scope="col" class="d-flex justify-content-center">{{ get_phrase('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable will populate this -->
                    </tbody>
                </table>
            </div>

            <div class="d-none d-lg-block">
                <div class="page-length-select fs-12px margin--40px d-flex align-items-center position-absolute">
                    <label for="page-length-select" class="pe-2">{{ get_phrase('Showing') }}:</label>
                    <select id="page-length-select" class="form-select ol-from-control fs-12px w-auto ol-niceSelect">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label for="page-length-select" class="ps-2 w-100"> of {{ count($categories) }}</label>
                </div>
            </div>

            <input type="hidden" value="category" id="datatable_type">
            <button id="delete-selected" class="btn btn-custom-danger mt-3 d-none">
                <i class="fi fi-rr-trash"></i>
                {{ get_phrase('Delete') }}
            </button>
            
        </div>      
    </div>
    @include('preloader')
</div>
@endsection
@push('js')
    <script>
        "use strict";
        server_side_datatable('["id","name","parent","status","options"]', '{{ route(get_current_user_role() . '.project.categories') }}');
    </script>
@endpush
