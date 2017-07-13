package com.example.karen.tallerguayaquil;

import android.content.Intent;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;


public class RegistroPersona extends AppCompatActivity implements View.OnClickListener {

    //Definiendo Views
    private EditText txtnombre, txtapellido, txtcorreo, txtusuario, txtpassword;
    private Button btnsiguiente;
    //Variable tipo cliente


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro_persona);



        //Inicializando Views
        txtnombre = (EditText) findViewById(R.id.txtnombre);
        txtapellido = (EditText) findViewById(R.id.txtapellido);
        txtcorreo = (EditText) findViewById(R.id.txtcorreo);
        txtusuario = (EditText) findViewById(R.id.txtusuario);
        txtpassword = (EditText) findViewById(R.id.txtpassword);
        btnsiguiente = (Button) findViewById(R.id.btn_siguiente);
        btnsiguiente.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
       if (txtnombre.getText().toString().equals("") || txtapellido.getText().toString().equals("") || txtcorreo.getText().toString().equals("") || txtusuario.getText().toString().equals("") || txtpassword.getText().toString().equals("")) {
            Toast.makeText(RegistroPersona.this, "Por favor, llene todos los campos", Toast.LENGTH_LONG).show();
           } else {
            String name = txtnombre.getText().toString();
            String apellido = txtapellido.getText().toString();
            String correo = txtcorreo.getText().toString();
            String usuario = txtusuario.getText().toString();
            String password = txtpassword.getText().toString();

            Intent intent = new Intent(RegistroPersona.this, RegistroVehiculo.class);
            Bundle extras = new Bundle();
            startActivity(intent);
       }
    }
}





