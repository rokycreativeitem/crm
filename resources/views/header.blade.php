@php
    $my_data = auth()->user();
@endphp
<div class="ol-header print-d-none d-flex align-items-center justify-content-between py-2 ps-3">
    <div class="header-title-menubar d-flex align-items-center">
        <button class="menu-toggler sidebar-plus">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 5.25H3C2.59 5.25 2.25 4.91 2.25 4.5C2.25 4.09 2.59 3.75 3 3.75H21C21.41 3.75 21.75 4.09 21.75 4.5C21.75 4.91 21.41 5.25 21 5.25Z" fill="#99A1B7" />
                <path d="M21 10.25H3C2.59 10.25 2.25 9.91 2.25 9.5C2.25 9.09 2.59 8.75 3 8.75H21C21.41 8.75 21.75 9.09 21.75 9.5C21.75 9.91 21.41 10.25 21 10.25Z" fill="#99A1B7" />
                <path d="M21 15.25H3C2.59 15.25 2.25 14.91 2.25 14.5C2.25 14.09 2.59 13.75 3 13.75H21C21.41 13.75 21.75 14.09 21.75 14.5C21.75 14.91 21.41 15.25 21 15.25Z" fill="#99A1B7" />
                <path d="M21 20.25H3C2.59 20.25 2.25 19.91 2.25 19.5C2.25 19.09 2.59 18.75 3 18.75H21C21.41 18.75 21.75 19.09 21.75 19.5C21.75 19.91 21.41 20.25 21 20.25Z" fill="#99A1B7" />
            </svg>
        </button>

        <div class="main-header-title">
            <h1 class="page-title fs-18px d-flex align-items-center gap-3">
                {{ config('app.name') }}
            </h1>
            <span class="text-12px d-none d-md-inline-block"></span>
        </div>
    </div>
    <div class="header-content-right d-flex align-items-center justify-content-end">

        <!-- language Select -->
        <div class="d-none d-sm-block">
            <div class="img-text-select ">
                @php
                    $activated_language = strtolower(session('language') ?? get_settings('language'));
                @endphp
                <div class="selected-show" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ get_phrase('Language') }}">
                    <i class="fi-rr-language text-20px py-2"></i>
                </div>
                <div class="drop-content">
                    <ul>
                        @foreach (App\Models\Language::get() as $lng)
                            <li>
                                <a href="{{ route('admin.select.language', ['language' => $lng->name]) }}" class="select-text text-capitalize">

                                    <i class="fi fi-br-check text-10px me-1 @if ($activated_language != strtolower($lng->name)) visibility-hidden @endif"></i>
                                    {{ $lng->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>


        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Help center">
            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1182_7818)">
                        <path
                            d="M13.7832 6.61386H13.7436V5.64356C13.7436 2.52671 11.217 0 8.10007 0C4.98318 0 2.4565 2.52671 2.4565 5.64356V6.61386H2.2189C1.3476 6.61386 0.674343 7.38612 0.674343 8.27724V10.7525C0.652398 11.6162 1.33479 12.3341 2.19847 12.356C2.20529 12.3562 2.21207 12.3563 2.2189 12.3564H3.68423C3.89179 12.3467 4.05215 12.1705 4.04237 11.9629C4.04203 11.9555 4.04146 11.948 4.04067 11.9406V7.08908C4.04067 6.85147 3.90206 6.61382 3.68423 6.61382H3.24859V5.64353C3.24859 2.96414 5.42068 0.792042 8.10007 0.792042C10.7795 0.792042 12.9515 2.96414 12.9515 5.64353V6.61382H12.5159C12.2981 6.61382 12.1595 6.85143 12.1595 7.08908V11.9406C12.1374 12.1472 12.2869 12.3326 12.4935 12.3547C12.501 12.3555 12.5084 12.356 12.5159 12.3564H12.9713L12.9317 12.4158C12.3375 13.2055 11.4051 13.668 10.4169 13.6633C10.2005 12.6024 9.16512 11.9178 8.10427 12.1342C7.19708 12.3192 6.54301 13.1137 6.53569 14.0395C6.54653 15.1254 7.42996 16 8.51589 15.9999C9.05346 15.9912 9.56586 15.7706 9.94162 15.3861C10.1951 15.1264 10.3613 14.7941 10.4169 14.4355C11.6545 14.4402 12.8216 13.8603 13.5654 12.8712L13.9416 12.3167C14.7931 12.2573 15.3278 11.7227 15.3278 10.9504V8.47516C15.3278 7.62376 14.6941 6.61386 13.7832 6.61386ZM3.24859 11.5643H2.2189C1.7925 11.554 1.45524 11.1999 1.46563 10.7735C1.46582 10.7665 1.46608 10.7595 1.46642 10.7524V8.2772C1.46642 7.82177 1.78325 7.4059 2.2189 7.4059H3.24859V11.5643ZM9.3674 14.8317C9.14795 15.0696 8.83962 15.2059 8.51593 15.2079C7.87167 15.1977 7.34885 14.6836 7.32781 14.0396C7.32754 13.3943 7.85041 12.8711 8.49565 12.8708C9.1409 12.8705 9.66418 13.3934 9.66444 14.0386C9.66444 14.0389 9.66444 14.0393 9.66444 14.0396C9.68093 14.3336 9.57314 14.621 9.3674 14.8317ZM14.5357 10.9505C14.5357 11.4851 14.0208 11.5643 13.7832 11.5643H12.9515V7.40594H13.7832C14.2189 7.40594 14.5357 8.0198 14.5357 8.47524V10.9505Z"
                            fill="#6D718C" />
                    </g>
                    <defs>
                        <clipPath id="clip0_1182_7818">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>

            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <div class="p-2">
                    <h5 class="title text-14px">{{ get_phrase('Help center') }}</h6>
                </div>
                <li>
                    <a href="https://creativeitem.com/docs/academy-lms" target="_blank" class="dropdown-item">
                        <i class="fi-rr-document-signed"></i>
                        <span>{{ get_phrase('Read documentation') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://www.youtube.com/watch?v=-HHhJUGQPeU&list=PLR1GrQCi5Zqvhh7wgtt-ShMAM1RROYJgE" target="_blank" class="dropdown-item">
                        <i class="fi-rr-video-arrow-up-right"></i>
                        <span>{{ get_phrase('Watch video tutorial') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="dropdown-item">
                        <i class="fi-rr-envelope-plus"></i>
                        <span>{{ get_phrase('Get customer support') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="dropdown-item">
                        <i class="fi-rr-box-up"></i>
                        <span>{{ get_phrase('Order customization') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="select-text text-capitalize">
                        <i class="fi-rr-add"></i>
                        <span>{{ get_phrase('Request a new feature') }}</span>
                    </a>
                </li>
                <li>
                    <a href="https://creativeitem.com/services" target="_blank" class="text-premium select-text text-capitalize d-flex align-items-center">
                        <i class="fi-rr-settings-sliders me-1"></i>
                        <span>{{ get_phrase('Get Services') }}</span>
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
                    </div>
                </div>
                <ul class="mb-12px pb-12px ol-border-bottom-2">
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="#manage_profile">{{ get_phrase('My Profile') }}</a>
                    </li>
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="#system_settings">{{ get_phrase('Settings') }}</a>
                    </li>
                </ul>
                <a href="{{ route('logout') }}" class="dropdown-item-1 bg-transparent d-inline-flex">{{ get_phrase('Sign Out') }}</a>
            </div>
        </div>
    </div>
</div>
