@extends('crm.parent')

@section('title', 'User Profile')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($user->trashed())
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5 style="margin-bottom: 0px"><i class="icon fas fa-ban"></i> This User has been Deleted</h5>
                        </div>
                    </div>
                @endif
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card @if ($user->trashed()) card-danger @else card-primary @endif card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $user->image_url }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }} @if ($user->trashed())
                                    <span class="badge bg-danger">Deleted</span>
                                @endif
                            </h3>

                            <p class="text-muted text-center">{{ $user->role_name }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Assigned Projects</b> <a href="{{route('users.relations.projects.assigned', $user)}}" class="float-right">{{$assigned_projects_count}} Projects</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Projects Created</b> <a href="{{route('users.relations.projects.created', $user)}}" class="float-right">{{$created_projects_count}} Projects</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Projects Deleted</b> <a href="{{route('users.relations.projects.deleted', $user)}}" class="float-right">{{$deleted_projects_count}} Projects</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Assigned Tasks</b> <a href="{{route('users.relations.tasks.assigned', $user)}}" class="float-right">{{$assigned_tasks_count}} Tasks</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tasks Created</b> <a href="{{route('users.relations.tasks.created', $user)}}" class="float-right">{{$created_tasks_count}} Tasks</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Users Created</b> <a href="{{route('users.relations.users.created', $user)}}" class="float-right">{{$created_users_count}} Users</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Users Deleted</b> <a href="{{route('users.relations.users.deleted', $user)}}" class="float-right">{{$deleted_users_count}} Users</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Clients Created</b> <a href="{{route('users.relations.clients.created', $user)}}" class="float-right">{{$created_clients_count}} Clients</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Clients Deleted</b> <a href="{{route('users.relations.clients.deleted', $user)}}" class="float-right">{{$deleted_clients_count}} Clients</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Files Uploaded</b> <a href="{{route('users.relations.files.uploaded', $user)}}" class="float-right">{{$files_count}} Files</a>
                                </li>
                            </ul>

                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-block"><b>Edit</b></a>
                            @if (!$user->trashed())
                                <button type="button" onclick="confirmDeleteUser()"
                                    class="btn btn-danger btn-block"><b>Delete</b></button>
                            @else
                                <button id="restore-button" type="button" onclick="restoreUser()"
                                    class="btn btn-warning btn-block"><b>Restore</b></button>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->



                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    @if ($user->trashed())
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-ban"></i> Deletion Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fad fa-trash"></i> Deleted By</strong>

                                <p class="text-muted">
                                    @if (auth()->user()->id == $user->deletedBy->id)
                                        <a href="{{ route('account.profile') }}">
                                        @else
                                            <a href="{{ route('users.show', $user->deletedBy) }}">
                                    @endif
                                    {{ $user->deletedBy->name }}</a>
                                </p>

                                <hr>

                                <strong><i class="fad fa-calendar mr-1"></i> Deleted At</strong>

                                <p class="text-muted">
                                    {{ $user->deleted_at->format('Y M d | h:i a') }}
                                </p>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    @endif

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About {{ $user->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted">
                                {{ $user->email }} {!! $user->email_verification_status !!}
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

                            <strong><i class="fas fa-plus mr-1"></i> Created By</strong>

                            <p class="text-muted">
                                @if ($user->created_by_system)
                                    <span class="badge bg-info">Created By The System</span>
                                @else
                                    @if (auth()->user()->id == $user->createdBy->id)
                                        <a href="{{ route('account.profile') }}">
                                            {{ $user->createdBy->name }}
                                        </a>
                                    @else
                                        <a href="{{ route('users.show', $user->createdBy) }}">
                                            {{ $user->createdBy->name }}
                                        </a>
                                    @endif
                                @endif
                            </p>

                            <hr>

                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $user->created_at->format('Y M d | h:i a') }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script>
        function confirmDeleteUser() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteUser();
                }
            });
        }

        function deleteUser() {
            axios
                .delete('{{ route('users.destroy', $user) }}')
                .then((response) => {
                    showUserResponseMessage(response.data);
                    setTimeout(() => {
                        location.reload();
                    }, 1300);
                })
                .catch((error) => {
                    showUserResponseMessage(error.response.data);
                });
        }

        function showUserResponseMessage(data) {
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1500
            });
        }

        function restoreUser() {
            let btn = document.getElementById('restore-button');
            btn.disabled = true;
            let url = `/crm/users/{{ $user->id }}/restore`;
            axios.put(url)
                .then((response) => {
                    toastr.success(response.data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }).catch((error) => {
                    toastr.error(error.reponse.data.message);
                    btn.disabled = false;
                });
        }
    </script>
@endsection
