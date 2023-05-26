@extends('crm.parent')

@section('title', 'Clients')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Clients</h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by name or vat number" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('clients.index') }}" class="btn btn-primary">
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
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
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
                                                @if (auth()->user()->id == $client->createdBy->id)
                                                    <a href="{{ route('account.profile') }}">
                                                        {{ $client->createdBy->name }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('users.show', $client->createdBy) }}">
                                                        {{ $client->createdBy->name }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $client->created_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                {{ $client->updated_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ route('clients.destroy', $client) }}', this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center">No Clients To Be Displayed</td>
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

@endsection
