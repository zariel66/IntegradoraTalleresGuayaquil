package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.EditText;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Api;
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
                Util.hideSoftKeyboard(getApplicationContext(), getCurrentFocus());
                Util.showLoading(LoginActivity.this, "Iniciando Sesión...");

                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);

                loginTask(params);
            } else {
                Util.showToast(getApplicationContext(), getString(R.string.message_network_connectivity_failed));
            }
        }
    }


    private void loginTask(Map<String,String> params){

        ApiService authService = ServiceGenerator.createApiService();
        Call<Api<Person>> call = authService.login(params);
        call.enqueue(new Callback<Api<Person>>() {
            @Override
            public void onResponse(@NonNull Call<Api<Person>> call, @NonNull Response<Api<Person>> response) {
                Log.e("Login", response.toString());

                if (response.isSuccessful()) {
                    Api<Person> api = response.body();

                    if (!api.isError()) {
                        Util.showToast(getApplicationContext(), api.getMsg());

                        Person p = api.getData();
                        if (p!=null) {

                            SessionManager sessionManager = new SessionManager(LoginActivity.this);
                            if (sessionManager.savePerson(p)) {
                                Intent intent = null;
                                int type = p.getType();

                                if (type == 1) { // Taller
                                    intent = new Intent(LoginActivity.this, ReservationActivity.class);
                                } else if (type == 2) { // Cliente
                                    intent = new Intent(LoginActivity.this, MapActivity.class);
                                } else {
                                    Util.showToast(getApplicationContext(),
                                            "La cuenta ingresada no ha sido actualizada. " +
                                            "Ingrese a su correo para activar su cuenta.");
                                }

                                if (intent != null) {
                                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                    startActivity(intent);
                                }
                            }
                        } else {
                            Util.showToast(getApplicationContext(),
                                    getString(R.string.message_service_server_failed));
                        }

                    } else {
                        // Show message error
                        Util.showToast(getApplicationContext(), api.getMsg());
                    }
                } else {
                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_service_server_failed));
                }
                Util.hideLoading();
            }

            @Override
            public void onFailure(@NonNull Call<Api<Person>> call, @NonNull Throwable t) {
                Util.showToast(getApplicationContext(), getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }
}
