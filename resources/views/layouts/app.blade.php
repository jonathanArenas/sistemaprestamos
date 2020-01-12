<!DOCTYPE html>

<html lang="en">
	<head>
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  
<!-- Bootstrap 3.3.4 -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />    
    <link href="{{asset('css/skin-blue-light.min.css')}}" rel="stylesheet" type="text/css" />  
		<title></title>
	</head>
	<body>
		<div class="container">
			@if(session()->has('flash'))
				<div class="alert alert-info">{{session('flash')}} </div>
			@endif
			@yield('content')
		</div>
	</body>

</html>