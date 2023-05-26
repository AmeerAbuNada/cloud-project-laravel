@extends('crm.parent')

@section('title', 'Registrations')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registrations</h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by name or vat number" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('registrations.index') }}" class="btn btn-primary">
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
                                        <th>Imaga</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Numebr</th>
                                        <th>Address</th>
                                        <th>Created At</th>
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
                                                <img src="{{ $user->image_url }}" width="100px" alt="">
                                            </td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                {{ $user->phone_number }}
                                            </td>
                                            <td>
                                                {{ $user->address }}
                                            </td>
                                            <td>
                                                {{ $user->created_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('users.show', $user) }}" class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" onclick="deny({{ $user->id }}, this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button type="button" onclick="accept({{ $user->id }}, this)"
                                                        class="btn btn-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center">No Registrations To Be Displayed</td>
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
        function accept(id, ref) {
            ref.disabled = true;
            axios.post(`/registrations/${id}/accept`)
                .then((response) => {
                    toastr.success(response.data.message)
                    ref.closest('tr').remove();
                })
                .catch((error) => {
                    ref.disabled = false;
                    toastr.error(error.response.data.message)
                })
        }

        function deny(id, ref) {
            ref.disabled = true;
            axios.post(`/registrations/${id}/accept`)
                .then((response) => {
                    toastr.success(response.data.message)
                    ref.closest('tr').remove();
                })
                .catch((error) => {
                    ref.disabled = false;
                    toastr.error(error.response.data.message)
                })
        }
    </script>

@endsection
