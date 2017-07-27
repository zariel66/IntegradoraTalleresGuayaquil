package com.example.karen.tallerguayaquil;


import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class SignupVehicleActivity extends AppCompatActivity implements Spinner.OnItemSelectedListener{

    //Declaring an Spinner
      private Spinner spinner;
    //An ArrayList for Spinner Items
      ArrayList<String> marcas;
     EditText txtmodelo;
     Button btnregistrar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_vehicle);


        //Initializing the ArrayList
        marcas = new ArrayList<String>();
        spinner = (Spinner) findViewById(R.id.spin_marcas);
        txtmodelo = (EditText) findViewById(R.id.txtmodelo);
        btnregistrar = (Button) findViewById(R.id.btnregistrar);

       // btnregistrar.setOnClickListener(this);

        spinner.setOnItemSelectedListener(this);
         getData();
    }


    private void getData(){
        String url ="http://192.168.0.4:8000/api/marcas";
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {

                            JSONArray jsonObj = new JSONArray(response);

                            JSONObject obj = new JSONObject();
                            for (int i = 0; i < jsonObj.length(); i++) {
                                JSONObject c = jsonObj.getJSONObject(i);
                                String result = c.getString("nombre");
                                marcas.add(result);
                            }
                            spinner.setAdapter(new ArrayAdapter<String>(SignupVehicleActivity.this, android.R.layout.simple_spinner_dropdown_item, marcas));
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {

                    }
                });

          RequestQueue requestQueue = Volley.newRequestQueue(this);
        //Adding request to the queue
        requestQueue.add(stringRequest);
    }


    @Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {

    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }


    private void registerUser( final String nombre, final String apellido, final String username, final String password, final String correo){
       final String modelo=txtmodelo.getText().toString();

        String url ="http://192.168.0.4:8000/api/clientes";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(SignupVehicleActivity.this,response,Toast.LENGTH_LONG).show();
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(SignupVehicleActivity.this,error.toString(),Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String,String> getParams(){
                Map<String,String> params = new HashMap<String, String>();
                params.put("nombre",nombre);
                params.put("apellido",apellido);
                params.put("username",username);
                params.put("password",password);
                params.put("correo",correo);
                params.put("modelo",modelo);
                return params;
            }

        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }

    public void onClick(View v) {
        if(v == btnregistrar){
            Bundle parametros = this.getIntent().getExtras();
            String nombre = parametros.getString("nombre");
            String apellido = parametros.getString("apellido");
            String correo = parametros.getString("correo");
            String username = parametros.getString("usuario");
            String password = parametros.getString("password");
            registerUser(nombre,apellido,username,password,correo);
        }

    }

}


