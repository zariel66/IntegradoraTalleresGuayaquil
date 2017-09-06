package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Evaluation;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.SessionManager;
import com.example.karen.tallerguayaquil.utils.Util;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import java.util.HashMap;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;

public class ScannerActivity extends AppCompatActivity {

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        IntentIntegrator integrator = new IntentIntegrator(this);
        integrator.setDesiredBarcodeFormats(IntentIntegrator.QR_CODE_TYPES);
        integrator.setPrompt("Escanear Código de Descuento");
        integrator.setCameraId(0);  // Use a specific camera of the device
        integrator.setBeepEnabled(true);
        integrator.setBarcodeImageEnabled(true);
        integrator.setOrientationLocked(false);
        integrator.initiateScan();
    }

    // Get the results:
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        if(result != null) {
            if(result.getContents() == null) {
                Util.showToast(getApplicationContext(), "Cancelado");
                finish();
            } else {
                getReservation(result.getContents());
            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }
    }

    private void getReservation(String code) {

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(ScannerActivity.this, "Buscando reservación...");

            SessionManager sessionManager = new SessionManager(getApplicationContext());
            ApiService auth = ServiceGenerator.createApiService();

            Map<String, String> params = new HashMap<>();
            params.put("api_token", sessionManager.getToken());
            params.put("code", code);

            Call<Api<Evaluation>> call = auth.getReservation(params);
            call.enqueue(new Callback<Api<Evaluation>>() {
                @Override
                public void onResponse(@NonNull Call<Api<Evaluation>> call,
                                       @NonNull retrofit2.Response<Api<Evaluation>> response) {
                    Log.i("scanner", response.toString());

                    if (response.isSuccessful()) {
                        Api<Evaluation> api = response.body();

                        if (api.isError()) {
                            // Show message error
                            Util.showToast(getApplicationContext(), api.getMsg());
                        } else {
                            Evaluation evaluation = api.getData();


                            if (evaluation!=null) {
                                Bundle bundle = new Bundle();
                                bundle.putSerializable("evaluation", evaluation);

                                Intent i = new Intent(ScannerActivity.this, CompleteActivity.class);
                                i.putExtras(bundle);
                                startActivity(i);
                            }
                        }
                    } else {
                        Util.showToast(getApplicationContext(),
                                getString(R.string.message_service_server_failed));
                    }
                    Util.hideLoading();
                    finish();
                }

                @Override
                public void onFailure(@NonNull Call<Api<Evaluation>> call, @NonNull Throwable t) {

                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_network_local_failed));
                    Util.hideLoading();
                    finish();
                }
            });
        } else {
            Util.showToast(
                    getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }

    }

}
