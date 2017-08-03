package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;

import com.example.karen.tallerguayaquil.R;

public class ActionActivity extends AppCompatActivity {

        @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_action);

    }

    public void signupPerson(View view) {
        Intent i = new Intent(this, SignupPersonActivity.class);
        startActivity(i);
    }

    public void signupWorkShop(View view) {
        Intent i = new Intent(this, SignupWorkShopActivity.class);
        startActivity(i);

    }

    public void login(View view) {
        Intent i = new Intent(this, LoginActivity.class);
        startActivity(i);
    }
}
