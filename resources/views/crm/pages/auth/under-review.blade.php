<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM | Under Review</title>

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
                <p class="mb-1">
                    Your account currently under review, Please check other time.
                </p>
            </div>
        </div>
    </div>

    @include('crm.components.js')

</body>

</html>
