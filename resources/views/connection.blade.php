@extends('layouts.master')

@section('content')
<div class="login-box">
  <div class="login-logo">
    {{ config('app.name') }}
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Veuillez vous connecter</p>

      <form action="{{ route('user.login') }}" method="post" id="connection-form">
        @include('user-notification')

        <div class="input-group mb-3">
          <select class="form-control" name="sis_id">
            <option value="-1">SIS</option>
            @foreach($sis_list as $sis)
              <option value="{{ $sis['id'] }}">{{ $sis['nom'] }}</option>
            @endforeach
          </select>          
        </div>
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur">
          <div class="input-group-append">
              <span class="fa fa-envelope input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Mot de passe">
          <div class="input-group-append">
              <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
     
      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
@stop
