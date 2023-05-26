@extends('crm.parent')

@section('title', 'Task')

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
                            <h3 class="profile-username text-center">Manage Task
                            </h3>
                            <br>

                            <a href="{{ route('my.tasks.edit', [$project, $task]) }}"
                                class="btn btn-primary btn-block"><b>Edit</b></a>
                            @if ($project->user_id == auth()->user()->id)
                                <button type="button" onclick="confirmDeleteItem()"
                                    class="btn btn-danger btn-block"><b>Delete</b></button>
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
                                {{ $task->user->name }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted">
                                {{ $task->user->email }} {!! $task->user->email_verification_status !!}
                            </p>

                            <hr>

                            <strong><i class="fas fa-phone-alt mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $task->user->phone_number }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                            <p class="text-muted">{{ $task->user->address }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fad fa-address-card"></i> &nbsp; Assigned Project
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fad fa-project-diagram mr-1"></i> Title</strong>

                            <p class="text-muted">
                                <a href="{{ route('my.projects.show', $project) }}">
                                    {{ $project->title }}
                                </a>
                            </p>

                            <hr>

                            <strong><i class="fad fa-map-marked-alt mr-1"></i> Deadline</strong>

                            <p class="text-muted">{{ $project->deadline }}</p>

                            <hr>
                            <strong><i class="fad fa-info-circle mr-1"></i> Status</strong>

                            <p class="text-muted">{!! $project->status_value !!}</p>

                            <hr>

                            <strong><i class="fas fa-plus mr-1"></i> Assigned To</strong>
                            <p class="text-muted">
                                {{ $project->user->name }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $project->created_at->format('Y M d | h:i a') }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fad fa-address-card"></i> &nbsp; About {{ $task->name }}
                            </h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fad fa-project-diagram mr-1"></i> Name</strong>

                            <p class="text-muted">
                                {{ $task->name }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-fingerprint mr-1"></i> Description</strong>

                            <p class="text-muted">
                                {{ $task->description }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-info-circle mr-1"></i> Status</strong>

                            <p class="text-muted">{!! $task->status_value !!}</p>

                            <hr>

                            <strong><i class="fad fa-building mr-1"></i> Assigned Client</strong>

                            <p class="text-muted">
                                {{ $task->project->client->name }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-plus mr-1"></i> Created By</strong>

                            <p class="text-muted">
                                {{ $project->createdBy->name }}
                            </p>

                            <hr>

                            <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $project->created_at->format('Y M d | h:i a') }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-12">
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
                                            @forelse ($files as $file)
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
                                                        {{ $file->uploadedBy->name }}
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
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
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

        function confirmDeleteItem() {
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
                    deleteTask();
                }
            });
        }

        function deleteTask() {
            axios
                .delete('{{ route('my.tasks.destroy', [$project, $task]) }}')
                .then((response) => {
                    showMessage(response.data);
                    setTimeout(() => {
                        window.location.href = '{{ route('my.projects.show', $project) }}';
                    }, 1300);
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
            formData.append('for', 'task');
            formData.append('file_name', document.getElementById('file_name').value);
            if (document.getElementById('file').files.length > 0) {
                formData.append('file', document.getElementById('file').files[0]);
            }

            post("{{ route('my.files.upload', $task) }}", formData, "upload-button", "create-form",
                "{{ URL::current() }}")
        }

        function deleteFile(id, reference) {
            let url = `/crm/my/projects/{{ $project->id }}/tasks/{{ $task->id }}/upload-file/${id}/delete`;
            confirmDelete(url, reference);
        }
    </script>
@endsection
