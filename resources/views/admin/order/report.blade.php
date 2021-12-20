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
                            <h3 class="card-header mb-3 text-center">Order Report</h3>
                            
                                <form method="POST" action="{{ ((Auth::user()->role)==2) ? url('user/report/order') : url('report/order') }}" >
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
                                    @if((Auth::user()->role)==1)
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control select2" style="width: 100%;" name="branch_id" >
                                            <option value="">Select Franchise</option>
                                            @foreach($branch as $b)
                                            <option value="{{$b->id}}">
                                                {{ $b->name }}
                                            </option>
                                            @endforeach
                                            <option value="all">All Branches</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif
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
                                <table id="example1" class="table caption-top table-bordered table-striped ">
                                    <caption class="text-center " style="caption-side:top;">Gallops Food Plaza (Store)<br>
                                    <b>Report: order Report</b></caption>
                                    <thead>
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Branch name</th>
                                            <th>Item</th>
                                            <th>Qty</th>
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
                                    <td>{{$info->name}}</td>
                                    <td>{{$info->item_id}}</td>
                                    <td>{{$info->qty}}</td>
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
