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
                                            <input type="date" name="from" class="form-control" value="{{old('from')}}" required/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="date" name="to" class="form-control" value="{{old('to')}}" required/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Department</label>
                                            <select class="form-control select2" style="width: 100%;" name="department_id" required>
                                            <option value="">Select Department</option>
                                            @foreach($cat as $c)
                                            <option value="{{$c->id}}">{{$c->title}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if((Auth::user()->role)==1)
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control select2" style="width: 100%;" name="branch_id" required>
                                            <option value="">Select Franchise</option>
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
                                <table id="example1" class="table caption-top table-bordered table-striped ">
                                    <caption class="text-center " style="caption-side:top;">Gallops Food Plaza (Store)<br>
                                    <b>Report: Stock Report {{(isset($from)) ? 'From: '.date('d-m-Y',strtotime($from)).' To '.date('d-m-Y',strtotime($to)) : '' }}</b></caption>
                                    <thead>
                                    <tr>
                                            <th>Date</th>
                                            <th>Item Name</th>
                                            <th>Department</th>
                                            <th>Unit</th>
                                            
                                            <th colspan="2" class="text-center">Opening</th>
                                            <th colspan="2" class="text-center">Inward</th>
                                            <th colspan="2" class="text-center">Outward</th>
                                            <th colspan="2" class="text-center">Closing</th>
                                    </tr>
                                        <tr>
                                            <th colspan="4"></th>
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
                                        
                                        @php 
                                        $opening = $received = $issued = $open =0;
                                        if(isset($data['opening']) && !empty($data['opening']))
                                        {
                                            $opening = $data['opening']->qty;
                                            $open = $data['opening']->qty;
                                            if(isset($data['received']) && !empty($data['received']))
                                                $received = $data['received']->qty;
                                            else
                                                $received = 0;
                                            if(isset($data['issued']) && !empty($data['issued']))
                                                $issued = $data['issued']->qty;
                                            else
                                                $issued = 0;
                                            $opening = $opening + $received - $issued;
                                        }
                                        else
                                            $opening =0;
                                        
                                        @endphp
                                        <tr>
                                            <td align="center">{{ (isset($data['opening']) && !empty($data['opening'])) ? date('d-m-Y',strtotime($data['opening']->date)) : '-' }}</td>
                                            <td align="center">{{$data['product']->name}}</td>
                                            <td align="center">{{$data['product']->title}}</td>
                                            <td align="center">{{$data['product']->unit}}</td>
                                            <td align="right">{{ (isset($data['opening']) && !empty($data['opening'])) ? $data['opening']->qty : '0.00'}}</td>
                                            <td align="right">{{ (isset($data['opening']) && !empty($data['opening'])) ? number_format($data['opening']->amount,2) : '0.00'}}</td>
                                            <td align="right">{{ (isset($data['received']) && !empty($data['received'])) ? $data['received']->qty : '0.00'}}</td>
                                            <td align="right">{{ (isset($data['received']) && !empty($data['received'])) ? number_format($data['received']->amount,2) : '0.00'}}</td>
                                            <td align="right">{{ (isset($data['issued']) && !empty($data['issued'])) ? $data['issued']->qty : '0.00'}}</td>
                                            <td align="right">{{ (isset($data['issued']) && !empty($data['issued'])) ? number_format($data['issued']->amount,2) : '0.00'}}</td>
                                            <td align="right">{{(isset($opening)) ? number_format($opening,2) : '0.00' }}</td>
                                            <td align="right">{{ (isset($data['opening']) && !empty($data['opening'])) ? number_format($data['opening']->unit_price*$opening,2) : '0.00' }}</td>
                                            
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
    <script src="{{ asset('/admin/assets/js/datatable-report.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>

    @endsection
    @include('layouts.footer')


</x-app-layout>
