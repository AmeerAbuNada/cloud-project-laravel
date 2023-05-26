@extends('crm.parent')

@section('title', 'Courses')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Courses</h3>
                            <div class="card-tools">
                                <form method="GET" class="input-group input-group-sm" style="width: 270px;">
                                    <input type="text" name="search" class="form-control float-right"
                                        placeholder="Search by name or vat number" value="{{ request()->search }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset(request()->search))
                                            <a href="{{ route('courses.index') }}" class="btn btn-primary">
                                                All
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="card-tools" style="float: left; margin-left: 30px">
                                <div class="input-group-append">
                                    <a href="{{ route('courses.create') }}" class="btn btn-success">
                                        Create New Course
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Advisor</th>
                                        <th>Starts At</th>
                                        <th>Ends At</th>
                                        <th>Is Paid</th>
                                        <th>Cost</th>
                                        <th>Created At</th>
                                        <th style="width: 40px">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courses as $course)
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
                                                <a href="{{ route('courses.show', $course) }}">
                                                    {{ $course->title }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('users.show', $course->advisor->id) }}">
                                                    {{ $course->advisor->name }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $course->starts_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                {{ $course->ends_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                {{ $course->is_paid }}
                                            </td>
                                            <td>
                                                ${{ $course->cost }}
                                            </td>
                                            <td>
                                                {{ $course->created_at->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ route('courses.destroy', $course) }}', this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center">No Courses To Be Displayed</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-header">
                            <div class="card-tools">
                                {!! $courses->links() !!}
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
