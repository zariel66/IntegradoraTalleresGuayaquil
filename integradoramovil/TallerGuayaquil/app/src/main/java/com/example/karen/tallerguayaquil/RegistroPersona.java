package com.example.karen.tallerguayaquil;

import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;


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


/*    private void registerUser() {
        final String nombre = txtnombre.getText().toString().trim();
        final String apellido = txtapellido.getText().toString().trim();
        final String correo = txtcorreo.getText().toString().trim();
        final String usuario = txtusuario.getText().toString().trim();
        final String password = txtpassword.getText().toString().trim();

        StringRequest stringRequest = new StringRequest(Request.Method.POST, URL_FOR_REGISTRATION,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(RegistroPersona.this, response, Toast.LENGTH_SHORT).show();
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(RegistroPersona.this, error.toString(), Toast.LENGTH_LONG).show();
                    }

                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(KEY_NOMBRE, nombre);
                params.put(KEY_APELLIDO, apellido);
                params.put(KEY_CORREO, correo);
                params.put(KEY_USUARIO, usuario);
                params.put(KEY_PASSWORD, password);
                return params;
            }


        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);

    }

    @Override
    public void onClick(View v) {
        if (v == btnsiguiente) {
            if(txtnombre.getText().toString().equals("")|| txtapellido.getText().toString().equals("")||txtcorreo.getText().toString().equals("") || txtusuario.getText().toString().equals("")||txtpassword.getText().toString().equals("")){
                Toast.makeText(RegistroPersona.this,"Por favor, llene todos los campos",Toast.LENGTH_LONG).show();
            }else {
                String name = txtnombre.getText().toString();
                String apellido = txtapellido.getText().toString();
                String correo = txtcorreo.getText().toString();
                String usuario = txtusuario.getText().toString();
                String password = txtpassword.getText().toString();
            registerUser();
        }
    }
}*/









/*
    /*
    btnsiguiente.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View view) {

            if(txtnombre.getText().toString().equals("")|| txtapellido.getText().toString().equals("")||txtcorreo.getText().toString().equals("") || txtusuario.getText().toString().equals("")||txtpassword.getText().toString().equals("")){
                Toast.makeText(RegistroPersona.this,"Por favor, llene todos los campos",Toast.LENGTH_LONG).show();
            }else {
                String name = txtnombre.getText().toString();
                String apellido = txtapellido.getText().toString();
                String correo = txtcorreo.getText().toString();
                String usuario = txtusuario.getText().toString();
                String password = txtpassword.getText().toString();

               // MedicamentoModel medicamento_new= new MedicamentoModel(0,name,num_dias,dosis,indicaciones,0);

                // 1. create an intent pass class name or intnet action name
                Intent intent = new Intent(getApplicationContext(), RegistroVehiculo.class);

                // 2. put key/value data
               // intent.putExtra("medicamento", medicamento_new);

                // 3. or you can add data to a bundle
                Bundle extras = new Bundle();
                extras.putString("status", "Datos correctos");

                // 4. add bundle to intent
                intent.putExtras(extras);

                // 5. start the activity
                startActivity(intent);
            }



        }
    }
    */


