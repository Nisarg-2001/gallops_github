<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">product Masters</h1>
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
               <h3>Add product</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="adduser" method="post" id="form">
                @csrf
<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
  <div class="form-group">
    
    <label >Product Name</label>
    <input type="text" class="form-control" name="name" placeholder="Enter Product Name" required>
    @error('name')
    <div class="text-danger">{{$message}}</div>
    @enderror
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label >Alias name</label>
    <input type="text" class="form-control" name="alias" placeholder="Alias Name" required>
    @error('name')
    <div class="text-danger">{{$message}}</div>
    @enderror
    
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Product Self Life</label>
    <select id="inputState" name="life" class="form-control" required>
        <option value="3">3 Months</option>
        <option value="6">6 Months</option>
        <option value="9">9 Months</option>
        <option value="12">12 Months</option>
      </select>
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >Category</label>
    <select id="inputState" name="category" class="form-control" required>
        <option value="1">Category 1</option>
        <option value="2">Category 2</option>
        <option value="3">Category 3</option>
        <option value="4">Category 4</option>
      </select>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Sub category</label>
    <select id="inputState" name="subcat" class="form-control" required>
        <option value="1">Category 1</option>
        <option value="2">Category 2</option>
        <option value="3">Category 3</option>
        <option value="4">Category 4</option>
      </select>
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Unit Of Measurement</label>
    <select id="inputState" name="unit" class="form-control" required>
        <option value="1">Kgs.</option>
        <option value="2">Ltrs.</option>
      </select>
  </div>
</div>

</div>


<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >Tax 1</label>
    <select id="inputState" name="role" class="form-control" required>
        <option value="1">GSTIN</option>
        <option value="2">CIN</option>
      </select>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Tax 2</label>
    <select id="inputState" name="role" class="form-control" required>
        <option value="1">GSTIN</option>
        <option value="2">CIN</option>
      </select>
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
<label for="inputState">Tax 3</label>
<select id="inputState" name="role" class="form-control" required>
        <option value="1">GSTIN</option>
        <option value="2">CIN</option>
      </select>
  </div>
</div>

</div>



<div class="text-center">
  <button type="submit" class="btn btn-primary ">Add Product</button>
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

