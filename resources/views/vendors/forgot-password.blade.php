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
<p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="{{ route('password.email') }}" method="post">
          @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">Login</a>
      </p>
    </div>

    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
@include('layouts.scripts')
</body>
</x-guest-layout>
