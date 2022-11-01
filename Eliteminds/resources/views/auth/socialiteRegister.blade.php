<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>{{env('APP_NAME')}} | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Courseplus - Professional Learning Management HTML Template">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{asset('assetsV2/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assetsV2/css/night-mode.css')}}">
    <link rel="stylesheet" href="{{asset('assetsV2/css/framework.css')}}">
    <link rel="stylesheet" href="{{asset('assetsV2/css/bootstrap.css')}}">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('assetsV2/css/icons.css')}}">


</head>


<body>



<!-- Content
================================================== -->
<div uk-height-viewport class="uk-flex uk-flex-middle">
    <div class="uk-width-2-3@m uk-width-1-2@s m-auto rounded">
        <div class="uk-child-width-1-2@m uk-grid-collapse bg-gradient-grey" uk-grid>

            <!-- column one -->
            <div class="uk-margin-auto-vertical uk-text-center uk-animation-scale-up p-3 uk-light">
                <i class="">
                    <img src="./img/pmplearning.jpg" height="150px" width="150px" alt="">
                </i>
                <h3 class="mb-4"> {{env('APP_NAME')}}</h3>
                <p>The Place You can learn Every Thing. </p>
            </div>

            <!-- column two -->
            <div class="uk-card-default p-5 rounded">
                <div class="mb-4 uk-text-center">
                    <h3 class="mb-0"> Welcome</h3>
                    <p class="my-2">Complete Final Step.</p>
                </div>
                @if (session('error'))
                    <span class="alert alert-danger" style="display:block">
                        <strong>{{ session('error') }}</strong>
                    </span>
                @endif
                @if (isset($error))
                    <span class="alert alert-danger" style="display:block">
                        <strong>{{ $error }}</strong>
                    </span>
                @endif
                <form action="{{route('socialite.setup.account')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="provider" value="{{$provider}}">
                    <input type="hidden" name="provider_id" value="{{$provider_id}}">
                    <input type="hidden" name="email" value="{{$email}}">
                    <div class="uk-width-1-2@s">
                        <div class="uk-form-group">
                            <label class="uk-form-label"> Password</label>

                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="icon-feather-lock"></i>
                                </span>
                                <input class="uk-input{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" />
                            </div>

                        </div>
                    </div>
                    <div class="uk-width-1-2@s">
                        <div class="uk-form-group">
                            <label class="uk-form-label"> Confirm password</label>

                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="icon-feather-lock"></i>
                                </span>
                                <input class="uk-input" type="password" autocomplete="off" placeholder="Re-type Your Password" name="password_confirmation" />
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="uk-for-group">
                            <label>By clicking Submit, you agree to our <a >Terms, Policy</a></label>
                        </div>
                    </div>
                    <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                        <div class="uk-width-auto@s">
                            <input type="submit" class="btn btn-default" value="Submit"/>
                        </div>
                    </div>


                </form>
            </div><!--  End column two -->

        </div>
    </div>
</div>

<!-- Content -End
================================================== -->


<!-- For Night mode -->
<script>
    (function (window, document, undefined) {
        'use strict';
        if (!('localStorage' in window)) return;
        var nightMode = localStorage.getItem('gmtNightMode');
        if (nightMode) {
            document.documentElement.className += ' night-mode';
        }
    })(window, document);


    (function (window, document, undefined) {

        'use strict';

        // Feature test
        if (!('localStorage' in window)) return;

        // Get our newly insert toggle
        var nightMode = document.querySelector('#night-mode');
        if (!nightMode) return;

        // When clicked, toggle night mode on or off
        nightMode.addEventListener('click', function (event) {
            event.preventDefault();
            document.documentElement.classList.toggle('night-mode');
            if (document.documentElement.classList.contains('night-mode')) {
                localStorage.setItem('gmtNightMode', true);
                return;
            }
            localStorage.removeItem('gmtNightMode');
        }, false);

    })(window, document);
</script>


<!-- javaScripts
================================================== -->
<script src="{{asset('assetsV2/js/framework.js')}}"></script>
<script src="{{asset('assetsV2/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assetsV2/js/simplebar.js')}}"></script>
<script src="{{asset('assetsV2/js/main.js')}}"></script>
<script src="{{asset('assetsV2/js/bootstrap-select.min.js')}}"></script>


</body>

</html>
