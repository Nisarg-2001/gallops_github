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
                <form action="{{ url('user/inward/post') }}" method="post" id="inwardForm">
                  @csrf
                  <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">
                  <input type="hidden" name="vendor" id="vendor" value="">

                  <div class="row">
                    <div class="col-6 col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Select Vendor *</label>
                        <select class="form-control select2" name="vendor_id" id="vendor_id" {{(isset($view)) ? 'disabled' : ''}} >
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
                        <input type="text" class="form-control" name="order" id="order" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}" placeholder="Order No." {{(isset($data)) ? 'readonly' : ''}}>
                        @error('order')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4 col-lg-4 col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Vendor Bill No.</label>
                        <input type="text" class="form-control" name="billno" value="{{ (isset($data->vendor_bill_no) && !empty($data->vendor_bill_no)) ? $data->vendor_bill_no : '' }}" placeholder="Vendor Bill No." {{(isset($data)) ? 'readonly' : ''}}>
                        @error('billno')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4 col-lg-4 col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Date of Receive</label>
                        <input type="date" class="form-control" name="dateofreceive" value="{{ (isset($data->received_date) && !empty($data->received_date)) ? $data->received_date : date('Y-m-d') }}" placeholder="Date of Receive" {{(isset($data)) ? 'readonly' : ''}}>
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
                      <div class="col-12 col-lg-2 col-md-2">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Unit Price</label>
                          <input type="text" class="form-control" name="unit_price" id="unit_price" value="" placeholder="0.00" >
                          @error('quantity')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12 col-lg-2 col-md-2">
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
                          <input type="text" class="form-control" name="batch_no" id="batch_number" value="" placeholder="Batch Number">
                          @error('batch_number')
                          <div class="text-danger">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Select Tax</label>
                          <select class="form-control select2" style="width: 100%;" name="tax" id="tax" multiple>
                            @foreach($taxData as $tax)
                              <option value="{{ $tax->id }}">{{ $tax->tax_name }}</option>
                            @endforeach
                          </select>
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
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <!-- <th>Unit</th> -->
                        <th>Tax</th>
                        <th>Pkg Month-Year</th>
                        <th>Batch No</th>
                        <th>Cost Per Item</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @if(isset($inwardItemData) && $inwardItemData)

                        @php
                        $i = 1;
                        @endphp

                        @foreach($inwardItemData as $orderItem)
                        <td> {{ $i }} </td>
                        <td>

                          <input type='text' value=" {{ $orderItem->product_name }}" id="Item_{{ $i }}" name='Item[]' class='form-control ' readonly />


                          <input type='hidden' name='product_id[]' i  d="intItemID_{{ $i }}" value="{{ $orderItem->product_id }}">
                          
                        </td>
                        <td>
                          <input type='text' value="{{ $orderItem->unit_price }}" id="Unit_Price_{{ $i }}" name='unit_price[]' class='form-control filterme' {{(isset($view)) ? 'readonly' : ''}}>
                        </td>
                        <td>
                          <input type='number' value="{{ $orderItem->qty }}" id="Qty_{{ $i }}" name='qty[]' class='form-control filterme' min='1' max='9999' {{(isset($view)) ? 'readonly' : ''}}>
                        </td>
                        <!-- <td>
                          <input type='text' value="{{ $orderItem->unit }}" id="Unit_{{ $i }}" name='unit[]' class='form-control filterme' readonly>
                        </td> -->
                        <td>
                          <input type='text' value="{{ $orderItem->tax }}" id="Tax_{{ $i }}" name='tax[]' class='form-control filterme' readonly>
                          <input type='hidden' id="Tax_Data_{{ $i }}" name='taxStr[]' value="{{ $orderItem->tax_data }}">
                        </td> 
                        <td>
                          <input type='text' value="{{ $orderItem->packaging_month }}" id="Packaging_month_{{ $i }}" name='monthYear[]' class='form-control filterme' readonly>
                        </td>
                        <td>
                          <input type='text' value="{{ $orderItem->batch_no }}" id="NetPrice_{{ $i }}" name='batch_number[]' class='form-control filterme' readonly>
                        </td>
                        <td>
                          <input type='text' value="{{ $orderItem->cost_per_item }}" id="Cost_Per_Item_{{ $i }}" name='cost_per_item[]' class='form-control filterme' readonly>
                        </td>
                         <td>
                          <button type="button" class="btn btn-danger btn-sm removethis">
                            <i class="fa fa-trash"></i>
                          </button>
                        </td> 
                      </tr>
                      @php $i++; @endphp
                      @endforeach
                      @endif
                    </tbody>
                  </table>

                  <div class="text-center">

                    @if(isset($view)) @else<button type="submit" class="btn btn-primary ">@if(isset($data)) Update @else Submit @endif</button>@endif
                    
                    @if(isset($data))<a href="{{url('user/inward')}}" class="btn btn-danger">Back</a>
                    @else<a href="{{url('user/inward')}}" class="btn btn-danger">Cancel</a>
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
  <script src="{{ asset('/admin/assets/js/inward/action.js') }}"></script>
  @endsection
  @include('layouts.footer')
</x-app-layout>