@extends('crm.parent')

@section('title', 'Deleted Clients')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Deleted Clients</h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by name or vat number" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('clients.deleted') }}" class="btn btn-primary">
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
                                        <th>Vat</th>
                                        <th>City</th>
                                        <th>Zip Code</th>
                                        <th>Deleted By</th>
                                        <th>Deleted At</th>
                                        <th style="width: 40px">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($clients as $client)
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
                                                <a href="{{ route('clients.show', $client) }}">
                                                    {{ $client->name }}
                                                </a>
                                            </td>
                                            <td>{{ $client->vat }}</td>
                                            <td>{{ $client->city }}</td>
                                            <td>{{ $client->zip }}</td>
                                            <td>
                                                @if (auth()->user()->id == $client->deletedBy->id)
                                                    <a href="{{ route('account.profile') }}">
                                                        {{ $client->deletedBy->name }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('users.show', $client->deletedBy) }}">
                                                        {{ $client->deletedBy->name }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $client->deleted_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="restoreClient({{ $client->id }}, this)"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" style="text-align: center">No Deleted Clients</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-header">
                            <div class="card-tools">
                                {!! $clients->links() !!}
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
        function restoreClient(id, reference) {
            let url = `/crm/clients/${id}/restore`;
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
