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
        <section class="content mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">


                        <div class="card">
                            <div class="card-header">
                                <a href="{{url('addvendor')}}" class="btn btn-primary">Add Vendor</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>GST no.</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $info)
                                        <tr>
                                            <td>{{ $info->id }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->email }}</td>
                                            <td>{{ $info->gst }}</td>
                                            <td class="text-center">
                                                <a href="updatevendor/{{$info->id}}" class="btn btn-info"
                                                    title="Edit"><i class="fas fa-pencil"></i></a>
                                                <a href="deletevendor/{{$info->id}}" class="btn btn-danger"
                                                    title="Delete"><i class="fas fa-trash-alt"></i></a>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>GST no.</th>
                                            <th>Action</th>
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

    @include('layouts.footer')


</x-app-layout>