@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="row">
				<h2 class="page-header"><strong>Clientes interesados</strong></h2>
			</div>
			<div class="row">
				<br>
				<br>
				<div id="opmessage" class=" text-center alert col-md-6 col-md-offset-3" style="display:none;">
				  <strong>Success!</strong> Indicates a successful or positive action.
				</div>
				<br>
				<br>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-3 col-md-offset-3">
					<div class="input-group">
					  <span class="input-group-addon glyphicon glyphicon-search" id="search-icon"></span>
					  <input type="search" class="form-control" placeholder="Buscar" aria-describedby="basic-addon1" id="buscador" onkeyup="restoretable(event)">
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
						<th class="text-center">Precio Final</th>
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
var tableContent;
function filterSearch()
{
	var filter = $("#searchfilter").val();
	$("#buscador").autocomplete({
		source: "busquedatickets/" + filter,
		minLength: 1,
		position: { my : "right top", at: "right bottom" },
		select: function( event, ui ) {
			user = ui.item.value;
			$(this).val(ui.item.label);
			var jqxhr = $.ajax({
				method: "GET",
				url: "cargarticket/" + user,
				dataType: 'json',
				data: {usuario: user},
				success: function(response)
				{
					if(response.success == 1)
					{
						tableContent = $("#tickets-table").html(); 
						$("#tickets-table").html(response.html);	
					}
					
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
// $('.doubleonly').keypress(function(eve) {
// 	if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
// 		eve.preventDefault();
// 	}
// });
function doubleOnlyPress(event)
{
	if ((event.which != 46 || $(event.target).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) || (event.which == 46 && $(event.target).caret().start == 0) ) {
		event.preventDefault();
	}
}     
// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
// $('.doubleonly').keyup(function(eve) {
// 	if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
// 	}
// });

function doubleOnlyUp(event)
{
	if($(event.target).val().indexOf('.') == 0) {    $(event.target).val($(event.target).val().substring(1));
	}
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    
    return true;
}

function maxnumber(event,entero)
{
	var number = event.target.value
	if(number > 100)
	{
		event.target.value = number.substr(0, number.length - 1);
	}
	else if(number*1 <= 0)
	{
		event.target.value = number.substr(0, number.length - 1);
	}
}

function calcTotal(id)
{
	$('#btnEnviar'+ id).prop("disabled", true);
	var precio = $("#preciooriginal" + id).val();
	var descuento = $("#descuento" + id).val();
	if(precio!="" && descuento!="")
	{
		var valor= parseFloat(precio -  precio * (descuento/100)).toFixed(2)
		$("#total" + id).val(valor);
		$('#btnEnviar'+ id).prop("disabled", false);	
	}
	else
	{
		$("#total" + id).val("");
	}
	
}

function actualizarRecomendacion(id)
{
	$("#opmessage").hide();
	$("#opmessage").removeClass("alert-success");
	$("#opmessage").removeClass("alert-danger");
	var precio = $("#preciooriginal" + id).val();
	var descuento = $("#descuento" + id).val();
	var total = $("#total" + id).val();
	var request={"id": id,"precio":precio , "descuento":descuento, "total": total};
	var jqxhr = $.ajax({
		method: "POST",
		url: "cerrarticket",
		dataType: 'json',
		data: request,
		success: function(response)
		{
			
			if(response.success == 1)
			{
				$("#opmessage").html(response.message);
				$("#opmessage").addClass("alert-success");
				$("#opmessage").show();
				$("#fila"+id).remove();
				 
			}
			else
			{
				$("#opmessage").html(response.message);
				$("#opmessage").addClass("alert-danger");
				$("#opmessage").show();
			}
		}
	});
}

function restoretable(event)
{
	var value = event.target.value;
	if(value == "")
	{
		$("#tickets-table").html(tableContent);	
	}
}

filterSearch();

</script>
@stop