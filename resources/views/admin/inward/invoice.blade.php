
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gallops | Order Invoice</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ ASSET('/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ ASSET('/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <i class="fas fa-globe"></i> Gallops, Inc.
          <small class="float-right">Date: {{ date('d-M-Y')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>{{$order->uname}}, Inc.</strong><br>
          {{$order->uadd1}}<br>
          {{$order->uadd2}}<br>
          Phone: +91-{{$order->ucontact}}<br>
          Email: {{$order->uemail}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong>{{ $order->vname}}</strong><br>
          {{ $order->vadd1}}<br>
          {{ $order->vadd2}}<br>
          Phone: {{$order->vcontact}}<br>
          Email: {{$order->vemail}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
     
        <br>
        <b>Order ID:</b> {{$order->id}}<br>
        <b>Vendor Bill No: </b> {{$order->vendor_bill_no}}<br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
      <hr/>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Sr.No.</th>
            <th>Product</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
            <?php $c=1; $total=0;?>
            @foreach($item as $data)
            <tr>
              <td>{{ $c }}</td>
              <td>{{ $data->name }}</td>
              <td>{{ $data->unit}}</td>
              <td>{{ $data->qty}}</td>
              <td> </td>
              <td> </td>
            </tr>
            <?php $c++; ?>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th> </th>
              <th> </th>
              <th> </th>
              <th> </th>
              <th>Total</th>
              <th>₹ {{ $total }}</th>
            </tr>
          </tfoot>
          
        </table>
        <hr/>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
     
      <!-- /.col -->
      <div class="col-4"></div>
      <div class="col-4"></div>
      <div class="col-4">
        <div class="table-responsive table-bordered">
          <table class="table">
            <tr>
              <th>Subtotal:</th>
              <th >₹ {{$total }}</th>
            </tr>
            <tr>
              <th>Tax (9.3%)</th>
              <td>₹ 10.34</td>
            </tr>
            <tr>
              <th>Shipping:</th>
              <td>₹ 5.80</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><b>₹ {{$total}}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <table class="table table-bordered" >
												<tr>	
													<td >
														<b>Declration</b> : Certified that the particulars given above are true and correct amount identical represents the price actually charged and that there is no flow additional consideration directly or indirectly from the buyer.
													</td>
												</tr>
												
												<tr>	
													<td >
														<b>Note</b> : This order is valid for 15 days.
													</td>
												</tr>
											</table>
											<div class="row">
												<div class="col-sm-12 center">
													<h6 style="margin-top:5px;">This is computer generated invoice.</h6>
												</div>
											</div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
