package com.example.karen.tallerguayaquil.activities;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.Spinner;

import com.example.karen.tallerguayaquil.R;


public class SignupServiceActivity extends AppCompatActivity {
    private Spinner spinner1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_service);


        spinner1 = (Spinner) findViewById(R.id.spinner1);
        String[] servicios = {"Mecanico", "Electrico-Mecanico", "Tapizado", "dividir"};
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, servicios);
        spinner1.setAdapter(adapter);
    }
}
