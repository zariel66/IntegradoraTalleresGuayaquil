package com.example.karen.tallerguayaquil;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.Spinner;


public class RegistroServicios extends AppCompatActivity {
    private Spinner spinner1;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro_servicios);


        spinner1 = (Spinner) findViewById(R.id.spinner1);
        String []servicios={"Mecanico","Electrico-Mecanico","Tapizado","dividir"};
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,android.R.layout.simple_spinner_item, servicios);
        spinner1.setAdapter(adapter);
    }
}
