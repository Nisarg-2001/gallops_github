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

                        <div class="card">
                            <div class="card-header">
                                <form method="POST" action="{{url('vendor/order')}}" >
                                    @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="hidden" name="id" class="form-control" value="{{session()->get('vid')}}" />
                                            <input type="date" name="from" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="date" name="to" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 col-md-1">
                                        <div class="form-group">
                                        <label> &nbsp;</label>
                                        <input type="submit" class="btn btn-primary form-control" value="Go">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order ID</th>
                                            <th>Branch Name</th>
                                            <th>Total</th>
                                            <th>Expecting Delivery Date</th>
                                            <th>Order Status</th>
                                            <th>Payment Status</th>
                                            <th>Dispatch Status</th>
                                            <th>Note</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order as $info)
                                    <tr>
                                    <td>{{$info->id}}</td>
                                    <td><a href="{{ url('vendor/vieworder') . '/' . $info->order_id }}" target="_blank" title="View Order">{{ $info->order_id }}</td>
                                    <td>{{$info->name}}</td>
                                    <td>{{$info->total}}</td>
                                    <td>{{ date('d M Y', strtotime($info->order_required_date)) }}</td>
                                    @if($info->is_confirm==0)
                                    <td><span class="badge bg-warning p-2 ml-5">Pending</span></td>
                                    @elseif($info->is_confirm==1)
                                    <td><span class="badge bg-success p-2 ml-5">Accepted</span></td>
                                    @else
                                    <td><span class="badge bg-danger p-2 ml-5">Cancelled</span></td>
                                    @endif

                                    @if($info->dispatch_status==0)
                                    <td><span class="badge bg-warning p-2 ml-5">Pending</span></td>
                                    @else
                                    <td><span class="badge bg-success p-2 ml-5">Dispatched</span></td>
                                    @endif

                                    @if($info->payment_status==0)
                                    <td><span class="badge bg-warning p-2 ml-5">Pending</span></td>
                                    @else
                                    <td><span class="badge bg-success p-2 ml-5">Completed</span></td>
                                    @endif
                                    <td>{{$info->note}}</td>
                                    <td class='text-center'>
                                    <!-- <a href="{{ url('order/invoice') }}" class="btn btn-info" title="Print Invoice"><i class="fas fa-print"></i></a> -->
                                    <a href="{{ url('vendor/vendor-order/'.$info->id)}}" class="btn btn-info" title="Edit"><i class="fas fa-pencil"></i></a>
                                    <!-- <a href="{{ url('admin-order/'.$info->id)}}" class="btn btn-primary" title="View"><i class="fas fa-eye"></i></a> -->
                                    <!-- <a data-confirm="" href="{{ url('order/delete/'.$info->id)}}" data-id="{{$info->id}}" class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></a> -->
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
