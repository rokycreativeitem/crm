@php
    $my_data = auth()->user();
@endphp
<div class="ol-header print-d-none d-flex align-items-center justify-content-between py-2 ps-3">
    <div class="header-title-menubar d-flex align-items-center">
        <button class="menu-toggler sidebar-plus">
            <span>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6.86621H13" stroke="#99A1B7" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 12.8662H11" stroke="#99A1B7" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 18.8662H13" stroke="#99A1B7" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 8.86621L4 12.8662L8 16.8662" stroke="#99A1B7" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </button>

        <div class="main-header-title">
            <h1 class="page-title fs-18px d-flex align-items-center gap-3">
                {{ get_phrase('Project Management System') }}
            </h1>
            <span class="text-12px d-none d-md-inline-block"></span>
        </div>
    </div>
    <div class="header-content-right d-flex align-items-center justify-content-end">

        <!-- language Select -->
        <div class="d-none d-sm-block">
            <div class="img-text-select ">
                <div class="selected-show" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Language">
                    <i class="fi-rr-language text-20px py-2"></i>
                </div>
                <div class="drop-content">
                    <ul>
                        <li>
                            <a href="#select-language/English" class="select-text text-capitalize">

                                <i class="fi fi-br-check text-10px me-1 "></i>
                                English
                            </a>
                        </li>
                        <li>
                            <a href="#select-language/Hindi" class="select-text text-capitalize">

                                <i class="fi fi-br-check text-10px me-1  visibility-hidden "></i>
                                Hindi
                            </a>
                        </li>
                        <li>
                            <a href="#select-language/Spanish" class="select-text text-capitalize">

                                <i class="fi fi-br-check text-10px me-1  visibility-hidden "></i>
                                Spanish
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        <a href="#" class="list text-18px d-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
            <span class="d-block h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="bottom" title="AI Assistant">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                    <g>
                        <g fill="#424242">
                            <path
                                d="M36.5 20C27.953 20 21 13.047 21 4.5a.5.5 0 0 0-1 0C20 13.047 13.047 20 4.5 20a.5.5 0 0 0 0 1C13.047 21 20 27.953 20 36.5a.5.5 0 0 0 1 0C21 27.953 27.953 21 36.5 21a.5.5 0 0 0 0-1zM60 34.5a.5.5 0 0 0-.5-.5C52.607 34 47 28.393 47 21.5a.5.5 0 0 0-1 0C46 28.393 40.393 34 33.5 34a.5.5 0 0 0 0 1C40.393 35 46 40.607 46 47.5a.5.5 0 0 0 1 0C47 40.607 52.607 35 59.5 35a.5.5 0 0 0 .5-.5zM38 49.5a.5.5 0 0 0-.5-.5c-5.238 0-9.5-4.262-9.5-9.5a.5.5 0 0 0-1 0c0 5.238-4.262 9.5-9.5 9.5a.5.5 0 0 0 0 1c5.238 0 9.5 4.262 9.5 9.5a.5.5 0 0 0 1 0c0-5.238 4.262-9.5 9.5-9.5a.5.5 0 0 0 .5-.5z"
                                fill="#424242" opacity="1" data-original="#424242" class=""></path>
                        </g>
                    </g>
                </svg>
            </span>
        </a>


        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Help center">
            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fi-rr-messages-question text-20px"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <div class="p-2">
                    <h5 class="title text-14px">Help center</h6>
                </div>
                <li>
                    <a href="https://creativeitem.com/docs/academy-lms" target="_blank" class="dropdown-item">
                        <i class="fi-rr-document-signed"></i>
                        <span>Read documentation</span>
                    </a>
                </li>

                <li>
                    <a href="https://www.youtube.com/watch?v=-HHhJUGQPeU&list=PLR1GrQCi5Zqvhh7wgtt-ShMAM1RROYJgE" target="_blank" class="dropdown-item">
                        <i class="fi-rr-video-arrow-up-right"></i>
                        <span>Watch video tutorial</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="dropdown-item">
                        <i class="fi-rr-envelope-plus"></i>
                        <span>Get customer support</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="dropdown-item">
                        <i class="fi-rr-box-up"></i>
                        <span>Order customization</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="select-text text-capitalize">
                        <i class="fi-rr-add"></i>
                        <span>Request a new feature</span>
                    </a>
                </li>
                <li>
                    <a href="https://creativeitem.com/services" target="_blank" class="text-premium select-text text-capitalize d-flex align-items-center">
                        <i class="fi-rr-settings-sliders me-1"></i>
                        <span>Get Services</span>
                        <i class="fi-rr-crown ms-auto"></i>
                    </a>
                </li>
            </ul>
        </div>


        <!-- Profile -->
        <div class="header-dropdown-md">
            <button class="header-dropdown-toggle-md" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-profile-sm">
                    <img src="{{ get_image($my_data->photo) }}" alt="">
                </div>
            </button>
            <div class="header-dropdown-menu-md p-3">
                <div class="d-flex column-gap-2 mb-12px pb-12px ol-border-bottom-2">
                    <div class="user-profile-sm">
                        <img src="{{ get_image($my_data->photo) }}" alt="">
                    </div>
                    <div>
                        <h6 class="title fs-12px mb-2px">{{ $my_data->name }}</h6>
                        <p class="sub-title fs-12px">Admin</p>
                    </div>
                </div>
                <ul class="mb-12px pb-12px ol-border-bottom-2">
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="#manage_profile">{{ get_phrase('My Profile') }}</a>
                    </li>
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="#system_settings">{{ get_phrase('Settings') }}</a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="post">@csrf
                    <button type="submit" class="dropdown-item-1 bg-transparent d-inline-flex">{{ get_phrase('Sign Out') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
