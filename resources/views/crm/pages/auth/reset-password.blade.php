<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM | Reset Password</title>

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
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.
                </p>
                <form id="reset-form" onsubmit="event.preventDefault(); resetPassword();">
                    <div class="input-group mb-3">
                        <input type="password" id="password" class="form-control" placeholder="New Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password-confirmation" class="form-control"
                            placeholder="Confirm New Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="reset-button" class="btn btn-primary btn-block">Change
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
        function resetPassword() {
            let data = {
                token: "{{ $token }}",
                email: "{{ request()->email }}",
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password-confirmation').value
            }

            post("{{ route('password.update') }}", data, "reset-button", "reset-form", "{{ route('login') }}");
        }
    </script>
</body>

</html>
