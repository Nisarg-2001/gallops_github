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
             @if( session('success'))
              <div class="alert alert-success alert-dismissible" role="alert" id="">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                {{session('success')}}
              </div>
              @endif
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              
             
              <div class="card-body">
                <form action="{{ url('user/stock/post') }}" method="post" id="inwardForm">
                  @csrf
                  <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                  

                  

                  

                  

                  <div id="inwardProductData">
                    <div class="row">
                      <div class="col-12 col-lg-12 col-md-6">
                        <div class="form-group">
                          <label>Select Product </label>
                          <select class="form-control select2" style="width: 100%;" name="product_id" id="product_id" required>
                            <option value="">Select Product</option>
                            @foreach($product as $p)
                            <option value="{{$p->product_id}}">{{$p->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      
                      <div class="col-12 col-lg-2 col-md-2">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Quantity</label>
                          <input type="text" class="form-control" pattern="[0-9]" name="qty"  value="0.0" placeholder="Quantity" min="0" max="9999" required>
                          @error('quantity')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-12 col-lg-2 col-md-2">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Unit Price</label>
                          <input type="number" class="form-control"  name="unit_price"  value="0.00" placeholder="Per unit Price" min="1" max="999999" required>
                          @error('int_price')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-12 col-lg-2 col-md-2">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Total Amount</label>
                          <input type="number" class="form-control" name="amount" id="amt" value="0.00" placeholder="Quantity" min="1" max="999999" required>
                          @error('amount')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      

                    

                    

                  </div>



                  

                  <div class="text-center">

                    @if(isset($view)) @else<button type="submit" class="btn btn-primary ">@if(isset($data)) Update @else Submit @endif</button>@endif
                    
                    @if(isset($data))<a href="{{url('user/inward')}}" class="btn btn-danger">Back</a>
                    @else<a href="{{url('user/dashboard')}}" class="btn btn-danger">Cancel</a>
                    @endif

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
  @endsection
  @include('layouts.footer')
</x-app-layout>