<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="admin, dashboard">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dompet : Payment Admin Template">
    <meta property="og:title" content="Dompet : Payment Admin Template">
    <meta property="og:description" content="Dompet : Payment Admin Template">
    <meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>{{config("app.name")}}</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="{{ asset('/168_res') }}/css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">

            <div class="col-12">
            </div>

            <div class="col-md-6">

                <div class="authincation-content">
                    <div class="row no-gutters">


                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="index.html"><img src="{{ asset('/168_res') }}/images/logo-full.png" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4">Sign in your account</h4>
                                <form method="POST" action="{{ url('proceedLogin') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Email/Phone</strong></label>
                                        <input type="text" name="contact" class="form-control"
                                               value={{ old('contact') }}>
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Password</strong></label>
                                        <input type="password" class="form-control" name="password" value="Password">
                                    </div>
                                    <div class="row d-flex justify-content-between mt-4 mb-2">
                                        <div class="mb-3">
                                            <div class="form-check custom-checkbox ms-1">
                                                <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                                <label class="form-check-label" for="basic_checkbox_1">Remember my
                                                    preference</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <a href="{{url("forgot-password")}}">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button style="" type="submit" class="btn btn-primary btn-block">Sign Me In
                                        </button>
                                    </div>


                                </form>
                                <div class="new-account mt-3">
                                    <p>Don't have an account? <a class="text-primary" href="{{url("/register")}}">Sign
                                            up</a></p>
                                </div>

                                @if ($errors->any())
                                    <div class="col-12">
                                        <div class="alert alert-danger left-icon-big alert-dismissible fade show">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="btn-close"><span><i
                                                        class="mdi mdi-btn-close"></i></span>
                                            </button>
                                            <div class="media">
                                                <div class="alert-left-icon-big">
                                                    <span><i class="mdi mdi-alert"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mt-1 mb-2">Error</h5>
                                                    <p class="mb-0">{!! implode('', $errors->all('<div>:message</div>')) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{ asset('/168_res') }}/vendor/global/global.min.js"></script>
<script src="{{ asset('/168_res') }}/js/custom.min.js"></script>
<script src="{{ asset('/168_res') }}/js/dlabnav-init.js"></script>
<script src="{{ asset('/168_res') }}/js/styleSwitcher.js"></script>
<script src="{{ asset('/168_res') }}/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
</body>
</html>
