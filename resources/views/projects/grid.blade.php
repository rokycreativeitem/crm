<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3 position-relative" id="filters-container">
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
                                        <path d="M17.5 4.375H2.5C2.15833 4.375 1.875 4.09167 1.875 3.75C1.875 3.40833 2.15833 3.125 2.5 3.125H17.5C17.8417 3.125 18.125 3.40833 18.125 3.75C18.125 4.09167 17.8417 4.375 17.5 4.375Z" fill="#6B708A"/>
                                        <path d="M17.5 8.54166H2.5C2.15833 8.54166 1.875 8.25832 1.875 7.91666C1.875 7.57499 2.15833 7.29166 2.5 7.29166H17.5C17.8417 7.29166 18.125 7.57499 18.125 7.91666C18.125 8.25832 17.8417 8.54166 17.5 8.54166Z" fill="#6B708A"/>
                                        <path d="M17.5 12.7083H2.5C2.15833 12.7083 1.875 12.425 1.875 12.0833C1.875 11.7417 2.15833 11.4583 2.5 11.4583H17.5C17.8417 11.4583 18.125 11.7417 18.125 12.0833C18.125 12.425 17.8417 12.7083 17.5 12.7083Z" fill="#6B708A"/>
                                        <path d="M17.5 16.875H2.5C2.15833 16.875 1.875 16.5917 1.875 16.25C1.875 15.9083 2.15833 15.625 2.5 15.625H17.5C17.8417 15.625 18.125 15.9083 18.125 16.25C18.125 16.5917 17.8417 16.875 17.5 16.875Z" fill="#6B708A"/>
                                    </svg>                                        
                                </a>

                                <div class="custom-dropdown dropdown filter-dropdown btn-group" id="export-btn">
                                    <button class="dropdown-header btn ol-btn-light dropdown-toggle-split" type="button" id="filterDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.29327 15.1C6.97327 15.1 6.65993 15.02 6.3666 14.86C5.77993 14.5333 5.4266 13.94 5.4266 13.2733V9.73999C5.4266 9.40666 5.2066 8.90666 4.99993 8.65333L2.5066 6.01333C2.0866 5.59333 1.7666 4.87333 1.7666 4.33333V2.79999C1.7666 1.73333 2.57327 0.899994 3.59993 0.899994H12.3999C13.4133 0.899994 14.2333 1.71999 14.2333 2.73333V4.19999C14.2333 4.89999 13.8133 5.69333 13.4199 6.08666L10.5333 8.63999C10.2533 8.87333 10.0333 9.38666 10.0333 9.79999V12.6667C10.0333 13.26 9.65993 13.9467 9.19327 14.2267L8.27327 14.82C7.97327 15.0067 7.63327 15.1 7.29327 15.1ZM3.59993 1.89999C3.13327 1.89999 2.7666 2.29333 2.7666 2.79999V4.33333C2.7666 4.57999 2.9666 5.05999 3.21993 5.31333L5.75994 7.98666C6.09994 8.40666 6.43327 9.10666 6.43327 9.73333V13.2667C6.43327 13.7 6.73327 13.9133 6.85993 13.98C7.13994 14.1333 7.47993 14.1333 7.73993 13.9733L8.6666 13.38C8.85327 13.2667 9.03994 12.9067 9.03994 12.6667V9.79999C9.03994 9.08666 9.3866 8.29999 9.8866 7.87999L12.7399 5.35333C12.9666 5.12666 13.2399 4.58666 13.2399 4.19333V2.73333C13.2399 2.27333 12.8666 1.89999 12.4066 1.89999H3.59993Z" fill="#99A1B7"/>
                                            <path d="M3.99995 7.16667C3.90661 7.16667 3.81995 7.14 3.73328 7.09334C3.49995 6.94667 3.42661 6.63334 3.57328 6.4L6.85995 1.13334C7.00661 0.900003 7.31328 0.826669 7.54661 0.973336C7.77995 1.12 7.85328 1.42667 7.70661 1.66L4.41995 6.92667C4.32661 7.08 4.16661 7.16667 3.99995 7.16667Z" fill="#99A1B7"/>
                                        </svg>                                            
                                        {{ get_phrase('Filter') }}
                                        <span class="filter-count-display d-none" id="filter-count-display"></span>
                                    </button>
                               
                                    <a href="javascript:void(0)" class="border-0 filter-reset d-none" id="filter-reset"> x
                                        <span>|</span>
                                    </a>
                                        
                                    <!-- Dropdown Menu -->
                                    <div class="dropdown-menu px-14px" aria-labelledby="filterDropdownButton">
                                        <!-- Category -->
                                        <div class="mb-3">
                                            <label for="category" class="form-label">{{get_phrase('Category')}}</label>
                                            <select class="form-control px-14px ol-form-control ol-select2" name="category" id="category">
                                                <option value="all">{{get_phrase('Select Category')}}</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{$item->id}}"> {{$item->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">{{get_phrase('Status')}}</label>
                                            <select class="form-control px-14px" name="status" id="status">
                                                <option value="all"> {{get_phrase('Select status')}} </option>
                                                <option value="in_progress"> {{get_phrase('In Progress')}} </option>
                                                <option value="not_started"> {{get_phrase('Not Started')}} </option>
                                                <option value="completed"> {{get_phrase('Completed')}} </option>
                                            </select>
                                        </div>
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label">{{get_phrase('Client')}}</label>
                                            <select class="form-control px-14px" name="client" id="client">
                                                <option value="all">{{get_phrase('Select client')}}</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Instructor -->
                                        <div class="mb-3">
                                            <label for="staff" class="form-label">{{get_phrase('Staff')}}</label>
                                            <select class="form-control px-14px" name="staff" id="staff">
                                                <option value="all">{{get_phrase('Select staff')}}</option>
                                                @foreach ($staffs as $staff)
                                                    <option value="{{$staff->id}}"> {{$staff->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="layout" value="grid">
                                        <div class="mb-3">
                                            <label for="budget" class="form-label">{{get_phrase('Budget')}}</label>
                                            <div class="accordion-item-range">
                                                <div id="budget-slider"></div>
                                                <div class="accordion-range-value d-flex align-items-center justify-content-between mt-4">
                                                    <div class="d-flex align-items-center">
                                                        <label for="min-price"> {{get_phrase('Min')}}: </label>
                                                        <span id="minPrice"></span>
                                                        <input type="text" class="value w-50 d-none minPrice" disabled id="min-price" name="minPrice">
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <label for="max-price"> {{get_phrase('Max')}}: </label>
                                                        <span id="maxPrice"></span>
                                                        <input type="text" class="value w-50 text-end d-none" disabled id="max-price" name="maxPrice">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Apply Button -->
                                        <div class="text-end">
                                            <button type="button" id="filter" class="btn btn-apply px-14px">{{get_phrase('Apply')}}</button>
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

                <div id="grid-list" class="row grid-list">
                    @foreach ($projects as $project)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 pt-3">
                        <div class="grid-card context-menu">
                            <!-- User Profile Section -->
                            <div class="grid-header">
                                <div class="note">
                                    <div class="logo me-2">
                                        <!-- SVG Icon -->
                                        <svg width="16" height="20" viewBox="0 0 16 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.1827 17.6395C14.873 15.9492 15.2375 14.5581 15.2405 14.5558C15.3386 13.217 15.4127 11.5773 15.4021 10.6101C15.4198 9.00912 15.2052 5.56203 15.0317 4.69423C14.756 3.27023 13.4543 1.89269 12.0332 1.57814C11.1707 1.40176 9.30342 1.22538 7.70128 1.22008C6.09914 1.21479 4.23243 1.39647 3.36992 1.57814C1.95004 1.89269 0.648343 3.26965 0.371423 4.69423C0.197981 5.56203 -0.016618 9.00912 0.00102021 10.6101C-0.016618 12.2111 0.197981 15.6587 0.371423 16.5265C0.647168 17.9505 1.94887 19.3275 3.36992 19.6426C4.23243 19.8219 6.09973 19.9954 7.70128 20.0001C8.42974 20.0001 9.21229 19.9619 9.93076 19.9048C9.94369 19.8996 11.4982 19.3234 13.1827 17.6395Z"
                                                fill="url(#paint0_linear_121_1134)" />
                                            <path
                                                d="M8.52329 12.6648H3.93323C3.83267 12.6677 3.73257 12.6503 3.63885 12.6137C3.54512 12.5772 3.45967 12.5222 3.38755 12.4521C3.31543 12.382 3.2581 12.2981 3.21895 12.2054C3.17981 12.1127 3.15964 12.0132 3.15964 11.9126C3.15964 11.812 3.17981 11.7124 3.21895 11.6197C3.2581 11.5271 3.31543 11.4432 3.38755 11.373C3.45967 11.3029 3.54512 11.248 3.63885 11.2114C3.73257 11.1749 3.83267 11.1575 3.93323 11.1603H8.52329C8.71916 11.1658 8.90518 11.2474 9.04178 11.3879C9.17839 11.5284 9.25482 11.7166 9.25482 11.9126C9.25482 12.1085 9.17839 12.2967 9.04178 12.4372C8.90518 12.5777 8.71916 12.6594 8.52329 12.6648ZM11.4689 9.50172H3.93323C3.83267 9.50453 3.73257 9.48715 3.63885 9.45061C3.54512 9.41407 3.45967 9.35911 3.38755 9.28898C3.31543 9.21885 3.2581 9.13497 3.21895 9.0423C3.17981 8.94963 3.15964 8.85005 3.15964 8.74945C3.15964 8.64885 3.17981 8.54928 3.21895 8.45661C3.2581 8.36394 3.31543 8.28006 3.38755 8.20992C3.45967 8.13979 3.54512 8.08483 3.63885 8.04829C3.73257 8.01175 3.83267 7.99437 3.93323 7.99718H11.4677C11.5683 7.99437 11.6684 8.01175 11.7621 8.04829C11.8558 8.08483 11.9413 8.13979 12.0134 8.20992C12.0855 8.28006 12.1428 8.36394 12.182 8.45661C12.2211 8.54928 12.2413 8.64885 12.2413 8.74945C12.2413 8.85005 12.2211 8.94963 12.182 9.0423C12.1428 9.13497 12.0855 9.21885 12.0134 9.28898C11.9413 9.35911 11.8558 9.41407 11.7621 9.45061C11.6684 9.48715 11.5683 9.50453 11.4677 9.50172H11.4689Z"
                                                fill="url(#paint1_linear_121_1134)" />
                                            <path
                                                d="M9.92978 19.9047C9.95036 18.9464 9.96858 17.7499 9.9821 16.8316C9.9874 16.4759 9.9921 16.1572 9.99621 15.9026C10.0041 15.5591 10.1445 15.2318 10.3881 14.9894C10.6317 14.747 10.9596 14.6082 11.3032 14.6021L12.7731 14.5851C13.6262 14.5757 14.5245 14.5657 15.2371 14.5557C15.2371 14.5557 14.8732 15.9473 13.1793 17.6394C11.4855 19.3315 9.92978 19.9047 9.92978 19.9047Z"
                                                fill="url(#paint2_linear_121_1134)" />
                                            <path
                                                d="M15.0293 4.69412C14.7536 3.27013 13.4519 1.89258 12.0308 1.57803H12.0226V0.754916C12.0226 0.555324 11.9433 0.363906 11.8022 0.222773C11.6611 0.0816395 11.4696 0.00235182 11.27 0.00235182C11.0705 0.00235182 10.879 0.0816395 10.7379 0.222773C10.5968 0.363906 10.5175 0.555324 10.5175 0.754916V1.37049C9.88251 1.30758 9.1611 1.25819 8.45146 1.23585V0.752565C8.44598 0.556691 8.36432 0.370677 8.22384 0.234069C8.08336 0.097461 7.89514 0.0210327 7.69919 0.0210327C7.50324 0.0210327 7.31501 0.097461 7.17453 0.234069C7.03405 0.370677 6.95239 0.556691 6.94692 0.752565V1.2335C6.23727 1.25584 5.51587 1.30523 4.88089 1.36814V0.752565C4.88089 0.552972 4.80161 0.361555 4.66047 0.220421C4.51934 0.0792881 4.32792 0 4.12833 0C3.92874 0 3.73732 0.0792881 3.59619 0.220421C3.45505 0.361555 3.37576 0.552972 3.37576 0.752565V1.57568H3.36753C1.94766 1.89023 0.645956 3.26719 0.369036 4.69177C0.337287 4.84875 0.30495 5.08981 0.272614 5.38848C2.08112 5.24326 4.94616 5.09039 7.69654 5.08745C10.4469 5.08451 13.3161 5.24326 15.1234 5.38848C15.0934 5.09216 15.0611 4.85051 15.0293 4.69412Z"
                                                fill="url(#paint3_linear_121_1134)" />
                                            <defs>
                                                <linearGradient id="paint0_linear_121_1134" x1="13.9558" y1="16.8658"
                                                    x2="0.624829" y2="3.5348" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#FF8145" />
                                                    <stop offset="0.43" stop-color="#FF8952" />
                                                    <stop offset="0.97" stop-color="#FFAD8A" />
                                                </linearGradient>
                                                <linearGradient id="paint1_linear_121_1134" x1="9.43401" y1="12.0646"
                                                    x2="4.49413" y2="7.12468" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#FFDDCE" />
                                                    <stop offset="0.52" stop-color="white" />
                                                    <stop offset="1" stop-color="white" />
                                                </linearGradient>
                                                <linearGradient id="paint2_linear_121_1134" x1="13.0882" y1="17.7341"
                                                    x2="8.98908" y2="13.6349" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#E95932" />
                                                    <stop offset="1" stop-color="#F9712D" />
                                                </linearGradient>
                                                <linearGradient id="paint3_linear_121_1134" x1="11.875" y1="8.64156"
                                                    x2="3.52569" y2="0.292797" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#F36062" />
                                                    <stop offset="0.44" stop-color="#F3585A" />
                                                    <stop offset="1" stop-color="#FF8C8B" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    </div>
                                    <span class="note-body">{{ $project->note }}</span>
                                </div>
            
                                <div>
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
                                </div>
                            </div>
            
                            <!-- Task Info Section -->
                            <div class="grid-title">
                                <span>{{ $project->title }}</span>
                                <div>
                                    <span>{{ $project->title }}</span>
                                    <span>{{ $project->code }}</span>
                                </div>
                            </div>

                            <!-- Progress -->
                            <div class="grid-progress">
                                <div class="d-flex align-items-center">
                                    @foreach (json_decode($project->staffs) as $key => $staff)
                                        @php
                                            if($key > 2){
                                                break;
                                            }
                                        @endphp
                                        <img src="{{get_image(App\models\User::where('id', $staff)->first()->photo)}}" alt="Attendee 1">
                                    @endforeach
                                    @if (count(json_decode($project->staffs)) > 3)
                                        <span class="project-count">+{{count(json_decode($project->staffs)) - 3}}</span>
                                    @endif
                                </div>
                                <div>
                                    @if ($project->status == 'in_progress')
                                        <span class="in_progress ">{{ get_phrase('In Progress') }}</span>
                                    @elseif($project->status == 'not_started')
                                        <span class="not_started">{{ get_phrase('Not Started') }}</span>
                                    @elseif($project->status == 'completed')
                                        <span class="completed">{{ get_phrase('Completed') }}</span>
                                    @endif
                                </div>
                            </div>
            
                            <div class="mt-4"> <!-- Changed to mt-4 for better Bootstrap spacing -->
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">{{ get_phrase('Progress') }}</span>
                                    <span class="text-muted">{{ $project->progress }}%</span>
                                </div>
                                <div class="bg-light rounded overflow-hidden" style="height: 8px;">
                                    <div class="bg-primary"
                                        style="width: {{ $project->progress }}%; height: 100%; border-radius: 8px;"></div>
                                </div>
                            </div>
            
            
                            <!-- View Details Link -->
                            <div style="margin-top: 12px;">
                                <a href="{{ route(get_current_user_role() . '.project.details', $project->code) }}">
                                    <div class="d-inline">
                                        <span>{{ get_phrase('View Details') }}</span>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.66666 11.3334L11.3333 4.66669M11.3333 4.66669H4.66666M11.3333 4.66669V11.3334"
                                                stroke="#6B708A" stroke-width="1.3" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="page-length-select fs-12px d-flex align-items-center mt-3 w-260">
                            <label for="page-length-select" class="pe-2">Showing:</label>
                            <select id="page-length-select" class="form-select fs-12px w-auto ol-select2">
                                <option value="10" {{$page_item == 10 ? 'selected':''}}>10</option>
                                <option value="20" {{$page_item == 20 ? 'selected':''}}>20</option>
                                <option value="50" {{$page_item == 50 ? 'selected':''}}>50</option>
                                <option value="100" {{$page_item == 100 ? 'selected':''}}>100</option>
                            </select>
                            <label for="page-length-select" class="ps-2 w-100"> of {{count(App\Models\Project::get())}}</label>
                        </div>
                        <div class="lpaginate mt-4">
                            {{$projects->links()}}
                        </div>
                    </div>
                </div>               

            </div>
        </div>
    </div>
</div>

@include('projects.budget_range')

@push('js')
<script>
    function grid_view() {
        $.ajax({
            url: "{{ route(get_current_user_role().'.projects', ['layout' => 'grid']) }}",
            type: 'GET',
            data: (function () {
                var formData = {};
                $('#filters-container :input').each(function () {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    if (name) {
                        formData[name] = value || null;
                    }
                });
                return formData;
            })(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function (response) {
                $("#grid-list").html(response);
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
            }
        });
    }
    $('#filter').on('click', function(e) {
        grid_view();
    })

    $('#custom-search-box').on('keyup', function(e) {
        grid_view();
    });
    $('#page-length-select').on('change', function () {
        grid_view();
    });
    $('#filter-reset').on('click', function(){
        $('#status, #client, #staff, #category').val('all')
        $('#filter-count-display, #filter-reset').addClass('d-none');
        $('.minPrice').val(0)
        grid_view();
    });
</script>
@endpush

