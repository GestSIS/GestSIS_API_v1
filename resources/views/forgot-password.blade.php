@extends('layouts.master') @section('content')
<div class="login-box">
  <div class="login-logo">
    {{ config('app.name') }}
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Mot de passe oublié</p>

      <form action="{{ route('user.forgot_password') }}" method="post" id="forgot-password-form">
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
          <label for="email" class="d-none">Adresse e-mail</label>
          <input type="text" name="email" class="form-control required" placeholder="Adresse e-mail">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
        </div>
        <div class="form-group">
            <label for="f-res-recaptcha" class="d-none">Captcha</label>            
            <div class="recaptcha" id="f-res-recaptcha"></div>
          </div>
        <div>
          <button type="submit" class="btn btn-primary btn-block btn-flat">Réinitialiser le mot de passe</button>          
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
@stop