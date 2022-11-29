@extends('layouts.blank.blank')

@section('title', 'Login')

@section('page_style')

@stop 

@section('content')

<div class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-primary">
    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h3">Admin Control Panel</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{ url('authentication/verification') }}" method="post" name="loginForm" id="loginForm" autocomplete="off">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Email">
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
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
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
</div>



@stop {{-- @ CONTENT SECTION END --}}

@section('page_javascript')

@stop {{-- @ JAVASCRIPT SECTION END --}}