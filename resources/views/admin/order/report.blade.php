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
                                            <select class="form-control select2" style="width: 100%;" name="branch_id" required>
                                            <option value="">Select Franchise</option>
                                            @foreach($branch as $b)
                                            <option value="{{$b->id}}">
                                                {{ $b->name }}
                                            </option>
                                            @endforeach
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
                                    <b>Report: order Report {{ (isset($from)) ? 'From: '.date('d-m-Y',strtotime($from)).' To '.date('d-m-Y',strtotime($to)) : '' }}</b></caption>
                                    <thead>
                                        <tr>
                                             <th>Date</th>
                                            <th>Order No.</th>
                                            <th>Branch name</th>
                                            <th>Payment Status</th>
                                            <th>Subtotal</th>
                                            <th>Tax</th>
                                            <th>Total Amount</th>
                                            
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($order))
                                    @php $total =0; @endphp
                                    @foreach($order as $info)
                                    <tr>
                                        <td>{{ date('d M Y', strtotime($info->created)) }}</td>
                                    <td>{{$info->id}}</td>
                                    <td>{{$info->name}}</td>
                                    <td>{{$info->payment_status}}</td>
                                    <td align="right">{{number_format($info->sub_total,2)}}</td>
                                    <td align="right">{{number_format($info->sub_total,2)}}</td>
                                    <td align="right">{{number_format($info->total,2)}}</td>
                                    
                                    
                                    </tr>
                                    @php $total = $total; @endphp
                                    @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr align="right">
                                            <th colspan="6" >Total:</th>
                                            <th >₹ {{(isset($total)) ? number_format($total,2) : ''}}</th>
                                            
                                        </tr>
                                    </tfoot>
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
