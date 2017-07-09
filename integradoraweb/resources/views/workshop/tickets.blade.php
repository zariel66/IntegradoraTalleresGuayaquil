@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="row">
				<h2 class="page-header"><strong>Clientes interesados</strong></h2>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-3 col-md-offset-3">
					<div class="input-group">
					  <span class="input-group-addon glyphicon glyphicon-search" id="search-icon"></span>
					  <input type="search" class="form-control" placeholder="Buscar por nombre" aria-describedby="basic-addon1" id="buscador">
					</div>
										
				</div>
				<div class="col-md-2">
					<select class="form-control" id="searchfilter" onchange="filterSearch()">
						<option value="1">Por nombre</option>
						<option value="2">Por código</option>
					</select>
				</div>
			</div>
			<br><br>
			<div class="row">
				<table class="table table-striped table-hover">
					<thead>
					  <tr>
						<th class="text-center">Codigo</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">Taller</th>
						<th class="text-center">Precio Normal</th>
						<th class="text-center">% descuento</th>
						<th class="text-center">Precio con descuento</th>
						<th class="text-center">Enviar</th>
					  </tr>
					</thead>
					<tbody id="tickets-table">
					  
					  @include("workshop.snippet.ticketsrow",["rows"=>$rows])
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
</style>


<script type="text/javascript">

function filterSearch()
{
	$("#buscador").autocomplete({
		source: "busquedatickets/" + $("#searchfilter").val(),
		minLength: 1,
		position: { my : "right top", at: "right bottom" },
		select: function( event, ui ) {
			user = ui.item.value;
			$(this).val(ui.item.label);
			var jqxhr = $.ajax({
				method: "GET",
				url: "",
				dataType: 'json',
				data: {usuario: user},
				success: function(response)
				{
					$("#tickets-table").html(response.html);

				}
			});
			return false;
		},
		focus: function( event, ui ) {
			$(this).val(ui.item.label);
			return false;
		}


	});	
}
filterSearch();
</script>
@stop