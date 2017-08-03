package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.view.View;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.utils.SessionManager;

public class ActionActivity extends AppCompatActivity {

        @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        initialize();
        setContentView(R.layout.activity_action);
    }

    public void signupPerson(View view) {
        Bundle b = new Bundle();
        b.putInt("type", 1);

        Intent i = new Intent(this, SignupPersonActivity.class);
        i.putExtras(b);
        startActivity(i);
    }

    public void signupWorkShop(View view) {
        Bundle b = new Bundle();
        b.putInt("type", 2);

        Intent i = new Intent(this, SignupPersonActivity.class);
        i.putExtras(b);
        startActivity(i);
    }

    public void login(View view) {
        Intent i = new Intent(this, LoginActivity.class);
        startActivity(i);
    }


    /**
     * Initialize user and actions
     */
    public void initialize(){

        SessionManager sessionManager = new SessionManager(getApplicationContext());
        Intent intent;

        if (sessionManager.hasToken()){
            intent = new Intent(ActionActivity.this, MainActivity.class);
            startActivity(intent);
            finish();
        }

    }

}
