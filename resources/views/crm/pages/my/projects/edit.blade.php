@extends('crm.parent')

@section('title', 'Edit Project')

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
                                        placeholder="Enter Project's Title" value="{{ $project->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" rows="3" placeholder="Enter Project's Description"
                                        style="height: 125px;">{{ $project->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="deadline">Deadline</label>
                                    <input type="date" class="form-control" id="deadline"
                                        value="{{ $project->deadline }}">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" class="form-control" style="width: 100%;">
                                        <option value="In Progress" @selected($project->status == 'In Progress')>In Progress</option>
                                        <option value="Completed" @selected($project->status == 'Completed')>Completed</option>
                                        <option value="Canceled" @selected($project->status == 'Canceled')>Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-button">Save</button>
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
        function createProject() {
            let data = {
                title: document.getElementById('title').value,
                description: document.getElementById('description').value,
                deadline: document.getElementById('deadline').value,
                status: document.getElementById('status').value
            }

            console.log(data);

            put("{{ route('my.projects.update', $project) }}", data, "submit-button", undefined, "{{ url()->previous() }}")
        }
    </script>
@endsection
