@extends('crm.parent')

@section('title', 'Create Task')

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
                            <h3 class="card-title">Create Task</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form" onsubmit="event.preventDefault(); createTask();">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Enter Tasks's Name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" rows="3" placeholder="Enter Project's Description"
                                        style="height: 125px;"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Assigned User</label>
                                    <select id="user" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" value="-1">Select a user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-button">Submit</button>
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-danger">Back</a>
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

        function createTask() {
            let data = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                user: document.getElementById('user').value
            }

            post("{{ route('tasks.store', $project) }}", data, "submit-button", "create-form",
                "{{ route('projects.show', $project) }}")
        }
    </script>
@endsection
