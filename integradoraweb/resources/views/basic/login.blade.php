@extends("template")
@section("content")
<div id="register-section-background">
			
	<div class="row login-section">
		<div class="panel panel-default col-md-5">
				<img src="{{ URL::asset('imagenes/icons/credentialicon.png')}}" alt="imagen" class="center-block" style="width:130px;height:130px">
				<h4 class="text-center"><strong>Ingresa al sistema</strong></h4>
				
				<div class="panel-body">
					<form method="POST" action="iniciarsesion">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					  <div class="form-group">
					    <label for="email">Usuario:</label>
					    <input type="text" class="form-control" id="username" name="username">
					  </div>
					  <div class="form-group">
					    <label for="pwd">Contraseña:</label>
					    <input type="password" class="form-control" id="pwd" name="password">
					  </div>
					  <br>
					  <input type="submit" class="btn login-btn center-block" value="Iniciar Sesion">
					</form>
		</div>
	</div>
</div>
<style type="text/css">
.login-section
{
	margin: 0px;
	height: 700px;
	background-image: url("{{ URL::asset('imagenes/icons/bgtool.jpg')}}");
	background-size: 300px 300px;
	padding-left: 40%;
	
	padding-top: 12%

}
.login-section .panel
{
	height: 430px;
	border-radius: 25px;

	/*position: absolute;
	top:30%;
	left:40%;*/
	animation: fadein 2s;
}
.login-btn
{
	font-weight:bold;
	color: #373737;
	background-color:#cdc0b7;
}
</style>
@stop