@extends('crm.parent')

@section('title', 'Created Tasks')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tasks Created by <a
                                            href="{{ auth()->user()->id == $user->id ? route('account.profile') : route('users.show', $user) }}">{{ $user->name }}</a>
                                    </h3>
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
                                                <th>Assigned Project</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th style="width: 40px">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($tasks as $task)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tasks.show', [$task->project, $task]) }}">
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
                                                        <a href="{{route('projects.show', $task->project)}}">
                                                            {{$task->project->title}}
                                                        </a>
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
                                                            <a href="{{ route('tasks.edit', [$task->project, $task]) }}"
                                                                class="btn btn-info">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                onclick="confirmDelete('{{ route('tasks.destroy', [$task->project, $task]) }}', this)"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" style="text-align: center">No Assgined Tasks for
                                                        {{ $task->user->name }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-header">
                                    <div class="card-tools">
                                        {!! $tasks->links() !!}
                                    </div>
                                </div>
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
@endsection
