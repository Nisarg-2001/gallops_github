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
             <h3>Add User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form method="POST" action="/createuser" id="userForm" >
                @csrf
<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
  <div class="form-group">
    
    <label >Company Name / Franchise Name</label>
    <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}" >
    <input type="text" class="form-control" name="name" value="{{ (isset($data->name) && !empty($data->name)) ? $data->name : '' }}" placeholder="Enter Name" required>
    @error('name')
    <div class="text-danger">{{$message}}</div>
    @enderror
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label >Email</label>
    <input type="email" class="form-control" name="email" value="{{ (isset($data->email) && !empty($data->email)) ? $data->email : '' }}" aria-describedby="emailHelp" placeholder="Enter Email" required>
    @error('email')
    <div class="text-danger">{{$message}}</div>
    @enderror
    
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Contact</label>
    <input type="text" class="form-control" name="contact" value="{{ (isset($data->contact) && !empty($data->contact)) ? $data->contact : '' }}" placeholder="Contact No." required>
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >GST no.</label>
    <input type="text" class="form-control" name="gst" value="{{ (isset($data->gst) && !empty($data->gst)) ? $data->gst : '' }}" placeholder="GST no." required>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">CIN no.</label>
    <input type="text" class="form-control" name="cin" value="{{ (isset($data->cin) && !empty($data->cin)) ? $data->cin : '' }}" placeholder="CIN no." required>
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">FSSAI no.</label>
    <input type="text" class="form-control" name="fssai" value="{{ (isset($data->fssai) && !empty($data->fssai)) ? $data->fssai : '' }}" placeholder="FSSAI no." required>
  </div>
</div>

</div>




@if(!isset($data))
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
@endif

<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
    <label >Address line 1.</label>
    <input type="text" class="form-control" name="address1" value="{{ (isset($data->address_line_1) && !empty($data->address_line_1)) ? $data->address_line_1 : '' }}" placeholder="Enter Address" required>
   
  </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
<div class="form-group">
    <label for="exampleInputPassword1">Address line 2.</label>
    <input type="text" class="form-control" name="address2" value="{{ (isset($data->address_line_2) && !empty($data->address_line_2)) ? $data->address_line_2 : '' }}" placeholder="Enter Address" required>
  </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
    <label >State</label>
    <select id="inputState" name="state" class="form-control" required>
      @foreach($state as $info)
        <option value="{{ $info->id}}" @if(isset($data->state) && $data->state==$info->id) ? Selected="Selected" :'' @endif >{{ $info->state_name }}</option>
      @endforeach
      </select>
   
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
    <label for="exampleInputPassword1">Pin Code</label>
    <input type="text" class="form-control" name="pincode" value="{{ (isset($data->pincode) && !empty($data->pincode)) ? $data->pincode : '' }}" placeholder="pincode" required>
  </div>
</div>
<div class="col-12 col-md-4 col-lg-4">
<div class="form-group">
<label for="inputState">Role</label>
      <select id="inputState" name="role" class="form-control" required>
        <option value="1"  @if(isset($data->role) && $data->role==1) ? selected="Selected" :'' @endif>Admin</option>
        <option value="2"  @if(isset($data->role) && $data->role==2) ? selected="Selected" :'' @endif>Franchise</option>
      </select>
  </div>
</div>

</div>



<div class="text-center">
  <button type="submit" class="btn btn-primary ">Submit</button>
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

  @include('layouts.footer')
  
  <script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });
  $('#userForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 5
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>

 
</x-app-layout>

