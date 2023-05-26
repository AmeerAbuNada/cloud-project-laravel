@extends('crm.parent')

@section('title', 'Change Password')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="change-password-form" onsubmit="event.preventDefault(); createUser();">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="current-password">Current Password</label>
                                    <input type="password" class="form-control" id="current-password"
                                        placeholder="Enter Your Current Password">
                                </div>
                                <div class="form-group">
                                    <label for="new-password">New Password</label>
                                    <input type="password" class="form-control" id="new-password"
                                        placeholder="Enter Your New Password">
                                </div>
                                <div class="form-group">
                                    <label for="new-password-confirmation">Repeat New Password</label>
                                    <input type="password" class="form-control" id="new-password-confirmation"
                                        placeholder="Repeat Your New Password">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-button">Change Password</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script>
        function createUser() {
            let data = {
                password: document.getElementById('current-password').value,
                new_password: document.getElementById('new-password').value,
                new_password_confirmation: document.getElementById('new-password-confirmation').value
            }

            put("{{ route('account.update-change-password') }}", data, "submit-button", "change-password-form")
        }
    </script>
@endsection
