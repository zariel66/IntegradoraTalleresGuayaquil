<h1>Saludos {{$user->nombre}}</h1>
<br>
<p>Hace poco registró una cuenta en nuestro sitio GEOCARFIX con su usuario <strong>{{$user->username}}</strong>.</p>
<p>
	Para confirmar la creación de esta cuenta ingrese al siguiente enlace {{url('confirmarcuenta',[$user->api_token,$user->correo])}} 
</p>
<br>
<p>Gracias por preferirnos.</p>