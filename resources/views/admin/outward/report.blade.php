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
                            <h3 class="card-header mb-3 text-center">Outward Report</h3>
                                <form method="POST" action="{{ ((Auth::user()->role)==2) ? url('user/report/outward') : url('report/outward') }}" >
                                    @csrf
                                    <div class="row">
                                <div class="col-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Select Category </label>
                                        <select class="form-control select2" name="person" >
                                        <option value="">Select Department</option>
                                        @foreach($person as $p)
                                        <option value="{{$p->person_name}}">{{ $p->person_name }}</option>
                                        @endforeach
                                        <option value="all">All Person</option>
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
                                <table id="example1" class="table table-bordered table-striped caption">
                                <caption class="text-center " style="caption-side:top;">Gallops Food Plaza (Store)<br>
                                    <b>Report: Outward Report</b></caption>
                                    <thead>
                                        <tr>
                                            <th>Sr.no.</th>
                                            <th>Department Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($outward))
                                    <?php $c=1; ?>
                                    @foreach($outward as $info)
                                    <tr>
                                    <td>{{$c}}</td>
                                    <td>{{$info->person_name}}</td>
                                    <td>1000</td>
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
    <script src="{{ asset('/admin/assets/js/data-tables.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>

    @endsection
    @include('layouts.footer')


</x-app-layout>
