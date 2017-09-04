@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-6 col-md-offset-3">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6 text-left">
					<h1><strong>Mi Perfil - Usuario</strong></h1>
				</div>
				
			</div>
			<hr>
			<div id="user-info" class="row">
				<div class="row">
					<div class="col-md-10 text-left">
						<h3><strong>Información de la Cuenta</strong></h3>
					</div>
					<div class="col-md-2 text-right" style="line-height:55px;padding-right:30px;padding-top:8px;">
						<a href="" data-toggle="modal" data-target="#userDataForm">Editar</a>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-8 text-left">
						<p><strong>Nombres y Apellidos: </strong>{{$usuario->nombre}} {{$usuario->apellido}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 text-left">
						<p><strong>Usuario: </strong>{{$usuario->username}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 text-left">
						<p><strong>Correo: </strong>{{$usuario->correo}}</p>
					</div>
				</div>
			</div>
			<br>
			<hr>
			<div id="user-cars" class="row">
				<div class="row">
					<div class="col-md-12 text-left">
						<h3><strong>Vehículos registrados</strong></h3>
					</div>
				</div>
				<br>
				<table class="table table-striped table-hover">
					<thead>
					  <tr>
						<th class="text-center">Modelo</th>
						<th class="text-center">Marca del Vehículo</th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						
					  </tr>
					</thead>
					<tbody  id="car-table">
					  @include("client.snippet.carsrows")
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="userDataForm" role="dialog">
	<div class="modal-dialog">
	
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Editar Información de la Cuenta</h4>
		</div>
		<div class="modal-body" id="formeditar">
			@include("basic.snippet.formeditarusuario")
		</div>
		<div class="modal-footer">
			<button onclick="editarUsuario()" type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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


	
		#search-btn:hover
		{
			animation-name: btnbgtrans;
			animation-duration: 1s;
			-webkit-animation-fill-mode: forwards;
			animation-fill-mode: forwards;
				
		}
		#user-info
		{
			padding-left: 25px;
			border:ridge 2px #e4e8e8;
			/*background-color: #f2f9f7;*/
			background-color:#e8f5f7;
		}
		#user-cars
		{
			padding-left: 25px;
		}
		@media only screen and (min-width: 640px) and (max-width: 1190px) {
		   #form-section-background
			{
				
				min-height:85vh;
				
				padding-top: 12vh;
			}
			
		}
	</style>
	<script type="text/javascript">
	function addCar() {
		var marca = $("#marca").val();
		var modelo = $("#modelo").val();
		var values = {"idmarca":marca, "modelo":modelo};
		if(modelo == "")
		{
			return;
		}
		var jqxhr = $.ajax({
			method: "POST",
			url: "anadircarro",
			dataType: 'json',
			data: values,
			success: function(response)
			{
				if(response.success == 1)
				{
					$("#car-table").html(response.html);
				}
			}
		});
	};

	function deleteCar(id)
	{
		var values = {"idvehiculo":id};
		var jqxhr = $.ajax({
			method: "POST",
			url: "borrarcarro",
			dataType: 'json',
			data: values,
			success: function(response)
			{
				if(response.success == 1)
				{
					$("#car-table").html(response.html);
				}
			}
		});
	}

	function editCar(id)
	{
		var modelo = $("#modelo" + id).val();
		var marca = $("#marca" + id).val();
		var values = {"id":id,"modelo":modelo, "marca":marca};
		var jqxhr = $.ajax({
			method: "POST",
			url: "editarcarro",
			dataType: 'json',
			data: values,
			success: function(response)
			{
				if(response.success == 1)
				{
					$("#car-table").html(response.html);
				}
			}
		});
	}
	function editarUsuario()
	{
		var nombre = $("input[name=nombre]").val();
		var apellido = $("input[name=apellido]").val();
		var correo = $("input[name=correo]").val();
		var username = $("input[name=username]").val();
		var values = {"nombre":nombre,"apellido":apellido,"correo":correo,"username":username};
		var jqxhr = $.ajax({
			method: "POST",
			url: "editarusuario",
			dataType: 'json',
			data: values,
			success: function(response)
			{
				if(response.success == 1)
				{
					location.reload(true);
				}
				else
				{
					$("#formeditar").html(response.html);
					$("input[name=nombre]").val(nombre);
					$("input[name=apellido]").val(apellido);
					$("input[name=correo]").val(correo);
					$("input[name=username]").val(username);
				}
			}
		});
	}
	</script>
@stop