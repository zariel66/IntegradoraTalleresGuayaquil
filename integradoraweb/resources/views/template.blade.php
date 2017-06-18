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

</head>
<body>
	<nav id="navbar-section" class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="demointro.html">APPNAME HERE</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Busca tu taller</a></li>
				<li><a href="#">Guía</a></li>
				<li><a href="#"> Mis vehiculos</a></li>
				<li><a href="#">Mi perfil</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="registerclient.html"><span class="glyphicon glyphicon-user"></span> Regístrate</a></li>
				<li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>
			</ul>
		</div>
	</nav>
	<div class="mainContent container">
		<div id="register-section-background">
			<!-- <h1 class="app-body-title">APP NAME HERE</h1> -->
			<div id="register-buttons-section" >
				<div class="row">
					<div class="panel panel-default col-md-5">
						<div class="panel-body">
							<div class="row info-text">
								<img src="{{ URL::asset('imagenes/icons/usericon.png')}}" alt="imagen"  class="center-block" style="width:130px;height:130px">
								<p class="register-text">Únete a nuestro sitio y encuentra el taller automotriz ideal que necesitas para el mantenimiento y reparación de tu vehiculo aquí en la ciudad de Guayaquil. Podrás encontrar un servicio de calidad basado en tu opinión y la de los demás. Qué esperas regístrate ya</p>
							</div>
							<div class="row">
								<a href="registerclient.html" class="btn register-buttons center-block">Regístrate</a>
							</div>
							
						</div>
					</div>
					<div class="panel panel-default col-md-5 col-md-offset-1">
						<div class="panel-body">
							<div class="row info-text">
								<img src="{{ URL::asset('imagenes/icons/tallericon.png')}}" alt="imagen" class="center-block" style="width:130px;height:130px">
								<p class="register-text">Registra la información de tus talleres automotrices en nuestra plataforma de forma gratuita y nuestros usuarios podrán contactarte por tus servicios. No pierdas la oportunidad de ganar clientes y de que tu negocio crezca.</p>

							</div>
							<div class="row">
								<a href="registerworkshop.html" class="btn register-buttons center-block">Registra tu taller</a>
							</div>
							
						</div>
					</div>
				</div>

			</div>
		</div>

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
</body>

<style type="text/css">

#register-buttons-section
{
	width: 100%;

	animation: fadein 2s;
}
#register-section-background
{
	background-image: url("{{ URL::asset('imagenes/icons/bg2.jpg')}}");
	background-color: #cccccc;
	/*background-size:  100% 100%;*/
	background-size: 100% 100%;
	height:700px;
	padding-left: 30%;
	padding-right: 20%;
	padding-top: 12%;
/*-webkit-filter: blur(2px);
-moz-filter: blur(2px);
-o-filter: blur(2px);
-ms-filter: blur(2px);
filter: blur(2px);*/

}
#register-buttons-section .panel{
	height: 400px;
	color: #373737;
	border-radius: 25px;
}

#register-buttons-section .info-text
{
	height: 320px;
}
.register-text
{
	text-align: justify;
	text-justify: inter-word;
	margin-top: 25px;
}
.register-buttons
{
	width: 150px;
	
	font-weight:bold;
	color: #373737;
	background-color:#cdc0b7;

}



</style>

</html> 