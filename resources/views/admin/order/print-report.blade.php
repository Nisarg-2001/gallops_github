
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
   <div class="row text-center">
       <div class="col-12"><h1>Gallops Food Plaza (Store)</h1></div>
   </div>
   <div class="row text-center">
       <div class="col-12"><h2><b>Order Report  ( From: 01-11-2021  to 16-12-2021 )</b></h2></div>
   </div>
<hr/>
    
<div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
          <tr>
            <th>Order ID</th>
            <th>Branch Name</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Expecting Delivery Date</th>
            <th>Order Date</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
              @foreach($order as $info)
              <tr>
                  <td>{$info->order_id}}</td>
                  <td>{{$info->name}}</td>
                  <td>{{$info->item_id}}</td>
                  <td>{{$info->qty}}</td>
                  <td>{{ date('d M Y', strtotime($info->order_required_date)) }}</td>
                  <td>{{ date('d M Y', strtotime($info->created)) }}</td>
                  <td>{$info->total}}</td>
              </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th> </th>
              <th> </th>
              <th> </th>
              <th> </th>
              <th> </th>
              <th>Total</th>
              <th>₹</th>
            </tr>
          </tfoot>
          
        </table>
    <!-- /.row -->
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
