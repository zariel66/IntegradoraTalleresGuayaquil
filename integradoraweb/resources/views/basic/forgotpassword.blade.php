@extends("template")
@section("content")
<div id="register-section-background">
			
	<div class="row login-section">
		<div class="panel panel-default col-md-4 col-md-offset-4">
			<img src="{{ URL::asset('imagenes/icons/credentialicon.png')}}" alt="imagen" class="center-block" style="width:130px;height:130px">
			<h4 class="text-center"><strong>Reestablecer Contraseña</strong></h4>
			<br><br>
			@if($errors->has('correo'))
			<div class="alert alert-danger text-center" style="font-size:12px">
			  <strong>{{ $errors->first('correo') }}</strong> 
			</div>
			
			@endif
			
			<div class="panel-body">
				<form method="POST" action="forgotpassword" autocomplete="on">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				  <div class="form-group">
				    <label for="correo">Ingrese el correo de su cuenta registrada:</label>
				    <input type="text" class="form-control" id="correo" name="correo">
				  </div>
				  <br>
				  <input type="submit" class="btn login-btn center-block" value="Enviar">
				</form>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
.login-section
{
	margin: 0px;
	min-height: 700px;
	background-image: url("{{ URL::asset('imagenes/icons/bgtool.jpg')}}");
	background-size: 300px 300px;
	/*padding-left: 40%;*/
	padding-top: 8%

}
.login-section .panel
{
	min-height: 430px;
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