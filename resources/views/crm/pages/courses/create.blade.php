@extends('crm.parent')

@section('title', 'Course Create')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <form class="form-horizontal" onsubmit="event.preventDefault(); editProfile(this);">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" id="title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" id="description" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Advisor</label>
                                    <div class="col-sm-10">
                                        <select name="advisor" id="advisor" class="form-control">
                                            @foreach ($advisors as $advisor)
                                                <option value="{{ $advisor->id }}">{{ $advisor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Type</label>
                                    <div class="col-sm-10">
                                        <select name="is_paid" id="is_paid" class="form-control"
                                            onchange="togglePaid(this)">
                                            <option value="free">Free</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none" id="cost-container">
                                    <label for="name" class="col-sm-2 col-form-label">Cost</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="cost" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Starts At</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" class="form-control" name="starts_at" id="starts_at">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Ends At</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" class="form-control" name="ends_at" id="ends_at">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="submit-button">Save</button>
                                        <a href="{{ route('managers.index') }}" class="btn btn-danger"
                                            id="submit-button">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function editProfile(ref) {
            let data = {
                title: document.getElementById('title').value,
                description: document.getElementById('description').value,
                user_id: document.getElementById('advisor').value,
                is_paid: document.getElementById('is_paid').value,
                cost: document.getElementById('cost').value,
                starts_at: document.getElementById('starts_at').value,
                ends_at: document.getElementById('ends_at').value,
            }
            post("{{ route('courses.store') }}", data, "submit-button", undefined,
                "{{ route('courses.index') }}")
        }

        function togglePaid(ref) {
            if (ref.value == 'paid') {
                document.getElementById('cost-container').style.display = 'flex';
            } else {
                document.getElementById('cost-container').style.display = 'none';
            }
        }
    </script>
@endsection
