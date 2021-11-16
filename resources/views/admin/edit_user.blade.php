<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Masters</h1>
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
              <h3>Add User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="{{ url('updateuser') }}" method="post" id="form">
                @csrf
                <div class="row">
    <div class="col-12 col-md-4 col-lg-4">
  <div class="form-group">
    
    <label >Company Name / Franchise Name</label>
    <input type="hidden" class="form-control"  name="id" value="{{$user->id}}">
    <input type="text" class="form-control"  name="name" value="{{$user->name}}" placeholder="Enter Name" required>
    @error('name')
    <div class="text-danger">{{$message}}</div>
    @enderror
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label >Email</label>
    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" value="{{$user->email}}" placeholder="Enter Email" required>
    @error('email')
    <div class="text-danger">{{$message}}</div>
    @enderror
    
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Contact</label>
    <input type="text" class="form-control" name="contact" value="{{ $user->contact}}"  required>
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >GST no.</label>
    <input type="text" class="form-control" name="gst" value="{{$user->gst}}" placeholder="GST no." required>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">CIN no.</label>
    <input type="text" class="form-control" name="cin" value="{{$user->cin}}" placeholder="CIN no." required>
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">FSSAI no.</label>
    <input type="text" class="form-control" name="fssai" value="{{$user->fssai}}" placeholder="FSSAI no." required>
  </div>
</div>

</div>







<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
    <label >Address line 1.</label>
    <input type="text" class="form-control" value="{{$user->address_line_1}}" name="address1" placeholder="Enter Address" required>
   
  </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
<div class="form-group">
    <label for="exampleInputPassword1">Address line 2.</label>
    <input type="text" class="form-control" name="address2" value="{{$user->address_line_2}}" placeholder="Enter Address" required>
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >State</label>
    <input type="text" class="form-control" value="{{$user->state}}" name="state" placeholder="Gujarat" required>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Pin Code</label>
    <input type="text" class="form-control" name="pincode" value="{{$user->pincode}}" placeholder="pincode" required>
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
<label for="inputState">Role</label>
      <select id="inputState" name="role" class="form-control" required>
        <option value="1" @if($user->role==1) echo selected="Selected"; @endif >Admin</option>
        <option value="2"  @if($user->role==2) echo selected="Selected"; @endif >Franchise</option>
      </select>
  </div>
</div>

</div>



<div class="text-center">
  <button type="submit" class="btn btn-primary ">Update User</button>
  <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
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

