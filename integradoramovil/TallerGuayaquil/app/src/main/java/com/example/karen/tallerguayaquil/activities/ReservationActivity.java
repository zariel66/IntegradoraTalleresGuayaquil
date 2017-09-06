package com.example.karen.tallerguayaquil.activities;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.design.widget.FloatingActionButton;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.adapters.CommentAdapter;
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


public class ReservationActivity extends AppCompatActivity {

    private ListView mReservationView;
    private CommentAdapter commentAdapter;
    private List<Evaluation> evaluations;
    private TextView mEmptyTextView;
    private FloatingActionButton mSearchView;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reservation);

        mReservationView = (ListView) findViewById(R.id.list);
        mEmptyTextView = (TextView) findViewById(R.id.txt_empty);
        mSearchView = (FloatingActionButton) findViewById(R.id.btn_search);

        mReservationView.setEmptyView(mSearchView);

        mReservationView.setOnItemClickListener(new AdapterView.OnItemClickListener()
        {
            @Override
            public void onItemClick(AdapterView<?> arg0, View arg1,int position, long arg3)
            {
                Evaluation evaluation = evaluations.get(position);
                getReservation(evaluation.getCode());
            }
        });

        mSearchView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent intent = new Intent(ReservationActivity.this, ScannerActivity.class);
                startActivity(intent);
            }
        });

        evaluations = new ArrayList<>();
        commentAdapter = new CommentAdapter(getApplicationContext(), evaluations);
        mReservationView.setAdapter(commentAdapter);
    }

    @Override
    protected void onResume() {
        super.onResume();
        populateComments();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main_workshop, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (id == R.id.action_about) {
            showAbout();
            return true;
        }else if (id == R.id.action_logout) {
            showLogOut();
            return true;
        }

        return false;
    }

    private void showAbout(){
        AlertDialog alert = new AlertDialog.Builder(ReservationActivity.this)
                .create();

        // Setting Dialog Title
        alert.setTitle("Acerca De");
        // Setting Dialog Message
        alert.setMessage("Esta aplicación es un demo del grupo 2 de la integradora.\nKaren Ponce y Dimitri Laaz\n\nTodos los derechos reservados");
        // Setting Icon to Dialog
        alert.setIcon(R.drawable.workshop_marker);
        // Showing Alert Message
        alert.show();
    }

    private void showLogOut(){
        AlertDialog.Builder alert = new AlertDialog.Builder(ReservationActivity.this);
        alert.setTitle("Taller Guayaquil");
        alert.setMessage("Desea cerrar sesión?");
        alert.setIcon(R.drawable.workshop_marker);

        alert.setPositiveButton("Aceptar", new DialogInterface.OnClickListener(){
            public void onClick(DialogInterface dialog, int whichButton) {
                SessionManager sessionManager = new SessionManager(getApplicationContext());
                sessionManager.clear();

                Util.showToast(getApplicationContext(), "Sesion cerrada correctamente");
                Intent i = new Intent(ReservationActivity.this, ActionActivity.class);
                dialog.dismiss();
                startActivity(i);
                finish();

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

    private void populateComments() {

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(ReservationActivity.this, "Buscando reservaciones...");

            SessionManager sessionManager = new SessionManager(getApplicationContext());
            ApiService auth = ServiceGenerator.createApiService();

            Map<String, String> params = new HashMap<>();
            params.put("api_token", sessionManager.getToken());

            Call<Api<List<Evaluation>>> call = auth.getReservations(params);
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

                            commentAdapter.notifyDataSetChanged();
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
            commentAdapter.notifyDataSetChanged();
            Util.showToast(
                    getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }

    }

    private void getReservation(String code) {

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(ReservationActivity.this, "Buscando reservación...");

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

                                Intent i = new Intent(ReservationActivity.this, CompleteActivity.class);
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
                }
            });
        } else {
            Util.showToast(
                    getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }

    }
}
