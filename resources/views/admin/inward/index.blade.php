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
                <a href="{{ url('user/inward/add') }}" class="btn btn-primary"> Add Inward</a>
                <a href="" id="reload" class="btn btn-sm btn-primary float-right"
                                    title="Refresh"><i class="fas fa-redo-alt"></i></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Order No.</th>
                      <th>Vendor Name</th>
                      <th>Date of Receive</th>
                      <th>Vendor bill No.</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($inward as $info)
                    <tr>
                      <td>{{$info->id}}</td>
                      <td>{{$info->name}}</td>
                      <td>{{date('d M Y', strtotime($info->received_date))}}</td>
                      <td>{{$info->vendor_bill_no}}</td>
                      <td class="text-center">
                      <a href="{{ url('/user/inward/invoice/'.$info->id) }}" class="btn btn-secondary" title="Print Invoice" value="edit"><i class="fas fa-print"></i></a>
                        <a href="{{ url('user/inward/view/'.$info->id)}}" class="btn btn-primary" title="View"><i class="fas fa-eye"></i></a>
                        <!--<a href="{{url('user/inward/edit/'.$info->id)}}" class="btn btn-info"
                            title="Edit"><i class="fas fa-pencil"></i></a>-->
                      </td>
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
  @endsection
  @include('layouts.footer')


</x-app-layout>