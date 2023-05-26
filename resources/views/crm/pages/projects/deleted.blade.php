@extends('crm.parent')

@section('title', 'Deleted Projects')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Deleted Projects</h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by title or status" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('projects.deleted') }}" class="btn btn-primary">
                                                All
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Deadline</th>
                                        <th>Assigned User</th>
                                        <th>Assigned Client</th>
                                        <th>Status</th>
                                        <th>Deleted By</th>
                                        <th>Deleted At</th>
                                        <th style="width: 40px">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($projects as $project)
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
                                                <a href="{{ route('projects.show', $project) }}">
                                                    {{ $project->title }}
                                                </a>
                                            </td>
                                            <td>{{ $project->deadline }}</td>
                                            <td>
                                                @if (auth()->user()->id == $project->user->id)
                                                    <a href="{{ route('account.profile') }}">
                                                    @else
                                                        <a href="{{ route('users.show', $project->user) }}">
                                                @endif
                                                {{ $project->user->name }}</a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('clients.show', $project->client) }}">{{ $project->client->name }}</a>
                                            </td>
                                            <td>{!! $project->status_value !!}</td>
                                            <td>
                                                @if (auth()->user()->id == $project->deletedBy->id)
                                                    <a href="{{ route('account.profile') }}">
                                                    @else
                                                        <a href="{{ route('users.show', $project->deletedBy) }}">
                                                @endif
                                                {{ $project->deletedBy->name }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $project->deleted_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="restoreProject({{ $project->id }}, this)"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center">No Deleted Projects</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-header">
                            <div class="card-tools">
                                {!! $projects->links() !!}
                            </div>
                        </div>
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
        function restoreProject(id, reference) {
            let url = `/crm/projects/${id}/restore`;
            axios.put(url)
                .then((response) => {
                    toastr.success(response.data.message);
                    reference.closest('tr').remove();
                }).catch((error) => {
                    toastr.error(error.reponse.data.message);
                });
        }
    </script>
@endsection
