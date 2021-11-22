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
                <a href="{{url('category/add')}}" class="btn btn-primary" title="Add Category">Add Category</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $info)
                    <tr>
                      <td>{{$info->id}}</td>
                      <td>{{$info->title}}</td>
                      <td>{{$info->description}}</td>
                      <td class="text-center">
                        <a href="{{ url('category/edit/' . $info->id) }}" class=" delete btn btn-info" title="Edit"><i class="fas fa-pencil"></i></a>
                        <a href="{{ url('category/delete/' . $info->id) }}" class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></a>
                      </td>

                    </tr>
                    @endforeach
                   
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