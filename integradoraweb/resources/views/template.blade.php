<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="google-site-verification" content="NDGZATgHI1U68kR2D0vM2ZWy6f1PY_WJkwTXLNfClGA" />
	<meta name="viewport" content="width=1190">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="icon" href="{{ URL::asset('imagenes/icons/autoshop.png')}}">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<link href="{{ URL::asset('css/template.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/jquery-ui.min.css')}}" rel="stylesheet">
	<script type="text/javascript" src="{{ URL::asset('js/jquery-ui.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{config("constants.app_name")}}</title>
	<meta name="description" content="Únete a nuestro sitio y encuentra el taller automotriz ideal que necesitas para el mantenimiento y reparación de tu vehiculo aquí en la ciudad de Guayaquil">
  	<meta name="keywords" content="skilledev,taller,talleres,guayaquil,Ecuador,reparacion,mantenimiento,gps,geoposicionamiento,vehiculos,busqueda,carroceria,mecanico,tapiceria,vidreria,neumaticos,llantas,cerca,mecanica,reparar,concesionaria,servicio">
  	<meta name="author" content="Dimitri Laaz">
</head>
<body>
	<nav id="navbar-section" class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<img class="navbar-left" src="{{ URL::asset('imagenes/icons/autoshop2.png')}}" style="width:40px;height:40px;margin-top:5px">
				<a class="navbar-brand" href="{{url('/')}}">{{config("constants.app_name")}}</a>
			</div>
			@if (Auth::check())
 			@if (Auth::user()->tipo == 2)
			<ul class="nav navbar-nav">
				<li class=""><a href="{{url('busquedataller')}}">Buscar taller</a></li>
				
				<li><a href="{{url('perfil')}}">Mi perfil - Usuario</a></li>
				<li><a href="{{url('evaluacionservicio')}}">Encuestas pendientes
				@if(session()->has('pendingreview') && session()->get('pendingreview')>0)	
				  <span class="badge">{{session()->get('pendingreview')}}</span>
				@endif  
				</a></li>
			</ul>
			@else if(Auth::user()->tipo == 1)
			<ul class="nav navbar-nav">
				<li class=""><a href="{{url('tallertickets')}}">Citas Reservadas</a></li>
				<li class=""><a href="{{url('perfiltallerowner')}}">Mi Perfil - Taller</a></li>
				<li class=""><a href="{{url('historialtaller')}}">Historial de Clientes</a></li>
			</ul>
 			@endif
 			@else
 			<ul class="nav navbar-nav">
				<li class=""><a href="{{url('/')}}">Inicio</a></li>
				<!-- <li class=""><a href="{{url('aboutus')}}">Acerca De</a></li> -->
				
			</ul>
			@endif
			<ul class="nav navbar-nav navbar-right">
			@if (Auth::check())
				<li><a
					@if (Auth::user()->tipo == 2)
					 href="{{url('perfil')}}"
					@else
					 href="{{url('perfiltallerowner')}}"
					@endif
					 ><span class="glyphicon glyphicon-user"></span>  {{Auth::user()->username}}</a></li>
				<li><a href="{{url('logout')}}"><span class="glyphicon glyphicon-off"></span> Cerrar Sesión</a></li>
			@else
				<li><a href="{{url('register')}}"><span class="glyphicon glyphicon-user"></span> Regístrate</a></li>
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
				<p>Contacto: (04) 226-9269</p>
				<p>Dirección:  Km 30., Vía Perimetral 5, Guayaquil</p>
			</div>
			<div class="col-md-3">
				<p>Email: mind.coder.66@gmail.com</p>
				<p>Powered by <a rel="nofollow" href="http://getbootstrap.com/css/" target="_blank">Bootstrap</a> </p>
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
	<style type="text/css">
	
	</style>
</body>



</html> 
