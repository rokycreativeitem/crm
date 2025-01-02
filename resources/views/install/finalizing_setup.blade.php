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
            <div class="text-center mb-4">
                <img src="{{asset('assets/install/images/complete.png')}}" alt="" />
                <p class="py-3">{{__('Now Log in to admin panel')}}</p>

                <a href="{{route('login')}}" class="ins-btn">
                    <span class="me-2"> Finish </span>
                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.5837 1C11.2503 0.666667 10.7503 0.666667 10.417 1L4.16699 7.25L1.58366 4.66667C1.25032 4.33333 0.750325 4.33333 0.416992 4.66667C0.0836589 5 0.0836589 5.5 0.416992 5.83333L3.58366 9C3.75032 9.16667 3.91699 9.25 4.16699 9.25C4.41699 9.25 4.58366 9.16667 4.75032 9L11.5837 2.16667C11.917 1.83333 11.917 1.33333 11.5837 1Z"
                            fill="white" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script type="text/javascript">
        "use strict";

        $(document).ready(function() {
            $('#loader').hide();
            $('#install_button').on('click', function() {
                $('#loader').fadeIn();
                setTimeout(
                    function() {
                        window.location.href =
                            "{{ route('step4.confirm_import', ['confirm_import' => 'confirm_install']) }}";
                    }, 5000);
            });
        });
    </script>
@endsection




{{-- @section('content')
    <div class="row justify-content-center ins-two">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body px-4">
                    <div class="panel panel-default ins-three" data-collapsed="0">
                        <!-- panel body -->
                        <div class="panel-body ins-four">

                            <i class="entypo-thumbs-up ins-five"></i>
                            <h4></h4>

                            <br>

                            <p>
                                
                            </p>

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-horizontal form-groups" method="post" action="{{ route('finalizing_setup') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('System Name') }}</label>

                                            <input type="text" class="form-control eForm-control" name="system_name" required autofocus>
                                            <small class="text-muted">
                                                {{ __('The name of your application') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your name') }}</label>

                                            <input type="text" class="form-control eForm-control" name="admin_name" placeholder="Ex: John Doe" required>
                                            <small class="text-muted">
                                                {{ __('Full name of Administrator') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your Email') }}</label>

                                            <input type="email" class="form-control eForm-control" name="admin_email" placeholder="Ex: john@example.com" required>
                                            <small class="text-muted">
                                                {{ __('Email address for administrator login') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Password') }}</label>

                                            <input type="password" class="form-control eForm-control" name="admin_password" placeholder="" required>
                                            <small class="text-muted">
                                                {{ __('Admin login password') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your Address') }}</label>

                                            <input type="text" class="form-control eForm-control" name="admin_address" placeholder="Ex: Your Address" required>
                                            <small class="text-muted">
                                                {{ __('Address of Administrator') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your Phone') }}</label>

                                            <input type="text" class="form-control eForm-control" name="admin_phone" placeholder="Ex: +9020040060" required>
                                            <small class="text-muted">
                                                {{ __('Phone of Administrator') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('TimeZone') }}</label>

                                            <select class="form-select eForm-select eChoice-multiple-with-remove" id="timezone" name="timezone">
                                                <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                                                <?php foreach ($tzlist as $tz): ?>
                                                <option value="{{ $tz }}" {{ $tz == 'Asia/Dhaka' ? 'selected' : '' }}>{{ $tz }}</option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="text-muted">
                                                {{ __('Choose System TimeZone') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-7">
                                                <button type="submit" class="btn btn-primary">{{ __('Set me up') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
