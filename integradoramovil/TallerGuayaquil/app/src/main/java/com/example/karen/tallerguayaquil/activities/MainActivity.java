package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

import com.example.karen.tallerguayaquil.R;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }

    public void mecanicos(View view) {
        Intent i = new Intent(this, MapActivity.class);
        startActivity(i);
    }
}