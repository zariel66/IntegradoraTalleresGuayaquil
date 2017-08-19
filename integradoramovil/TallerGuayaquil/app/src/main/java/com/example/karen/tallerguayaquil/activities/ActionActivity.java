package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.utils.SessionManager;

public class ActionActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_action);
    }

    @Override
    protected void onResume() {
        super.onResume();
        initialize();
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
        Person person = sessionManager.getPerson();
        Intent intent = null;

        if (person.getType() == 1) { // Taller
            intent = new Intent(ActionActivity.this, ReservationActivity.class);
        } else if (person.getType() == 2) { // Cliente
            intent = new Intent(ActionActivity.this, MapActivity.class);
        }

        if (intent != null ) {

            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intent);
            finish();
        }
    }

}
