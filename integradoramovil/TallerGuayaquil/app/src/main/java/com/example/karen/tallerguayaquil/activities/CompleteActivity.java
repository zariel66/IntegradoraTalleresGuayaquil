package com.example.karen.tallerguayaquil.activities;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Evaluation;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.Util;

import java.util.HashMap;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CompleteActivity extends AppCompatActivity {

    private TextView mNameView, mCodeView, mTotalView;
    private EditText mDescountView, mSubTotalView;
    private Button mSendView;

    private Evaluation evaluation;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_complete);

        evaluation = (Evaluation) getIntent().getExtras().getSerializable("evaluation");

        mNameView = (TextView) findViewById(R.id.txt_name);
        mNameView.setText(evaluation.getUser().getFullName());

        mCodeView = (TextView) findViewById(R.id.txt_code);
        mCodeView.setText(evaluation.getCode());

        mTotalView = (TextView) findViewById(R.id.txt_total);
        mSubTotalView = (EditText) findViewById(R.id.txt_subtotal);
        mDescountView = (EditText) findViewById(R.id.txt_descount);

        mDescountView.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void afterTextChanged(Editable editable) {
                double descount = 0;
                double subtotal = 0;
                try {
                    descount = Double.valueOf(editable.toString());
                    subtotal = Double.valueOf(mSubTotalView.getText().toString());
                } catch (Exception ignore){}

                if (descount > 0 && subtotal > 0) {
                    mTotalView.setText("" + (subtotal - (subtotal * descount / 100)));
                } else {
                    mTotalView.setText("");
                }
            }
        });

        mSubTotalView.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void afterTextChanged(Editable editable) {
                double descount = 0;
                double subtotal = 0;
                try {
                    descount = Double.valueOf(mDescountView.getText().toString());
                    subtotal = Double.valueOf(editable.toString());
                } catch (Exception ignore){}

                if (descount > 0 && subtotal > 0) {
                    mTotalView.setText("" + (subtotal - (subtotal * descount / 100)));
                } else {
                    mTotalView.setText("");
                }
            }
        });

        mSendView = (Button) findViewById(R.id.btn_send);

        mSendView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                attemptSend();
            }
        });
    }

    public void attemptSend() {

        // Reset errors.
        mDescountView.setError(null);
        mSubTotalView.setError(null);
        mTotalView.setError(null);

        // Store values at the time of the login attempt.
        String descount = mDescountView.getText().toString();
        String subtotal = mSubTotalView.getText().toString();
        String total = mTotalView.getText().toString();

        boolean cancel = false;
        View focusView = null;

        if (TextUtils.isEmpty(descount)) {
            mDescountView.setError(getString(R.string.error_field_required));
            focusView = mDescountView;
            cancel = true;
        }else if (Double.valueOf(descount) == 0) {
            mDescountView.setError("Descuento debe ser mayor a 0");
            focusView = mDescountView;
            cancel = true;
        }else if (Double.valueOf(descount) > 100) {
            mDescountView.setError("Descuento debe ser menor a 100");
            focusView = mDescountView;
            cancel = true;
        }


        if (TextUtils.isEmpty(subtotal)) {
            mSubTotalView.setError(getString(R.string.error_field_required));
            focusView = mSubTotalView;
            cancel = true;
        }else if (Double.valueOf(subtotal) == 0) {
            mSubTotalView.setError("Subtotal debe ser mayor a 0");
            focusView = mSubTotalView;
            cancel = true;
        }else if (Double.valueOf(subtotal) > 100) {
            mSubTotalView.setError("Subtotal debe ser menor a 100");
            focusView = mSubTotalView;
            cancel = true;
        }


        if (TextUtils.isEmpty(total)) {
            mTotalView.setError(getString(R.string.error_field_required));
            focusView = mTotalView;
            cancel = true;
        }else if (Double.valueOf(total) > 100) {
            mTotalView.setError("Total debe ser menor a 100");
            focusView = mTotalView;
            cancel = true;
        }

        if (cancel) {
            // There was an error; don't attempt login and focus the first
            // form field with an error.
            focusView.requestFocus();
        } else {
            if (Util.isNetworkAvailable(getApplicationContext())) {

                Util.showLoading(CompleteActivity.this, "Enviando...");

                Map<String, String> params = new HashMap<>();
                params.put("id", "" + evaluation.getId());
                params.put("precio", subtotal);
                params.put("descuento", descount);
                params.put("total", total);

                evaluationTask(params);
            } else {
                Util.showToast(getApplicationContext(), getString(R.string.message_network_connectivity_failed));
            }
        }
    }

    private void evaluationTask(Map<String,String> params){

        Util.showLoading(CompleteActivity.this, "Cerrando ticket...");
        ApiService authService = ServiceGenerator.createApiService();
        Call<Api> call = authService.closeTicket(params);
        call.enqueue(new Callback<Api>() {
            @Override
            public void onResponse(@NonNull Call<Api> call, @NonNull Response<Api> response) {
                Log.e("Ticket", response.toString());

                if (response.isSuccessful()) {
                    Api api = response.body();
                    Util.showToast(getApplicationContext(), api.getMsg());

                    if (!api.isError()) {
                        finish();
                    }
                } else {
                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_service_server_failed));
                }
                Util.hideLoading();
            }

            @Override
            public void onFailure(@NonNull Call<Api> call, @NonNull Throwable t) {
                Util.showToast(getApplicationContext(), getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }


}
