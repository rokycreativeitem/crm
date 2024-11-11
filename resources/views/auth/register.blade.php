<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project management | Register</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}">
    <!-- UI Icon -->
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <!-- Admin Login Area Start -->
    <main>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-12">
                    <div class="ol2-logo-area">
                        <a href="#">
                            <img src="{{ asset('assets/images/workplace.png') }}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="login-form-wrap">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form class="form mt-0" method="POST" action="{{ route('register') }}">
                            @csrf
                            <h1 class="title fs-36px mb-20px">Create Account</h1>
                            <p class="sub-title3 fs-15px mb-30px">See your growth and get consulting support! </p>
                            <div class="mb-20px">
                                <label for="name" class="form-label ol2-form-label mb-3">Name</label>
                                <input type="text" class="form-control ol2-form-control" name="name"
                                    id="name" placeholder="Your name here">
                            </div>
                            <div class="mb-20px">
                                <label for="email" class="form-label ol2-form-label mb-3">Email</label>
                                <input type="email" class="form-control ol2-form-control" name="email"
                                    id="email" placeholder="Your email here">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label ol2-form-label mb-3">Password</label>
                                <div class="password-input-wrap">
                                    <input type="password" class="form-control ol2-form-control password-field"
                                        id="password" name="password" placeholder="Min 8 character">
                                    <div class="password-toggle-icons">
                                        <img src="{{ asset('assets/images/icons/eye-slash-gray-20.svg') }}"
                                            class="password-toggle-icon password-toggle-icon-hide"
                                            toggle=".password-field" alt="">
                                        <img src="{{ asset('assets/images/icons/eye-gray-20.svg') }}"
                                            class="password-toggle-icon d-none password-toggle-icon-show"
                                            toggle=".password-field" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label ol2-form-label mb-3">Confirm Password</label>
                                <div class="password-input-wrap">
                                    <input type="password" class="form-control ol2-form-control password-field"
                                        id="password" name="password_confirmation" placeholder="Min 8 character">
                                    <div class="password-toggle-icons">
                                        <img src="{{ asset('assets/images/icons/eye-slash-gray-20.svg') }}"
                                            class="password-toggle-icon password-toggle-icon-hide"
                                            toggle=".password-field" alt="">
                                        <img src="{{ asset('assets/images/icons/eye-gray-20.svg') }}"
                                            class="password-toggle-icon d-none password-toggle-icon-show"
                                            toggle=".password-field" alt="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn ol2-btn-primary w-100 mb-3">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Admin Login Area End -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
