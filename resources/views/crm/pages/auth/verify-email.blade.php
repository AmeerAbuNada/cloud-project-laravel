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
                <p class="login-box-msg">We have sent you a verification email to <br> {{ auth()->user()->email }}.
                    <br>
                    If you don't see the email in your inbox, Please check in the spam section
                    <br>
                    If you don't see it anywhere you can click resend to resend the verification email
                </p>
                <div>
                    <div class="row">
                        <div class="col-12">
                            <button id="resend-button" onclick="resedVerificationEmail()" type="button"
                                class="btn btn-primary btn-block"><i class="fad fa-inbox-out"></i> &nbsp;&nbsp; Resend
                                verification email</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row" style="margin-top: 15px">
                        <div class="col-12">
                            <button id="check-button" onclick="checkVerificationStatus()" type="button"
                                class="btn btn-primary btn-block"><i class="fad fa-badge-check"></i> &nbsp;&nbsp; Check
                                Verification Status</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row" style="margin-top: 15px">
                        <div class="col-12">
                            <a href="{{ route('logout') }}" class="btn btn-primary btn-block"><i
                                    class="fad fa-sign-out"></i> &nbsp;&nbsp; Logout</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    @include('crm.components.js')
    <script>
        function resedVerificationEmail() {
            post("{{ route('verification.send') }}", {}, "resend-button")
        }

        function checkVerificationStatus() {
            get("{{ route('verification.status') }}", "check-button", "{{ route('crm.home') }}")
        }
    </script>
</body>

</html>
