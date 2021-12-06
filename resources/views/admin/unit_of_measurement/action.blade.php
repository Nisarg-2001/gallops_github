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
                                <h3>Add Unit</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('unit/post') }}" method="post" id="unitForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Unit of Measurement</label>
                                                <input type="hidden" name="id" value="{{(isset($unit->id) && !empty($unit->id)) ? $unit->id : ''}}">
                                                <input type="text" class="form-control" name="name" value="{{(isset($unit->unit) && !empty($unit->unit)) ? $unit->unit : ''}}" aria-describedby="emailHelp" placeholder="Enter Unit Name" required>
                                                @error('name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                        <a href="{{url('unit')}}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('/admin/assets/js/unit/action.js') }}"></script>
    @endsection
    @include('layouts.footer')




</x-app-layout>