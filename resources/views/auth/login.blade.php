<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.shared/title-meta', ['title' => "Log In"])
    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])

</head>
<style>
    body.authentication-bg-pattern {
        background-image: url("../../../images/bg4.jpg");
    }
</style>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('assets/images/huaxixiang.png')}}" alt="" height="60">
                                        </span>
                                    </a>

                                    <a href="" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('assets/images/huaxixiang.png')}}" alt="" height="22">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                            </div>


                            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>
                            <br>@endif
                            @if(session('success'))<div class=" alert alert-success">{{ session('success') }}
                            </div>
                            <br>@endif

                            @if (sizeof($errors) > 0)
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">帳號</label>
                                    <input class="form-control" type="text" name="username" id="emailaddress" required="" placeholder="Enter your email">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">密碼</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>



                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    @include('layouts.shared/footer-script')

</body>

</html>