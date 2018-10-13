
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Aplikacija') }}</title>

  <link rel="stylesheet" href="{{ asset('/css/app.css') }}" href="">   
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  @include('partials.navbar')

  @include('partials.main-sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield ('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('partials.footer')

</div>
<!-- ./wrapper -->

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
