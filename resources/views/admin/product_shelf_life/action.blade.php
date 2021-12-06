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
                                <h3>Add Product Shelf Life</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('productshelflife/post') }}" method="post" id="pslForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Product Shelf Life Label</label>
                                                <p>('for eg. 12 months')</p>
                                                <input type="hidden" name="id" value="{{(isset($psl->id) && !empty($psl->id)) ? $psl->id : ''}}">
                                                <input type="text" class="form-control" name="label" value="{{(isset($psl->label) && !empty($psl->label)) ? $psl->label : ''}}" aria-describedby="emailHelp" placeholder="Enter ShelfLife Label">
                                                @error('label')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label>Month</label>
                                                
                                                <input type="number" class="form-control" name="month" value="{{(isset($psl->month) && !empty($psl->month)) ? $psl->month : '12'}}" aria-describedby="emailHelp">
                                                @error('month')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label>Year</label>
                                                
                                                <input type="number" class="form-control" name="year" value="{{(isset($psl->year) && !empty($psl->year)) ? $psl->year : '1'}}" aria-describedby="emailHelp">
                                                @error('year')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                        <a href="{{url('productshelflife')}}" class="btn btn-danger">Cancel</a>
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