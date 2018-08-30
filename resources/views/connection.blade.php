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
          <label for="sis_id" class="d-none">SIS</label>
          <select class="form-control required" name="sis_id">
            <option value="">SIS</option>
            @foreach($sis_list as $sis)
              <option value="{{ $sis['id'] }}">{{ $sis['nom'] }}</option>
            @endforeach
          </select>          
        </div>
        <div class="input-group mb-3">
          <label for="username" class="d-none">Nom d'utilisateur</label>
          <input type="text" name="username" class="form-control required" placeholder="Nom d'utilisateur">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <label for="password" class="d-none">Mot de passe</label>
          <input type="password" name="password" class="form-control required" placeholder="Mot de passe">
          <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-lock"></i></span>
            </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="stay_connected" value="1"> Rester connecté
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Connexion</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
     
      <p class="mb-1">
        <a href="{{ route('user.forgot_password') }}" class="internal-link">Mot de passe oublié</a>
      </p>      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
@stop
