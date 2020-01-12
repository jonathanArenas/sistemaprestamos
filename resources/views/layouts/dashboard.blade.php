

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>@yield('title','Default') | SISTEMAPRETAMOS</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="_token" content="{{csrf_token()}}">
  
<!-- Bootstrap 3.3.4 -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />    
    <link href="{{asset('css/skin-blue-light.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/morris.css')}}">
    <link rel="stylesheet" href="{{asset('css/example.css')}}">
  </head>
  <body class="skin-blue-light fixed  sidebar-mini" >     

	<div class="wrapper">
  <!-- Inicia Main Header -->
@include('layouts.partial.main_header')  

<!-- Left side column. contains the logo and sidebar -->
@include('layouts.partial.sidebar')
<div class="content-wrapper">
	  <div class="content">
			  @yield('content')	
		</div><!-- /.content -->
</div><!-- /.content-wrapper --> 

@include('layouts.partial.footer') 
</div><!-- ./wrapper -->
   
    <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
   <script src="{{asset('js/app.min.js')}}" type="text/javascript"></script>
   <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/crud.js')}}"></script>
    <!--<script src="{{asset('js/raphael-min.js')}}"></script>-->
    <script src="{{asset('js/morris.js')}}"></script>
    <!--<script src="{{asset('js/jspdf.min.js')}}"></script>-->
    <!--<script src="{{asset('js/jspdf.plugin.autotable.js')}}"></script>-->
     
    
    <!--<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>-->
    <!--<script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>-->


  </body>
</html>
