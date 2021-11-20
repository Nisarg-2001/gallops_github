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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">


            <div class="card">
              <div class="card-header">

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('category/post') }}" method="post" id="catForm">
                  @csrf

                  <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">

                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label>Title *</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ ( isset($data->title) && !empty($data->title)) ? $data->title : '' }}" placeholder="Title" >
                        @error('title')
                        <div class="text-danger">{{$message}}</div>
                        @enderror

                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                        <input type="text" class="form-control" name="description" value="{{ (isset($data->description) && !empty($data->description)) ? $data->description : '' }}" placeholder="Description" >
                        @error('description')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                  </div>





                  <div class="text-center">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                    <a href="{{ url('category') }}" class="btn btn-danger">Cancel</a>
                  </div>
                </form>
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
  <script src="{{ asset('/admin/assets/js/form-validation.js') }}"></script>
  <script src="{{ asset('/admin/assets/js/category/action.js') }}"></script>
  @endsection

  @include('layouts.footer')


</x-app-layout>