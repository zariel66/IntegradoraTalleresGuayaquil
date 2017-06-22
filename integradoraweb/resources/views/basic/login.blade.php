@extends("template")
@section("content")
<div id="register-section-background">
			
	<div class="row login-section">
		<div class="panel panel-default col-md-5">
				<img src="credentialicon.png" alt="imagen" class="center-block" style="width:130px;height:130px">
				<h4 class="text-center"><strong>Ingresa al sistema</strong></h4>
				
				<div class="panel-body">
					<form>
					  <div class="form-group">
					    <label for="email">Usuario:</label>
					    <input type="text" class="form-control" id="username">
					  </div>
					  <div class="form-group">
					    <label for="pwd">Contraseña:</label>
					    <input type="password" class="form-control" id="pwd">
					  </div>
					  <br>
					  <a href="searchclient.html"	class="btn login-btn center-block">Iniciar Sesión</a>
					</form>
		</div>
	</div>
</div>
<style type="text/css">
.login-section
{
	margin: 0px;
	height: 700px;
	background-image: url("bgtool.jpg");
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