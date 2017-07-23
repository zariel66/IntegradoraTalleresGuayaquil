@extends("template")
@section("content")
<div id="register-section-background">
	<!-- <h1 class="app-body-title">APP NAME HERE</h1> -->
	
		<div id="register-buttons-section" class="row">
			<div class="panel panel-default col-md-5">
				<div class="panel-body">
					<div class="row info-text">
						<img src="{{ URL::asset('imagenes/icons/usericon.png')}}" alt="imagen"  class="center-block" style="width:130px;height:130px">
						<p class="register-text">Únete a nuestro sitio y encuentra el taller automotriz ideal que necesitas para el mantenimiento y reparación de tu vehiculo aquí en la ciudad de Guayaquil. Podrás encontrar un servicio de calidad basado en tu opinión y la de los demás. Qué esperas regístrate ya</p>
					</div>
					<div class="row">
						<a href="{{url('registrocliente')}}" class="btn register-buttons center-block">Regístrate</a>
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
						<a href="{{url('registrartaller')}}" class="btn register-buttons center-block">Registra tu taller</a>
					</div>

				</div>
			</div>
		</div>

</div>
<style type="text/css">

/*#register-buttons-section
{
	width: 100%;

	animation: fadein 2s;
}*/
#register-section-background
{
	background-image: url("{{ URL::asset('imagenes/icons/bg2.jpg')}}");
	background-color: #cccccc;
	/*background-size:  100% 100%;*/
	background-size: 100% 100%;
	/*min-height:700px;*/
	height:700px;
	padding-left: 30%;
	padding-right: 20%;
	padding-top: 12%;


}
#register-buttons-section .panel{
	height: 400px;
	color: #373737;
	border-radius: 25px;
	
}
#register-buttons-section .info-text
{
	min-height: 320px;
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

@media only screen and (min-width: 640px) and (max-width: 1190px) {
   #register-section-background
	{
		
		height:85vh;
		
		padding-top: 20vh;


	}
	.register-text
	{
		font-size: smaller;
	}
	
}

</style>
@stop