
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
  <section class="invoice p-5" style="border:2px solid black">
  <div class="row">
      
      <div class="col-sm-12 text-center">
        <h3 style="margin-bottom:0px;">RETAIL INVOICE</h3>
        <h6 style="margin-top:5px;">(ISSUE OF INVOICE UNDER RULE 11 OF CENTRAL EXCISE RULE 2002)</h6>
      </div>
</div>
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          
          <small class="float-right">Date: {{ date('d-M-Y')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row">
      <div class="col-6">
      <h4>Customer</h4>
        <address>
          <strong>Name: </strong>{{$order->name}}<br>
          <strong>GST No :</strong>{{$order->gst}}<br>
          <strong>Address :</strong>
          {{$order->address_line_1}}<br>
          <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>{{$order->address_line_2}}<br>
          <strong>Phone :</strong> +91-{{$order->contact}}<br>
          <strong>Email:</strong> {{$order->email}}<br>
          <b>Order ID:</b> {{$order->id}}<br>
        </address>
      </div>
      <!-- /.col -->
      
      <!-- /.col -->
    </div>
    <!-- /.row -->
    

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-bordered">
          <thead>
          <tr>
            <th>Sr.No.</th>
            <th>Particulars</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Amount</th>
          </tr>
          </thead>
          <tbody>
            <?php $c=1; $total=0;?>
            @foreach($item as $data)
            <tr>
              <td>{{ $c }}</td>
              <td>{{ $data->name }}</td>
              <td>{{ $data->qty}}</td>
              <td>{{ $data->qty}}&nbsp; {{$data->unit_name}}</td>
              <td>{{ $data->unit_price}} / {{$data->unit_name}}</td>
              <td>{{ ($data->qty * $data->unit_price)}}</td>
            </tr>
            <?php $total+=($data->qty * $data->unit_price); ?>
            <?php $c++; ?>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="5" class="text-right">Subtotal:</th>
              <th >₹ {{$total }}</th>
            </tr>
            <tr>
              <th colspan="5" class="text-right">Tax (9.3%)</th>
              <td>₹ 10.34</td>
            </tr>
            <tr>
              <th colspan="5" class="text-right">Shipping:</th>
              <td>₹ 5.80</td>
            </tr>
            <tr>
              <th colspan="5" class="text-right">Total:</th>
              <td><b>₹ {{$total}}</td>
            </tr>
          </tfoot>
          
        </table>
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
												<div class="col-sm-12 text-center">
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
