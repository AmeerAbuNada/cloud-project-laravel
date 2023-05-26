<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM | Register</title>

    @include('crm.components.css')
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('crm-assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('login') }}" class="h1"><b>Cloud</b> Training</a>
            </div>
            <div class="card-body">
                <form onsubmit="event.preventDefault(); performRegister();">
                    <div class="input-group mb-3">
                        <input type="name" class="form-control" id="name" placeholder="Full Name">
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" id="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password_confirmation"
                            placeholder="Password Confirmation">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="role" id="role" class="form-control">
                            <option value="trainee">Trainee</option>
                            <option value="advisor">Advisor</option>
                        </select>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" id="login-button" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    Do you have and account? <a href="{{ route('login') }}">Login Here</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    {{-- <script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script> --}}
    @include('crm.components.js')

    <script>
        function performRegister() {
            let data = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value,
                role: document.getElementById('role').value,
            }

            post("{{ route('register.post') }}", data, "login-button", undefined, "{{ url()->previous() }}");
        }
    </script>
</body>

</html>
