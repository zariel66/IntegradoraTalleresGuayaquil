package com.example.karen.tallerguayaquil;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class RegistroPersona extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro_persona);
    }

    public void registrovehiculo(View view) {
        Intent i = new Intent(this, RegistroVehiculo.class );
        startActivity(i);
    }
}
