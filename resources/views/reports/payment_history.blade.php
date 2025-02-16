@extends('layouts.admin')
@push('title', get_phrase('Payments History'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3 mb-10 position-relative" id="filters-container">
                    <div id="project-filter" class="d-none"></div>
                    <div class="ol-card radius-8px print-d-none">
                        <div class="ol-card-body px-2">
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                                <h4 class="title fs-16px">
                                    <i class="fi-rr-settings-sliders me-2"></i>
                                    {{ get_phrase('Payments History') }}
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
                                                <a class="dropdown-item export-btn" href="javascript:void(0)" onclick="exportFile('{{ route(get_current_user_role() . '.payment-report.export-file', ['file' => 'pdf']) }}')"><i class="fi-rr-file-pdf"></i>
                                                    {{ get_phrase('PDF') }}</a>
                                            </li>
                                            <li class="mb-1">
                                                <a class="dropdown-item export-btn"
                                                    href="javascript:void(0)" onclick="exportFile('{{ route(get_current_user_role() . '.payment-report.export-file', ['file' => 'csv']) }}')">
    
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.8988 4.68501L10.2739 1.10011C10.2091 1.03603 10.1212 1 10.0295 1H5.96971C3.78081 1 2.00003 2.76151 2.00003 4.92671V9.84474C2.00003 10.0335 2.00128 11.1745 2.34567 11.1154C2.80714 11.1154 2.69132 10.0335 2.69132 9.84474V4.92671C2.69132 3.13849 4.162 1.68367 5.96974 1.68367H9.68389V3.13003C9.68389 4.30449 10.6501 5.26 11.8376 5.26H13.3087V11.0741C13.3087 12.8619 11.8377 14.3164 10.0295 14.3164H5.96971C4.16197 14.3164 2.69129 12.8619 2.69129 11.0741C2.69129 10.8853 2.6811 9.75342 2.34567 9.75342C2.00003 9.75342 2 10.8853 2 11.0741C2 13.2388 3.78081 15 5.96968 15H10.0295C12.2189 15 14 13.2388 14 11.0741V4.92671C14 4.83605 13.9636 4.7491 13.8988 4.68501ZM10.3752 3.13V2.16707L12.8113 4.57633H11.8376C11.0312 4.57633 10.3752 3.92753 10.3752 3.13Z"
                                                            fill="#4d5675" />
                                                        <path
                                                            d="M6.58284 9.02809C6.58284 9.12016 6.56009 9.21981 6.51466 9.32697C6.46919 9.43422 6.39772 9.53941 6.30025 9.64266C6.20272 9.74594 6.07825 9.82975 5.92675 9.89419C5.77522 9.95866 5.59869 9.99088 5.39713 9.99088C5.24428 9.99088 5.10531 9.97638 4.98016 9.94747C4.85497 9.91853 4.74134 9.8735 4.63925 9.81234C4.53713 9.75119 4.44328 9.67063 4.35766 9.57066C4.28125 9.47994 4.21603 9.37831 4.16203 9.26584C4.108 9.15338 4.0675 9.03341 4.0405 8.90581C4.01347 8.77825 4 8.64278 4 8.49941C4 8.26659 4.03391 8.05816 4.10178 7.874C4.16959 7.68984 4.26678 7.53237 4.39325 7.4015C4.51972 7.27062 4.66794 7.171 4.83791 7.10259C5.00784 7.03422 5.18897 7 5.38134 7C5.61581 7 5.82466 7.04669 6.00778 7.14006C6.19088 7.23344 6.33119 7.34888 6.42872 7.48628C6.52619 7.62372 6.57497 7.75362 6.57497 7.87594C6.57497 7.943 6.55125 8.00222 6.50381 8.05353C6.45638 8.10481 6.39906 8.13047 6.33191 8.13047C6.25681 8.13047 6.2005 8.11272 6.16294 8.07719C6.12537 8.04169 6.08353 7.98053 6.03744 7.89372C5.96103 7.75037 5.87109 7.64316 5.76769 7.57216C5.66425 7.50113 5.53678 7.46562 5.38531 7.46562C5.14422 7.46562 4.95219 7.55706 4.80925 7.73984C4.66628 7.92269 4.59484 8.18244 4.59484 8.51912C4.59484 8.74403 4.62647 8.93116 4.68972 9.08041C4.75294 9.22969 4.84253 9.34119 4.95847 9.41481C5.07437 9.48847 5.21009 9.52528 5.36556 9.52528C5.53419 9.52528 5.67681 9.48356 5.79341 9.4C5.91 9.3165 5.99794 9.19384 6.05722 9.03209C6.08222 8.95584 6.11322 8.89366 6.15009 8.84562C6.18697 8.79766 6.24625 8.77363 6.32794 8.77363C6.39775 8.77363 6.45769 8.79797 6.50775 8.84663C6.55778 8.89528 6.58284 8.95581 6.58284 9.02809Z"
                                                            fill="#4d5675" stroke="#4d5675" stroke-width="0.2"
                                                            stroke-miterlimit="10" />
                                                        <path
                                                            d="M9.21088 9.0735C9.21088 9.24847 9.16579 9.40562 9.07557 9.54503C8.98529 9.68447 8.85322 9.79359 8.67932 9.8725C8.50541 9.95141 8.29919 9.99087 8.06079 9.99087C7.77491 9.99087 7.5391 9.93694 7.35332 9.82909C7.22157 9.75153 7.1145 9.64794 7.03219 9.51837C6.94985 9.38884 6.90869 9.26287 6.90869 9.14056C6.90869 9.06956 6.93338 9.00872 6.98279 8.95806C7.03219 8.90747 7.0951 8.88209 7.1715 8.88209C7.23341 8.88209 7.28579 8.90184 7.3286 8.94131C7.37141 8.98078 7.40797 9.03931 7.43829 9.11687C7.47516 9.20897 7.51503 9.28591 7.55785 9.34772C7.60066 9.40956 7.66091 9.4605 7.73866 9.50062C7.81638 9.54075 7.9185 9.56081 8.04497 9.56081C8.21888 9.56081 8.36016 9.52037 8.46888 9.43947C8.5776 9.35859 8.63191 9.25769 8.63191 9.13666C8.63191 9.04066 8.60257 8.96275 8.54397 8.90287C8.48532 8.84306 8.40957 8.79734 8.31675 8.76575C8.22385 8.73419 8.09966 8.70066 7.94422 8.66512C7.73604 8.61647 7.56185 8.55959 7.42154 8.49447C7.28122 8.42937 7.16988 8.34059 7.08757 8.22816C7.00522 8.11569 6.96407 7.97597 6.96407 7.80891C6.96407 7.64978 7.00754 7.50841 7.09447 7.38475C7.18144 7.26112 7.30722 7.16609 7.47194 7.09966C7.6366 7.03325 7.83025 7.00003 8.05291 7.00003C8.23075 7.00003 8.38457 7.02206 8.51432 7.06612C8.64407 7.11022 8.75182 7.16872 8.83744 7.24172C8.92307 7.31472 8.98563 7.39134 9.02519 7.47156C9.06475 7.55178 9.08444 7.63006 9.08444 7.70634C9.08444 7.77603 9.05978 7.83884 9.01035 7.89472C8.96097 7.95066 8.89932 7.97859 8.8256 7.97859C8.75841 7.97859 8.70732 7.96181 8.67247 7.92828C8.6375 7.89475 8.59966 7.83984 8.55882 7.76356C8.50607 7.65444 8.44285 7.56925 8.36913 7.50809C8.29535 7.44691 8.17675 7.41631 8.01341 7.41631C7.86188 7.41631 7.73972 7.44953 7.64685 7.51594C7.55397 7.58237 7.50754 7.66228 7.50754 7.75566C7.50754 7.81356 7.52335 7.8635 7.55497 7.90559C7.5866 7.94772 7.63007 7.98387 7.68541 8.01412C7.74075 8.04437 7.79672 8.06806 7.85338 8.08512C7.91 8.10222 8.00357 8.12725 8.134 8.16006C8.29735 8.19825 8.44522 8.24031 8.57766 8.28634C8.71004 8.33241 8.82266 8.38828 8.91557 8.45403C9.00847 8.51978 9.08091 8.603 9.13297 8.70359C9.18488 8.80419 9.21088 8.9275 9.21088 9.0735Z"
                                                            fill="#4d5675" stroke="#4d5675" stroke-width="0.2"
                                                            stroke-miterlimit="10" />
                                                        <path
                                                            d="M10.0404 7.38472L10.6965 9.32406L11.3545 7.37094C11.3888 7.26834 11.4145 7.197 11.4316 7.15687C11.4487 7.11675 11.477 7.08062 11.5166 7.04834C11.5561 7.01612 11.6101 7.00003 11.6786 7.00003C11.7287 7.00003 11.7751 7.01253 11.818 7.0375C11.8608 7.0625 11.8943 7.09569 11.9188 7.13712C11.9431 7.17856 11.9553 7.22031 11.9553 7.26241C11.9553 7.29134 11.9514 7.32259 11.9435 7.35612C11.9355 7.38966 11.9257 7.42253 11.9138 7.45475C11.902 7.487 11.8901 7.52022 11.8782 7.55437L11.1767 9.44437C11.1517 9.51672 11.1266 9.58544 11.1016 9.65056C11.0766 9.71566 11.0476 9.77287 11.0147 9.82219C10.9817 9.8715 10.9379 9.91194 10.8833 9.94353C10.8286 9.97509 10.7617 9.99087 10.6827 9.99087C10.6037 9.99087 10.5368 9.97541 10.4821 9.94453C10.4274 9.91366 10.3833 9.87284 10.3497 9.82222C10.3161 9.77159 10.2868 9.71403 10.2618 9.64959C10.2367 9.58516 10.2117 9.51678 10.1867 9.44444L9.49705 7.57019C9.48517 7.536 9.47298 7.50247 9.46048 7.46956C9.44795 7.43669 9.43742 7.40119 9.42886 7.36303C9.4203 7.32487 9.41602 7.29269 9.41602 7.26634C9.41602 7.19928 9.44298 7.13809 9.49705 7.08287C9.55108 7.02762 9.61889 7.00003 9.70061 7.00003C9.8007 7.00003 9.87155 7.03062 9.91305 7.09178C9.95455 7.15294 9.99689 7.25056 10.0404 7.38472Z"
                                                            fill="#4d5675" stroke="#4d5675" stroke-width="0.2"
                                                            stroke-miterlimit="10" />
                                                    </svg>
                                                    <span>{{ get_phrase('CSV') }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item export-btn" href="javascript:void(0)" onclick="printFile('{{ route(get_current_user_role() . '.payment-report.export-file', ['file' => 'print']) }}')"><i class="fi-rr-print"></i>
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
                                        <div class="dropdown-menu px-14px" id="filter-section" aria-labelledby="filterDropdownButton">
                                            <!-- Category -->
                                            <div class="mb-3">
                                                <label for="payment_method" class="form-label">{{ get_phrase('Payment Method') }}</label>
                                                <select class="form-control px-14px ol-form-control ol-select2" name="payment_method" id="payment_method">
                                                    <option value="all"> {{get_phrase('Select Payment Method')}} </option>
                                                    @foreach ($payment_gateways as $payment_gateway)
                                                        <option value="{{ $payment_gateway->identifier }}"> {{ $payment_gateway->identifier }} </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Date Filter -->
                                            <div class="mb-3">
                                                <label for="date" class="form-label">{{ get_phrase('Date') }}</label>
                                                <input type="date" name="start_date" class="form-control" id="date" name="date">
                                            </div>
                                            <!-- Amount Filter -->
                                            <div class="mb-3">
                                                <label for="budget" class="form-label">{{ get_phrase('Payment Amount') }}</label>

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
                                                <button type="button" id="filter" onclick="applyFilter('project-filter')" class="btn btn-apply px-14px">{{ get_phrase('Apply') }}</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table server-side-datatable server_side_datatable" id="offline_payment_list">
                            <thead>
                                <tr class="context-menu-header">
                                    <th scope="col" class="d-flex align-items-center">
                                        <input type="checkbox" id="select-all" class="me-2 table-checkbox">
                                        <span>#</span>
                                    </th>
                                    <th scope="col">{{ get_phrase('Payment Type') }}</th>
                                    <th scope="col">{{ get_phrase('Invoice') }}</th>
                                    <th scope="col">{{ get_phrase('Amount') }}</th>
                                    <th scope="col">{{ get_phrase('Transaction') }}</th>
                                    <th scope="col">{{ get_phrase('Payment Purpose') }}</th>
                                    <th scope="col">{{ get_phrase('Date') }}</th>
                                    </th>
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
                        <label for="page-length-select" class="ps-2 w-100"> of {{ count($payment_history) }}</label>
                    </div>

                    <input type="hidden" value="payment_history" id="datatable_type">
                    <button id="delete-selected" class="btn btn-custom-danger mt-3 d-none">
                        <i class="fi fi-rr-trash"></i>
                        {{ get_phrase('Delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('projects.budget_range')
@endsection

@push('js')
    <script>
        "use strict";
        setTimeout(function() {
            server_side_datatable(
                '["id","payment_type","invoice_id","amount","transaction_id","payment_purpose", "created_at"]',
                "{{ route(get_current_user_role() . '.payment_history') }}");
        }, 500);
    </script>
@endpush
