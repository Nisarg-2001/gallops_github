<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tax Masters</h1>
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
              <h3>Edit Tax</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="#" method="post" id="form">
                @csrf
<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
  <div class="form-group">
    
    <label >Tax Name</label>
    <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Enter Tax Name" required>
    @error('name')
    <div class="text-danger">{{$message}}</div>
    @enderror
  </div>
</div>
<div class="col-12 col-md-3 col-lg-3">
<div class="form-group">
    <label >Tax type</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault1">
            <label class="form-check-label mr-5" for="flexRadioDefault1">
                Percentage
            </label>
            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    Fixed Amount
                </label>
        </div>
</div>
</div>
<div class="col-4">
<div class="form-group">
    <label for="exampleInputPassword1">Value</label>
    <input type="text" class="form-control" name="value" placeholder="Enter tax value" required>
  </div>
</div>
</div>






<div class="text-center">
  <button type="submit" class="btn btn-primary ">Update</button>
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

