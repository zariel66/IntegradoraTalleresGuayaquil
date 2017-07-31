package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.EditText;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.SessionManager;
import com.example.karen.tallerguayaquil.utils.Util;

import java.util.HashMap;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity {

    private EditText mUsernameView, mPasswordView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        mUsernameView = (EditText) findViewById(R.id.txt_username);
        mPasswordView = (EditText) findViewById(R.id.txt_password);

        mPasswordView.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                if (id == EditorInfo.IME_ACTION_DONE) {
                    Util.hideSoftKeyboard(getApplicationContext(), getCurrentFocus());
                    attemptLogin(null);
                    return true;
                }
                return false;
            }
        });
    }

    /**
     * Attempts to sign in or register the account specified by the login form.
     * If there are form errors (invalid email, missing fields, etc.), the
     * errors are presented and no actual login attempt is made.
     */
    public void attemptLogin(View v) {


        // Reset errors.
        mUsernameView.setError(null);
        mPasswordView.setError(null);

        // Store values at the time of the login attempt.
        String username = mUsernameView.getText().toString();
        String password = mPasswordView.getText().toString();

        boolean cancel = false;
        View focusView = null;


        if (TextUtils.isEmpty(username)) {
            mUsernameView.setError(getString(R.string.error_field_required));
            focusView = mUsernameView;
            cancel = true;
        }

        if (TextUtils.isEmpty(password)) {
            mPasswordView.setError(getString(R.string.error_field_required));
            focusView = mPasswordView;
            cancel = true;
        }


        if (cancel) {
            // There was an error; don't attempt login and focus the first
            // form field with an error.
            focusView.requestFocus();
        } else {
            if (Util.isNetworkAvailable(getApplicationContext())) {

                //Util.showLoading(LoginActivity.this, "Iniciando Sesión...");

                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);

                //loginTask(params);

                Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            } else {
                Util.showToast(getApplicationContext(), getString(R.string.message_network_connectivity_failed));
            }
        }
    }


    private void loginTask(Map<String,String> params){

        ApiService authService = ServiceGenerator.createApiService();
        Call<Person> call = authService.login(params);

        call.enqueue(new Callback<Person>() {
            @Override
            public void onResponse(@NonNull Call<Person> call, @NonNull Response<Person> response) {
                if (response.isSuccessful()) {
                    Person person = response.body();

                    // Save user in shared preferences
                    SessionManager sessionManager = new SessionManager(getApplicationContext());
                    //sessionManager.savePerson(person);

                    // Show message success
                    Util.showToast(getApplicationContext(), "Inicio de Sesión existoso");

                    // Init Main
                    Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                    startActivity(intent);
                    finish();

                } else {
                    Util.showToast(getApplicationContext(), getString(R.string.message_service_server_failed));
                }
                Util.hideLoading();
            }

            @Override
            public void onFailure(@NonNull Call<Person> call, @NonNull Throwable t) {
                Util.showToast(getApplicationContext(), getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }
}
