@extends('crm.parent')

@section('title', 'Created Projects')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Projects Created By <a
                                    href="{{ auth()->user()->id == $user->id ? route('account.profile') : route('users.show', $user) }}">{{ $user->name }}</a>
                            </h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by title or status" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('users.relations.projects.created', $user) }}"
                                                class="btn btn-primary">
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
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
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
                                                @if (auth()->user()->id == $project->createdBy->id)
                                                    <a href="{{ route('account.profile') }}">
                                                    @else
                                                        <a href="{{ route('users.show', $project->createdBy) }}">
                                                @endif
                                                {{ $project->createdBy->name }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $project->created_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                {{ $project->updated_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if ($project->trashed())
                                                        <button type="button"
                                                            onclick="restoreProject({{ $project->id }}, this)"
                                                            class="btn btn-warning">
                                                            <i class="fas fa-recycle"
                                                                id="button_icon_{{ $project->id }}"></i>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            onclick="confirmDelete('{{ route('projects.destroy', $project) }}', this, {{ $project->id }})"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"
                                                                id="button_icon_{{ $project->id }}"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" style="text-align: center">No Projects To Be Displayed</td>
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
        function confirmDelete(url, reference, id) {
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
                    deleteItem(url, reference, id);
                }
            });
        }

        function deleteItem(url, reference, id) {
            let iconBtn = document.getElementById(`button_icon_${id}`);
            iconBtn.disabled = true;
            axios
                .delete(url)
                .then((response) => {
                    iconBtn.setAttribute('class', 'fas fa-recycle');
                    reference.setAttribute('class', 'btn btn-warning');
                    reference.setAttribute('onclick', `restoreProject(${id}, this)`);
                    showResponseMessage(response.data);
                    iconBtn.disabled = false;
                })
                .catch((error) => {
                    showResponseMessage(error.response.data);
                    iconBtn.disabled = false;
                });
        }

        function restoreProject(id, reference) {
            let iconBtn = document.getElementById(`button_icon_${id}`);
            iconBtn.disabled = true;
            let url = `/crm/projects/${id}/restore`;
            axios.put(url)
                .then((response) => {
                    iconBtn.setAttribute('class', 'fas fa-trash');
                    reference.setAttribute('class', 'btn btn-danger');
                    reference.setAttribute('onclick', `confirmDelete('/crm/projects/${id}', this, ${id})`);
                    toastr.success(response.data.message);
                    iconBtn.disabled = false;
                }).catch((error) => {
                    toastr.error(error.reponse.data.message);
                    iconBtn.disabled = false;
                });
        }
    </script>

@endsection
