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
                                <form action="{{ url('user/outward/post') }}" method="post" id="outwardForm">
                                    @csrf


                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Person Name *</label>
                                                <input type="text" class="form-control" name="person_name" id="person_name" value="@if(isset($orderData->person_name) && !empty($orderData->person_name))  <?php echo $orderData->person_name; ?> 
                                                @elseif(isset($outward->person_name) && !empty($outward->person_name)) <?php echo $outward->person_name; ?> @else <?php echo ''; ?> @endif " {{ ((isset($orderData))) ? 'readonly' : '' }} />
                                                @error('name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="date_of_issue">Date of Issue *</label>
                                                <input type="hidden" name="id" value="{{(isset($outward->id)) ? $outward->id : ''}}" />
                                                <input type="date" class="form-control" name="date_of_issue" id="date_of_issue" value="{{(isset($orderData->issue_date) || isset($outward->issue_date)) ? (isset($orderData)) ? $orderData->issue_date : $outward->issue_date   : date('Y-m-d') }}" {{ ((isset($orderData))) ? 'readonly' : '' }} placeholder="Date of Issue">
                                                @error('date_of_issue')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    @if(isset($orderData))
                                    @else
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-6">
                                            <div class="form-group">
                                                <label>Select Product *</label>
                                                <select class="form-control select2" style="width: 100%;" name="product_id" id="product_id">
                                                    <option value="">Select Product</option>
                                                    @foreach($product as $p)
                                                    <option value="{{$p->id}}" data-unit="{{ $p->unit_name }}" data-batch="{{ $p->batch_no }}" data-pname="{{ $p->name }}" data-qty="{{ $p->qty }}">
                                                        {{ $p->name . ' (Qty:' . $p->qty . ' ' . $p->unit_name . ' | Batch No.: ' . $p->batch_no . ' | Exp. Date: ' . date('M Y', strtotime($p->expiry_date)) . ')' }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    @endif

                                    <div id="outwardProductData" style="display: none;">
                                        <div class="row">

                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label for="qty">Quantity</label>
                                                    <input type="number" class="form-control" name="qty" id="qty" value="1" placeholder="Quantity" min="1" max="9999">
                                                    @error('quantity')
                                                    <div class="text-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 1rem;">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <button class="btn btn-primary" id="addOutwardProduct">Add Product</button>
                                            </div>
                                        </div>

                                    </div>

                                    <table id="example1" class="table table-bordered table-hover outward-table">
                                        <thead>
                                            <tr>
                                                <th class='text-center' width="5%">No.</th>
                                                <th width="50%">Product Name</th>
                                                <th width="10%">Quantity</th>
                                                <th width="10%">Unit</th>
                                                <th width="30%">Batch Number</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        
                                                        

                                                       @if(isset($outwardItemData))
                                                       <tr>
                                                        @php
                                                        $i = 1;
                                                       
                                                        @endphp
                                                        
                                                        @foreach($outwardItemData as $orderItem)
                                                       
                                                        <td> {{ $i }} </td>
                                                        <input type="hidden" name="product_id[]" value="{{$orderItem->product_id }}">
                                                        <td>

                                                        <input type='text' value=" {{ $orderItem->product_name }}" id="Item_{{ $i }}" name='Item[]' class='form-control ' readonly/>
                                                        </td>
                                                        <td>
                                                        <input type='number' value="{{ $orderItem->qty }}" id="Qty_{{ $i }}" name='qty[]' class='form-control filterme' min='1' max='9999' {{(isset($orderItemData)) ? 'readonly' : ''}}>
                                                        </td>
                                                        <td>
                                                        <input type='text' value="{{ $orderItem->unit }}" id="NetPrice_{{ $i }}" name='unit[]' class='form-control filterme' readonly>
                                                        </td>
                                                        <td>
                                                        <input type='text' value="{{$orderItem->batch_no}}" id="NetPrice_{{ $i }}" name='batch_number[]' class='form-control filterme' readonly>
                                                        </td>
                                                        <td class='text-center'>
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





                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Note</label>
                                            <textarea type="text" class="form-control" name="note" id="note" value="" placeholder="{{ ((isset($orderData))) ? '' : 'Enter Note...' }}" {{ ((isset($orderData))) ? 'readonly' : '' }}>{{ (isset($orderData) && !empty($orderData->note)) ? $orderData->note : '' }}</textarea>
                                            @error('name')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        @if((isset($orderData)))
                                        @else
                                        <button type="submit" class="btn btn-primary" onClick="return check();"> {{(isset($outward)) ? 'Update' : 'Place' }}
                                          Order</button>
                                        @endif
                                        <a href="{{url('user/outward')}}" class="btn btn-danger">Back</a>
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
    <script src="{{ asset('/admin/assets/js/outward/action.js') }}"></script>
    @endsection
    @include('layouts.footer')
</x-app-layout>