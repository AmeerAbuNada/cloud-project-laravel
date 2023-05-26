@extends('crm.parent')

@section('title', 'Create Client')

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <form class="row" id="create-form" onsubmit="event.preventDefault(); createClient();">
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Client's Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Enter Client's Name">
                                </div>
                                <div class="form-group">
                                    <label for="vat">Vat</label>
                                    <input type="text" class="form-control" id="vat"
                                        placeholder="Enter Client's Vat">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address"
                                        placeholder="Enter Client's Address">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city"
                                        placeholder="Enter Clients's City Name">
                                </div>
                                <div class="form-group">
                                    <label for="zip">Zip Code</label>
                                    <input type="text" class="form-control" id="zip"
                                        placeholder="Enter Client's Zip Code">
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
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Contact Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="form-group">
                                <label for="contact_name">Contact Name</label>
                                <input type="text" class="form-control" id="contact_name"
                                    placeholder="Enter Contact's Name">
                            </div>
                            <div class="form-group">
                                <label for="contact_email">Contact Email address</label>
                                <input type="email" class="form-control" id="contact_email"
                                    placeholder="Enter Contact's Email">
                            </div>
                            <div class="form-group">
                                <label for="contact_phone">Contact Phone Number</label>
                                <input type="text" class="form-control" id="contact_phone"
                                    placeholder="Enter Contact's Phone Number">
                            </div>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
            </form>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script>
        function createClient() {
            let data = {
                name: document.getElementById('name').value,
                vat: document.getElementById('vat').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                zip: document.getElementById('zip').value,
                contact_name: document.getElementById('contact_name').value,
                contact_email: document.getElementById('contact_email').value,
                contact_phone: document.getElementById('contact_phone').value
            }

            post("{{ route('clients.store') }}", data, "submit-button", "create-form", "{{ route('clients.index') }}")
        }
    </script>
@endsection
