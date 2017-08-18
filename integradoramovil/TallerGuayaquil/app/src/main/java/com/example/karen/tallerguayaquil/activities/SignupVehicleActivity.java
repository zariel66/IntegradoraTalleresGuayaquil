package com.example.karen.tallerguayaquil.activities;


import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.models.Vehicle;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.Util;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;


public class SignupVehicleActivity extends AppCompatActivity{

    //Declaring an Spinner
    private ArrayAdapter<Brand> brandArrayAdapter;
    private Spinner mVehicleBrands;
    private Person person;

    private EditText mModelView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_vehicle);

        // Get workshop
        person = (Person) getIntent().getExtras().getSerializable("person");

        mVehicleBrands = (Spinner) findViewById(R.id.spn_vehicle_brand);
        mModelView = (EditText) findViewById(R.id.txt_model);

        brandArrayAdapter = new ArrayAdapter<Brand>(this, android.R.layout.select_dialog_singlechoice);
        mVehicleBrands.setAdapter(brandArrayAdapter);
    }


    @Override
    protected void onResume() {
        super.onResume();

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(SignupVehicleActivity.this, "Cargando...");
            brandsTask();
        } else {
            Util.showToast(getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }
    }

    public void attemptSignup(View v) {


        // Reset errors.
        mModelView.setError(null);

        String modelName = mModelView.getText().toString();
        Brand brand = (Brand) mVehicleBrands.getSelectedItem();

        boolean cancel = false;
        View focusView = null;

        if (modelName.length() < 2) {
            mModelView.setError(getString(R.string.error_field_required));
            focusView = mModelView;
            cancel = true;
        }

        if (brand==null){
            Util.showToast(getApplicationContext(), "Debe seleccionar una marca");
        }

        if (cancel) {
            // There was an error; don't attempt login and focus the first
            // form field with an error.
            focusView.requestFocus();
        } else {
            if (Util.isNetworkAvailable(getApplicationContext())) {

                Util.showLoading(SignupVehicleActivity.this, "Registrando...");

                List<Vehicle> vehicles = new ArrayList<>();
                Vehicle vehicle = new Vehicle();
                vehicle.setModel(modelName);
                vehicle.setBrand(brand);
                vehicles.add(vehicle);

                person.setVehicles(vehicles);

                signupTask(person);

            } else {
                Util.showToast(
                        getApplicationContext(), getString(R.string.message_network_connectivity_failed));
            }
        }
    }

    /**
     * Brands task
     */
    private void brandsTask(){
        ApiService api = ServiceGenerator.createApiService();

        Call<List<Brand>> call = api.getBrands();
        call.enqueue(new Callback<List<Brand>>() {

            @Override
            public void onResponse(Call<List<Brand>> call, retrofit2.Response<List<Brand>> response) {
                if (response.isSuccessful()) {
                    List<Brand> brands = response.body();

                    if (!brands.isEmpty()) {
                        for (Brand b : brands) {
                            brandArrayAdapter.add(b);
                        }
                        brandArrayAdapter.notifyDataSetChanged();

                    } else {
                        Util.showToast(getApplicationContext(), getString(R.string.message_service_server_empty));
                    }
                } else {
                    Util.showToast(getApplicationContext(), getString(R.string.message_service_server_failed));
                }
                Util.hideLoading();
            }

            @Override
            public void onFailure(Call<List<Brand>> call, Throwable t) {
                Log.e("Marcas", t.getMessage());
                Util.showToast(getApplicationContext(), getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }


    /**
     * Signup Task
     */
    private void signupTask(Person person){

        ApiService auth = ServiceGenerator.createApiService();

        Call<Api> call = auth.signupPerson(person);
        call.enqueue(new Callback<Api>() {
            @Override
            public void onResponse(@NonNull Call<Api> call, @NonNull retrofit2.Response<Api> response) {

                if (response.isSuccessful()) {
                    Api api = response.body();

                    if (!api.isError()) {
                        Util.showToast(getApplicationContext(), api.getMsg());

                        // Init Login
                        Intent intent = new Intent(SignupVehicleActivity.this, LoginActivity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        startActivity(intent);

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
            public void onFailure(@NonNull Call<Api> call, @NonNull Throwable t) {

                Util.showToast(getApplicationContext(),
                        getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }
}


