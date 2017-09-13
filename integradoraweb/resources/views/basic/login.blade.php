@extends("template")
@section("content")

			
	<div class="row login-section">
		<div class="panel panel-default col-md-offset-4 col-md-4">
				<img src="{{ URL::asset('imagenes/icons/credentialicon.png')}}" alt="imagen" class="center-block" style="width:130px;height:130px">
				<h4 class="text-center"><strong>Ingresa al sistema</strong></h4>
				@if(isset($mensajet1))
				<br>
				<div class="alert alert-success text-center" style="font-size:12px">
				  <strong>{{ $mensajet1 }}</strong> 
				</div>
				@endif
				@if(isset($mensajet2))
				<br>
				<div class="alert alert-warning text-center" style="font-size:12px">
				  <strong>{{ $mensajet2 }}</strong> 
				</div>
				@endif
				@if(isset($mensajet3))
				<br>
				<div class="alert alert-danger text-center" style="font-size:12px">
				  <strong>{{ $mensajet3 }}</strong> 
				</div>
				@endif
				@if(isset($mensajet4))
				<br>
				<div class="alert alert-info text-center" style="font-size:12px">
				  <strong>{{ $mensajet4 }}</strong> 
				</div>
				@endif
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
					    <p  class="text-center"><a style="font-size:12px;" href="{{url('forgotpassword')}}">Olvidé mi contraseña</a></p>
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
	min-height: 700px;
	/*min-height: 100%;*/
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
		
		min-height:85vh;
		
		padding-top: 20vh;
	}
	
}
</style>
<script type="text/javascript">
window.localStorage.clear();
</script>
@stop