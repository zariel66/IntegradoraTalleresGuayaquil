package com.example.karen.tallerguayaquil;


import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import java.util.ArrayList;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class RegistroVehiculo extends AppCompatActivity implements Spinner.OnItemSelectedListener{

    //Declaring an Spinner
      private Spinner spinner;

    //An ArrayList for Spinner Items
      ArrayList<String> marcas;

     EditText txtmodelo;
     Button btnregistrar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro_vehiculo);

        //Initializing the ArrayList
        marcas = new ArrayList<String>();
        spinner = (Spinner) findViewById(R.id.spin_marcas);
        //spinner = (Spinner) findViewById(R.id.spinner1);
        txtmodelo = (EditText) findViewById(R.id.txtmodelo);
        btnregistrar = (Button) findViewById(R.id.btnregistrar);
        spinner.setOnItemSelectedListener(this);

        getData();
    }



    private void getData(){
        RequestQueue queue = Volley.newRequestQueue(this);
        String url ="http://192.168.0.4:8000/marcas";
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
                            spinner.setAdapter(new ArrayAdapter<String>(RegistroVehiculo.this, android.R.layout.simple_spinner_dropdown_item, marcas));
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
}
