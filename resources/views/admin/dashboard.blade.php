<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Dashboard</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content mt-3 mb-5">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        @if( session('success'))
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                {{session('success')}}
              </div>
              @endif
              @if( session('danger'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                {{session('danger')}}
              </div>
            @endif
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ $products }}</h3>

                <p>Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('products') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $user }}</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('user') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
       
        <!-- /.row (main row) -->
      <div class="row">
        <div class="col-8">
       <!-- TABLE: LATEST ORDERS -->
       <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Payments</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($order as $info)
                    <tr>
                      <td>{{ $info->id }}</td>
                      <td>{{ $info->total }}</td>
                      @if($info->is_confirm==0)
                      <td><span class="badge bg-warning p-2 ml-5">Pending</span></td>
                      @elseif($info->is_confirm==1)
                      <td><span class="badge bg-success p-2 ml-5">Accepted</span></td>
                      @else
                      <td><span class="badge bg-danger p-2 ml-5">Cancelled</span></td>
                      @endif

                      @if($info->payment_status==0)
                      <td><span class="badge bg-warning p-2 ml-5">Pending</span></td>
                      @else
                      <td><span class="badge bg-success p-2 ml-5">Completed</span></td>
                      @endif
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="{{ url('order/add') }}" class="btn btn-sm btn-primary float-left">Place New Order</a>
                <a href="{{ url('/order') }}" class="btn btn-sm btn-info float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-4">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($product as $data)  
                <li class="item">
                    <div class="">
                      <a class="product-title text-dark"><b>{{ $data->name }}</b>
                        <span class="badge badge-success p-2 float-right"><strong>{{ $data->self_life }}&nbsp;</strong>Months</span></a>
                      <span class="product-description">
                        {{ $data->alias }}
                      </span>
                    </div>
                  </li>
                  @endforeach
                  <!-- /.item -->
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="{{ url('products') }}" class=" btn btn-info">View All Products</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          </div>
            <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  @include('layouts.footer')
</x-app-layout>

