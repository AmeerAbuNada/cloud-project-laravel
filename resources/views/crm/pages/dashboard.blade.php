@extends('crm.parent')

@section('title', 'Home')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            @if (auth()->user()->is_admin)
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"
                                onclick="window.location.href = '{{ route('users.index') }}'" style="cursor: pointer"><i
                                    class="fad fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total User</span>
                                <span class="info-box-number">{{ $users_count }} <small>Users</small></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"
                                onclick="window.location.href = '{{ route('clients.index') }}'" style="cursor: pointer"><i
                                    class="fad fa-building"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Clients</span>
                                <span class="info-box-number">
                                    {{ $clients_count }}
                                    <small>Clients</small>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"
                                onclick="window.location.href = '{{ route('projects.index') }}'" style="cursor: pointer"><i
                                    class="fad fa-project-diagram"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Projects</span>
                                <span class="info-box-number">{{ $projects_count }} <small>Projects</small></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fad fa-tasks"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Tasks</span>
                                <span class="info-box-number">{{ $tasks_count }} <small>Tasks</small></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Status Statistics</h5>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-center">
                                            <strong>Projects</strong>
                                        </p>
                                        <div class="progress-group">
                                            <span class="progress-text">Completed Projects</span>
                                            <span
                                                class="float-right"><b>{{ $completed_projects }}</b>/{{ $projects_count }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success"
                                                    @if ($projects_count == 0) style="width: 0%"
                                                @else
                                                style="width: {{ ($completed_projects / $projects_count) * 100 }}%" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="progress-group">
                                            <span class="progress-text">In Progress Projects</span>
                                            <span
                                                class="float-right"><b>{{ $inProgress_projects }}</b>/{{ $projects_count }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-primary"
                                                    @if ($projects_count == 0) style="width: 0%"
                                            @else
                                            style="width: {{ ($inProgress_projects / $projects_count) * 100 }}%" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="progress-group">
                                            <span class="progress-text">Canceled Projects</span>
                                            <span
                                                class="float-right"><b>{{ $canceled_projects }}</b>/{{ $projects_count }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-danger"
                                                    @if ($projects_count == 0) style="width: 0%"
                                            @else
                                            style="width: {{ ($canceled_projects / $projects_count) * 100 }}%" @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <p class="text-center">
                                            <strong>Tasks</strong>
                                        </p>

                                        <div class="progress-group">
                                            <span class="progress-text">Completed Tasks</span>
                                            <span
                                                class="float-right"><b>{{ $completed_tasks }}</b>/{{ $tasks_count }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success"
                                                    @if ($tasks_count == 0) style="width: 0%"
                                            @else
                                            style="width: {{ ($completed_tasks / $tasks_count) * 100 }}%" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="progress-group">
                                            <span class="progress-text">In Progress Tasks</span>
                                            <span
                                                class="float-right"><b>{{ $inProgress_tasks }}</b>/{{ $tasks_count }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-primary"
                                                    @if ($tasks_count == 0) style="width: 0%"
                                            @else
                                            style="width: {{ ($inProgress_tasks / $tasks_count) * 100 }}%" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="progress-group">
                                            <span class="progress-text">Canceled Tasks</span>
                                            <span
                                                class="float-right"><b>{{ $canceled_tasks }}</b>/{{ $tasks_count }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-danger"
                                                    @if ($tasks_count == 0) style="width: 0%"
                                            @else
                                            style="width: {{ ($canceled_tasks / $tasks_count) * 100 }}%" @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            @endif
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    @if (auth()->user()->is_admin)
                        <!-- MAP & BOX PANE -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- USERS LIST -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Latest Members</h3>

                                        <div class="card-tools">
                                            <span class="badge badge-danger">Latest 4 Members</span>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <ul class="users-list clearfix">
                                            @foreach ($users as $user)
                                                <li>
                                                    <img src="{{ $user->image_url }}" style="width: 120px"
                                                        alt="User Image">
                                                    @if (auth()->user()->id == $user->id)
                                                        <a class="users-list-name"
                                                            href="{{ route('account.profile') }}">{{ $user->name }}</a>
                                                    @else
                                                        <a class="users-list-name"
                                                            href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                                                    @endif
                                                    <span
                                                        class="users-list-date">{{ $user->created_at->format('Y M d | H:i') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <!-- /.users-list -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer text-center">
                                        <a href="javascript:">View All Users</a>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                                <!--/.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    @endif
                    <!-- TABLE: LATEST ORDERS -->
                    @if (auth()->user()->is_admin)
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Latest 8 Projects</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Client</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a href="{{ route('projects.show', $project) }}">
                                                            {{ $project->title }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('clients.show', $project->client) }}">
                                                            {{ $project->client->name }}
                                                        </a>
                                                    </td>
                                                    <td>{!! $project->status_value !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary float-left">View
                                    All
                                    Projects</a>
                                <a href="{{ route('projects.create') }}"
                                    class="btn btn-sm btn-success float-right">Create a
                                    New Project</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Latest 15 Projects</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Client</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a href="{{ route('my.projects.show', $project) }}">
                                                            {{ $project->title }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $project->client->name }}
                                                    </td>
                                                    <td>{!! $project->status_value !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="{{ route('my.projects.index') }}" class="btn btn-sm btn-primary float-left">View
                                    All
                                    Projects</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    @endif
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-4">
                    @if (auth()->user()->is_admin)
                        <!-- Info Boxes Style 2 -->
                        <a href="{{ route('users.deleted') }}">
                            <div class="info-box mb-3 bg-danger">
                                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Deleted Users</span>
                                    <span class="info-box-number">{{ $deleted_users }} Users</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                        <a href="{{ route('clients.deleted') }}">
                            <div class="info-box mb-3 bg-danger">
                                <span class="info-box-icon"><i class="far fa-heart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Deleted Client</span>
                                    <span class="info-box-number">{{ $deleted_clients }} Clients</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                        <a href="{{ route('projects.deleted') }}">
                            <div class="info-box mb-3 bg-danger">
                                <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Deleted Projects</span>
                                    <span class="info-box-number">{{ $deleted_projects }} Projects</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    @endif

                    @if (auth()->user()->is_admin)
                        <!-- PRODUCT LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Latest 6 Clients</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    @foreach ($clients as $client)
                                        <li class="item">
                                            <div class="product-img">
                                                <i class="fad fa-building" style="font-size: 48px"></i>
                                            </div>
                                            <div class="product-info">
                                                <a href="{{route('clients.show', $client)}}" class="product-title">{{ $client->name }}
                                                    <span
                                                        class="badge badge-warning float-right">{{ $client->vat }}</span></a>
                                                <span class="product-description">
                                                    {{ $client->address }}
                                                </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('clients.index') }}" class="uppercase">View All Clients</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">My 15 Latest Tasks</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    @foreach ($tasks as $task)
                                        <li class="item">
                                            <div class="product-img">
                                                <i class="fad fa-building" style="font-size: 48px"></i>
                                            </div>
                                            <div class="product-info">
                                                <a href="{{ route('my.tasks.show', [$task->project, $task]) }}"
                                                    class="product-title">{{ $task->name }}
                                                    <span
                                                        class="badge badge-warning float-right">{{ $task->vat }}</span></a>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('my.tasks.index') }}" class="uppercase">View All Tasks</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    @endif
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!--/. container-fluid -->
    </section>
@endsection

@section('scripts')
@endsection
