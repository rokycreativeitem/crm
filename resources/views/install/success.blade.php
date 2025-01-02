@extends('install.index')

@section('content')
    <?php if(isset($error)) { ?>
    <div class="row justify-content-center ins-seven">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <strong>{{ $error }}</strong>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="card">
        <div class="card-body">
            <div class="text-center pt-2">
                <img src="{{ asset('assets/install/images/logo.png') }}" alt="" />
            </div>
            <div class="page-title">
                <h4> {{ __('Installation') }} </h4>
            </div>
            <p class="ins-p-1">
                <strong
                    class="text-success">{{ __('Installation was successfull.') . ' ' . __('Please login to continue..') }}</strong>
            </p>
            <table>
                <tbody>
                    <tr>
                        <td class="ins-eight"><strong class="mb-2 d-inline-block">{{ __('Administrator Email') }} </strong>
                        </td>
                        <td class="ins-eight"><span class="mx-4 mb-2 d-inline-block">|</span></td>
                        <td class="ins-eight"><span class="mb-2 d-inline-block">{{ $admin_email }}</span></td>
                    </tr>
                    <tr>
                        <td class="ins-eight"><strong>{{ __('Password') }} </strong></td>
                        <td class="ins-eight"><span class="mx-4">|</span></td>
                        <td class="ins-eight">{{ __('Your chosen password') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-between pt-2">
                <div></div>
                <a href="{{ route('login') }}" class="ins-btn"> {{ __('Continue') }} </a>
            </div>

            <ul class="ins-step">
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
            </ul>
            <span> Step-6 </span>
            <div class="text-center">
                <p>Need any help? <a href="">Contact Us</a></p>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
@endsection
