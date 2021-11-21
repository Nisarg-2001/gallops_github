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
                <form action="{{ url('product/post') }}" method="post" id="productForm">
                  @csrf
                  <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">
                  <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" name="name" value="{{ (isset($data->name) && !empty($data->name)) ? $data->name : '' }}" placeholder="Enter Product Name" required>
                        @error('name')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label>Alias name</label>
                        <input type="text" class="form-control" name="alias" value="{{ (isset($data->alias) && !empty($data->alias)) ? $data->alias : '' }}" placeholder="Alias Name" required>
                        @error('name')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Product Self Life</label>
                        <select id="inputState" name="life" class="form-control" required>
                          <option value="3" @if(isset($data->self_life)==3) ? selected="Selected" :'' @endif >3 Months</option>
                          <option value="6" @if(isset($data->self_life)==6) ? selected="Selected" :'' @endif>6 Months</option>
                          <option value="9" @if(isset($data->self_life)==9) ? selected="Selected" :'' @endif>9 Months</option>
                          <option value="12" @if(isset($data->self_life)==12) ? selected="Selected" :'' @endif>12 Months</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label>Category</label>
                        <select id="inputState" name="category" class="form-control" required>
                          @foreach($category as $info)
                          <option value="{{ $info->id}}" @if(isset($data->category)==$info->id) ? selected="Selected" :'' @endif>{{ $info->title }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Sub category</label>
                        <select id="inputState" name="subcategory" class="form-control" required>
                          @foreach($sub_category as $info)
                          <option value="{{ $info->id}}" @if(isset($data->sub_category)==$info->id) ? selected="Selected" :'' @endif>{{ $info->sub_category }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Unit Of Measurement</label>
                        <select id="inputState" name="unit" class="form-control" required>
                          <option value="kg" @if(isset($data->unit)=='kg') ? selected="Selected" :'' @endif>Kgs.</option>
                          <option value="ltr" @if(isset($data->unit)=='ltr') ? selected="Selected" :'' @endif>Ltrs.</option>
                        </select>
                      </div>
                    </div>
                    @if(isset($taxData) && !empty($taxData))
                    
                    @if(isset($data->default_tax) && !empty($data->default_tax))
                      @php $default_tax = json_decode($data->default_tax); @endphp
                    @else
                      @php $default_tax = []; @endphp
                    @endif



                    @foreach($default_tax as $t)
                      @php $default_tax[$t->id] = $t; @endphp
                    @endforeach

                    
                    
                    @foreach($taxData as $tax)
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label>{{ $tax->tax_name }} (%)</label>
                        <input type="hidden" class="form-control" name="tax_id[]" value="{{ $tax->id }}">
                        <input type="hidden" class="form-control" name="tax_name[]" value="{{ $tax->tax_name }}">
                        <input type="text" class="form-control" name="tax_value[]" value="{{ !empty($default_tax) && (isset($default_tax[$tax->id])) ? $default_tax[$tax->id]->value : 0 }}" placeholder="0.00">
                      </div>
                    </div>
                    @endforeach
                    @endif


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