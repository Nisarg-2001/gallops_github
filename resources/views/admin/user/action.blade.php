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
                                <form method="POST" action="{{url('user/post')}}" id="userForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Company Name / Franchise Name</label>
                                                <input type="hidden" name="id"
                                                    value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ (isset($data->name) && !empty($data->name)) ? $data->name : '' }}"
                                                    placeholder="Enter Name" required>
                                                @error('name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ (isset($data->email) && !empty($data->email)) ? $data->email : '' }}"
                                                    aria-describedby="emailHelp" placeholder="Enter Email" required>
                                                @error('email')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Contact</label>
                                                <input type="text" class="form-control" name="contact"
                                                    value="{{ (isset($data->contact) && !empty($data->contact)) ? $data->contact : '' }}"
                                                    placeholder="Contact No." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>GST no.</label>
                                                <input type="text" class="form-control" name="gst"
                                                    value="{{ (isset($data->gst) && !empty($data->gst)) ? $data->gst : '' }}"
                                                    placeholder="GST no." required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">CIN no.</label>
                                                <input type="text" class="form-control" name="cin"
                                                    value="{{ (isset($data->cin) && !empty($data->cin)) ? $data->cin : '' }}"
                                                    placeholder="CIN no." required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">FSSAI no.</label>
                                                <input type="text" class="form-control" name="fssai"
                                                    value="{{ (isset($data->fssai) && !empty($data->fssai)) ? $data->fssai : '' }}"
                                                    placeholder="FSSAI no." required>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!isset($data))
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" name="username"
                                                    placeholder="Enter Username" required>
                                                @error('username')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Passsword</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Address line 1.</label>
                                                <input type="text" class="form-control" name="address1"
                                                    value="{{ (isset($data->address_line_1) && !empty($data->address_line_1)) ? $data->address_line_1 : '' }}"
                                                    placeholder="Enter Address" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Address line 2.</label>
                                                <input type="text" class="form-control" name="address2"
                                                    value="{{ (isset($data->address_line_2) && !empty($data->address_line_2)) ? $data->address_line_2 : '' }}"
                                                    placeholder="Enter Address" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select id="inputState" name="state" class="form-control" required>
                                                    @foreach($state as $info)
                                                    <option value="{{ $info->id}}" @if(isset($data->state) &&
                                                        $data->state==$info->id) ? Selected="Selected" :'' @endif
                                                        >{{ $info->state_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Pin Code</label>
                                                <input type="text" class="form-control" name="pincode"
                                                    value="{{ (isset($data->pincode) && !empty($data->pincode)) ? $data->pincode : '' }}"
                                                    placeholder="pincode" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="inputState">Role</label>
                                                <select id="inputState" name="state" class="form-control" required>
                                                    @foreach($role as $info)
                                                    <option value="{{ $info->id}}" @if(isset($data->role) &&
                                                        $data->role==$info->id) ? Selected="Selected" :'' @endif
                                                        >{{ $info->role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                        <a href="{{url('user')}}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('/admin/assets/js/common.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/form-validation.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/user/action.js') }}"></script>
    @endsection
    @include('layouts.footer')
</x-app-layout>