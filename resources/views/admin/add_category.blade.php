<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category Masters</h1>
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
              <h3>Add Category</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="{{ url('createcategory') }}" method="post" id="catForm">
                @csrf


<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
    <label >Title</label>
    <input type="text" class="form-control" name="title"  placeholder="Title" required>
    @error('title')
    <div class="text-danger">{{$message}}</div>
    @enderror
   
  </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
<div class="form-group">
    <label for="exampleInputPassword1">Description</label>
    <input type="text" class="form-control" name="description" placeholder="Description" required>
    @error('description')
    <div class="text-danger">{{$message}}</div>
    @enderror
  </div>
</div>
</div>





<div class="text-center">
  <button type="submit" class="btn btn-primary ">Add Category</button>
  <a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
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

  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

 
</x-app-layout>

