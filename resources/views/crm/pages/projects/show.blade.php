@extends('crm.parent')

@section('title', 'Project')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($project->trashed())
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5 style="margin-bottom: 0px"><i class="icon fas fa-ban"></i> This Project has been Deleted</h5>
                        </div>
                    </div>
                @endif
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card @if ($project->trashed()) card-danger @else card-primary @endif card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">Manage Project
                            </h3>
                            <br>

                            <a href="{{ route('projects.edit', $project) }}"
                                class="btn btn-primary btn-block"><b>Edit</b></a>
                            @if (!$project->trashed())
                                <button type="button" onclick="confirmDeleteItem()"
                                    class="btn btn-danger btn-block"><b>Delete</b></button>
                            @else
                                <button id="restore-button" type="button" onclick="restoreProject()"
                                    class="btn btn-warning btn-block"><b>Restore</b></button>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Assigned User -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fad fa-user"></i> &nbsp; Assigned User</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-envelope mr-1"></i> Name</strong>

                            <p class="text-muted">
                                @if (auth()->user()->id == $project->user->id)
                                    <a href="{{ route('account.profile') }}">
                                        {{ $project->user->name }}
                                    </a>
                                @else
                                    <a href="{{ route('users.show', $project->user) }}">
                                        {{ $project->user->name }}
                                    </a>
                                @endif
                            </p>

                            <hr>

                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted">
                                {{ $project->user->email }} {!! $project->user->email_verification_status !!}
                            </p>

                            <hr>

                            <strong><i class="fas fa-phone-alt mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $project->user->phone_number }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                            <p class="text-muted">{{ $project->user->address }}</p>

                            <hr>

                            <strong><i class="fas fa-plus mr-1"></i> Created By</strong>

                            <p class="text-muted">
                                @if ($project->user->created_by_system)
                                    <span class="badge bg-info">Created By The System</span>
                                @else
                                    @if (auth()->user()->id == $project->user->createdBy->id)
                                        <a href="{{ route('account.profile') }}">
                                            {{ $project->user->createdBy->name }}
                                        </a>
                                    @else
                                        <a href="{{ route('users.show', $project->user->createdBy) }}">
                                            {{ $project->user->createdBy->name }}
                                        </a>
                                    @endif
                                @endif
                            </p>

                            <hr>

                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $project->user->created_at->format('Y M d | h:i a') }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Assigned Client -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fad fa-address-card"></i> &nbsp; Assigned Client</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fad fa-building mr-1"></i> Client</strong>

                            <p class="text-muted">
                                <a href="{{ route('clients.show', $project->client) }}">
                                    {{ $project->client->name }}
                                </a>
                            </p>

                            <hr>

                            <strong><i class="fad fa-fingerprint mr-1"></i> Vat Number</strong>

                            <p class="text-muted">
                                {{ $project->client->vat }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-map-marked-alt mr-1"></i> Address</strong>

                            <p class="text-muted">{{ $project->client->address }}</p>

                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> City</strong>

                            <p class="text-muted">{{ $project->client->city }}</p>

                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Zip Code</strong>

                            <p class="text-muted">{{ $project->client->zip }}</p>

                            <hr>

                            <strong><i class="fas fa-plus mr-1"></i> Created By</strong>

                            <p class="text-muted">
                                @if (auth()->user()->id == $project->client->createdBy->id)
                                    <a href="{{ route('account.profile') }}">
                                        {{ $project->client->createdBy->name }}
                                    </a>
                                @else
                                    <a href="{{ route('users.show', $project->client->createdBy) }}">
                                        {{ $project->client->createdBy->name }}
                                    </a>
                                @endif
                            </p>

                            <hr>

                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $project->client->created_at->format('Y M d | h:i a') }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    @if ($project->trashed())
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-ban"></i> Deletion Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fad fa-trash"></i> Deleted By</strong>

                                <p class="text-muted">
                                    @if (auth()->user()->id == $project->deletedBy->id)
                                        <a href="{{ route('account.profile') }}">
                                        @else
                                            <a href="{{ route('users.show', $project->deletedBy) }}">
                                    @endif
                                    {{ $project->deletedBy->name }}</a>
                                </p>

                                <hr>

                                <strong><i class="fad fa-calendar mr-1"></i> Deleted At</strong>

                                <p class="text-muted">
                                    {{ $project->deleted_at->format('Y M d | h:i a') }}
                                </p>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fad fa-address-card"></i> &nbsp; About {{ $project->title }}
                            </h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fad fa-project-diagram mr-1"></i> Title</strong>

                            <p class="text-muted">
                                {{ $project->title }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-fingerprint mr-1"></i> Description</strong>

                            <p class="text-muted">
                                {{ $project->description }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-map-marked-alt mr-1"></i> Deadline</strong>

                            <p class="text-muted">{{ $project->deadline }}</p>

                            <hr>
                            <strong><i class="fad fa-info-circle mr-1"></i> Status</strong>

                            <p class="text-muted">{!! $project->status_value !!}</p>

                            <hr>

                            <strong><i class="fas fa-plus mr-1"></i> Created By</strong>

                            <p class="text-muted">
                                @if (auth()->user()->id == $project->createdBy->id)
                                    <a href="{{ route('account.profile') }}">
                                        {{ $project->createdBy->name }}
                                    </a>
                                @else
                                    <a href="{{ route('users.show', $project->createdBy) }}">
                                        {{ $project->createdBy->name }}
                                    </a>
                                @endif
                            </p>

                            <hr>

                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $project->created_at->format('Y M d | h:i a') }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="files-table">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Files</h3>
                                    <div class="card-tools">
                                        <button type="button" id="show-upload-button" onclick="showUpload()"
                                            class="btn btn-success">
                                            <i class="fad fa-upload"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>File</th>
                                                <th>Uploaded By</th>
                                                <th>Uploaded At</th>
                                                <th style="width: 40px">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($project->files as $file)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ Storage::url($file->path) }}">
                                                            {{ $file->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if ($file->uploadedBy->id == auth()->user()->id)
                                                            <a href="{{ route('account.profile') }}">
                                                                {{ $file->uploadedBy->name }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('users.show', $file->uploadedBy) }}">
                                                                {{ $file->uploadedBy->name }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $file->created_at->format('Y M d | h:i a') }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                onclick="deleteFile({{ $file->id }}, this)"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" style="text-align: center">No Uploaded Files
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div id="upload-form" class="col-md-4" style="display: none">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Upload a File</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="create-form" onsubmit="event.preventDefault(); uploadFile();">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="file_name"
                                                placeholder="Enter File's Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="file">File</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file">
                                                    <label class="custom-file-label" for="file">Choose
                                                        File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" id="upload-button">Upload</button>
                                        <button type="button" onclick="cancelUpload()" class="btn btn-danger"
                                            id="cancel-upload">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tasks <span class="badge bg-info">{{ $project->tasks->count() }}</span>
                                    </h3>
                                    <div class="card-tools">
                                        <a href="{{ route('tasks.create', $project) }}" class="btn btn-success">
                                            Create
                                        </a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Assigned User</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th style="width: 40px">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($project->tasks as $task)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tasks.show', [$project, $task]) }}">
                                                            {{ $task->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {!! $task->status_value !!}
                                                    </td>
                                                    <td>
                                                        @if ($task->user->id == auth()->user()->id)
                                                            <a href="{{ route('account.profile') }}">
                                                                {{ $task->user->name }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('users.show', $task->user) }}">
                                                                {{ $task->user->name }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($task->createdBy->id == auth()->user()->id)
                                                            <a href="{{ route('account.profile') }}">
                                                                {{ $task->createdBy->name }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('users.show', $task->createdBy) }}">
                                                                {{ $task->createdBy->name }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $task->created_at->format('Y M d | h:i a') }}</td>
                                                    <td>{{ $task->updated_at->format('Y M d | h:i a') }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('tasks.edit', [$project, $task]) }}"
                                                                class="btn btn-info">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                onclick="confirmDeleteItem('task', {{ $task->id }}, this)"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" style="text-align: center">No Created Tasks, <a
                                                            href="{{ route('tasks.create', $project) }}">Create Now</a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
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
        const table = document.getElementById('files-table');
        const uploadForm = document.getElementById('upload-form');
        const showUploadBtn = document.getElementById('show-upload-button');

        function confirmDeleteItem(type, id, reference) {
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
                    if (type != undefined) {
                        if (type == 'task') {
                            deleteTask(id, reference);
                        }
                    } else {
                        deleteProject();
                    }
                }
            });
        }

        function deleteProject() {
            axios
                .delete('{{ route('projects.destroy', $project) }}')
                .then((response) => {
                    showMessage(response.data);
                    setTimeout(() => {
                        location.reload();
                    }, 1300);
                })
                .catch((error) => {
                    showMessage(error.response.data);
                });
        }

        function deleteTask(id, reference) {
            axios
                .delete(`{{ URL::current() }}/tasks/${id}`)
                .then((response) => {
                    reference.closest('tr').remove();
                    showMessage(response.data);
                })
                .catch((error) => {
                    showMessage(error.response.data);
                });
        }

        function showMessage(data) {
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1500
            });
        }

        function restoreProject() {
            let btn = document.getElementById('restore-button');
            btn.disabled = true;
            let url = `/crm/projects/{{ $project->id }}/restore`;
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

        function showUpload() {
            table.setAttribute('class', 'col-md-8');
            uploadForm.setAttribute('style', 'display: block');
            showUploadBtn.setAttribute('style', 'display: none');
        }

        function cancelUpload() {
            showUploadBtn.setAttribute('style', 'display: block');
            uploadForm.setAttribute('style', 'display: none');
            table.setAttribute('class', 'col-md-12');
        }

        function uploadFile() {
            let formData = new FormData();
            formData.append('for', 'project');
            formData.append('file_name', document.getElementById('file_name').value);
            if (document.getElementById('file').files.length > 0) {
                formData.append('file', document.getElementById('file').files[0]);
            }

            post("{{ route('files.upload', $project) }}", formData, "upload-button", "create-form",
                "{{ URL::current() }}")
        }

        function deleteFile(id, reference) {
            let url = `/crm/projects/{{ $project->id }}/upload-file/${id}/delete`;
            confirmDelete(url, reference);
        }
    </script>
@endsection
