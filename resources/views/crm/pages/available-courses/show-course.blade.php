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
                                        {{ $course->advisor->name }}
                                    </p>

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
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
