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
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-header mb-3 text-center">Stock Ledger Report</h3>
                                <form method="POST" action="{{ ((Auth::user()->role)==2) ? url('user/report/stock-ledger') : url('report/stock-ledger') }}" >
                                    @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="hidden" name="role" class="form-control" value="{{Auth::user()->role}}" />
                                            <input type="hidden" name="id" class="form-control" value="{{Auth::user()->id}}" />
                                            <input type="date" name="from" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="date" name="to" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Product</label>
                                            <select class="form-control select2" style="width: 100%;" name="product_id" required>
                                            <option value="">Select Product</option>
                                            @foreach($department as $d)
                                            <option value="{{$d->id}}">{{$d->name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     @if((Auth::user()->role)==1)
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control select2" style="width: 100%;" name="branch_id" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branch as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
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
                                <table id="example1" class="table table-bordered table-striped caption">
                                <caption class="text-center " style="caption-side:top;">Gallops Food Plaza (Store)<br>
                                    <b>Report: Stock Ledger Report {{(isset($from)) ? 'From: '.date('d-m-Y',strtotime($from)).' To '.date('d-m-Y',strtotime($to)) : ''}}</b></caption>
                                    <thead>
                                        <tr align="center">
                                            <th>Date</th>
                                            <th>Voucher No.</th>
                                            <th>Vendor/Department</th>
                                            <th>Product</th>
                                            <th>Opening<br>Qty.</br></th>
                                            <th class="text-center" colspan="2">Inward<br> Qty. &nbsp;&nbsp;|&nbsp;&nbsp; Eff. Rate</th>
                                            <th class="text-center" colspan="2">Outward<br> Qty. &nbsp;&nbsp;|&nbsp; Eff. Rate</th>
                                            <th class="text-center">Balance<br> Qty. &nbsp;</th>
                                    </tr>
                                        
                                    </thead>
                                    <tbody>
                                    @if(isset($stock))
                                    
                                    @foreach($stock as $info)
                                    
                                    <tr>
                                        
                                    <td align="center">{{$info->date}}</td>
                                    <td align="center">{{$info->voucher_id}}</td>
                                    <td align="center">{{(isset($info->type) && $info->type == 'I') ? $info->vname : $info->dname}}</td>
                                    <td align="center">{{$info->name}}</td>
                                    <td align="center">{{$info->dqty}}</td>
                                    <td align="right">{{(isset($info->type) && $info->type == 'I') ? number_format($info->qty,2) : '0.00'}}</td>
                                    <td align="right">{{(isset($info->type) && $info->type == 'I') ? number_format($info->unit_price,2) : '0.00'}}</td>
                                    <td align="right">{{(isset($info->type) && $info->type == 'O') ? number_format($info->qty,2) : '0.00'}}</td>
                                    <td align="right">{{(isset($info->type) && $info->type == 'O') ? number_format($info->unit_price,2) : '0.00'}}</td>
                                    <td align="right">{{(isset($info->balance_qty)) ? number_format($info->balance_qty,2) : '0.00'}}</td>
                                    
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
    <script src="{{ asset('/admin/assets/js/datatable-report.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>

    @endsection
    @include('layouts.footer')


</x-app-layout>