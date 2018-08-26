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
    @if(!$full_page)
      <div class="wrapper">
        <!-- Navbar -->
        @include('navbar')
        <!-- /.navbar --> 

        <!-- Main Sidebar Container -->
        @include('main-sidebar')
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="main-content">
          @include('common')
          @yield('content')        
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
      @include('common')
      @yield('content')
    @endif

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>