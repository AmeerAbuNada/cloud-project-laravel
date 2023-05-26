@extends('crm.parent')

@section('title', 'Edit User')

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
                            <h3 class="card-title">Edit User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form" onsubmit="event.preventDefault(); updateUser();">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ $user->name }}"
                                        placeholder="Enter User's Name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}"
                                        placeholder="Enter User's Email">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" value="{{ $user->address }}"
                                        placeholder="Enter User's Address">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone"
                                        value="{{ $user->phone_number }}" placeholder="Enter User's Phone Number">
                                </div>
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" id="role">
                                        <option value="user" @selected($user->role == 'user')>User</option>
                                        <option value="admin" @selected($user->role == 'admin')>Admin</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-button">Submit</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger" id="submit-button">Cancel</a>
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
        function updateUser() {
            let data = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value,
                role: document.getElementById('role').value
            }

            put("{{ route('users.update', $user) }}", data, "submit-button", undefined, "{{ url()->previous() }}")
        }
    </script>
@endsection
