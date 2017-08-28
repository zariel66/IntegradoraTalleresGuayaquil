package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
<<<<<<< HEAD
=======
import android.os.Bundle;
import android.support.annotation.NonNull;
>>>>>>> master
import android.support.v7.app.AppCompatActivity;
<<<<<<< HEAD
import android.os.Bundle;
=======
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
>>>>>>> master
import android.view.View;

import com.example.karen.tallerguayaquil.R;

public class LoginActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
    }

<<<<<<< HEAD
    public void categorias(View view) {
        Intent i = new Intent(this, MainActivity.class);
        startActivity(i);
=======

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
                                Intent intent;

                                if (p.getType() == 1) { // Taller
                                    intent = new Intent(LoginActivity.this, ReservationActivity.class);
                                } else { // Cliente
                                    intent = new Intent(LoginActivity.this, MapActivity.class);
                                }

                                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                startActivity(intent);
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
>>>>>>> master
    }
}
