<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Vendor Masters</h1>
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
             <h3>Add Vendor</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="{{ url('createvendor') }}" method="post" id="userForm">
                @csrf
                <div class="row">
    <div class="col-12 col-md-4 col-lg-4">
  <div class="form-group">
    
    <label >Company Name / Franchise Name</label>
    <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
    @error('name')
    <div class="text-danger">{{$message}}</div>
    @enderror
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label >Email</label>
    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter Email" required>
    @error('email')
    <div class="text-danger">{{$message}}</div>
    @enderror
    
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Contact</label>
    <input type="text" class="form-control" name="contact" placeholder="Contact No." required>
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >GST no.</label>
    <input type="text" class="form-control" name="gst" placeholder="GST no." required>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">CIN no.</label>
    <input type="text" class="form-control" name="cin" placeholder="CIN no." required>
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">FSSAI no.</label>
    <input type="text" class="form-control" name="fssai" placeholder="FSSAI no." required>
  </div>
</div>

</div>





<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
    <label >Username</label>
    <input type="text" class="form-control" name="username"  placeholder="Enter Username" required>
    @error('username')
    <div class="text-danger">{{$message}}</div>
    @enderror
   
  </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
<div class="form-group">
    <label for="exampleInputPassword1">Passsword</label>
    <input type="password" class="form-control" name="password" placeholder="Password" required >
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
    <label >Address line 1.</label>
    <input type="text" class="form-control" name="address1" placeholder="Enter Address" required>
   
  </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
<div class="form-group">
    <label for="exampleInputPassword1">Address line 2.</label>
    <input type="text" class="form-control" name="address2" placeholder="Enter Address" required>
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >State</label>
    <input type="text" class="form-control" name="state" placeholder="Gujarat" required>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Pin Code</label>
    <input type="text" class="form-control" name="pincode" placeholder="pincode" required>
  </div>
</div>


</div>



<div class="text-center">
  <button type="submit" class="btn btn-primary ">Add Vendor</button>
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

