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
                            <h3 class="card-header mb-3 text-center">Raw Stock Report</h3>
                            
                                <form method="POST" action="{{ ((Auth::user()->role)==2) ? url('user/report/order') : url('report/raw-stock') }}" >
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
                                    <b>Report: Raw Stock Report</b></caption>
                                    <thead>
                                    <tr>
                                            <th>Code</th>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            
                                            <th colspan="2" class="text-center">Opening</th>
                                            <th colspan="2" class="text-center">Received</th>
                                            <th colspan="2" class="text-center">Issued</th>
                                            <th colspan="2" class="text-center">Closing</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>Qty.</th>
                                            <th>Amt.</th>
                                            <th>Qty.</th>
                                            <th>Amt.</th>
                                            <th>Qty.</th>
                                            <th>Amt.</th>
                                            <th>Qty.</th>
                                            <th>Amt.</th>
                                        </tr>
                                       
                                      
                                    </thead>
                                    @if(isset($stock))
                                    <tbody>
                                        @foreach($stock as $data)
                                        <tr>
                                            <td>{{$data->code}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->uunit}}</td>
                                            <td>{{$data->oqty}}</td>
                                            <td>{{($data->oqty * $data->price)}}</td>
                                            <td>{{$data->oqty}}</td>
                                            <td>{{($data->oqty * $data->price)}}</td>
                                            <td>{{$data->oqty}}</td>
                                            <td>{{($data->oqty * $data->price)}}</td>
                                            <td>{{$data->oqty}}</td>
                                            <td>{{($data->oqty * $data->price)}}</td>


                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
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
