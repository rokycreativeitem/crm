<!DOCTYPE html>
<html lang="en" class="default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project management | Login</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}">
    <!-- UI Icon -->
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/variables/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>

    <div class="ol-card rounded-0 bg-light vh-100">
        <div class="ol-card-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="ol2-logo-area">
                            <a href="#">
                                <svg width="130" height="29" viewBox="0 0 130 29" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_125_980)">
                                        <path
                                            d="M14.0859 7.93216V2.51123C14.0857 1.84528 13.8121 1.20666 13.3251 0.735759C12.8382 0.264858 12.1779 0.000214237 11.4893 0C10.8006 0 10.1401 0.264575 9.65313 0.735523C9.16616 1.20647 8.89258 1.84521 8.89258 2.51123C8.89239 3.76638 9.39259 4.97327 10.2891 5.88083L13.3956 9.02573L14.0859 7.93216Z"
                                            fill="url(#paint0_linear_125_980)" />
                                        <path
                                            d="M14.0857 14.521L8.88735 18.635C5.33709 21.4469 0 19.002 0 14.5663C0 10.1508 5.28444 7.69616 8.84556 10.4612L14.0857 14.5251V14.521Z"
                                            fill="url(#paint1_linear_125_980)" />
                                        <path
                                            d="M14.0856 14.521V7.93219L8.26875 3.57411C7.99203 3.3668 7.67491 3.2156 7.33637 3.12957C6.99783 3.04354 6.64482 3.02444 6.29846 3.07341C5.95211 3.12239 5.61953 3.23842 5.32062 3.41459C5.02171 3.59075 4.76263 3.82341 4.55886 4.09866C4.16962 4.62301 4.00349 5.27191 4.09479 5.91133C4.18609 6.55074 4.52784 7.13182 5.04945 7.53453L14.0856 14.521Z"
                                            fill="url(#paint2_linear_125_980)" />
                                        <path
                                            d="M14.0859 14.521V24.3946C14.0859 25.6164 13.584 26.7882 12.6907 27.6522C11.7973 28.5162 10.5856 29.0016 9.32216 29.0016H8.83408C7.57065 29.0016 6.35897 28.5162 5.46559 27.6522C4.57221 26.7882 4.07031 25.6164 4.07031 24.3946C4.07029 23.6986 4.2333 23.0117 4.54712 22.3854C4.86093 21.7591 5.31739 21.2097 5.88222 20.7785L14.0859 14.521Z"
                                            fill="url(#paint3_linear_125_980)" />
                                    </g>
                                    <g clip-path="url(#clip1_125_980)">
                                        <path
                                            d="M15.7432 7.93216V2.51123C15.7434 1.84528 16.017 1.20666 16.504 0.735759C16.9909 0.264858 17.6512 0.000214237 18.3399 0C19.0285 0 19.689 0.264575 20.176 0.735523C20.6629 1.20647 20.9365 1.84521 20.9365 2.51123C20.9367 3.76638 20.4365 4.97327 19.54 5.88083L16.4335 9.02573L15.7432 7.93216Z"
                                            fill="url(#paint4_linear_125_980)" />
                                        <path
                                            d="M15.7434 14.521L20.9417 18.635C24.492 21.4469 29.8291 19.002 29.8291 14.5663C29.8291 10.1508 24.5447 7.69616 20.9835 10.4612L15.7434 14.5251V14.521Z"
                                            fill="url(#paint5_linear_125_980)" />
                                        <path
                                            d="M15.7435 14.521V7.93219L21.5603 3.57411C21.8371 3.3668 22.1542 3.2156 22.4927 3.12957C22.8313 3.04354 23.1843 3.02444 23.5306 3.07341C23.877 3.12239 24.2096 3.23842 24.5085 3.41459C24.8074 3.59075 25.0665 3.82341 25.2702 4.09866C25.6595 4.62301 25.8256 5.27191 25.7343 5.91133C25.643 6.55074 25.3013 7.13182 24.7797 7.53453L15.7435 14.521Z"
                                            fill="url(#paint6_linear_125_980)" />
                                        <path
                                            d="M15.7432 14.521V24.3946C15.7432 25.6164 16.2451 26.7882 17.1384 27.6522C18.0318 28.5162 19.2435 29.0016 20.5069 29.0016H20.995C22.2584 29.0016 23.4701 28.5162 24.3635 27.6522C25.2569 26.7882 25.7588 25.6164 25.7588 24.3946C25.7588 23.6986 25.5958 23.0117 25.282 22.3854C24.9682 21.7591 24.5117 21.2097 23.9469 20.7785L15.7432 14.521Z"
                                            fill="url(#paint7_linear_125_980)" />
                                    </g>
                                    <path
                                        d="M37.28 20V8.48H39.208V20H37.28ZM47.5804 20V15.84C47.5804 15.568 47.5617 15.2667 47.5244 14.936C47.487 14.6053 47.399 14.288 47.2604 13.984C47.127 13.6747 46.9244 13.4213 46.6524 13.224C46.3857 13.0267 46.023 12.928 45.5644 12.928C45.319 12.928 45.0764 12.968 44.8364 13.048C44.5964 13.128 44.3777 13.2667 44.1804 13.464C43.9884 13.656 43.8337 13.9227 43.7164 14.264C43.599 14.6 43.5404 15.032 43.5404 15.56L42.3964 15.072C42.3964 14.336 42.5377 13.6693 42.8204 13.072C43.1084 12.4747 43.5297 12 44.0844 11.648C44.639 11.2907 45.3217 11.112 46.1324 11.112C46.7724 11.112 47.3004 11.2187 47.7164 11.432C48.1324 11.6453 48.463 11.9173 48.7084 12.248C48.9537 12.5787 49.135 12.9307 49.2524 13.304C49.3697 13.6773 49.4444 14.032 49.4764 14.368C49.5137 14.6987 49.5324 14.968 49.5324 15.176V20H47.5804ZM41.5884 20V11.36H43.3084V14.04H43.5404V20H41.5884ZM54.956 20.24C53.8893 20.24 53.0227 20 52.356 19.52C51.6893 19.04 51.284 18.3653 51.14 17.496L53.108 17.192C53.2093 17.6187 53.4333 17.9547 53.78 18.2C54.1267 18.4453 54.564 18.568 55.092 18.568C55.556 18.568 55.9133 18.4773 56.164 18.296C56.42 18.1093 56.548 17.856 56.548 17.536C56.548 17.3387 56.5 17.1813 56.404 17.064C56.3133 16.9413 56.1107 16.824 55.796 16.712C55.4813 16.6 54.9987 16.4587 54.348 16.288C53.6227 16.096 53.0467 15.8907 52.62 15.672C52.1933 15.448 51.8867 15.184 51.7 14.88C51.5133 14.576 51.42 14.208 51.42 13.776C51.42 13.2373 51.5613 12.768 51.844 12.368C52.1267 11.968 52.5213 11.6613 53.028 11.448C53.5347 11.2293 54.132 11.12 54.82 11.12C55.492 11.12 56.0867 11.224 56.604 11.432C57.1267 11.64 57.548 11.936 57.868 12.32C58.188 12.704 58.3853 13.1547 58.46 13.672L56.492 14.024C56.444 13.656 56.276 13.3653 55.988 13.152C55.7053 12.9387 55.3267 12.8187 54.852 12.792C54.3987 12.7653 54.0333 12.8347 53.756 13C53.4787 13.16 53.34 13.3867 53.34 13.68C53.34 13.8453 53.396 13.9867 53.508 14.104C53.62 14.2213 53.844 14.3387 54.18 14.456C54.5213 14.5733 55.028 14.7173 55.7 14.888C56.388 15.064 56.9373 15.2667 57.348 15.496C57.764 15.72 58.0627 15.9893 58.244 16.304C58.4307 16.6187 58.524 17 58.524 17.448C58.524 18.3173 58.2067 19 57.572 19.496C56.9427 19.992 56.0707 20.24 54.956 20.24ZM60.4363 10.048V8.28H62.3643V10.048H60.4363ZM60.4363 20V11.36H62.3643V20H60.4363ZM68.3926 24.08C67.9126 24.08 67.4513 24.0053 67.0086 23.856C66.5713 23.7067 66.1766 23.4907 65.8246 23.208C65.4726 22.9307 65.1846 22.5947 64.9606 22.2L66.7366 21.32C66.902 21.6347 67.134 21.8667 67.4326 22.016C67.7366 22.1707 68.0593 22.248 68.4006 22.248C68.8006 22.248 69.158 22.176 69.4726 22.032C69.7873 21.8933 70.03 21.6853 70.2006 21.408C70.3766 21.136 70.4593 20.7947 70.4486 20.384V17.928H70.6886V11.36H72.3766V20.416C72.3766 20.6347 72.366 20.8427 72.3446 21.04C72.3286 21.2427 72.2993 21.44 72.2566 21.632C72.1286 22.192 71.8833 22.6507 71.5206 23.008C71.158 23.3707 70.7073 23.64 70.1686 23.816C69.6353 23.992 69.0433 24.08 68.3926 24.08ZM68.2246 20.24C67.43 20.24 66.7366 20.04 66.1446 19.64C65.5526 19.24 65.094 18.696 64.7686 18.008C64.4433 17.32 64.2806 16.544 64.2806 15.68C64.2806 14.8053 64.4433 14.0267 64.7686 13.344C65.0993 12.656 65.566 12.1147 66.1686 11.72C66.7713 11.32 67.4806 11.12 68.2966 11.12C69.118 11.12 69.806 11.32 70.3606 11.72C70.9206 12.1147 71.3446 12.656 71.6326 13.344C71.9206 14.032 72.0646 14.8107 72.0646 15.68C72.0646 16.5387 71.9206 17.3147 71.6326 18.008C71.3446 18.696 70.9153 19.24 70.3446 19.64C69.774 20.04 69.0673 20.24 68.2246 20.24ZM68.5206 18.512C69.038 18.512 69.454 18.3947 69.7686 18.16C70.0886 17.92 70.3206 17.5867 70.4646 17.16C70.614 16.7333 70.6886 16.24 70.6886 15.68C70.6886 15.1147 70.614 14.6213 70.4646 14.2C70.3206 13.7733 70.094 13.4427 69.7846 13.208C69.4753 12.968 69.0753 12.848 68.5846 12.848C68.0673 12.848 67.6406 12.976 67.3046 13.232C66.9686 13.4827 66.7206 13.824 66.5606 14.256C66.4006 14.6827 66.3206 15.1573 66.3206 15.68C66.3206 16.208 66.398 16.688 66.5526 17.12C66.7126 17.5467 66.9553 17.8853 67.2806 18.136C67.606 18.3867 68.0193 18.512 68.5206 18.512ZM80.596 20V15.84C80.596 15.568 80.5773 15.2667 80.54 14.936C80.5027 14.6053 80.4147 14.288 80.276 13.984C80.1427 13.6747 79.94 13.4213 79.668 13.224C79.4013 13.0267 79.0387 12.928 78.58 12.928C78.3347 12.928 78.092 12.968 77.852 13.048C77.612 13.128 77.3933 13.2667 77.196 13.464C77.004 13.656 76.8493 13.9227 76.732 14.264C76.6147 14.6 76.556 15.032 76.556 15.56L75.412 15.072C75.412 14.336 75.5533 13.6693 75.836 13.072C76.124 12.4747 76.5453 12 77.1 11.648C77.6547 11.2907 78.3373 11.112 79.148 11.112C79.788 11.112 80.316 11.2187 80.732 11.432C81.148 11.6453 81.4787 11.9173 81.724 12.248C81.9693 12.5787 82.1507 12.9307 82.268 13.304C82.3853 13.6773 82.46 14.032 82.492 14.368C82.5293 14.6987 82.548 14.968 82.548 15.176V20H80.596ZM74.604 20V8.48H76.324V14.544H76.556V20H74.604ZM89.6996 20C89.129 20.1067 88.569 20.152 88.0196 20.136C87.4756 20.1253 86.9876 20.0267 86.5556 19.84C86.1236 19.648 85.7956 19.3467 85.5716 18.936C85.3743 18.5627 85.2703 18.1813 85.2596 17.792C85.249 17.4027 85.2436 16.9627 85.2436 16.472V8.96H87.1636V16.36C87.1636 16.7067 87.1663 17.0107 87.1716 17.272C87.1823 17.5333 87.2383 17.7467 87.3396 17.912C87.5316 18.232 87.8383 18.4107 88.2596 18.448C88.681 18.4853 89.161 18.464 89.6996 18.384V20ZM83.6756 12.872V11.36H89.6996V12.872H83.6756ZM99.6326 20.24C98.4806 20.24 97.494 19.9893 96.6726 19.488C95.8513 18.9813 95.2193 18.2773 94.7766 17.376C94.3393 16.4747 94.1206 15.4293 94.1206 14.24C94.1206 13.0507 94.3393 12.0053 94.7766 11.104C95.2193 10.2027 95.8513 9.50133 96.6726 9C97.494 8.49333 98.4806 8.24 99.6326 8.24C100.961 8.24 102.067 8.57333 102.953 9.24C103.838 9.90133 104.459 10.7947 104.817 11.92L102.873 12.456C102.649 11.704 102.267 11.1173 101.729 10.696C101.19 10.2693 100.491 10.056 99.6326 10.056C98.8593 10.056 98.214 10.2293 97.6966 10.576C97.1846 10.9227 96.798 11.4107 96.5366 12.04C96.2806 12.664 96.15 13.3973 96.1446 14.24C96.1446 15.0827 96.2726 15.8187 96.5286 16.448C96.79 17.072 97.1793 17.5573 97.6966 17.904C98.214 18.2507 98.8593 18.424 99.6326 18.424C100.491 18.424 101.19 18.2107 101.729 17.784C102.267 17.3573 102.649 16.7707 102.873 16.024L104.817 16.56C104.459 17.6853 103.838 18.5813 102.953 19.248C102.067 19.9093 100.961 20.24 99.6326 20.24ZM106.573 20V8.48H111.333C111.445 8.48 111.589 8.48533 111.765 8.496C111.941 8.50133 112.104 8.51733 112.253 8.544C112.92 8.64533 113.469 8.86667 113.901 9.208C114.338 9.54933 114.661 9.98133 114.869 10.504C115.082 11.0213 115.189 11.5973 115.189 12.232C115.189 13.1707 114.952 13.9787 114.477 14.656C114.002 15.328 113.274 15.744 112.293 15.904L111.469 15.976H108.501V20H106.573ZM113.189 20L110.917 15.312L112.877 14.88L115.373 20H113.189ZM108.501 14.176H111.253C111.36 14.176 111.48 14.1707 111.613 14.16C111.746 14.1493 111.869 14.128 111.981 14.096C112.301 14.016 112.552 13.8747 112.733 13.672C112.92 13.4693 113.05 13.24 113.125 12.984C113.205 12.728 113.245 12.4773 113.245 12.232C113.245 11.9867 113.205 11.736 113.125 11.48C113.05 11.2187 112.92 10.9867 112.733 10.784C112.552 10.5813 112.301 10.44 111.981 10.36C111.869 10.328 111.746 10.3093 111.613 10.304C111.48 10.2933 111.36 10.288 111.253 10.288H108.501V14.176ZM117.136 20V8.48H118.872L122.856 16.64L126.84 8.48H128.576V20H126.776V12.616L123.24 20H122.472L118.944 12.616V20H117.136Z"
                                        fill="#212534" />
                                    <defs>
                                        <linearGradient id="paint0_linear_125_980" x1="11.4893" y1="0"
                                            x2="14.9143" y2="8.7" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#F6DBFE" />
                                            <stop offset="0.713201" stop-color="#FEB8FE" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_125_980" x1="-1.24286" y1="14.5"
                                            x2="14.9143" y2="15.3286" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#A683F5" />
                                            <stop offset="1" stop-color="#016DEB" />
                                        </linearGradient>
                                        <linearGradient id="paint2_linear_125_980" x1="4.9709" y1="3.7286"
                                            x2="14.9138" y2="13.6715" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FAAEFF" />
                                            <stop offset="1" stop-color="#00AFFF" />
                                        </linearGradient>
                                        <linearGradient id="paint3_linear_125_980" x1="14.5003" y1="14.5"
                                            x2="7.04314" y2="29.4142" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#AA49F7" />
                                            <stop offset="1" stop-color="#FD2A9B" />
                                        </linearGradient>
                                        <linearGradient id="paint4_linear_125_980" x1="18.3399" y1="0"
                                            x2="14.9148" y2="8.7" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#F6DBFE" />
                                            <stop offset="0.713201" stop-color="#FEB8FE" />
                                        </linearGradient>
                                        <linearGradient id="paint5_linear_125_980" x1="31.072" y1="14.5"
                                            x2="14.9148" y2="15.3286" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#A683F5" />
                                            <stop offset="1" stop-color="#016DEB" />
                                        </linearGradient>
                                        <linearGradient id="paint6_linear_125_980" x1="24.8582" y1="3.7286"
                                            x2="14.9153" y2="13.6715" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FAAEFF" />
                                            <stop offset="1" stop-color="#00AFFF" />
                                        </linearGradient>
                                        <linearGradient id="paint7_linear_125_980" x1="15.3288" y1="14.5"
                                            x2="22.786" y2="29.4142" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#AA49F7" />
                                            <stop offset="1" stop-color="#FD2A9B" />
                                        </linearGradient>
                                        <clipPath id="clip0_125_980">
                                            <rect width="14.0857" height="29" fill="white" />
                                        </clipPath>
                                        <clipPath id="clip1_125_980">
                                            <rect width="14.0857" height="29" fill="white"
                                                transform="matrix(-1 0 0 1 29.8291 0)" />
                                        </clipPath>
                                    </defs>
                                </svg>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-end">
                    <div class="col-md-6 col-lg-7 d-none d-md-block">
                        <div class="pe-lg-4">
                            <div class="login-form-banner ">
                                <img src="{{ asset('assets/images/login.webp') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="login-form-wrap">
                            <form class="form" method="POST" action="{{ route('login') }}" id="ajaxForm">
                                @csrf
                                <h1 class="title fs-36px mb-20px">{{ get_phrase('Log in') }}</h1>
                                <p class="sub-title3 fs-15px mb-30px">
                                    {{ get_phrase('See your growth and get consulting support!') }}
                                </p>
                                <div class="mb-20px">
                                    <label for="email"
                                        class="form-label ol2-form-label mb-3">{{ get_phrase('Email') }}</label>
                                    <input type="email" class="form-control ol2-form-control" id="email"
                                        name="email" placeholder="Your email here">
                                </div>
                                <div class="mb-3">
                                    <label for="password"
                                        class="form-label ol2-form-label mb-3">{{ get_phrase('Password') }}</label>
                                    <div class="password-input-wrap">
                                        <input type="password" class="form-control ol2-form-control password-field"
                                            id="password" name="password" placeholder="Min 8 character">
                                        <div class="password-toggle-icons">
                                            <span class="password-toggle-icon fs-5" toggle=".password-field">

                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.89063 12.7333C7.73229 12.7333 7.57396 12.675 7.44896 12.55C6.76562 11.8667 6.39062 10.9583 6.39062 10C6.39062 8.00834 8.00729 6.39167 9.99896 6.39167C10.9573 6.39167 11.8656 6.76667 12.549 7.45C12.6656 7.56667 12.7323 7.725 12.7323 7.89167C12.7323 8.05834 12.6656 8.21667 12.549 8.33334L8.33229 12.55C8.20729 12.675 8.04896 12.7333 7.89063 12.7333ZM9.99896 7.64167C8.69896 7.64167 7.64062 8.7 7.64062 10C7.64062 10.4167 7.74896 10.8167 7.94896 11.1667L11.1656 7.95C10.8156 7.75 10.4156 7.64167 9.99896 7.64167Z"
                                                        fill="#99A1B7" />
                                                    <path
                                                        d="M4.66849 15.425C4.52682 15.425 4.37682 15.375 4.26016 15.275C3.36849 14.5167 2.56849 13.5833 1.88516 12.5C1.00182 11.125 1.00182 8.88333 1.88516 7.5C3.91849 4.31666 6.87682 2.48333 10.0018 2.48333C11.8352 2.48333 13.6435 3.11666 15.2268 4.30833C15.5018 4.51666 15.5602 4.90833 15.3518 5.18333C15.1435 5.45833 14.7518 5.51666 14.4768 5.30833C13.1102 4.275 11.5602 3.73333 10.0018 3.73333C7.31016 3.73333 4.73516 5.35 2.93516 8.175C2.31016 9.15 2.31016 10.85 2.93516 11.825C3.56016 12.8 4.27682 13.6417 5.06849 14.325C5.32682 14.55 5.36016 14.9417 5.13516 15.2083C5.01849 15.35 4.84349 15.425 4.66849 15.425Z"
                                                        fill="#99A1B7" />
                                                    <path
                                                        d="M9.99818 17.5167C8.88985 17.5167 7.80651 17.2917 6.76485 16.85C6.44818 16.7167 6.29818 16.35 6.43151 16.0333C6.56485 15.7167 6.93151 15.5667 7.24818 15.7C8.13151 16.075 9.05651 16.2667 9.98985 16.2667C12.6815 16.2667 15.2565 14.65 17.0565 11.825C17.6815 10.85 17.6815 9.15 17.0565 8.175C16.7982 7.76667 16.5148 7.375 16.2148 7.00833C15.9982 6.74167 16.0398 6.35 16.3065 6.125C16.5732 5.90833 16.9648 5.94167 17.1898 6.21667C17.5148 6.61667 17.8315 7.05 18.1148 7.5C18.9982 8.875 18.9982 11.1167 18.1148 12.5C16.0815 15.6833 13.1232 17.5167 9.99818 17.5167Z"
                                                        fill="#99A1B7" />
                                                    <path
                                                        d="M10.5737 13.5583C10.282 13.5583 10.0154 13.35 9.95702 13.05C9.89035 12.7083 10.1154 12.3833 10.457 12.325C11.3737 12.1583 12.1404 11.3917 12.307 10.475C12.3737 10.1333 12.6987 9.91666 13.0403 9.975C13.382 10.0417 13.607 10.3667 13.5404 10.7083C13.2737 12.15 12.1237 13.2917 10.6904 13.5583C10.6487 13.55 10.6153 13.5583 10.5737 13.5583Z"
                                                        fill="#99A1B7" />
                                                    <path
                                                        d="M1.66589 18.9583C1.50755 18.9583 1.34922 18.9 1.22422 18.775C0.982552 18.5333 0.982552 18.1333 1.22422 17.8917L7.44922 11.6667C7.69089 11.425 8.09089 11.425 8.33255 11.6667C8.57422 11.9083 8.57422 12.3083 8.33255 12.55L2.10755 18.775C1.98255 18.9 1.82422 18.9583 1.66589 18.9583Z"
                                                        fill="#99A1B7" />
                                                    <path
                                                        d="M12.1073 8.51666C11.949 8.51666 11.7906 8.45833 11.6656 8.33333C11.424 8.09166 11.424 7.69166 11.6656 7.45L17.8906 1.225C18.1323 0.98333 18.5323 0.98333 18.774 1.225C19.0156 1.46666 19.0156 1.86666 18.774 2.10833L12.549 8.33333C12.424 8.45833 12.2656 8.51666 12.1073 8.51666Z"
                                                        fill="#99A1B7" />
                                                </svg>

                                            </span>
                                            <span class="password-toggle-icon fs-5 d-none password-toggle-icon-show"
                                                toggle=".password-field">

                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.99896 13.6083C8.00729 13.6083 6.39062 11.9917 6.39062 10C6.39062 8.00833 8.00729 6.39166 9.99896 6.39166C11.9906 6.39166 13.6073 8.00833 13.6073 10C13.6073 11.9917 11.9906 13.6083 9.99896 13.6083ZM9.99896 7.64166C8.69896 7.64166 7.64063 8.7 7.64063 10C7.64063 11.3 8.69896 12.3583 9.99896 12.3583C11.299 12.3583 12.3573 11.3 12.3573 10C12.3573 8.7 11.299 7.64166 9.99896 7.64166Z"
                                                        fill="#99A1B7" />
                                                    <path
                                                        d="M9.99844 17.5167C6.8651 17.5167 3.90677 15.6833 1.87344 12.5C0.990104 11.125 0.990104 8.88334 1.87344 7.5C3.9151 4.31667 6.87344 2.48334 9.99844 2.48334C13.1234 2.48334 16.0818 4.31667 18.1151 7.5C18.9984 8.875 18.9984 11.1167 18.1151 12.5C16.0818 15.6833 13.1234 17.5167 9.99844 17.5167ZM9.99844 3.73334C7.30677 3.73334 4.73177 5.35 2.93177 8.175C2.30677 9.15 2.30677 10.85 2.93177 11.825C4.73177 14.65 7.30677 16.2667 9.99844 16.2667C12.6901 16.2667 15.2651 14.65 17.0651 11.825C17.6901 10.85 17.6901 9.15 17.0651 8.175C15.2651 5.35 12.6901 3.73334 9.99844 3.73334Z"
                                                        fill="#99A1B7" />
                                                </svg>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-30px d-flex align-items-center gap-2 flex-wrap justify-content-between">
                                    <div class="form-check form-check-checkbox2">
                                        <input class="form-check-input form-check-input-checkbox2" type="checkbox"
                                            value="" id="flexCheckDefault">
                                        <label class="form-check-label form-check-label-checkbox2"
                                            for="flexCheckDefault">
                                            {{ get_phrase('Remember me') }}
                                        </label>
                                    </div>
                                    <a
                                        href="{{ route('password.request') }}">{{ get_phrase('Forgot Password?') }}</a>
                                </div>
                                <button type="submit" class="btn ol2-btn-primary w-100 mb-3">{{ get_phrase('Log in') }}</button>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <button type="button" onclick="$('#email').val('admin@example.com'); $('#password').val('12345678')" class="btn ol2-btn-primary w-100 mb-3">{{ get_phrase('Admin') }}</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="button" onclick="$('#email').val('client@example.com'); $('#password').val('12345678')" class="btn ol2-btn-primary w-100 mb-3">{{ get_phrase('Client') }}</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="button" onclick="$('#email').val('staff@example.com'); $('#password').val('12345678')" class="btn ol2-btn-primary w-100 mb-3">{{ get_phrase('Staff') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
@include('toastr')
