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
                                @if ($course->assinged)
                                    <div class="row" style="flex-wrap: wrap; gap: 10px">
                                        <button class="btn btn-success mb-2" style="width: 20%"
                                            onclick="attend(this)">Attend</button>
                                        <button class="btn btn-warning mb-2" style="width: 20%"
                                            onclick="openModal()">Request Meeting</button>
                                    </div>
                                @endif
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
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" style="text-align: center">No Assigned Trainees</td>
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


        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Request a meeting</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" onsubmit="event.preventDefault(); editProfile();">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Subject</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Time</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" id="time">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="requestMeeting(this)">Request</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var modal = document.getElementById('modal-default');
        var modalInstance = new bootstrap.Modal(modal);

        function attend(ref) {
            ref.disabled = true;
            axios.post(`/attend/{{ $course->id }}`)
                .then((response) => {
                    toastr.success(response.data.message);
                })
                .catch((error) => {
                    toastr.error(error.response.data.message)
                })
                .finally(() => {
                    ref.disabled = false;
                })
        }

        function requestMeeting(ref) {
            ref.disabled = true;
            let data = {
                subject: document.getElementById('subject').value,
                time: document.getElementById('time').value,
            }
            axios.post(`/meeting/{{ $course->id }}`, data)
                .then((response) => {
                    toastr.success(response.data.message);
                    closeModal();
                })
                .catch((error) => {
                    toastr.error(error.response.data.message)
                })
                .finally(() => {
                    ref.disabled = false;
                })
        }

        function openModal() {
            modalInstance.show();
        }

        function closeModal() {
            modalInstance.hide();
        }
    </script>
@endsection
