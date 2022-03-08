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
                <a href="{{ (Auth::User()->role==2) ? url('user/return/add') : url('return/add') }}" class="btn btn-primary"> Return Product</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Return ID</th>
                      <th>Vendor Name</th>
                      <th>Date of Issue</th>
                      <th>Return Status</th>
                      <th>Payment Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @if(isset($data))
                    @foreach($data as $info)
                    <tr>
                      <td>{{ $info->id }}</td>
                      <td>{{ $info->name }}</td>
                      <td>{{ date('d M Y', strtotime($info->issue_date)) }}</td>
                      <td>Pending</td>
                      <td>Pending</td>
                      <td>
                           <a href="{{ (Ath::User()->role==2) ? url('/user/return/print/'.$info->id) : url('/user/return/print/'.$info->id) }}" class="btn btn-secondary" title="Print Invoice" value="print"><i class="fas fa-print"></i></a>
                        <a href="{{ (Ath::User()->role==2) ? url('user/return/view/'.$info->id) : url('user/return/view/'.$info->id) }}" class="btn btn-primary" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{(Ath::User()->role==2) ? url('user/return/edit/'.$info->id) : url('user/return/edit/'.$info->id) }}" class="btn btn-info"
                            title="Edit"><i class="fas fa-pencil"></i></a>
                        <!-- <a data-confirm="" href="{{ url('order/delete/'.$info->id)}}" data-id="{{$info->id}}" class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></a> -->
                      </td>

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
    <script src="{{ asset('/admin/assets/js/data-tables.js') }}"></script>
  @endsection
  @include('layouts.footer')


</x-app-layout>