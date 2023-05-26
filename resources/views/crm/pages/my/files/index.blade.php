@extends('crm.parent')

@section('title', 'Uploaded Files')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12" id="files-table">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">My Uploaded Files</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>File</th>
                                                <th>Uploaded To</th>
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
                                                        @if ($file->related_item instanceof App\Models\Project)
                                                            <a href="{{ route('my.projects.show', $file->related_item) }}">
                                                                {{ $file->related_item->title }}
                                                            </a>
                                                            (Project)
                                                        @elseif ($file->related_item instanceof App\Models\Task)
                                                            <a
                                                                href="{{ route('my.tasks.show', [$file->related_item->project, $file->related_item]) }}">
                                                                {{ $file->related_item->name }}
                                                            </a>
                                                            (Task)
                                                        @endif
                                                    </td>
                                                    <td>{{ $file->created_at->format('Y M d | h:i a') }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                            @if ($file->related_item instanceof App\Models\Project)
                                                            onclick="deleteFileProject({{ $file->id }}, this, {{$file->related_item->id}})"
                                                            @elseif ($file->related_item instanceof App\Models\Task)
                                                            onclick="deleteFileTask({{ $file->id }}, this, {{$file->related_item->project->id}}, {{$file->related_item->id}})"
                                                            @endif
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" style="text-align: center">
                                                        You didn't upload any files
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
        function deleteFileProject(id, reference, projectId) {
            let url = `/crm/my/projects/${projectId}/upload-file/${id}/delete`;
            confirmDelete(url, reference);
        }

        function deleteFileTask(id, reference, projectId, taskId) {
            let url =
                `/crm/my/projects/${projectId}/tasks/${taskId}/upload-file/${id}/delete`;
            confirmDelete(url, reference);
        }
    </script>
@endsection
