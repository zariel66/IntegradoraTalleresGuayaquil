package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.karen.tallerguayaquil.R;


public class SignupPersonActivity extends AppCompatActivity implements View.OnClickListener {

    //Definiendo Views
     EditText txtnombre, txtapellido, txtcorreo, txtusuario, txtpassword;
    private Button btnsiguiente;
    //Variable tipo cliente


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_person);

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
            Toast.makeText(SignupPersonActivity.this, "Por favor, llene todos los campos", Toast.LENGTH_LONG).show();
           } else {
                  String nombre=txtnombre.getText().toString();
                  String apellido=txtapellido.getText().toString();
                  String correo=txtcorreo.getText().toString();
                  String usuario=txtusuario.getText().toString();
                  String password=txtpassword.getText().toString();

                  Bundle parametros = new Bundle();
                  parametros.putString("nombre", nombre);
                  parametros.putString("apellido", apellido);
                  parametros.putString("correo", correo);
                  parametros.putString("usuario", usuario);
                  parametros.putString("password", password);


                Intent i = new Intent(this, SignupVehicleActivity.class);

                i.putExtras(parametros);
                startActivity(i);
       }
    }
}





