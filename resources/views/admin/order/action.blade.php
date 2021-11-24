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
                                <form action="{{ url('order/post') }}" method="post" id="orderForm">
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Select Product *</label>
                                                <select class="form-control select2" style="width: 100%;"
                                                    name="product_id" id="product_id">
                                                    <option value="">Select Product</option>
                                                    @foreach($product as $p)
                                                    <option value="{{$p->id}}"
                                                        {{ (isset($data->product_id) && $data->product_id == $p->id ) ? 'selected' : '' }}>
                                                        {{ $p->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                            <label>Expecting Delivery Date</label>
                                                <input type="date" name="exp_date" class="form-control"
                                                 value="{{ (isset($data->order_required_date) && !empty($data->order_required_date)) ? $data->order_required_date : ''" required />
                                            </div>
                                        </div>
                                    </div>

                                    <table id="example1" class="table table-bordered table-hover order-table">
                                        <thead>
                                            <tr>
                                                <th class='text-center'>No.</th>
                                                <th>Product Name</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php /*
<tr>
<td class='text-center'> 1 </td>
<td>
?>
<input type='text' value="<?php echo $xx[$i]['I_Name'];?>"
id="Item_<?php echo $i+1;?>" name='Item[]' class='form-control '
readonly>
<input type='hidden' name='intItemID[]' id="intItemID_<?php echo $i+1;?>"
value='<?php echo $xx[$i]['I_ItemID'];?>'>
<?php */?>
                                            </td>
                                            <td>
                                                <?php /* ?>
<input type='text' value="<?php echo $xx[$i]['I_ItemPrice'];?>"
id='NetPrice_<?php echo $i+1;?>' name='NetPrice[]'
class='form-control filterme' readonly>
<?php */?>
                                            </td>
                                            <td>
                                                <?php /* ?>
<input type='number' value="<?php echo $xx[$i]['I_ItemQty'];?>"
id='Qty_<?php echo $i+1;?>' name='Qty[]'
class='form-control filterme' min='1' max='9999'
onkeyup="updateAmount(<?php echo $xx[$i]['I_ItemID'];?>,<?php echo $i+1;?>)"
onchange="updateAmount(<?php echo $xx[$i]['I_ItemID'];?>,<?php echo $i+1;?>)"
readonly>
<?php */?>
                                            </td>
                                            <td>
                                                <?php /* ?>
<input type='text'
value="<?php echo $xx[$i]['I_ItemPrice']*$xx[$i]['I_ItemQty'] ;?>"
id='Amount_<?php echo $i+1;?>' name='Amount[]'
class='form-control filterme' readonly>
<?php
</td>
<td class='text-center'>
<button type="button" class="btn btn-danger btn-sm removethis">
<i class="fa fa-trash"></i>
</button>
</td>
</tr>*/?>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered table-hover " id="taxTotal">
                                        <tr>
                                            <td width="85%" align="right" style="padding-right:20px;"> <b>Sub Total</b>
                                            </td>
                                            <td width="15%" align="right"> <span id="SubTotalAmt">0.00 </span></td>
                                        </tr>

                                        @foreach($taxes as $t)
                                        <tr>
                                            <input type="hidden" name="hiddenTotalTax[]"
                                                id="hiddenTotalTax_{{ $t->id }}" value="0">
                                                <input type="hidden" name="hiddenTaxId[]" id="hiddenTaxId_{{ $t->id }}"
                                                    value="{{ $t->id }}">
                                                <input type="hidden" name="hiddenTaxName[]"
                                                    id="hiddenTaxName_{{ $t->id }}" value="{{ $t->tax_name }}">
                                                <td width="85%" align="right" style="padding-right:20px;">
                                                    <b>{{ $t->tax_name }}</b>
                                                </td>
                                                <td width="15%" align="right"> <b><span
                                                            id="TotalSingleTax_{{ $t->id }}">0.00</span></b></td>
                                                </tr>
                                                @endforeach

                                                <tr>
                                                    <td width="85%" align="right" style="padding-right:20px;"><b>Total
                                                            Amount
                                                            (₹)</b> </td>
                                                    <td width="15%" align="right"> <b><span
                                                                id="TotalAmt">0.00</span></b></td>
                                                </tr>
                                                </table>

                                                <input type="hidden" name="hiddenSubTotalAmt" id="hiddenSubTotalAmt"
                                                    value="">
                                                <input type="hidden" name="hiddenTotalAmt" id="hiddenTotalAmt" value="">

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Note</label>
                                                        <textarea type="text" class="form-control" name="note" id="note"
                                                            value="" placeholder="Enter Note..."></textarea>
                                                        @error('name')
                                                        <div class="text-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Place Order</button>
                                                    <a href="{{url('order')}}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('/admin/assets/js/order/action.js') }}"></script>
    @endsection
    @include('layouts.footer')
</x-app-layout>