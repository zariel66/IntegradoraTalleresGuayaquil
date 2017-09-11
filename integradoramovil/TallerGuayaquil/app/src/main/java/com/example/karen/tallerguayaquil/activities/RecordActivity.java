package com.example.karen.tallerguayaquil.activities;

import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.design.widget.FloatingActionButton;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.adapters.CommentAdapter;
import com.example.karen.tallerguayaquil.adapters.RecordAdapter;
import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Evaluation;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.SessionManager;
import com.example.karen.tallerguayaquil.utils.Util;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;

public class RecordActivity extends AppCompatActivity {

    private ListView mRecordView;
    private RecordAdapter recordAdapter;
    private List<Evaluation> evaluations;
    private TextView mEmptyTextView;
    private FloatingActionButton mSearchView;

    private String mYear = "";
    private String[] spinnerArray;
    private HashMap<Integer,String> spinnerMap = new HashMap<>();

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_record);

        createFilter();

        mRecordView = (ListView) findViewById(R.id.list);
        mEmptyTextView = (TextView) findViewById(R.id.txt_empty);
        mSearchView = (FloatingActionButton) findViewById(R.id.btn_search);

        mRecordView.setEmptyView(mEmptyTextView);

        mSearchView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                LayoutInflater inflater = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                View v = inflater.inflate(R.layout.dialog_record, null, false);

                ArrayAdapter<String> yearArrayAdapter =new ArrayAdapter<String>(
                        getApplicationContext(), R.layout.dialog_item, spinnerArray);

                final Spinner mYearView = v.findViewById(R.id.spn_year);
                mYearView.setAdapter(yearArrayAdapter);

                AlertDialog.Builder alert = new AlertDialog.Builder(RecordActivity.this);
                alert.setIcon(R.drawable.workshop_marker);
                alert.setView(v);

                alert.setPositiveButton("Aceptar", new DialogInterface.OnClickListener(){
                    public void onClick(DialogInterface dialog, int whichButton) {
                        int position = mYearView.getSelectedItemPosition();
                        mYear = spinnerMap.get(position);
                        populateRecord();
                    }
                });

                alert.setNegativeButton("Cancelar", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        dialog.dismiss();
                    }
                });

                AlertDialog ad = alert.create();
                ad.show();
            }
        });

        evaluations = new ArrayList<>();
        recordAdapter = new RecordAdapter(getApplicationContext(), evaluations);
        mRecordView.setAdapter(recordAdapter);
    }

    @Override
    protected void onResume() {
        super.onResume();
        populateRecord();
    }

    private void createFilter(){
        spinnerArray = getResources().getStringArray(R.array.years);

        for (int i = 0; i < spinnerArray.length; i++) {
            String value;

            if (i==0) value = "";
            else value = spinnerArray[i];

            spinnerMap.put(i, value);
        }
    }

    private void populateRecord(){
        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(RecordActivity.this, "Buscando historial...");

            SessionManager sessionManager = new SessionManager(getApplicationContext());
            ApiService auth = ServiceGenerator.createApiService();

            Map<String, String> params = new HashMap<>();
            params.put("api_token", sessionManager.getToken());
            params.put("year", mYear);

            Call<Api<List<Evaluation>>> call = auth.getRecord(params);
            call.enqueue(new Callback<Api<List<Evaluation>>>() {
                @Override
                public void onResponse(@NonNull Call<Api<List<Evaluation>>> call,
                                       @NonNull retrofit2.Response<Api<List<Evaluation>>> response) {

                    if (response.isSuccessful()) {
                        Api<List<Evaluation>> api = response.body();

                        if (api.isError()) {
                            // Show message error
                            Util.showToast(getApplicationContext(), api.getMsg());
                        } else {
                            evaluations.clear();

                            List<Evaluation> evaluationList = api.getData();

                            if (evaluationList != null && evaluationList.size() > 0) {
                                for (Evaluation evaluation : evaluationList) {
                                    evaluations.add(evaluation);
                                }
                            }

                            recordAdapter.notifyDataSetChanged();
                        }
                    } else {
                        Util.showToast(getApplicationContext(),
                                getString(R.string.message_service_server_failed));
                    }
                    Util.hideLoading();
                }

                @Override
                public void onFailure(@NonNull Call<Api<List<Evaluation>>> call, @NonNull Throwable t) {

                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_network_local_failed));
                    Util.hideLoading();
                }
            });
        } else {
            evaluations.clear();
            recordAdapter.notifyDataSetChanged();
            Util.showToast(
                    getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }
    }
}