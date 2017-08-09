@extends("template")
@section("content")

			
<div class="row login-section">
	<div class="panel panel-default col-md-offset-4 col-md-4">
			<img src="{{ URL::asset('imagenes/icons/credentialicon.png')}}" alt="imagen" class="center-block" style="width:130px;height:130px">
			<h4 class="text-center"><strong>Nueva Contraseña</strong></h4>
			@if($errors->has('password'))
			<br>
			<div class="alert alert-danger text-center" style="font-size:12px">
			  <strong>{{$errors->first('password')}}</strong> 
			</div>
			@elseif(!$errors->isEmpty())
			<br>
			<div class="alert alert-danger text-center" style="font-size:12px">
			  <strong>Ambos campos son requeridos y deben coincidir</strong> 
			</div>
			@endif
			<div class="panel-body">
				<form id="resetPassword" method="POST" action="{{url('nuevopwd')}}" autocomplete="on">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				  <div class="form-group">
				    <label for="password">Ingrese la nueva contraseña</label>
				    <input type="password" class="form-control" id="password" name="password">
				  </div>
				  <div class="form-group">
				    <label for="repeat_password">Repita la contraseña</label>
				    <input type="password" class="form-control" id="repeat_password" name="repeat_password">
				    
				  </div>
				  <input type="hidden" name="pass_token" value="{{ $pass_token }}">
				  <input type="hidden" name="correo" value="{{ $correo }}">
				  <br>
				  <!-- <input type="submit" class="btn login-btn center-block" value="Restablecer Contraseña"> -->
				  <button class="btn login-btn center-block" type="submit" form="resetPassword" value="Submit"><span class="glyphicon glyphicon-lock"></span> Restablecer Contraseña</button>
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
	/*padding-left: 40%;*/
	
	padding-top: 8%

}
.login-section .panel
{
	min-height: 430px;
	border-radius: 25px;
	/*width: 400px;*/
	/*position: absolute;
	top:30%;
	left:40%;*/
	animation: fadein 2s;
}
.login-btn
{
	font-weight:bold;
	color: #373737;
	background-color:#f3d3be;
}

@media only screen and (min-width: 640px) and (max-width: 1190px) {
   .login-section
	{
		
		height:100vh;
		
		padding-top: 20vh;
	}
	
}
</style>
@stop