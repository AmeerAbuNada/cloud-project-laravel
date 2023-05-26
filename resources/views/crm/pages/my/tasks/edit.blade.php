@extends('crm.parent')

@section('title', 'Edit Task')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Task</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form" onsubmit="event.preventDefault(); editTask();">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ $task->name }}"
                                        placeholder="Enter Tasks's Name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" rows="3" placeholder="Enter Project's Description"
                                        style="height: 125px;">{{ $task->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Assigned User</label>
                                    <select id="user" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" value="-1">Select a user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected($user->id == $task->user->id)>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select id="status" class="form-control" style="width: 100%;">
                                        @foreach (['In Progress', 'Completed', 'Canceled'] as $status)
                                            <option value="{{ $status }}" @selected($status == $task->status)>
                                                {{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-button">Save</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('crm-assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        function editTask() {
            let data = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                user: document.getElementById('user').value,
                status: document.getElementById('status').value
            }

            put("{{ route('my.tasks.update', [$project, $task]) }}", data, "submit-button", undefined,
                "{{ url()->previous() }}")
        }
    </script>
@endsection