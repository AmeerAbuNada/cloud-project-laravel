<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM | Forgot Password</title>

    @include('crm.components.css')
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('crm-assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('login') }}" class="h1"><b>Cloud</b> Training</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <form id="reset-form" onsubmit="event.preventDefault(); sendResetPasswordEmail();">
                    <div class="input-group mb-3">
                        <input type="email" id="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button id="reset-button" type="submit" class="btn btn-primary btn-block">Request new
                                password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    @include('crm.components.js')
    <script>
        function sendResetPasswordEmail() {
            let data = {
                email: document.getElementById('email').value
            }
            post("{{ route('password.email') }}", data, "reset-button", "reset-form");
        }
    </script>
</body>

</html>
