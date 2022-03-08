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
                            <h3 class="card-header mb-3 text-center">Product About to Expire </h3>
                            
                               
                            
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table caption-top table-bordered table-striped ">
                                    <caption class="text-center " style="caption-side:top;">Gallops Food Plaza (Store)<br>
                                    <b>Products about to expire</b></caption>
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Product name</th>
                                            <th>Unit</th>
                                            <th>Expire in</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item as $data)
                                        <tr>
                                            <td>{{$data->code}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->uunit}}</td>
                                            <td>
                                            <?php
                                            $Date =0;
                                            $validity = 0;
                                            $expiry = 0;
                                          
                                                $now = date('d-M-Y',time());
                                                $validity =$data->packaging_month;
                                                 $date1 = new DateTime($now);
                                                $date2 = new DateTime($validity);
                                                $date2 = $date2->add(new DateInterval('P'.$data->self_life.'D'));
                                                $interval = $date1->diff($date2);
                                                //$result = $validity->diff($now);
                                                //$validity = date('Y-m-d', strtotime($Date. ' + $data->self_life days'));
                                                //$result = abs(strtotime($now) - strtotime($validity));
                                                //$expiry = floor($result/ (365*60*60*24));
                                            ?>
                                            {{$interval->days}} days</td>
                                        </tr>
                                        @endforeach
                                    
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
