

<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>@yield('title','Default') | SISTEMAPRETAMOS</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <meta name="_token" content="{{csrf_token()}}">
  
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('css/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('css/tucredito.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">     

<div class="wrapper">
  <!-- Inicia Navbar -->
  @include('layouts.partial.navbar')  
  <!-- Left side column. contains the logo and sidebar -->
  @include('layouts.partial.sidebar')
  <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{request()->segment(2)}}</h1>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div><!-- /.div content-header --> 
          <div class="row">
            <div class="col-lg-4">
              @if(\Session::has('success'))
				        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <i class="icon fas fa-check"></i>
                  {{\Session::get('success')}}
                </div>
              @endif
            </div>
          </div> <!-- /.div row -->
          @yield('content')
        </div><!-- /.container-fluid- --> 
      </section><!-- /.section --> 
  </div><!-- /.content-wrapper --> 
  @include('layouts.partial.footer') 
</div>
<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('js/sparkline.js')}}"></script>
<!-- JQVMap -->
<!-- jQuery Knob Chart -->
<script src="{{asset('js/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.js')}}"></script>
<script src="{{asset('js/jquery.inputmask.bundle.js')}}"></script>
<!-- javascript proyecto -->
<script src="{{asset('js/tucredito.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@yield('extras')
</body>
</html>
