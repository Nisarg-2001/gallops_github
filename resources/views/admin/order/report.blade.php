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
                                <form method="POST" action="{{url('user/report/order/')}}" >
                                    @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="hidden" name="id" class="form-control" value="{{Auth::user()->id}}" />
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
                                        <input type="submit" class="btn btn-primary form-control" value="Generate">
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
                                            <th>Order ID</th>
                                            <th>sub Total</th>
                                            @foreach($tax as $data)
                                            <th>{{$data->tax_name}}</th>
                                            @endforeach
                                            <th>Total</th>
                                            <th>Expecting Delivery Date</th>
                                            <th>Order Status</th>
                                            <th>Payment Status</th>
                                            <th>Created on</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($order))
                                    @foreach($order as $info)
                                    <tr>
                                    <td>{{$info->order_id}}</td>
                                    <td>{{$info->sub_total}}</td>
                                    @foreach($tax as $data)
                                    <td>{{$data->value}}</td>
                                    @endforeach
                                    <td>{{$info->total}}</td>
                                    <td>{{ date('d M Y', strtotime($info->order_required_date)) }}</td>
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
                                    <td>{{ date('d M Y', strtotime($info->created)) }}</td>
                                    
                                    </tr>
                                    @endforeach
                                    @endif
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
