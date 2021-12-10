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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('user/inward/store') }}" method="post" id="inwardForm">
                  @csrf
                  <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">
                  <input type="hidden" name="vendor" id="vendor" value="">


                  <div class="row">
                    <div class="col-6 col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Select Vendor *</label>
                        <select class="form-control select2" name="vendor_id" id="vendor_id">
                          <option value="">Select Vendor</option>
                          @foreach($vendor as $v)
                          <option value="{{$v->id}}" {{ (isset($data->vendor_id) && $data->vendor_id == $v->id ) ? 'selected' : '' }} {{(Request::get("product")) ? 'selected' : ''}}>{{ $v->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6"  style="margin-top: 30px;">
                      <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-2" id="changeVendor" style="display:none;" title="Change Vendor">Change Vendor</a>
                    </div>
                  </div>

                  

                  <div class="row">
                    <div class="col-4 col-lg-4 col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Order No.</label>
                        <input type="text" class="form-control" name="order" id="order" value="{{ (isset($data->order) && !empty($data->order)) ? $data->order : '' }}" placeholder="Order No.">
                        @error('order')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4 col-lg-4 col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Vendor Bill No.</label>
                        <input type="text" class="form-control" name="billno" value="{{ (isset($data->billno) && !empty($data->billno)) ? $data->billno : '' }}" placeholder="Vendor Bill No.">
                        @error('billno')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4 col-lg-4 col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Date of Receive</label>
                        <input type="date" class="form-control" name="dateofreceive" value="{{ (isset($data->dateofreceive) && !empty($data->dateofreceive)) ? $data->dateofreceive : date('Y-m-d') }}" placeholder="Date of Receive">
                        @error('dateofreceive')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>

                  </div>

                  <div id="inwardProductData" style="display: none;">
                    <div class="row">
                      <div class="col-12 col-lg-12 col-md-6">
                        <div class="form-group">
                          <label>Select Product </label>
                          <select class="form-control select2" style="width: 100%;" name="product_id" id="product_id">
                            <option value="">Select Product</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">

                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Quantity</label>
                          <input type="number" class="form-control" name="qty" id="qty" value="1" placeholder="Quantity" min="1" max="9999">
                          @error('quantity')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12 col-lg-2 col-md-2">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Packaging Month</label>
                          <select class="form-control select2" name="packaging_month" id="packaging_month" id="packaging_month">
                            @for($i = 1; $i <= 12; $i++) <option value="{{$i}}">{{date('M', strtotime('01-'.$i.'-'.date('Y')))}}</option>
                              @endfor
                          </select>

                          @error('monthofpackage')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="col-12 col-lg-2 col-md-2">
                        <div class="form-group">
                          <label for="packaging_year">Packaging Year</label>
                          <select class="form-control select2" name="packaging_year" id="packaging_year">
                            @for($i = date('Y')-10; $i <= date('Y'); $i++) <option value="{{$i}}" {{ (date('Y') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                              @endfor
                          </select>
                          @error('packaging_year')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label for="batch_number">Batch Number *</label>
                          <input type="text" class="form-control" name="batch_number" id="batch_number" value="" placeholder="Batch Number">
                          @error('batch_number')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <div class="row" style="margin-bottom: 1rem;">
                      <div class="col-12 col-lg-12 col-md-12">
                        <button class="btn btn-primary" id="addInwardProduct">Add Product</button>
                      </div>
                    </div>

                  </div>



                  <table id="example1" class="table table-bordered table-striped inward-table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Pkg Month-Year</th>
                        <th>Batch No</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>

                  <div class="text-center">

                    <button type="submit" class="btn btn-primary ">Submit</button>
                    <a href="{{url('user/inward')}}" class="btn btn-danger">Cancel</a>

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
  <script src="{{ asset('/admin/assets/js/inward/action.js') }}"></script>
  @endsection
  @include('layouts.footer')
</x-app-layout>