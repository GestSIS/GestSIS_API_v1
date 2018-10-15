<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ mix('css/app.css') }}" rel='stylesheet' type='text/css'>
  </head>
  <body class="hold-transition {{ $body_class }}">
    <div id="app" class="wrapper">
      @if(!$full_page)
        <!-- Navbar -->
        @include('navbar')
        <!-- /.navbar --> 

        <!-- Main Sidebar Container -->
        @include('main-sidebar')
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="main-content">
          <div class="container-fluid">
            @include('common')
            @yield('content')
          </div>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        @include('control-sidebar')
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('footer')
      </div>
      <!-- ./wrapper -->
      @else
        <div id="main-content">
          <div class="container-fluid">
            @include('common')
            @yield('content')
          </div>
        </div>
      @endif
    </div>

    <script type="text/javascript">
      var RECAPTCHA_PUBLIC_KEY = '{{ config('services.recaptcha.public_key') }}';
      var g_trans = {
        'form_error' : '@lang('global.field_error')',
        'form_errors' : '@lang('global.fields_errors')',
        'request_error' : '@lang('global.request_error')'
      };
      var g_recaptchaLoaded = false;
    </script>   

    <script src="{{ mix('js/app.js') }}"></script>
    
    <script type="text/javascript">
      function onRecaptchaLoaded(){
        g_recaptchaLoaded = true;
        $(window).trigger("recaptchaloaded");
      }
    </script>
    <script src='https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoaded&render=explicit' async defer></script>
</body>
</html>