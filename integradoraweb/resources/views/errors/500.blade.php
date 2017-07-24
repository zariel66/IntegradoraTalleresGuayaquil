@extends("template")
@section("content")

			
	<div class="row login-section">
		<div class="panel panel-default col-md-offset-4 col-md-4">
				<br>
				<img src="{{ URL::asset('imagenes/icons/500.png')}}" alt="imagen" class="center-block" style="width:230px;height:130px">
				<h2 class="text-center"><strong>ERROR</strong></h2>
				<br><br>
				<div class="panel-body">
					<div class="alert alert-danger text-center">
					  <h4 style="margin:0px">
					  	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					  	<strong>Hubo un error en nuestros servidores. Espere mientras lo arreglamos.</strong>
					  	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					  </h4>
					</div>
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
	background-color:#cdc0b7;
}

@media only screen and (min-width: 640px) and (max-width: 1190px) {
   .login-section
	{
		
		height:85vh;
		
		padding-top: 20vh;
	}
	
}
</style>
@stop