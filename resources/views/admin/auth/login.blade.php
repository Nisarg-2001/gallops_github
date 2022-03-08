<x-guest-layout>
<head>
 @include('layouts.css-links')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="mt-3">
      <a class="h1"><img src="{{ asset('dist/img/gallops.png') }}" height="auto" width="150px;" class="mx-auto"/></a>
    </div>
    <div class="card-body">
         <!-- Session Status -->
         <x-auth-session-status class="mb-4" :status="session('status')" />

<!-- Validation Errors -->
<x-auth-validation-errors class="mb-4" :errors="$errors" />
@if( session('danger'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                {{session('danger')}}
              </div>
            @endif
      <form action="{{ route('login') }}" method="POST">
      @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      

      <p class="mb-1">
        <a href="{{ route('password.request') }}">I forgot my password</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  <div style="margin-top:50px;">
      <center><a href="https://mpiricsoftware.com/" target="_blank" style="font-size:18px;font-weight:bold;color:#5e6fb5;">Developed by MPIRIC</a></center>
  </div>
</div>
<!-- /.login-box -->
@include('layouts.scripts')
</body>
</x-guest-layout>
