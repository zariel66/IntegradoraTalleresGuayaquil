package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.EditText;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.listeners.SpinnerListener;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.KeyPairBoolData;
import com.example.karen.tallerguayaquil.models.Service;
import com.example.karen.tallerguayaquil.models.WorkShop;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.Util;
import com.example.karen.tallerguayaquil.widgets.MultiSpinnerSearch;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.Manifest.permission.ACCESS_FINE_LOCATION;


public class SignupServiceActivity extends AppCompatActivity
        implements OnMapReadyCallback {

    private GoogleMap mMapAddress;
    private Marker marker = null;
    private EditText mManagerName;
    private MultiSpinnerSearch mWorkshopServices, mVehicleBrands;
    private WorkShop workShop;

    private List<KeyPairBoolData> serviceList;
    private List<KeyPairBoolData> brandList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_service);

        // Get workshop
        workShop = (WorkShop) getIntent().getExtras().getSerializable("workshop");

        mManagerName = (EditText) findViewById(R.id.txt_managerName);
        mWorkshopServices = (MultiSpinnerSearch) findViewById(R.id.spn_workshop_services);
        mVehicleBrands = (MultiSpinnerSearch) findViewById(R.id.spn_vehicle_brands);

        // Init spinner adapters to services
        serviceList = new ArrayList<KeyPairBoolData>();

        // Init spinner adapters to brands
        brandList = new ArrayList<KeyPairBoolData>();

        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map_address);
        mapFragment.getMapAsync(this);
    }

    @Override
    protected void onResume() {
        super.onResume();
        populate();
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMapAddress = googleMap;

        LatLng guayaquil = new LatLng(-2.203816, -79.897453);
        marker = mMapAddress.addMarker(
                new MarkerOptions()
                        .position(guayaquil)
                        .draggable(true));
        mMapAddress.moveCamera(CameraUpdateFactory.newLatLng(guayaquil));


        if (mayRequestLocation()) {
            currentPosition();
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions,
                                           @NonNull int[] grantResults) {
        if (requestCode == Util.LOCATION_REQUEST_CODE) {
            if (grantResults.length == 1 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                currentPosition();
            } else {
                Util.showToast(getApplicationContext(), "Se requieren estos permisos para continuar");
                mayRequestLocation();
            }
        }
    }

    private boolean mayRequestLocation() {
        if (Build.VERSION.SDK_INT < Build.VERSION_CODES.M) {
            return true;
        }
        if (ActivityCompat.checkSelfPermission(this,
                ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            return true;
        }

        requestPermissions(new String[]{ACCESS_FINE_LOCATION}, Util.LOCATION_REQUEST_CODE);

        return false;
    }

    public void currentPosition() {
        mMapAddress.setMyLocationEnabled(true);
        mMapAddress.setOnMyLocationButtonClickListener(new GoogleMap.OnMyLocationButtonClickListener() {
            @Override
            public boolean onMyLocationButtonClick() {

                try {
                    Location location = mMapAddress.getMyLocation();
                    double latitude = location.getLatitude();
                    double longitude = location.getLongitude();

                    // Add a marker and move the camera
                    LatLng position = new LatLng(latitude, longitude);

                    marker.setPosition(position);

                    mMapAddress.moveCamera(CameraUpdateFactory.newLatLng(position));
                } catch (Exception e){

                }
                return false;
            }
        });
    }

    public void attemptSignup(View v) {


        // Reset errors.
        mManagerName.setError(null);

        String managerName = mManagerName.getText().toString();
        List<KeyPairBoolData> services = mWorkshopServices.getSelectedItems();
        List<KeyPairBoolData> brands = mVehicleBrands.getSelectedItems();

        boolean cancel = false;
        View focusView = null;

        if (!Util.isNameValid(managerName)) {
            mManagerName.setError(getString(R.string.error_field_required));
            focusView = mManagerName;
            cancel = true;
        }

        if (services.size() == 0){
            Util.showToast(getApplicationContext(), "Debe seleccionar por lo menos un servicio");
        }

        if (brands.size() == 0){
            Util.showToast(getApplicationContext(), "Debe seleccionar por lo menos una marca ");
        }

        if (cancel) {
            // There was an error; don't attempt login and focus the first
            // form field with an error.
            focusView.requestFocus();
        } else {
            if (Util.isNetworkAvailable(getApplicationContext())) {

                //Util.showLoading(SignupServiceActivity.this, "Registrando...");

                for ( KeyPairBoolData data : services) {
                    workShop.getBrandList().add(String.valueOf(data.getId()));
                }

                for ( KeyPairBoolData data : services) {
                    workShop.getServiceList().add(data.getName());
                }

                // Init Login
                Intent intent = new Intent(SignupServiceActivity.this, LoginActivity.class);
                startActivity(intent);
                finish();

                //signupTask(workShop);
            } else {
                Util.showToast(
                        getApplicationContext(), getString(R.string.message_network_connectivity_failed));
            }
        }
    }

    public void populate() {

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(getApplicationContext(), "Cargando...");
            brandsTask();
            servicesTask();
        } else {
            Util.showToast(getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }
    }

    /**
     * Brands task
     */
    private void servicesTask(){
        ApiService api = ServiceGenerator.createApiService();

        Call<List<Service>> call = api.getServices();
        call.enqueue(new Callback<List<Service>>() {

            @Override
            public void onResponse(Call<List<Service>> call, Response<List<Service>> response) {
                if (response.isSuccessful()) {
                    List<Service> services = response.body();

                    if (!services.isEmpty()) {
                        int i= 1;
                        for (Service s : services) {
                            KeyPairBoolData h = new KeyPairBoolData();
                            h.setId(i);
                            h.setName(s.getName());
                            h.setObject(s);
                            h.setSelected(false);

                            serviceList.add(h);
                            i++;
                        }

                        mWorkshopServices.setItems(serviceList, -1, new SpinnerListener() {
                            @Override
                            public void onItemsSelected(List<KeyPairBoolData> items) {
                                for(int i=0; i<items.size(); i++) {
                                    if(items.get(i).isSelected()) {
                                        Log.i("TAG", i + " : " + items.get(i).getName() + " : " + items.get(i).isSelected());
                                    }
                                }
                            }
                        });

                    } else {
                        Util.showToast(getApplicationContext(), getString(R.string.message_service_server_empty));
                    }
                } else {
                    Util.showToast(getApplicationContext(), getString(R.string.message_service_server_failed));
                }
                Util.hideLoading();
            }

            @Override
            public void onFailure(Call<List<Service>> call, Throwable t) {
                Util.showToast(getApplicationContext(), getString(R.string.message_network_local_failed));
                Util.hideLoading();
            }
        });
    }


    /**
     * Brands task
     */
    private void brandsTask(){
        ApiService api = ServiceGenerator.createApiService();

        Call<List<Brand>> call = api.getBrands();
        call.enqueue(new Callback<List<Brand>>() {

            @Override
            public void onResponse(Call<List<Brand>> call, Response<List<Brand>> response) {
                if (response.isSuccessful()) {
                    List<Brand> brands = response.body();

                    if (!brands.isEmpty()) {
                        for (Brand b : brands) {
                            KeyPairBoolData h = new KeyPairBoolData();
                            h.setId(b.getId());
                            h.setName(b.getName());
                            h.setObject(b);
                            h.setSelected(false);

                            brandList.add(h);
                        }

                        mVehicleBrands.setItems(brandList, -1, new SpinnerListener() {
                            @Override
                            public void onItemsSelected(List<KeyPairBoolData> items) {
                                for(int i=0; i<items.size(); i++) {
                                    if(items.get(i).isSelected()) {
                                        Log.i("TAG", i + " : " + items.get(i).getName() + " : " + items.get(i).isSelected());
                                    }
                                }
                            }
                        });

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

        Call<Void> call = auth.signupWorkshop(workShop);
        call.enqueue(new Callback<Void>() {
            @Override
            public void onResponse(@NonNull Call<Void> call, @NonNull Response<Void> response) {

                if (response.isSuccessful()) {
                    //if (!userResponse.isError()) {

                    Util.showToast(getApplicationContext(), "Registrado correctamente");

                    // Init Login
                    Intent intent = new Intent(SignupServiceActivity.this, LoginActivity.class);
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
}
