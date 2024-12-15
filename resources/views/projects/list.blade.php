<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3 position-relative" id="filters-container">


                <div class="ol-card radius-8px print-d-none">
                    <div class="ol-card-body px-2">
                        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-lg-nowrap">
                            <h4 class="title fs-16px">
                                <i class="fi-rr-settings-sliders me-2"></i>
                                {{ get_phrase('Manage Project') }}
                            </h4>
                            <div class="top-bar flex-wrap d-flex align-items-center">
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
                                    <input type="text" class="form-control" name="customSearch" id="custom-search-box" placeholder="Search">
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
                                        <path d="M17.5 4.375H2.5C2.15833 4.375 1.875 4.09167 1.875 3.75C1.875 3.40833 2.15833 3.125 2.5 3.125H17.5C17.8417 3.125 18.125 3.40833 18.125 3.75C18.125 4.09167 17.8417 4.375 17.5 4.375Z" fill="#6B708A" />
                                        <path d="M17.5 8.54166H2.5C2.15833 8.54166 1.875 8.25832 1.875 7.91666C1.875 7.57499 2.15833 7.29166 2.5 7.29166H17.5C17.8417 7.29166 18.125 7.57499 18.125 7.91666C18.125 8.25832 17.8417 8.54166 17.5 8.54166Z" fill="#6B708A" />
                                        <path d="M17.5 12.7083H2.5C2.15833 12.7083 1.875 12.425 1.875 12.0833C1.875 11.7417 2.15833 11.4583 2.5 11.4583H17.5C17.8417 11.4583 18.125 11.7417 18.125 12.0833C18.125 12.425 17.8417 12.7083 17.5 12.7083Z" fill="#6B708A" />
                                        <path d="M17.5 16.875H2.5C2.15833 16.875 1.875 16.5917 1.875 16.25C1.875 15.9083 2.15833 15.625 2.5 15.625H17.5C17.8417 15.625 18.125 15.9083 18.125 16.25C18.125 16.5917 17.8417 16.875 17.5 16.875Z" fill="#6B708A" />
                                    </svg>
                                </a>

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
                                            <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.server-side-datatable', 'Project-list')"><i class="fi-rr-file-pdf"></i>
                                                {{ get_phrase('PDF') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i>
                                                {{ get_phrase('Print') }}</a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="custom-dropdown dropdown filter-dropdown btn-group" id="export-btn">
                                    <button class="dropdown-header btn ol-btn-light dropdown-toggle-split" type="button" id="filterDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.29327 15.1C6.97327 15.1 6.65993 15.02 6.3666 14.86C5.77993 14.5333 5.4266 13.94 5.4266 13.2733V9.73999C5.4266 9.40666 5.2066 8.90666 4.99993 8.65333L2.5066 6.01333C2.0866 5.59333 1.7666 4.87333 1.7666 4.33333V2.79999C1.7666 1.73333 2.57327 0.899994 3.59993 0.899994H12.3999C13.4133 0.899994 14.2333 1.71999 14.2333 2.73333V4.19999C14.2333 4.89999 13.8133 5.69333 13.4199 6.08666L10.5333 8.63999C10.2533 8.87333 10.0333 9.38666 10.0333 9.79999V12.6667C10.0333 13.26 9.65993 13.9467 9.19327 14.2267L8.27327 14.82C7.97327 15.0067 7.63327 15.1 7.29327 15.1ZM3.59993 1.89999C3.13327 1.89999 2.7666 2.29333 2.7666 2.79999V4.33333C2.7666 4.57999 2.9666 5.05999 3.21993 5.31333L5.75994 7.98666C6.09994 8.40666 6.43327 9.10666 6.43327 9.73333V13.2667C6.43327 13.7 6.73327 13.9133 6.85993 13.98C7.13994 14.1333 7.47993 14.1333 7.73993 13.9733L8.6666 13.38C8.85327 13.2667 9.03994 12.9067 9.03994 12.6667V9.79999C9.03994 9.08666 9.3866 8.29999 9.8866 7.87999L12.7399 5.35333C12.9666 5.12666 13.2399 4.58666 13.2399 4.19333V2.73333C13.2399 2.27333 12.8666 1.89999 12.4066 1.89999H3.59993Z"
                                                fill="#99A1B7" />
                                            <path
                                                d="M3.99995 7.16667C3.90661 7.16667 3.81995 7.14 3.73328 7.09334C3.49995 6.94667 3.42661 6.63334 3.57328 6.4L6.85995 1.13334C7.00661 0.900003 7.31328 0.826669 7.54661 0.973336C7.77995 1.12 7.85328 1.42667 7.70661 1.66L4.41995 6.92667C4.32661 7.08 4.16661 7.16667 3.99995 7.16667Z"
                                                fill="#99A1B7" />
                                        </svg>
                                        {{ get_phrase('Filter') }}
                                        <span class="filter-count-display d-none" id="filter-count-display"></span>
                                    </button>

                                    <a href="javascript:void(0)" class="border-0 filter-reset d-none d-flex align-items-center" id="filter-reset">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 6.99927L1.00141 1.00068" stroke="#99A1B7" stroke-width="1.3" stroke-linecap="round" />
                                            <path d="M1 6.99936L6.99859 1.00077" stroke="#99A1B7" stroke-width="1.3" stroke-linecap="round" />
                                        </svg>

                                        <span>|</span>
                                    </a>

                                    <!-- Dropdown Menu -->
                                    <div class="dropdown-menu px-14px" aria-labelledby="filterDropdownButton">
                                        <!-- Category -->
                                        <div class="mb-3">
                                            <label for="category" class="form-label">{{ get_phrase('Category') }}</label>
                                            <select class="form-control px-14px ol-form-control ol-select2" name="category" id="category">
                                                <option value="all">{{ get_phrase('Select Category') }}</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">{{ get_phrase('Status') }}</label>
                                            <select class="form-control px-14px ol-form-control ol-select2" name="status" id="status">
                                                <option value="all"> {{ get_phrase('Select status') }} </option>
                                                <option value="in_progress"> {{ get_phrase('In Progress') }} </option>
                                                <option value="not_started"> {{ get_phrase('Not Started') }} </option>
                                                <option value="completed"> {{ get_phrase('Completed') }} </option>
                                            </select>
                                        </div>
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label">{{ get_phrase('Client') }}</label>
                                            <select class="form-control px-14px ol-form-control ol-select2" name="client" id="client">
                                                <option value="all">{{ get_phrase('Select client') }}</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Instructor -->
                                        <div class="mb-3">
                                            <label for="staff" class="form-label">{{ get_phrase('Staff') }}</label>
                                            <select class="form-control px-14px ol-form-control ol-select2" name="staff" id="staff">
                                                <option value="all">{{ get_phrase('Select staff') }}</option>
                                                @foreach ($staffs as $staff)
                                                    <option value="{{ $staff->id }}"> {{ $staff->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Price -->
                                        <div class="mb-3">
                                            <label for="budget" class="form-label">{{ get_phrase('Budget') }}</label>

                                            <div class="accordion-item-range">
                                                <div id="budget-slider"></div>
                                                <div class="accordion-range-value d-flex align-items-center mt-4">
                                                    <div class="d-flex align-items-center">
                                                        <label for="min-price" class="me-2"> {{ get_phrase('From') }} </label>
                                                        <input type="text" class="value minPrice" disabled id="min-price" name="minPrice">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <label for="max-price" class="mx-2"> {{ get_phrase('To') }} </label>
                                                        <input type="text" class="value" disabled id="max-price" name="maxPrice">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- Apply Button -->
                                        <div class="text-end">
                                            <button type="button" id="filter" class="btn btn-apply px-14px">{{ get_phrase('Apply') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="rightCanvas('{{ route(get_current_user_role() . '.project.create') }}', 'Create project')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                                    <span class="fi-rr-plus"></span>
                                    <span>{{ get_phrase('Add new') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTable -->
                <div class="table-responsive">
                    <table class="table server-side-datatable" id="table_list">
                        <thead>
                            <tr class="context-menu-header">
                                <th scope="col" class="d-flex align-items-center">
                                    <input type="checkbox" id="select-all" class="me-2 table-checkbox">
                                    <span> # </span>
                                </th>
                                <th scope="col">{{ get_phrase('Title') }}</th>
                                <th scope="col">{{ get_phrase('Code') }}</th>
                                <th scope="col">{{ get_phrase('Client') }}</th>
                                <th scope="col">{{ get_phrase('Staff') }}</th>
                                <th scope="col">{{ get_phrase('Budget') }}</th>
                                <th scope="col">{{ get_phrase('Progress') }}</th>
                                <th scope="col">{{ get_phrase('Status') }}</th>
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
                        <select id="page-length-select" class="form-select fs-12px w-auto ol-select2">
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="page-length-select" class="ps-2 w-100"> of {{ count($projects) }}</label>
                    </div>
                </div>


                <input type="hidden" value="project" id="datatable_type">
                <button id="delete-selected" class="btn btn-custom-danger mt-3 d-none">
                    <i class="fi fi-rr-trash"></i>
                    {{ get_phrase('Delete') }}
                </button>
            </div>
        </div>
    </div>
</div>

@include('projects.budget_range')
@include('components.datatable')
@push('js')
    <script>
        setTimeout(function() {
            server_side_datatable('["id","title","code","client","staff","budget","progress","status","options"]', "{{ route(get_current_user_role() . '.projects', ['layout' => 'list']) }}");
        }, 500);
    </script>
@endpush
