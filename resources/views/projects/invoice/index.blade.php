@push('title', get_phrase('Invoice'))

<div class="ol-card">
    <div class="ol-card-body">
        <!-- Search and filter -->
        <div class="row mt-2 mb-2 print-d-none">
            <div class="col-md-6 d-flex align-items-center gap-3 d-none" id="table-action-btns">
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
                <div class="custom-dropdown dropdown-filter">
                    <button class="dropdown-header btn ol-btn-light">
                        <i class="fi-rr-filter me-2"></i>
                        Filter
                    </button>
                    <ul class="dropdown-list w-250px">
                        <li>
                            <form id="filter-dropdown" action="#courses" method="get">
                                <!-- Filter Form Content -->
                                <div class="filter-option d-flex flex-column gap-3">
                                    <!-- Categories, Status, Instructor, Price Filters -->
                                    <div>
                                        <label for="eDataList" class="form-label ol-form-label">Category</label>
                                        <select class="form-control ol-form-control ol-select2 select2-hidden-accessible" name="category">
                                            <option value="yoga">Yoga</option>
                                            <option value="vinyasa-yoga">--Vinyasa yoga</option>
                                            <option value="restorative-yoga">--Restorative Yoga</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="eDataList" class="form-label ol-form-label">Status</label>
                                        <select class="form-control ol-form-control ol-select2 select2-hidden-accessible">
                                            <option value="active">Active </option>
                                            <option value="inactive">Inactive </option>
                                            <option value="pending">Pending </option>
                                            <option value="upcoming">Upcoming </option>
                                            <option value="private">Private </option>
                                            <option value="draft">Draft </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="eDataList" class="form-label ol-form-label">Instructor</label>
                                        <select class="form-control ol-form-control ol-select2 select2-hidden-accessible">
                                            <option value="1">John Doe</option>
                                            <option value="2">James Mariyati</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="eDataList" class="form-label ol-form-label">Price</label>
                                        <select class="form-control ol-form-control ol-select2 select2-hidden-accessible">
                                            <option value="free">Free</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-button d-flex justify-content-end align-items-center mt-3">
                                    <button type="submit" class="ol-btn-primary">Apply</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <div>
                    <a href="#" onclick="rightCanvas('{{ route(get_current_user_role() . '.invoice.create', ['code' => request()->route()->parameter('code')]) }}', 'Create Invoice')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                        <span class="fi-rr-plus"></span>
                        <span>{{ get_phrase('Add') }}</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="d-flex justify-content-center align-items-center" id="spinnner-before-table">
            <div class="spinner-border text-primary spinner-border-lg" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="table-responsive overflow-auto course_list d-none" id="project_list">
            <table class="table eTable eTable-2 " id="datatable">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">{{ get_phrase('Title') }}</th>
                        <th scope="col">{{ get_phrase('Payment') }}</th>
                        <th scope="col">{{ get_phrase('Time') }}</th>
                        <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $key => $payment)
                        <tr data-id="{{ $payment->id }}" class="context-menu">
                            <td>
                                <input type="checkbox" class="checkbox-item">
                            </td>
                            <td>
                                <p class="row-number fs-12px">{{ ++$key }}</p>
                            </td>
                            <td>
                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                    <div class="dAdmin_profile_name">
                                        <h4 class="title fs-12px">{{ $payment->title }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                    <div class="dAdmin_profile_name">
                                        <h4 class="title fs-12px">{{ $payment->payment }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                    <div class="dAdmin_profile_name">
                                        <h4 class="title fs-12px">{{ $payment->timestamps }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td class="print-d-none">
                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fi-rr-menu-dots-vertical"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" onclick="rightCanvas('{{ route(get_current_user_role() . '.invoice.edit', $payment->id) }}', 'Edit invoice')" href="#">{{ get_phrase('Edit') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" onclick="confirmModal('{{ route(get_current_user_role() . '.invoice.delete', $payment->id) }}')" href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
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
                            const id = opt.$trigger.attr("data-id");
                            rightCanvas("{{ url(get_current_user_role() . '/invoice/edit/') }}" + '/' +
                                id,
                                'Edit invoice')
                        }
                    },
                    Delete: {
                        name: "Delete",
                        callback: function(itemKey, opt, e) {
                            const id = opt.$trigger.attr("data-id");
                            confirmModal("{{ url(get_current_user_role() . '/invoice/delete/') }}" +
                                '/' +
                                id)
                        }
                    }
                }
            });



            // Handle multi-deletion
            $('#delete-selected').click(function() {
                const selectedIds = $('.checkbox-item:checked').map(function() {
                    return $(this).closest('tr').data('id');
                }).get();

                if (selectedIds.length > 0) {
                    multiDelete("{{ route(get_current_user_role() . '.invoice.multi-delete') }}",
                        selectedIds);
                    $('#delete-selected').addClass('d-none');
                } else {
                    alert('Please select at least one file to delete.');
                }
            });
        });
    </script>
@endpush
