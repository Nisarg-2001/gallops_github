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
                            <h3 class="card-header mb-3 text-center">Inward Report</h3>
                                <form method="POST" action="{{ ((Auth::user()->role)==2) ? url('user/report/inward') : url('report/inward') }}" >
                                    @csrf
                                <div class="row">
                                @if((Auth::user()->role)==1)
                                <div class="col-6 col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>Select Branch</label>
                                        <select class="form-control select2" name="user_id" >
                                        <option value="">Select Franchise</option>
                                        @foreach($branch as $b)
                                        <option value="{{$b->id}}">{{ $b->name }}</option>
                                        @endforeach
                                        <option value="all">All Franchise</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-6 col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>Select Vendor </label>
                                        <select class="form-control select2" name="vendor_id" >
                                        <option value="">Select Vendor</option>
                                        @foreach($vendor as $v)
                                        <option value="{{$v->id}}">{{ $v->name }}</option>
                                        @endforeach
                                        <option value="all">All Vendors</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
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
                                            <th>Inward no.</th>
                                            <th>Order no.</th>
                                            <th>Branch</th>
                                            <th>Vendor Bill no.</th>
                                            <th>Vendor</th>
                                            <th>Item id</th>
                                            <th>Qty</th>
                                            <th>Received on</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($inward))
                                    @foreach($inward as $info)
                                    <tr>
                                    <td>{{$info->id}}</td>
                                    <td>{{$info->order_no}}</td>
                                    <td>{{$info->uname}}</td>
                                    <td>{{$info->vendor_bill_no}}</td>
                                    <td>{{$info->vname}}</td>
                                    <td>{{$info->product_id}}</td>
                                    <td>{{$info->qty}}</td>
                                    <td>{{ date('d M Y', strtotime($info->received_date)) }}</td>
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
