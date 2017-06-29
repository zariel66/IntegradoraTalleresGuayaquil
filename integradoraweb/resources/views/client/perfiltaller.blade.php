@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="page-header">
		    	<h3><strong>Nombre taller o empresa</strong></h3>      
		  	</div>
		  	<div class="row">
		  		<div class="col-md-8">
		  			<div ><p>Direccion</p></div>
		  			<div ><p>Los servicios ofrecidos por nuestro taller son:</p></div>
		  			<div ><p>Trabajamos con las siguientes marcas de vehiculos:</p></div>
		  			<br>
		  			<button class="btn" style="background-color: #cdc0b7">Deseo contactarme</button>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="row">
		  				<div class="col-md-4">
		  					<div class="bar-label">Honestidad</div>
		  					<div class="bar-label">Eficiencia</div>
		  					<div class="bar-label">Costo</div>
		  				</div>
		  				<div class="col-md-8">
		  					<div class="progress">
							    <div class="progress-bar .progress-bar-danger low-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:40%">
							      4.3
							    </div>
							</div>
							<div class="progress">
							    <div class="progress-bar .progress-bar-danger medium-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:68%">
							     6.8
							    </div>
							</div>
							<div class="progress">
							    <div class="progress-bar .progress-bar-danger high-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:84%">
							     8.4
							    </div>
							</div>
		  				</div>
		  				
		  			</div>
		  			<div class="row">

		  			</div>
		  			
		  		</div>
		  	</div>
		  	<br>
		  	
		  	<hr>
		  	<div class="comment-section">
		  		<div class="">
		  			<h4><strong>Comentarios del servicio</strong></h4> 
		  		</div>
		  		<br>
		  		<div>
		  			<div class="user-comment row">
		  				<div class="col-md-8">
		  					<p class="user-comment-username"><strong>UsuarioX</strong> comento:</p>
		  					<p>Nome gusto la forma en como me atendieron</p>
		  					<p class="date-comment text-left">24/05/2017 8h50</p>
		  				</div>
		  				<div class="col-md-2 col-md-offset-2">
		  					
		  					<div class="row">
				  				<div class="col-md-4">
				  					<div class="bar-label-mini"><strong>Honestidad</strong></div>
				  					<div class="bar-label-mini"><strong>Eficiencia</strong></div>
				  					<div class="bar-label-mini"><strong>Costo</strong></div>
				  				</div>
				  				<div class="col-md-8">
				  					<div class="progress mini-progress">
									    <div class="progress-bar .progress-bar-danger low-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:40%">
									     
									    </div>
									</div>
									<div class="progress mini-progress">
									    <div class="progress-bar .progress-bar-danger medium-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:68%">
									     
									    </div>
									</div>
									<div class="progress mini-progress">
									    <div class="progress-bar .progress-bar-danger high-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:84%">
									    
									    </div>
									</div>
				  				</div>
				  				
				  			</div>
		  				</div>
		  			</div>
		  			<div class="user-comment row">
		  				<div class="col-md-8">
		  					<p class="user-comment-username"><strong>UsuarioX</strong> comento:</p>
		  					<p>Nome gusto la forma en como me atendieron</p>
		  					<p class="date-comment text-left">24/05/2017 8h50</p>
		  				</div>
		  				<div class="col-md-2 col-md-offset-2">
		  					
		  					<div class="row">
				  				<div class="col-md-4">
				  					<div class="bar-label-mini"><strong>Honestidad</strong></div>
				  					<div class="bar-label-mini"><strong>Eficiencia</strong></div>
				  					<div class="bar-label-mini"><strong>Costo</strong></div>
				  				</div>
				  				<div class="col-md-8">
				  					<div class="progress mini-progress">
									    <div class="progress-bar .progress-bar-danger low-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:40%">
									     
									    </div>
									</div>
									<div class="progress mini-progress">
									    <div class="progress-bar .progress-bar-danger medium-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:68%">
									     
									    </div>
									</div>
									<div class="progress mini-progress">
									    <div class="progress-bar .progress-bar-danger high-grade" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:84%">
									    
									    </div>
									</div>
				  				</div>
				  				
				  			</div>
		  				</div>
		  			</div>
		  		</div>	
		  		
		  	</div>
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

				.bar-label
				{
					margin-bottom: 20px;
				}
				.low-grade
				{
					background-image: linear-gradient(to bottom,#f90505 0,#770404 100%);
				}
				.medium-grade
				{
					background-image: linear-gradient(to bottom,#acb10c 0,#e4b509 100%);
				}
				.high-grade
				{
					background-image: linear-gradient(to bottom,#60f906 0,#2c940a 100%);
				}
				.user-comment
				{
					padding-top: 20px;
					padding-bottom: 20px;
					background-color: #f1e4dc;
					border: ridge 2px #afa6a6;
				}
				.user-comment-username
				{
					margin-bottom: 18px;
				}
				.date-comment
				{
					font-size: 9px;
				}
				.mini-progress
				{
					height: 13px;
					margin: 0;
				}
				.bar-label-mini
				{
					font-size: 9px;
				}
			</style>
	
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
	</script>	
@stop