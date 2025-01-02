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
                {!! __("The provided information will be written into your application's <b>config/database.php</b> file, so click the Confirm button to write the file")!!}.
            </p>
            <div class="d-flex align-items-center justify-content-between pt-2">
                <div>
                    <div class="mt-3" id="loader">
                        {{ __('Configuring the database....') }}
                    </div>
                </div>
                <button type="button" id="install_button" class="ins-btn"> Continue </a>
            </div>

            <ul class="ins-step">
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li></li>
            </ul>
            <span> Step-5 </span>
            <div class="text-center">
                <p>Need any help? <a href="">Contact Us</a></p>
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
                        window.location.href = "{{ route('step4.confirm_import', ['confirm_import' => 'confirm_install']) }}";
                    }, 5000);
            });
        });
    </script>
@endsection



