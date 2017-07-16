<h1>Saludos {{$user->nombre}}</h1>
<br>
<p>Para restablecer tu contraseña has click en el siguiente enlace {{url('nuevopwd',[$user->pass_token,$user->correo])}}</p>
<p>
	Recuerda que este enlace solo puede ser usado una vez, puedes volver a generarlo a través de {{url('forgotpassword')}}
</p>
<br>
<p>Gracias por preferirnos.</p>