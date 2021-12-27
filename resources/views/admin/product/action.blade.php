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
                <form action="{{ url('product/post') }}" method="post" id="productForm">
                  @csrf
                  <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">
                  <div class="row">
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" name="name" value="{{ (isset($data->name) && !empty($data->name)) ? $data->name : '' }}" placeholder="Enter Product Name" required>
                        @error('name')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label>Alias name</label>
                        <input type="text" class="form-control" name="alias" value="{{ (isset($data->alias) && !empty($data->alias)) ? $data->alias : '' }}" placeholder="Alias Name" required>
                        @error('name')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label>Product Code</label>
                        <input type="number" class="form-control" name="code" value="{{ (isset($data->alias) && !empty($data->alias)) ? $data->alias : '' }}" placeholder="Product Code" >
                        @error('code')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>HSN no.</label>
                        <input type="text" class="form-control" name="hsn" value="{{ (isset($data->alias) && !empty($data->alias)) ? $data->alias : '' }}" placeholder="Hsn no.">
                        @error('hsn')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                      </div>
                    
                  </div>
                  <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                          <div class="form-group">
                            <label for="exampleInputPassword1">Product Self Life</label>
                            <div class="row">
                              <div class="col-md-8 col-lg-8">
                            <input type="number" class="form-control" name="life">
                            </div>
                            <div class="col-md-4 col-lg-4">
                           <select class="form-control" name="format">
                             <option value="1">Days</option>
                             <option value="2">Months</option>
                             <option value="3">Years</option>
                           </select>
                            </div>
                            </div>
                           
                          </div>
                        </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control" required>
                          @foreach($category as $info)
                          <option value="{{ $info->id}}" @if(isset($data->category)==$info->id) ? selected="Selected" :'' @endif>{{ $info->title }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Sub category</label>
                        <select name="subcategory" class="form-control" required>
                          <option value="none" selected>none</option>
                          @foreach($sub_category as $info)
                          <option value="{{ $info->id}}" @if(isset($data->sub_category)==$info->id) ? selected="Selected" :'' @endif>{{ $info->sub_category }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Unit Of Measurement</label>
                        <select name="unit" class="form-control" required>
                        @foreach($unit as $info)
                          <option value="{{ $info->id}}" @if(isset($data->unit)==$info->id) ? selected="Selected" :'' @endif>{{ $info->unit }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-3 col-lg-3" >
                    <div class="form-group">
                        <label>Below Stock quantity</label>
                        <input type="text" class="form-control" name="below" value="{{ (isset($data->below) && !empty($data->below)) ? $data->below : '10' }}" placeholder="below quantity range">
                        @error('below')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                      </div>
                    </div>
                    


                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                    <a href="{{url('products')}}" class="btn btn-danger">Cancel</a>
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
  <script src="{{ asset('/admin/assets/js/product/action.js') }}"></script>
  @endsection
  @include('layouts.footer')
</x-app-layout>