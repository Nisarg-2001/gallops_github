<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Order Master</h1>
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
               <h3>Place Order</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="addcat" method="post">
                @csrf
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
  <div class="form-group">
    <label >Category Title</label>
    <input type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Enter Category" required>
  </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
  <div class="form-group">
    <label for="exampleInputPassword1">Description</label>
    <input type="text" class="form-control" name="description" placeholder="Description" required>
  </div>
</div>
</div>

  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Add Category</button>
  <a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>

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

