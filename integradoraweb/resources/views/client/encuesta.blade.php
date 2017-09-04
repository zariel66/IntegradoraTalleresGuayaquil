@extends("template")
@section("content")

<div id="form-section-background" class="container">
	<div class="panel col-md-6 col-md-offset-3">
		<div class="panel-body">
			<div class="text-center">
		    	<h2><strong>Evaluación y encuesta del servicio</strong></h2>      
		  	</div>
		  	@if(count($reviews) > 0)
		  	@foreach($reviews as $review)
		  	<div id="review-content">
				<div class="row">
					<h4>Cuéntanos tú experiencia en <strong>{{$review->taller->nombre_taller}}</strong></h4>
				</div>
				<br>
				<div class="row">
					Tu <strong>última visita</strong> fue el {{$review->fecha_hora->format('d/m/Y')}}
				</div>
				<div class="row">
					<strong>Precio del servicio recibido:</strong> ${{$review->precio_original}}
				</div>
				<div class="row">
					<strong>Descuento recibido en la última visita: </strong> {{$review->descuento}}%
				</div>
				<div class="row">
					<strong>Total cancelado: </strong> ${{$review->total}}
				</div>
				<br><br>
				<div >
					<form method="POST" action="{{url('evaluacionservicio')}}" autocomplete="on">
						{{ csrf_field() }}
						<input type="hidden" value="{{$review->id}}" name="idcalificacion">
						<div class="row">
							<label>Escriba sus recomendaciones y críticas del taller en un comentario:</label>
							<textarea class="form-control" name="comentario" maxlength="300"  
							@if($errors->has('comentario'))
							style="border-color:red;"
							@endif
							>{{old('comentario')}}</textarea>
							<div style="color:red"><small>{{ $errors->first('comentario') }}</small></div>
						</div>
						<br><br><br><br><br><br>
						<div class="row">
							<label>Evalúe la honestidad de las personas que lo atendieron en el taller:</label>
							<div id="honestidad" class="range-input"></div>
							<input class="form-control" type="hidden" name="honestidad" value="5">
							<div class="col-md-4 bad-label"><strong>Poco confiable</strong></div>
							<div class="col-md-4 medium-label"><strong>Honrado</strong></div>
							<div class="col-md-4 good-label"><strong>Íntegro</strong></div>
						</div>
						<br><br><br><br><br><br>
						<div class="row">
							<label>¿Pudo el taller resolver los problemas de su vehículo de forma óptima?, califique la eficiencia del mismo:</label>
							<div id="eficiencia" class="range-input"></div>
							<input class="form-control" type="hidden" name="eficiencia" value="5">
							<div class="col-md-4 bad-label"><strong>Poco capacitado</strong></div>
							<div class="col-md-4 medium-label"><strong>Competente</strong></div>
							<div class="col-md-4 good-label"><strong>Eficiente</strong></div>
						</div>
						<br><br><br><br><br><br>
						<div class="row">
							<label>¿Cómo se siente respecto al precio de los servicios del taller?</label>
							<div id="precio" class="range-input"></div>
							<input class="form-control" type="hidden" name="precio" value="5">
							<div class="col-md-4 bad-label"><strong>Caro</strong></div>
							<div class="col-md-4 medium-label"><strong>Moderado</strong></div>
							<div class="col-md-4 good-label"><strong>Económico</strong></div>
						</div>
						<br><br><br><br>
						<div class="row">
							<input id="send-btn" type="submit" class="btn submit-btn center-block" value="Enviar">
						</div>
						
					</form>
				</div>
		  	</div>
		  	
		  	@endforeach
		  	
		  	@else
		  	<br>
		  	<br>
		  	<div class="alert alert-warning text-center">
			  <strong>Usted no tiene evaluaciones pendientes. Busque un taller de acuerdo a sus necesidades <a href="{{url('busquedataller')}}">aquí</a></strong>
			</div>
		  	@endif
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
	textarea {
    	resize: none;
	}
	.submit-btn
	{
		font-weight:bold;
		color: #373737;
		background-color:#f3d3be;
		width: 150px;
	}
	
	/*.range-input .noUi-connect
	{
		background: red;
	}*/
	#send-btn:hover
	{
		animation-name: btnbgtrans;
		animation-duration: 1s;
		-webkit-animation-fill-mode: forwards;
		animation-fill-mode: forwards;
    		
	} 
	@media only screen and (min-width: 640px) and (max-width: 1190px) {
	    #form-section-background
		{
			
			min-height:1200px;
			
			/*padding-top: 20vh;*/
		}
	
	}
</style>
<link href="{{ asset('css/nouislider.min.css') }}" rel="stylesheet">

<!-- In <body> -->
<script src="{{ asset('js/nouislider.min.js') }}"></script>
<script type="text/javascript">
var slider = document.getElementsByClassName('range-input');
for (var i = 0; i < slider.length; i++) {
	noUiSlider.create(slider[i], {
		start: 0,
		animate: true,
		step:1,
		connect: [true, false],
		range: {
			min: 0,
			max: 10
		},
		tooltips: [ true ],
	});

	slider[i].noUiSlider.on('slide', function(){
		var id= this.target.id;
		var value = this.get();
		if(value <= 5)
		{
			$("#" + id + " .noUi-connect").css("background","#c51010");
		}
		else if(value < 8)
		{
			$("#" + id + " .noUi-connect").css("background","#f58610");
		}
		if(value >= 8)
		{
			$("#" + id + " .noUi-connect").css("background","#49da5c");
		}
		$("input[name=" + id + "]").val(value);
	});
}



</script>		
@stop