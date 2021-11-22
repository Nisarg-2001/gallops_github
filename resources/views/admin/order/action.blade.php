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
    <section class="content mt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('') }}" method="post" id="orderForm">
                  @csrf
                  <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">


                  <div class="row">
                    <div class="col-12 col-lg-12 col-md-6">
                      <div class="form-group">
                        <label>Select Product *</label>
                        <select class="form-control select2" style="width: 100%;" name="product_id" id="product_id">
                          <option value="">Select Product</option>
                          @foreach($product as $p)
                          <option value="{{$p->id}}" {{ (isset($data->product_id) && $data->product_id == $p->id ) ? 'selected' : '' }} {{(Request::get("product")) ? 'selected' : ''}}>{{ $p->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Qty Multiply By</th>
                    <th>Amount</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                    <a href="{{url('order   ')}}" class="btn btn-danger">Cancel</a>
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
  <script src="{{ asset('/admin/assets/js/assign_product/action.js') }}"></script>
  @endsection
  @include('layouts.footer')
</x-app-layout>