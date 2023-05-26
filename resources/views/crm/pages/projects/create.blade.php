@extends('crm.parent')

@section('title', 'Create Project')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <form class="row" id="create-form" onsubmit="event.preventDefault(); createProject();">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Project's Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title"
                                        placeholder="Enter Project's Title">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" rows="3" placeholder="Enter Project's Description"
                                        style="height: 125px;"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="deadline">Deadline</label>
                                    <input type="date" class="form-control" id="deadline">
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
                                <div class="form-group">
                                    <label>Assigned Client</label>
                                    <select id="client" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" value="-1">Select a client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-button">Create</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </form>
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

        function createProject() {
            let data = {
                title: document.getElementById('title').value,
                description: document.getElementById('description').value,
                deadline: document.getElementById('deadline').value,
                user: document.getElementById('user').value,
                client: document.getElementById('client').value
            }

            console.log(data);

            post("{{ route('projects.store') }}", data, "submit-button", "create-form", "{{ route('projects.index') }}")
        }
    </script>
@endsection
