@php use Illuminate\Support\Facades\Session; @endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="utf-8"/>
    <title>Log In </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/img/dark-mode-washease.png">
    <!-- Theme Config Js -->
    <script src="customer_assets/js/config.js"></script>
    <!-- App css -->
    <link href="customer_assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>
    <!-- Icons css -->
    <link href="customer_assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
</head>

<body class="authentication-bg position-relative" style="height: 100vh;">
<div class="account-pages p-sm-5  position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-9 col-lg-11">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="d-flex flex-column h-100">
                                <div class="auth-brand p-4 text-center">
                                    <a href="{{ route('home') }}" class="logo-light fs-2 fw-bold">
                                        <img src="{{ asset('assets/img/light-mode-washease.png') }}" class="w-25"/>
                                    </a>
                                    <a href="{{ route('home') }}" class="logo-dark fs-2 fw-bold">
                                        <img src="{{ asset('assets/img/light-mode-washease.png') }}" class="w-25"/>
                                    </a>
                                </div>
                                <div class="p-4 text-center">
                                    <h4 class="fs-20">Sign In</h4>
                                    <p class="text-muted mb-4">Enter your email address and password to <br> access
                                        account.
                                    </p>

                                    @if(Session::has('error'))
                                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>Oops!</strong> {{  Session::get('error') }}
                                        </div>
                                    @endif

                                    <!-- form -->
                                    <form action="{{ route('auth.login.web') }}" method="POST" class="text-start">
                                        @csrf <!-- CSRF protection for POST requests -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input class="form-control" id="email" type="email" name="email" required="" placeholder="Enter your email">
                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <a href="#" class="text-muted float-end"><small>Forgot your password?</small></a>
                                            <label for="password" class="form-label">Password</label>
                                            <input class="form-control" id="password" type="password" required="" name="password" placeholder="Enter your password">
                                            @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="mb-0 text-start">
                                            <button class="btn btn-soft-primary w-100" id="customer_login">
                                                <i class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Log In</span>
                                            </button>
                                        </div>
                                    </form>


                                    <!-- end form-->
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-dark-emphasis">Don't have an account? <a href="{{ route('register') }}"
                                                                        class="text-dark fw-bold ms-1 link-offset-3 text-decoration-underline"><b>Sign
                            up</b></a>
                </p>
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<!-- Vendor js -->
<script src="customer_assets/js/vendor.min.js"></script>
<script src="customer_assets/vendor/lucide/umd/lucide.min.js"></script>
<!-- App js -->
<script src="customer_assets/js/app.min.js"></script>
<script src="https://unpkg.com/bs5-toast/dist/bs5-toast.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>
