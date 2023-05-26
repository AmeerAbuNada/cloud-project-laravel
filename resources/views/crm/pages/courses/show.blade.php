@extends('crm.parent')

@section('title', 'Course')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">About {{ $course->name }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <strong><i class="fas fa-envelope mr-1"></i> Title</strong>

                                    <p class="text-muted">
                                        {{ $course->title }}
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-phone-alt mr-1"></i> Description</strong>

                                    <p class="text-muted">
                                        {{ $course->description }}
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Is Paid </strong>

                                    <p class="text-muted">{{ $course->is_paid }}</p>

                                    <hr>
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Cost </strong>

                                    <p class="text-muted">${{ $course->cost }}</p>

                                    <hr>

                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Advisor </strong>

                                    <p class="text-muted">
                                        <a href="{{ route('users.show', $course->user_id) }}">
                                            {{ $course->advisor->name }}
                                    </p>
                                    </a>

                                    <hr>

                                    <strong><i class="fad fa-calendar mr-1"></i> Starts At</strong>

                                    <p class="text-muted">{{ $course->starts_at->format('Y M d | h:i a') }}
                                    </p>

                                    <hr>
                                    <strong><i class="fad fa-calendar mr-1"></i> Ends At</strong>

                                    <p class="text-muted">{{ $course->ends_at->format('Y M d | h:i a') }}
                                    </p>

                                    <hr>

                                    <strong><i class="fad fa-calendar mr-1"></i> Created At</strong>

                                    <p class="text-muted">{{ $course->created_at->format('Y M d | h:i a') }}
                                    </p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Assigned Trainees</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
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
                                            @forelse ($course->users as $user)
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
                                                        <img src="{{ $user->image_url }}" width="60px" alt="">
                                                    </td>
                                                    <td>
                                                        {{ $user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $user->email }}
                                                    </td>
                                                    <td>
                                                        {{ $user->phone_number ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $user->address ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $user->created_at->format('Y M d | H:i') }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                onclick="confirmDelete('{{ route('managers.destroy', $user) }}', this)"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" style="text-align: center">No Trainees To Be
                                                        Displayed</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
