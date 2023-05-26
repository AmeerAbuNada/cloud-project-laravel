@extends('crm.parent')

@section('title', 'Client Profile')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($client->trashed())
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5 style="margin-bottom: 0px"><i class="icon fas fa-ban"></i> This Client has been Deleted</h5>
                        </div>
                    </div>
                @endif
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card @if ($client->trashed()) card-danger @else card-primary @endif card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{ $client->name }} @if ($client->trashed())
                                    <span class="badge bg-danger"><i class="fas fa-ban"></i> Deleted</span>
                                @endif
                            </h3>
                            <br>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Projects</b> <a href="{{route('clients.relations.projects', $client)}}" class="float-right">{{$client->projects_count}} Projects</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tasks</b> <a href="{{route('clients.relations.tasks', $client)}}" class="float-right">{{$client->tasks_count}} Tasks</a>
                                </li>
                            </ul>

                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary btn-block"><b>Edit</b></a>
                            @if (!$client->trashed())
                                <button type="button" onclick="confirmDeleteClient()"
                                    class="btn btn-danger btn-block"><b>Delete</b></button>
                            @else
                                <button id="restore-button" type="button" onclick="restoreClient()"
                                    class="btn btn-warning btn-block"><b>Restore</b></button>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fad fa-address-book"></i> &nbsp; Contact Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fad fa-address-book mr-1"></i> Contact Name</strong>

                            <p class="text-muted">
                                {{ $client->contact_name }}
                            </p>

                            <hr>
                            <strong><i class="fad fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted">
                                {{ $client->contact_email }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-phone-alt mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $client->contact_phone_number }}
                            </p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    @if ($client->trashed())
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-ban"></i> Deletion Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fad fa-trash"></i> Deleted By</strong>

                                <p class="text-muted">
                                    @if (auth()->user()->id == $client->deletedBy->id)
                                        <a href="{{ route('account.profile') }}">
                                        @else
                                            <a href="{{ route('users.show', $client->deletedBy) }}">
                                    @endif
                                    {{ $client->deletedBy->name }}</a>
                                </p>

                                <hr>

                                <strong><i class="fad fa-calendar mr-1"></i> Deleted At</strong>

                                <p class="text-muted">
                                    {{ $client->deleted_at->format('Y M d | h:i a') }}
                                </p>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fad fa-address-card"></i> &nbsp; About {{ $client->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fad fa-building mr-1"></i> Client</strong>

                            <p class="text-muted">
                                {{ $client->name }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-fingerprint mr-1"></i> Vat Number</strong>

                            <p class="text-muted">
                                {{ $client->vat }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-map-marked-alt mr-1"></i> Address</strong>

                            <p class="text-muted">{{ $client->address }}</p>

                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> City</strong>

                            <p class="text-muted">{{ $client->city }}</p>

                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Zip Code</strong>

                            <p class="text-muted">{{ $client->zip }}</p>

                            <hr>

                            <strong><i class="fas fa-plus mr-1"></i> Created By</strong>

                            <p class="text-muted">
                                @if (auth()->user()->id == $client->createdBy->id)
                                    <a href="{{ route('account.profile') }}">
                                        {{ $client->createdBy->name }}
                                    </a>
                                @else
                                    <a href="{{ route('users.show', $client->createdBy) }}">
                                        {{ $client->createdBy->name }}
                                    </a>
                                @endif
                            </p>

                            <hr>

                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $client->created_at->format('Y M d | h:i a') }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script>
        function confirmDeleteClient() {
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
                    deleteClient();
                }
            });
        }

        function deleteClient() {
            axios
                .delete('{{ route('clients.destroy', $client) }}')
                .then((response) => {
                    showClientResponseMessage(response.data);
                    setTimeout(() => {
                        location.reload();
                    }, 1300);
                })
                .catch((error) => {
                    showClientResponseMessage(error.response.data);
                });
        }

        function showClientResponseMessage(data) {
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1500
            });
        }

        function restoreClient() {
            let btn = document.getElementById('restore-button');
            btn.disabled = true;
            let url = `/crm/clients/{{ $client->id }}/restore`;
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
