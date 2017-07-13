package com.example.karen.tallerguayaquil;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class Principal extends AppCompatActivity {
        @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_principal);

    }

    public void registropersona(View view) {
        Intent i = new Intent(this, RegistroPersona.class);
        startActivity(i);
    }

    public void registrotaller(View view) {
        Intent i = new Intent(this, RegistroTaller.class);
        startActivity(i);

    }

    public void credencial(View view) {
        Intent i = new Intent(this, Credencial.class);
        startActivity(i);
    }
}
