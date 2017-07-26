package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

import com.example.karen.tallerguayaquil.R;

public class ActionActivity extends AppCompatActivity {

        @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_action);

    }

    public void registropersona(View view) {
        Intent i = new Intent(this, SignupPersonActivity.class);
        startActivity(i);
    }

    public void registrotaller(View view) {
        Intent i = new Intent(this, SignupWorkshopActivity.class);
        startActivity(i);

    }

    public void credencial(View view) {
        Intent i = new Intent(this, LoginActivity.class);
        startActivity(i);
    }
}
