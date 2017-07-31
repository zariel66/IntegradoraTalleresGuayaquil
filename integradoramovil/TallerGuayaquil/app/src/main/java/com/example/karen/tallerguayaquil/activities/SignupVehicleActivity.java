package com.example.karen.tallerguayaquil.activities;


import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.models.WorkShop;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.Util;

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

        if (!Util.isNameValid(modelName)) {
            mModelView.setError(getString(R.string.error_field_required));
            focusView = mModelView;
            cancel = true;
        }

        if (brand.getId() != 0){
            Util.showToast(getApplicationContext(), "Debe seleccionar una marca");
        }

        if (cancel) {
            // There was an error; don't attempt login and focus the first
            // form field with an error.
            focusView.requestFocus();
        } else {
            if (Util.isNetworkAvailable(getApplicationContext())) {

                //Util.showLoading(SignupVehicleActivity.this, "Registrando...");

                person.setModelName(modelName);
                person.setBrand(brand);

                //signupTask(person);

                // Init Login
                Intent intent = new Intent(SignupVehicleActivity.this, LoginActivity.class);
                startActivity(intent);
                finish();

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
                Util.showToast(getApplicationContext(), getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }


    /**
     * Signup Task
     */
    private void signupTask(WorkShop workShop){

        ApiService auth = ServiceGenerator.createApiService();

        Call<Void> call = auth.signupPerson(person);
        call.enqueue(new Callback<Void>() {
            @Override
            public void onResponse(@NonNull Call<Void> call, @NonNull retrofit2.Response<Void> response) {

                if (response.isSuccessful()) {
                    //if (!userResponse.isError()) {

                    Util.showToast(getApplicationContext(), "Registrado correctamente");

                    // Init Login
                    Intent intent = new Intent(SignupVehicleActivity.this, LoginActivity.class);
                    startActivity(intent);
                    finish();

                    /*} else {
                        // Show message error
                        Util.showToast(getApplicationContext(), "Revise los parametros");
                    }*/
                } else {
                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_service_server_failed));
                }
                Util.hideLoading();
            }

            @Override
            public void onFailure(@NonNull Call<Void> call, @NonNull Throwable t) {

                Util.showToast(getApplicationContext(),
                        getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }

    /*

    private void registerUser( final String nombre, final String apellido, final String username, final String password, final String correo){
       final String modelo=txtmodelo.getText().toString();

        String url ="http://192.168.0.4:8000/api/clientes";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(SignupVehicleActivity.this,response,Toast.LENGTH_LONG).show();
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(SignupVehicleActivity.this,error.toString(),Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String,String> getParams(){
                Map<String,String> params = new HashMap<String, String>();
                params.put("nombre",nombre);
                params.put("apellido",apellido);
                params.put("username",username);
                params.put("password",password);
                params.put("correo",correo);
                params.put("modelo",modelo);
                return params;
            }

        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }

    public void onClick(View v) {
        if(v == btnregistrar){
            Bundle parametros = this.getIntent().getExtras();
            String nombre = parametros.getString("nombre");
            String apellido = parametros.getString("apellido");
            String correo = parametros.getString("correo");
            String username = parametros.getString("usuario");
            String password = parametros.getString("password");
            registerUser(nombre,apellido,username,password,correo);
        }

    }*/

}


