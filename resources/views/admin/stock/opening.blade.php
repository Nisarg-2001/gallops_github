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
                            <h3 class="card-header mb-3 text-center">Opening Stock Report </h3>
                                <form method="POST" action="{{ ((Auth::user()->role)==2) ? url('user/report/opening-stock') : url('report/opening-stock') }}" >
                                    @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Date</label>
                                            <input type="hidden" name="role" class="form-control" value="{{Auth::user()->role}}" />
                                             <input type="hidden" name="id" class="form-control" value="{{Auth::user()->id}}" />
                                            <input type="date" name="from" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Select Department</label>
                                            <select class="form-control select2" style="width: 100%;" name="department_id">
                                            <option value="">Select Department</option>
                                            <option value="">Select All</option>
                                            @foreach($department as $d)
                                            <option value="{{$d->id}}">{{$d->title}}</option>
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
                                    <b>Report: Opening Stock Report &nbsp;{{(isset($date)) ? 'of Date: '.date('d-m-Y',strtotime($date)) : ''}} </b></caption>
                                    <thead>
                                        <tr>
                                            
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>UOM</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Total Amount</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($opening))
                                    <?php $c=1; ?>
                                    @foreach($opening as $info)
                                    <tr>
                                        
                                    <td>{{$info['product']->name}}</td>
                                    <td>{{$info['product']->title}}</td>
                                    <td>{{$info['product']->unit}}</td>
                                    <td align="right">{{(isset($info['opening']) && !empty($info['opening'])) ? $info['opening']->qty : '0.00'}} </td>
                                    <td align="right">{{(isset($info['opening']) && !empty($info['opening'])) ? number_format($info['opening']->unit_price,2) : '0.00'}} </td>
                                    <td align="right">{{(isset($info['opening']) && !empty($info['opening'])) ? number_format($info['opening']->amount,2) : '0.00'}} </td>
                                   
                                    </tr>
                                    <?php $c++; ?>
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