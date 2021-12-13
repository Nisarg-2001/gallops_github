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
                                <h3 class="card-header mb-3 text-center">Purchase Order Report</h3>
                            <form method="POST" action="{{url('report/purchase-order')}}" >
                                    @csrf
                                <div class="row">
                                <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="hidden" name="id" class="form-control" value="{{Auth::user()->id}}" />
                                            <input type="date" name="from" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="date" name="to" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Vendor *</label>
                                            <select class="form-control select2" style="width: 100%;" name="vendor_id"
                                                id="product_id">
                                                <option value="">Select Vendor</option>
                                                @foreach($vendor as $v)
                                                <option value="{{$v->id}}">
                                                    {{ $v->name }}
                                                </option>
                                                @endforeach
                                                <option value="all">All Vendors</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 col-md-1">
                                        <div class="form-group">
                                        <label> &nbsp;</label>
                                        <input type="submit" class="btn btn-primary form-control" value="Generate">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Purchase Order ID</th>
                                            <th>Order ID</th>
                                            <th>Branch Name</th>
                                            <th>Total Amount</th>
                                            <th>Order Date</th>
                                            <th>Expecting Delivery Date</th>
                                            <th>Order Status</th>
                                            <th>Dispatch</th>
                                            <th>Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($data))
                                    @foreach($data as $info)
                                    <tr>
                                    <td>{{$info->id}}</td>
                                    <td>{{$info->order_id}}</td>
                                    <td>{{$info->name}}</td>
                                    <td>{{$info->total}}</td>
                                    <td>{{ date('d M Y', strtotime($info->order_required_date)) }}</td>
                                    <td>{{ date('d M Y', strtotime($info->created_at)) }}</td>
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
                                    @if($info->dispatch_status==0)
                                    <td><span class="badge bg-warning p-2 ml-5">Pending</span></td>
                                    @else
                                    <td><span class="badge bg-success p-2 ml-5">Dispatched</span></td>
                                    @endif
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

    @endsection
    @include('layouts.footer')


</x-app-layout>