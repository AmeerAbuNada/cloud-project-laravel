@extends('crm.parent')

@section('title', 'User Profile')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ auth()->user()->image_url }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                            <p class="text-muted text-center">{{ auth()->user()->role_name }}</p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#about" data-toggle="tab">About</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="about">
                                    <!-- About Me Box -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">About {{ auth()->user()->name }}</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                                            <p class="text-muted">
                                                {{ auth()->user()->email }}
                                            </p>

                                            <hr>

                                            <strong><i class="fas fa-phone-alt mr-1"></i> Phone Number</strong>

                                            <p class="text-muted">
                                                {{ auth()->user()->phone_number }}
                                            </p>

                                            <hr>

                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                                            <p class="text-muted">{{ auth()->user()->address }}</p>

                                            <hr>

                                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                                            <p class="text-muted">{{ auth()->user()->created_at->format('Y M d | h:i a') }}
                                            </p>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal" onsubmit="event.preventDefault(); editProfile();">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Your Name" value="{{ auth()->user()->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email"
                                                    style="cursor: not-allowed" placeholder="Your Email"
                                                    value="{{ auth()->user()->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Phone Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="phone"
                                                    placeholder="Your Phone Number"
                                                    value="{{ auth()->user()->phone_number }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="address"
                                                    placeholder="Your Address" value="{{ auth()->user()->address }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="image" class="col-sm-2 col-form-label">Profile Image</label>
                                            <div class="col-sm-10">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        Image</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary"
                                                    id="submit-button">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            @if (!auth()->user()->IsRegistrationComplete)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Alert
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    Please Complete Your Registration
                                </div>
                                <form class="form-horizontal" onsubmit="event.preventDefault(); completeRegistration();">
                                    <div class="form-group row">
                                        <label for="id-card" class="col-sm-2 col-form-label">Id Card</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="id-card">
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    File</label>
                                            </div>
                                        </div>
                                    </div>
                                    @if (auth()->user()->role == 'advisor')
                                        <div class="form-group row">
                                            <label for="id-card" class="col-sm-2 col-form-label">Select Your Classification</label>
                                            <div class="col-sm-10">
                                                <select id="type" class="form-control">
                                                    <option value="-1">Select Your Classification</option>
                                                    <option>Programming</option>
                                                    <option>Graphic Design</option>
                                                    <option>Video Editing</option>
                                                    <option>Database Specialist</option>
                                                    <option>Data Analyst</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary"
                                                id="submit-button">Complete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            @endif
            @if (auth()->user()->accomplishments)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Accomplishments
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                {!! auth()->user()->accomplishments !!}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function editProfile() {
            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', document.getElementById('name').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('phone', document.getElementById('phone').value);
            if (document.getElementById('image').files.length > 0) {
                formData.append('image', document.getElementById('image').files[0]);
            }

            post("{{ route('account.update-general-info') }}", formData, "submit-button", undefined,
                "{{ URL::current() }}")
        }

        @if (!auth()->user()->IsRegistrationComplete)
            function completeRegistration() {
                let formData = new FormData();
                formData.append('_method', 'PUT');
                if (document.getElementById('id-card').files.length > 0) {
                    formData.append('id_card', document.getElementById('id-card').files[0]);
                }
                @if (auth()->user()->role == 'advisor')
                    formData.append('type', document.getElementById('type').value);
                @endif

                post("{{ route('account.complete-registration') }}", formData, "submit-button", undefined,
                    "{{ URL::current() }}")
            }
        @endif
    </script>
@endsection
