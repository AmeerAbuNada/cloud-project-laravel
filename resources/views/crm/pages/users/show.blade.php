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
                                <img class="profile-user-img img-fluid img-circle" src="{{ $user->image_url }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            <p class="text-muted text-center">{{ $user->role_name }}</p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">About {{ $user->name }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                                    <p class="text-muted">
                                        {{ $user->email }}
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-phone-alt mr-1"></i> Phone Number</strong>

                                    <p class="text-muted">
                                        {{ $user->phone_number }}
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                                    <p class="text-muted">{{ $user->address }}</p>

                                    <hr>

                                    <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                                    <p class="text-muted">{{ $user->created_at->format('Y M d | h:i a') }}
                                    </p>
                                    <strong><i class="fad fa-calendar mr-1"></i> ID CARD</strong>

                                    <img src="{{ Storage::url($user->id_card) }}" width="100px" alt="">
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            @if ($user->accomplishments)
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

                                {!! $user->accomplishments !!}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                Logs and Activites
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Activity</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $log)
                                        <tr>
                                            @if (isset(request()->page))
                                                <td>
                                                    {{ (request()->page - 1) * 25 + $loop->iteration }}
                                                </td>
                                            @else
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                            @endif
                                            <td>
                                                {{ $log->content }}
                                            </td>
                                            <td>
                                                {{ $log->created_at->format('Y M d | H:i') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center">No Logs To Be Displayed</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    {{$logs->links()}}
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
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
    </script>
@endsection
