package com.example.karen.tallerguayaquil;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class RegistroTaller extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro_taller);
    }

    public void registroservicios(View view) {
        Intent i = new Intent(this, RegistroServicios.class);
        startActivity(i);
    }
}
