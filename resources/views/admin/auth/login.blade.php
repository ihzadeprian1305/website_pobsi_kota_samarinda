<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POBSI Kota Samarinda</title>
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/logo_pobsi_samarinda_1.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="{{ asset('assets/static/images/logo/logo_pobsi_samarinda_2.svg') }}" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Login</h1>
                    <p class="auth-subtitle mb-5">Login untuk masuk ke halaman Admin</p>
                    @if (session('status'))
                        <div class="col-sm-12">
                            <div class="alert alert-danger">
                                {!! session()->get('status') !!}
                            </div>
                        </div>
                    @endif
                    <form action="{{ url('/admin/login/check-login') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="email_or_username" id="login_email_or_username" class="form-control form-control-xl" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('email_or_username')
                                <div class="text-danger mt-2" role="alert" id="login_email_or_username">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" id="login_password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <div class="text-danger mt-2" role="alert" id="login_email_or_username">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        {{-- <p class="text-gray-600">Don't have an account? <a href="auth-register.html" class="font-bold">Sign
                                up</a>.</p> --}}
                        {{-- <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p> --}}
                        <p><a class="font-bold" href="{{ url('/') }}">Website POBSI Kota Samarinda</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
