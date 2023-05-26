@extends('crm.parent')

@section('title', 'My Meetings')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Meetings</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Subject</th>
                                        <th>Advisor</th>
                                        <th>Starts At</th>
                                        <th>Ends At</th>
                                        <th>Status</th>
                                        <th style="width: 40px">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($meetings as $meeting)
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
                                                {{ $meeting->subject }}
                                            </td>
                                            <td>
                                                {{ $meeting->advisor->name }}
                                            </td>
                                            <td>
                                                {{ $meeting->time->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                {{ $meeting->time->addHour()->format('Y M d | H:i') }}
                                            </td>
                                            <td>
                                                {{ $meeting->is_accepted ? 'Accepted' : 'Pending' }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if (auth()->user()->role == 'advisor')
                                                        @if (!$meeting->is_accepted)
                                                            <button type="button"
                                                                onclick="acceptMeet({{ $meeting->id }}, this)"
                                                                class="btn btn-success">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                    <button type="button" onclick="removeCourse({{ $meeting->id }}, this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center">No Meetings To Be Displayed</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-header">
                            <div class="card-tools">
                                {!! $meetings->links() !!}
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
        function removeCourse(id, ref) {
            ref.disabled = true;
            axios.delete(`/myMeetings/${id}`)
                .then((response) => {
                    toastr.success(response.data.message);
                    ref.closest('tr').remove();
                })
                .catch((error) => {
                    ref.disabled = false;
                    toastr.error(error.response.data.message);
                })
        }

        @if (auth()->user()->role == 'advisor')
            function acceptMeet(id, ref) {
                ref.disabled = true;
                axios.put(`/myMeetings/${id}`)
                    .then((response) => {
                        toastr.success(response.data.message);
                        ref.remove();
                    })
                    .catch((error) => {
                        ref.disabled = false;
                        toastr.error(error.response.data.message);
                    })
            }
        @endif
    </script>
@endsection
