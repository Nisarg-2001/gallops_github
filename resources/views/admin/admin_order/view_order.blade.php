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
              <div class="card-header text-right">
                <a href="{{url('place-purchase-order') . '/' . $orderData->id}}" class="btn btn-primary">Convert to Purchase Order</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('admin-order/updateStatus') }}" method="post" id="orderForm">
                  @csrf
                  <input type="hidden" name="id" value="{{ (isset($orderData->id) && !empty($orderData->id)) ? $orderData->id : '' }}">
                  <div class="row">
                    @if((isset($orderData)))
                    @else
                    <div class="col-12 col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Select Product *</label>
                        <select class="form-control select2" style="width: 100%;" name="product_id" id="product_id">
                          <option value="">Select Product</option>
                          @foreach($product as $p)
                          <option value="{{$p->id}}">
                            {{ $p->name }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    @endif
                    <div class="col-12 col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Expecting Delivery Date</label>
                        <input type="date" name="exp_date" class="form-control" value="{{ (isset($orderData->order_required_date) && !empty($orderData->order_required_date)) ? $orderData->order_required_date : date('Y-m-d', strtotime('+7 day')) }}" {{ ((isset($orderData))) ? 'readonly' : '' }} />
                      </div>
                    </div>
                  </div>

                  <table id="example1" class="table table-bordered table-hover order-table">
                    <thead>
                      <tr>
                        <th class='text-center' width="5%">No.</th>
                        <th width="45%">Product Name</th>
                        <th width="10%">Quantity</th>
                        <th width="20%">Unit Price</th>
                        <th width="20%">Amount</th>
                        <!-- <th></th> -->
                      </tr>
                    </thead>
                    <tbody>


                      <tr>
                        @if(isset($orderItemData) && $orderItemData)

                        @foreach($taxList as $tax)
                        @php $taxData[$tax->id] = 0; @endphp
                        @endforeach

                        @php
                        $i = 1;
                        $taxData = [];
                        @endphp

                        @foreach($orderItemData as $orderItem)
                        @php


                        $taxes = json_decode($orderItem->tax);
                        $totalTaxAmt = 0;
                        $taxStr = '';
                        if (!empty($taxes)) {
                          foreach ($taxes as $tax) {
                            $t = 0;
                            $t = $orderItem->unit_price * $orderItem->qty * ($tax->value / 100);
                            $totalTaxAmt += $t;
                            $taxStr = $taxStr . ' ' . 'tax-' . $tax->id . '=' . '"' . $t . '"';

                            $taxData[$tax->id] = ((isset($taxData[$tax->id])) ? $taxData[$tax->id] : 0) + $t;
                          }
                        }
                        @endphp
                        <td class='text-center'> {{ $i }} </td>
                        <td>

                          <input type='text' value=" {{ $orderItem->product_name }}" id="Item_{{ $i }}" name='Item[]' class='form-control ' readonly />


                          <input type='hidden' name='intItemID[]' id="intItemID_{{ $i }}" value="{{ $orderItem->item_id }}">
                          <input type="hidden" name="itemTax[]" id="itemTax_{{ $i }}" value="{{ $orderItem->tax }}" data-id="{{ $i }}">
                        </td>
                        <td>
                          <input type='number' value="{{ $orderItem->qty }}" id="Qty_{{ $i }}" name='Qty_[]' class='form-control filterme' min='1' max='9999' onkeyup="updateAmount('{{ $orderItem->item_id }}', '{{ $i }}')" onchange="updateAmount('{{ $orderItem->item_id }}', '{{ $i }}')" readonly>
                        </td>
                        <td>
                          <input type='text' value="{{ $orderItem->unit_price }}" id="NetPrice_{{ $i }}" name='NetPrice[]' class='form-control filterme' readonly>
                        </td>
                        <td>
                          <input type='text' value="{{ number_format($orderItem->unit_price * $orderItem->qty, 2) }}" id='Amount_{{ $i }}' name='Amount[]' class='form-control filterme' readonly>
                          <input type='hidden' name='taxAmount[]' id='taxAmount_{{ $i }}' value='{{ $totalTaxAmt }}' data-id='{{ $i }}' {{ $taxStr }}>
                        </td>
                        <!-- <td class='text-center'>
                          <button type="button" class="btn btn-danger btn-sm removethis">
                            <i class="fa fa-trash"></i>
                          </button>
                        </td> -->
                      </tr>
                      @php $i++; @endphp
                      @endforeach
                      @endif
                    </tbody>
                  </table>

                  <table class="table table-bordered table-hover " id="taxTotal">
                    <tr>
                      <td width="85%" align="right" style="padding-right:20px;"> <b>Sub Total (₹)</b>
                      </td>
                      <td width="15%" align="right"> <span id="SubTotalAmt">{{ (isset($orderData)) ? number_format($orderData->sub_total, 2) : 0.00 }}</span></td>
                    </tr>
                    
                    @foreach($taxList as $t)
                        @if(isset($taxData[$t->id]))

                    <tr>
                      <input type="hidden" name="hiddenTotalTax[]" id="hiddenTotalTax_{{ $t->id }}" value="{{ (isset($taxData)) ? $taxData[$t->id] : 0 }}">
                      <input type="hidden" name="hiddenTaxId[]" id="hiddenTaxId_{{ $t->id }}" value="{{ $t->id }}">
                      <input type="hidden" name="hiddenTaxName[]" id="hiddenTaxName_{{ $t->id }}" value="{{ $t->tax_name }}">
                      <td width="85%" align="right" style="padding-right:20px;">
                        <b>{{ $t->tax_name }} (₹)</b>
                      </td>
                      <td width="15%" align="right"> <b><span id="TotalSingleTax_{{ $t->id }}">{{ (isset($taxData)) ? number_format($taxData[$t->id], 2) : 0.00 }}</span></b></td>
                    </tr>
                        @endif
                    @endforeach

                    <tr>
                      <td width="85%" align="right" style="padding-right:20px;">
                        <b>Total Amount (₹)</b>
                      </td>
                      <td width="15%" align="right"> <b><span id="TotalAmt">{{ (isset($orderData)) ? number_format($orderData->total, 2) : 0.00 }}</span></b></td>
                    </tr>
                  </table>

                  <input type="hidden" name="hiddenSubTotalAmt" id="hiddenSubTotalAmt" value="{{ (isset($orderData) && !empty($orderData->sub_total)) ? $orderData->sub_total : 0 }}">
                  <input type="hidden" name="hiddenTotalAmt" id="hiddenTotalAmt" value="{{ (isset($orderData) && !empty($orderData->total)) ? $orderData->total : 0 }}">

                  <div class="col-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Note</label>
                      <textarea type="text" class="form-control" name="note" id="note" value="" placeholder="{{ ((isset($orderData))) ? '' : 'Enter Note...' }}" {{ ((isset($orderData))) ? 'readonly' : '' }}>{{ (isset($orderData) && !empty($orderData->note)) ? $orderData->note : '' }}</textarea>
                      @error('name')
                      <div class="text-danger">{{$message}}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6 col-md-6 col-lg-5">
                    <div class="form-group">
                      <label>Order Status *</label>
                      <select class="form-control select2" style="width: 100%;" name="is_confirm" id="is_confirm">
                        <option value="0" {{ (isset($orderData) && $orderData->is_confirm == 0) ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ (isset($orderData) && $orderData->is_confirm == 1) ? 'selected' : '' }}>Accepted</option>
                        <option value="2" {{ (isset($orderData) && $orderData->is_confirm == 2) ? 'selected' : '' }}>Cancelled</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-6 col-md-6 col-lg-5">
                    <div class="form-group">
                      <label>Payment Status *</label>
                      <select class="form-control select2" style="width: 100%;" name="payment_status" id="payment_status">
                        <option value="0" {{ (isset($orderData) && $orderData->payment_status == 0) ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ (isset($orderData) && $orderData->payment_status == 1) ? 'selected' : '' }}>Completed</option>
                      </select>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Order</button>
                    <a href="{{url('admin-order')}}" class="btn btn-danger">Back</a>
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
  <!-- <script src="{{ asset('/admin/assets/js/order/action.js') }}"></script> -->
  @endsection
  @include('layouts.footer')
</x-app-layout>