<x-app-layout>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content mt-5 mb-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Add Tax</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('role/post') }}" method="post" id="taxForm">
                                    @csrf
                                    <div class="col-6">
                                                <input type="hidden" class="form-control" name="id"
                                                    value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">
                                    <div class="form-group">
                                                <label for="exampleInputPassword1">Role name</label>
                                                <input type="text" class="form-control" name="role"
                                                    value="{{ (isset($data->role) && !empty($data->role)) ? $data->role : '' }}"
                                                    placeholder="Enter Role name" required>
                                            </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                        <a href="{{url('role')}}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @section('page-footer-script')
    <script src="{{ asset('/admin/assets/js/common.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/form-validation.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/tax/action.js') }}"></script>
    @endsection
    @include('layouts.footer')




</x-app-layout>