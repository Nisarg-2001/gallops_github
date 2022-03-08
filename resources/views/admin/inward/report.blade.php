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
                            <h3 class="card-header mb-3 text-center">Inward Stock Report</h3>
                                <form method="POST" action="{{ ((Auth::user()->role)==2) ? url('user/report/inward') : url('report/inward') }}" >
                                    @csrf
                                <div class="row">
                                    
                                <div class="col-3 col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>Select Vendor </label>
                                        <select class="form-control select2" name="vendor_id" >
                                        <option value="">Select Vendor</option>
                                        <option value="">Select All</option>
                                        @foreach($vendor as $v)
                                        <option value="{{$v->id}}">{{ $v->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>Select Department </label>
                                        <select class="form-control select2" name="department_id" >
                                           
                                        <option value="">Select department</option>
                                        <option value="">Select All</option>
                                         @foreach($cat as $c)
                                        <option value="{{$c->id}}">{{$c->title}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if(Auth::USer()->role!=2)
                                <div class="col-3 col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>Select Branch </label>
                                        <select class="form-control select2" name="branch_id" >
                                        <option value="">Select Branch</option>
                                        @foreach($branch as $v)
                                        <option value="{{$v->id}}">{{ $v->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
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
                                <table id="example1" class="table table-bordered table-striped caption">
                                <caption class="text-center " style="caption-side:top;">Gallops Food Plaza (Store)<br>
                                    Report: Inward Report {{(isset($from)) ? 'From: '.date('d-m-Y',strtotime($from)).' To '.date('d-m-Y',strtotime($to)) : ''}}</caption>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Vendor Name</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>UOM</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($inward))
                                    <?php $c=1; $totamt=0; ?>
                                    @foreach($inward as $info)
                                    <tr>
                                    <td>{{ (isset($info['received']) && !empty($info['received'])) ? date('d-m-Y',strtotime($info['received']->received_date)) : ' ' }}</td> 
                                    <td>{{ (isset($info['received']) && !empty($info['received'])) ? $info['received']->name : ''}}</td>
                                    <td>{{$info['product']->name}}</td>
                                    <td>{{$info['product']->title}}</td>
                                    <td>{{(isset($info['received']) && !empty($info['received'])) ? $info['received']->qty : 0}}</td>
                                    <td>{{$info['product']->unit}}</td>
                                    <td align="right">{{ (isset($info['received']) && !empty($info['received'])) ? number_format(($info['received']->unit_price),2) : '0.00'}}</td>
                                    <td align="right">{{ (isset($info['received']) && !empty($info['received'])) ? number_format(($info['received']->qty)*($info['received']->unit_price),2) : '0.00' }}</td>
                                    
                                    </tr>
                                     @php
                                        
                                        $totamt =$totamt + ((isset($info['received']) && !empty($info['received'])) ? ($info['received']->qty)*($info['received']->unit_price) : '0.00') ;    @endphp
                                    @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr align="right">
                                            <th colspan="7"  >Total:</th>
                                            <th  >{{(isset($totamt)) ? number_format($totamt,2) : '' }}</th>
                                            
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
    <script src="{{ asset('/admin/assets/js/report/datatable-report.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>

    @endsection
    @include('layouts.footer')


</x-app-layout>
