@extends("template")
@section("content")
<div id="info-section-background">
<div class="panel panel-default col-md-offset-2 col-md-8">
	<div class="panel-body">
		<h3 class="text-center"><strong>Conoce más de {{config("constants.app_name")}}</strong></h3>
		<hr>
		<div class="row">
			<div class="col-md-6">
				
				<div class="col-md-4 col-md-offset-8">
					<ul class="text-center" style="list-style-type:disc">
					  <li>Coffee</li>
					  <li>Tea</li>
					  <li>Milk</li>
					</ul>  
				</div>
				
			</div>
			<div class="col-md-6">
				<img class="left-block" src="{{ URL::asset('imagenes/icons/servicios.jpg')}}" style="width:300px;height:300px;">
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
#info-section-background
{
	background-image: url("{{ URL::asset('imagenes/icons/bg2.jpg')}}");
	background-color: #cccccc;
	/*background-size:  100% 100%;*/
	background-size: 100% 100%;
	/*min-height:700px;*/
	min-height:700px;
	
	padding-top: 7%;


}



@media only screen and (min-width: 640px) and (max-width: 1190px) {
   #register-section-background
	{
		
		min-height:85vh;
		
		padding-top: 20vh;


	}
	.register-text
	{
		font-size: smaller;
	}
	
}

</style>
@stop