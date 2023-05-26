@extends('crm.parent')

@section('title', 'Deleted Users')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Deleted Users</h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by email or name or role" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('users.deleted') }}" class="btn btn-primary">
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Role</th>
                                        <th>Deleted By</th>
                                        <th>Deleted At</th>
                                        <th style="width: 40px">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
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
                                                <a href="{{ route('users.show', $user) }}">
                                                    {{ $user->name }}
                                                </a>
                                            </td>
                                            <td>{{ $user->email }} <span class="badge bg-success">verified</span></td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->phone_number }}</td>
                                            <td>
                                                @if ($user->role == 'admin')
                                                    <span class="badge bg-warning">Admin</span>
                                                @else
                                                    <span class="badge bg-primary">User</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->deletedBy->id == auth()->user()->id)
                                                    <a href="{{ route('account.profile') }}">
                                                    @else
                                                        <a href="{{ route('users.show', $user->deletedBy) }}">
                                                @endif
                                                {{ $user->deletedBy->name }}</a>
                                            </td>
                                            <td>
                                                {{ $user->deleted_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" onclick="restoreUser({{ $user->id }}, this)"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center">No Deleted Users</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-header">
                            <div class="card-tools">
                                {!! $users->links() !!}
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
        function restoreUser(id, reference) {
            let url = `/crm/users/${id}/restore`;
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
