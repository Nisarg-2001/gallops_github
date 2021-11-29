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
              <div class="alert bg-success alert-dismissible disabled color-pelette" role="alert">
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
                <a href="{{url('category/add')}}" class="btn btn-primary" title="Add Category">Add Category</a>
                <a href="" id="reload" class="btn btn-sm btn-primary float-right"
                                    title="Refresh"><i class="fas fa-redo-alt"></i></a>
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
                    <?php $c=1; ?>
                    @foreach($data as $info)
                    <tr>
                      <td>{{$c}}</td>
                      <td>{{$info->title}}</td>
                      <td>{{$info->description}}</td>
                      <td class="text-center">
                        <a href="{{ url('category/edit/' . $info->id) }}" class=" delete btn btn-info" title="Edit"><i class="fas fa-pencil"></i></a>
                        <a data-confirm="" href="{{ url('category/delete/' . $info->id) }}"  class="del btn btn-danger" data-id="{{$info->id}}" title="Delete"><i class="fas fa-trash-alt"></i></a>
                      </td>

                    </tr>
                    <?php $c++; ?>
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
    <script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>

    
    @endsection

  @include('layouts.footer')


</x-app-layout>