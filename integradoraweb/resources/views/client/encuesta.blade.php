@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-6 col-md-offset-3">
		<div class="panel-body">
			<div class="text-center">
		    	<h2><strong>Evaluación y encuesta del servicio</strong></h2>      
		  	</div>
		  	@foreach($reviews as $review)
		  	<div id="review-content">
				<div>
					<h4>Cuéntanos tu experiencia en <strong>{{$review->taller->nombre_taller}}</strong></h4>
				</div>
				<br><br><br>
				<div >
					<form>
						<div class="row">
							<label>Escriba sus recomendaciones y críticas del taller en un comentario:</label>
							<textarea class="form-control" name="comentario"></textarea>
						</div>
						<br><br><br>
						<div class="row">
							<label>Evalúe la honestidad de las personas que lo atendieron en el taller:</label>
							<input class="form-control" type="range" min="1" max="10" name="honestidad">
							<div class="col-md-4 bad-label">Malo</div>
							<div class="col-md-4 medium-label">Regular</div>
							<div class="col-md-4 good-label">Bueno</div>
						</div>
						<br><br><br>
						<div class="row">
							<label>¿Pudo el taller resolver los problemas de vehículo?, califique la eficiencia del mismo:</label>
							<input class="form-control" type="range" min="1" max="10" name="eficiencia">
							<div class="col-md-4 bad-label">Malo</div>
							<div class="col-md-4 medium-label">Regular</div>
							<div class="col-md-4 good-label">Bueno</div>
						</div>
						<br><br><br>
						<div class="row">
							<label>¿Cómo se siente respecto a precio de los servicios del taller?</label>
							<input class="form-control" type="range" min="1" max="10" name="honestidad">
							<div class="col-md-4 bad-label">Malo</div>
							<div class="col-md-4 medium-label">Regular</div>
							<div class="col-md-4 good-label">Bueno</div>
						</div>
					</form>
				</div>
		  	</div>
		  	
		  	@endforeach
		  	<div class="text-center">{{$reviews->links()}}</div>
		</div>
	</div>
</div>

<style type="text/css">
	#form-section-background
	{
		width: 100%;
		margin: 0px;
		min-height: 700px;
		background-image:  url("{{ URL::asset('imagenes/icons/bgtool.jpg')}}");
		background-size: 300px 300px;
		padding: 5%;

	}
	#form-section-background .panel{
		border-radius: 25px;
		animation: fadein 2s;
	}

	.page-header
	{
		padding-left: 15px;
		padding-right: 15px;
	}

	.pagination .active span,.pagination .active span:hover
	 {
	 	background-color: #333;
	 	border-color:#333;
	 }

	#review-content
	{
		padding: 15px;
	}
	.bad-label
	{
		text-align: left;
	}
	.medium-label
	{
		text-align: center;
	}
	.good-label
	{
		text-align: right;
	} 
</style>

		
@stop