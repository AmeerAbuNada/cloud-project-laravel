@extends('crm.parent')

@section('title', 'Created Users')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users Created by <a
                                    href="{{ auth()->user()->id == $user->id ? route('account.profile') : route('users.show', $user) }}">{{ $user->name }}</a>
                            </h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by email or name or role" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('users.relations.users.created', $user) }}"
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Verification</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Role</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
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
                                                @if ($user->id == auth()->user()->id)
                                                    <a href="{{ route('account.profile') }}">
                                                        {{ $user->name }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('users.show', $user) }}">
                                                        {{ $user->name }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{!! $user->email_verification_status !!}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->phone_number }}</td>
                                            <td>
                                                @if ($user->role == 'admin')
                                                    <span class="badge bg-warning">
                                                    @else
                                                        <span class="badge bg-primary">
                                                @endif
                                                {{ $user->role_name }}</span>
                                            </td>
                                            <td>
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
                                            </td>
                                            <td>
                                                {{ $user->created_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                {{ $user->updated_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                @if (auth()->user()->id != $user->id)
                                                    <div class="btn-group">
                                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if ($user->trashed())
                                                            <button type="button"
                                                                onclick="restoreUser({{ $user->id }}, this)"
                                                                class="btn btn-warning">
                                                                <i class="fas fa-recycle"
                                                                    id="button_icon_{{ $user->id }}"></i>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                onclick="confirmDelete('{{ route('users.destroy', $user) }}', this, {{ $user->id }})"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"
                                                                    id="button_icon_{{ $user->id }}"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="badge bg-info">Current Account</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" style="text-align: center">{{ $user->name }} hasn't
                                                created any users</td>
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
                    reference.setAttribute('onclick', `restoreUser(${id}, this)`);
                    showResponseMessage(response.data);
                    iconBtn.disabled = false;
                })
                .catch((error) => {
                    showResponseMessage(error.response.data);
                    iconBtn.disabled = false;
                });
        }

        function restoreUser(id, reference) {
            let iconBtn = document.getElementById(`button_icon_${id}`);
            iconBtn.disabled = true;
            let url = `/crm/users/${id}/restore`;
            axios.put(url)
                .then((response) => {
                    iconBtn.setAttribute('class', 'fas fa-trash');
                    reference.setAttribute('class', 'btn btn-danger');
                    reference.setAttribute('onclick', `confirmDelete('/crm/users/${id}', this, ${id})`);
                    toastr.success(response.data.message);
                    iconBtn.disabled = false;
                }).catch((error) => {
                    toastr.error(error.reponse.data.message);
                    iconBtn.disabled = false;
                });
        }
    </script>
@endsection
