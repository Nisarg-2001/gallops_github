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
                <a href="{{ url('order/add') }}" class="btn btn-primary"> Add Order</a>
                <a href="" id="reload" class="btn btn-sm btn-primary float-right"
                                    title="Refresh"><i class="fas fa-redo-alt"></i></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Order Date</th>
                      <th>Total Amount</th>
                      <th>Expecting Delivery Date</th>
                      <th>Order Status</th>
                     <th>Payment Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $info)
                    <tr>
                      <td>{{ $info->id }}</td>
                      <td>{{ date('d-m-Y', strtotime($info->created_at)) }}</td>
                      <td>{{ $info->total }}</td>
                      <td>{{ date('d-m-Y', strtotime($info->order_required_date)) }}</td>
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
                      <td>
                        <a href="{{ url('order/edit/'.$info->id)}}" class="btn btn-info" title="Edit"><i class="fas fa-pencil"></i></a>
                        <a data-confirm="" href="{{ url('order/delete/'.$info->id)}}" data-id="{{$info->id}}" class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></a>
                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>
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
    <script src="{{ asset('/admin/assets/js/data-tables.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>

  @endsection
  @include('layouts.footer')


</x-app-layout>