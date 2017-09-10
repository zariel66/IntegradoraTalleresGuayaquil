@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="row">
				<h2 class="page-header"><strong>Historial de Clientes</strong></h2>
			</div>
			
			<div class="row">
				<div class="col-md-2 col-md-offset-3 text-right">
				<p><strong>Visualizar por año</strong></p>
				</div>
				<div class="col-md-2">
					<select class="form-control" id="searchfilter" onchange="yearSelect()">
						<option value="0">Todo el tiempo</option>
						<option value="{{\Carbon\Carbon::now()->year}}">{{\Carbon\Carbon::now()->year}}</option>
						<option value="{{\Carbon\Carbon::now()->subYears(1)->year}}">{{\Carbon\Carbon::now()->subYears(1)->year}}</option>
						<option value="{{\Carbon\Carbon::now()->subYears(2)->year}}">{{\Carbon\Carbon::now()->subYears(2)->year}}</option>
						<option value="{{\Carbon\Carbon::now()->subYears(3)->year}}">{{\Carbon\Carbon::now()->subYears(3)->year}}</option>
						<option value="{{\Carbon\Carbon::now()->subYears(4)->year}}">{{\Carbon\Carbon::now()->subYears(4)->year}}</option>
					</select>
				</div>
			</div>

			<br><br>
			<div class="row">
				<table class="table table-striped table-hover">
					<thead>
					  <tr>
						<th class="text-center">Cliente</th>
						<th class="text-center">Fecha de la visita</th>
						<th class="text-center">Taller</th>
						<th class="text-center">Descuento Recibido</th>
						<th class="text-center">Total Cancelado</th></tr>
					</thead>
					<tbody id="history-table">
					  
					  @include("workshop.snippet.historialtable")
					</tbody>
				</table>
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

	#search-icon
	{
		position: initial;
	}

	.porcentaje-label
	{
		display: inline-block;
	    font-size: 120%;
	    margin-top: 9px;
	}
	.ui-state-active,
	.ui-widget-content .ui-state-active,
	.ui-widget-header .ui-state-active,
	a.ui-button:active,
	.ui-button:active,
	.ui-button.ui-state-active:hover {
	background-color: #e6e6e6;
	border-color: white;
	color:black;
	}
	.sendDiscount
	{
		font-weight:bold;
		color: #373737;
		background-color:#f3d3be;
	}
	@media only screen and (min-width: 640px) and (max-width: 1190px) {
		    #form-section-background
			{
				
				min-height:85vh;
				
				/*padding-top: 20vh;*/
			}
		
		}
</style>


<script type="text/javascript">

var tableContent = $("#history-table").html();
function yearSelect()
{
	var anio = $("#searchfilter").val();
	if(anio == 0)
	{
		$("#history-table").html(tableContent);
		return;
	}
	var jqxhr = $.ajax({
		method: "GET",
		url: "historialtaller",
		dataType: 'json',
		data: {year: anio},
		success: function(response)
		{
			if(response.success == 1)
			{
				
				$("#history-table").html(response.html);	
			}
			
		}
	});
			
}
</script>
@stop