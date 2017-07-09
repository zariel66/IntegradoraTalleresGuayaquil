<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<link href="{{ URL::asset('css/template.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/jquery-ui.min.css')}}" rel="stylesheet">
	<script type="text/javascript" src="{{ URL::asset('js/jquery-ui.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Integradora Demo</title>
</head>
<body>
	<nav id="navbar-section" class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{url('/')}}">APPNAME HERE</a>
			</div>
			@if (Auth::check())
 			@if (Auth::user()->tipo == 2)
			<ul class="nav navbar-nav">
				<li class=""><a href="{{url('busquedataller')}}">Busca tu taller</a></li>
				<li><a href="{{url('evaluacionservicio')}}">Recomienda y evalúa
				@if(session()->has('pendingreview') && session()->get('pendingreview')>0)	
				  <span class="badge">{{session()->get('pendingreview')}}</span>
				@endif  
				</a></li>
				<li><a href="#"> Mis vehiculos</a></li>
				<li><a href="#">Mi perfil</a></li>
			</ul>
 			@endif
			@endif
			<ul class="nav navbar-nav navbar-right">
			@if (Auth::check())
				<li><a href="{{url('logout')}}"><span class="glyphicon glyphicon-off"></span> Cerrar Sesión</a></li>
			@else
				<li><a href="{{url('registrocliente')}}"><span class="glyphicon glyphicon-user"></span> Regístrate</a></li>
				<li><a href="{{url('login')}}"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>
			@endif
			</ul>
		</div>
	</nav>
	<div class="mainContent container">
		@yield("content")

	</div>
	<footer class="container footer navbar-static-bottom">

		<div class="row adjust-content footer-body">
			<div class="col-md-3">
				<img src="{{ URL::asset('imagenes/icons/espologo.png')}}" style="width:60px;height:60px;">
				
			</div>
			<div class="col-md-3  col-md-offset-3">
				<p>Contacto: 04-22920556</p>
				<p>Dirección:  Km 30., Vía Perimetral 5, Guayaquil</p>
			</div>
			<div class="col-md-3">
				<p>Email: integradoragrupo2@espol.edu.ec</p>
				<p>Powered by <a href="http://getbootstrap.com/css/" target="_blank">Bootstrap</a> </p>
			</div>

		</div>
		<div class="row adjust-content footer-bottom">
			<div>
				<div class="col-md-4">
					<p>© 2017 - Todos los derechos reservados</p>

				</div>
			</div>
		</div>


	</footer>
	<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
	</script>
</body>



</html> 