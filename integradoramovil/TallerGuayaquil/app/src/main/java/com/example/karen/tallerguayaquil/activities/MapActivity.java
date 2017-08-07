package com.example.karen.tallerguayaquil.activities;

import android.Manifest;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentSender;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.graphics.Typeface;
import android.location.Location;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.NumberPicker;
import android.widget.TextView;
import android.widget.Toast;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Service;
import com.example.karen.tallerguayaquil.models.Vehicle;
import com.example.karen.tallerguayaquil.models.WorkShop;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.SessionManager;
import com.example.karen.tallerguayaquil.utils.Util;
import com.getbase.floatingactionbutton.FloatingActionButton;
import com.getbase.floatingactionbutton.FloatingActionsMenu;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.LocationSettingsRequest;
import com.google.android.gms.location.LocationSettingsResult;
import com.google.android.gms.location.LocationSettingsStates;
import com.google.android.gms.location.LocationSettingsStatusCodes;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;


import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import io.realm.Realm;
import io.realm.RealmResults;
import io.realm.Sort;
import retrofit2.Call;
import retrofit2.Callback;

import static android.Manifest.permission.ACCESS_FINE_LOCATION;

public class MapActivity extends AppCompatActivity
        implements
        OnMapReadyCallback,
        GoogleApiClient.ConnectionCallbacks,
        GoogleApiClient.OnConnectionFailedListener,
        LocationListener{

    private GoogleMap mMap;
    private GoogleApiClient mGoogleApiClient = null;
    private List<Marker> markerList = null;

    private ArrayAdapter<Vehicle> vehicleArrayAdapter;
    private ArrayAdapter<Service> serviceArrayAdapter;

    private Vehicle vehicle = null;
    private Service service = null;
    private double lastLat=0, lastLong=0;
    private int distance = 5;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);

        final FloatingActionsMenu menu_fab = (FloatingActionsMenu) findViewById(R.id.menu_fab);
        FloatingActionButton fab_route = (FloatingActionButton) findViewById(R.id.fab_route);
        FloatingActionButton fab_stop = (FloatingActionButton) findViewById(R.id.fab_stop);
        fab_route.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                menu_fab.collapse();
                showServices();
            }
        });
        fab_stop.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                menu_fab.collapse();
                showVehicles();
            }
        });

        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        // Markers
        markerList = new ArrayList<>();
    }


    @Override
    protected void onResume() {
        super.onResume();

        if (mayRequestLocation())
            connectAPIGoogle();

        populateServices();
        populateVehicles();
    }

    @Override
    protected void onStop() {
        super.onStop();
        disconnectAPIGoogle();
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;

        mMap.setMyLocationEnabled(true);

        LatLng guayaquil = new LatLng(-2.203816, -79.897453);
        /*Marker marker = mMap.addMarker(
                new MarkerOptions()
                        .position(guayaquil)
                        .draggable(true));*/
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(guayaquil, 10));

        mMap.setInfoWindowAdapter(new GoogleMap.InfoWindowAdapter() {

            @Override
            public View getInfoWindow(Marker arg0) {
                return null;
            }

            @Override
            public View getInfoContents(Marker marker) {

                LinearLayout info = new LinearLayout(getApplicationContext());
                info.setOrientation(LinearLayout.VERTICAL);

                TextView title = new TextView(getApplicationContext());
                title.setTextColor(Color.BLACK);
                title.setGravity(Gravity.CENTER);
                title.setTypeface(null, Typeface.BOLD);
                title.setText(marker.getTitle());

                TextView snippet = new TextView(getApplicationContext());
                snippet.setTextColor(Color.GRAY);
                snippet.setText(marker.getSnippet());

                info.addView(title);
                info.addView(snippet);

                return info;
            }
        });
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions,
                                           @NonNull int[] grantResults) {
        if (requestCode == Util.LOCATION_REQUEST_CODE) {
            if (grantResults.length == 1 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                connectAPIGoogle();
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

    void populateServices(){
        // Options services
        if (serviceArrayAdapter==null) {
            serviceArrayAdapter = new ArrayAdapter<Service>(getApplicationContext(),
                    R.layout.dialog_item);

            serviceArrayAdapter.addAll(Util.getServices());

            // Select first service by default;
            service = serviceArrayAdapter.getItem(0);
        }
    }

    void populateVehicles(){
        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(MapActivity.this, "Buscando vehículos...");

            // Options services
            if (vehicleArrayAdapter == null)
                vehicleArrayAdapter = new ArrayAdapter<>(getApplicationContext(),
                        R.layout.dialog_item);
            else
                vehicleArrayAdapter.clear();

            ApiService auth = ServiceGenerator.createApiService();
            SessionManager sessionManager = new SessionManager(getApplicationContext());
            Call<Api<List<Vehicle>>> call = auth.getVehicles(sessionManager.getPerson());
            call.enqueue(new Callback<Api<List<Vehicle>>>() {
                @Override
                public void onResponse(@NonNull Call<Api<List<Vehicle>>> call,
                                       @NonNull retrofit2.Response<Api<List<Vehicle>>> response) {

                    if (response.isSuccessful()) {
                        Api<List<Vehicle>> api = response.body();

                        if (api.isError()) {
                            // Show message error
                            Util.showToast(getApplicationContext(), api.getMsg());
                        } else {
                            vehicleArrayAdapter.addAll(api.getData());

                            // Select first vehicle by default;
                            vehicle = vehicleArrayAdapter.getItem(0);
                        }
                    } else {
                        Util.showToast(getApplicationContext(),
                                getString(R.string.message_service_server_failed));
                    }
                    Util.hideLoading();
                }

                @Override
                public void onFailure(@NonNull Call<Api<List<Vehicle>>> call, @NonNull Throwable t) {

                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_network_local_failed));
                    Util.hideLoading();
                }
            });
        } else {
            Util.showToast(
                    getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }

        /*
        Realm realm = Realm.getDefaultInstance();
        try {
            RealmResults<Vehicle> result = realm.where(Vehicle.class).findAllSorted("id", Sort.DESCENDING);
            if(!result.isEmpty()){
                vehicleArrayAdapter.addAll(realm.copyFromRealm(result));

                // Select first vehicle by default;
                vehicle = vehicleArrayAdapter.getItem(0);
            } else {
                Util.showToast(getApplicationContext(), "Problemas en la BD, intente nuevamente");
            }

        } finally {
            realm.close();
        }*/
    }

    private void showServices(){

        if(serviceArrayAdapter.isEmpty()) {
            Toast.makeText(getApplicationContext(),"No hay servicios disponibles",Toast.LENGTH_LONG).show();
        }else{
            final AlertDialog.Builder alert = new AlertDialog.Builder(MapActivity.this);
            alert.setTitle("Servicios");
            alert.setCancelable(true);

            alert.setAdapter(
                    serviceArrayAdapter,
                    new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            service = serviceArrayAdapter.getItem(which);

                            // Search workshops in radius
                            search();
                        }
                    });
            alert.show();
        }
    }

    private void showVehicles(){

        if(vehicleArrayAdapter.isEmpty()) {
            Toast.makeText(getApplicationContext(),"No hay vehículos disponibles",Toast.LENGTH_LONG).show();
        }else{
            final AlertDialog.Builder alert = new AlertDialog.Builder(MapActivity.this);
            alert.setTitle("Vehículos");
            alert.setCancelable(true);

            alert.setAdapter(
                    vehicleArrayAdapter,
                    new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            vehicle = vehicleArrayAdapter.getItem(which);

                            // Search workshops in radius
                            search();
                        }
                    });
            alert.show();
        }
    }

    public void showRadiusPicker() {

        // Build picker
        final NumberPicker np = new NumberPicker(getApplicationContext());
        np.setMaxValue(50); // max value 100
        np.setMinValue(1);   // min value 0
        np.setWrapSelectorWheel(false);
        np.setBackgroundColor(R.color.colorAccent);

        final AlertDialog.Builder alert = new AlertDialog.Builder(MapActivity.this);
        alert.setTitle("Seleccione el radio de búsqueda (KM)");
        alert.setCancelable(true);
        alert.setPositiveButton("Aceptar", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                distance = np.getValue();
                Util.showToast(getApplicationContext(),
                        "Buscando talleres de " + service.toString() +
                                " para " + vehicle.toString() +
                                " en " + distance + "Km de radio");

                searchWorkshops();
            }
        });
        alert.setView(np);
        alert.show();
    }

    private void search() {
        if (lastLat==0 && lastLong==0) {
            Util.showToast(getApplicationContext(), "Estamos buscando su posición, intente en unos minutos\n" + lastLat + " " + lastLong);
        } else if (vehicle != null && service != null) {
            showRadiusPicker();
        } else {
            Util.showToast(getApplicationContext(), "Hubo problemas, cierre y vuelva abrir la aplicación");
        }
    }

    /* Tracking */

    @Override
    public void onLocationChanged(Location location) {

        if (location != null) {
            lastLat = location.getLatitude();
            lastLong = location.getLongitude();
        }

    }

    @Override
    public void onConnected(@Nullable Bundle bundle) {

        // Make a request for locations
        LocationRequest locationRequest = LocationRequest.create();
        locationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        locationRequest.setInterval(3000);
        locationRequest.setFastestInterval(1000);

        LocationServices.FusedLocationApi.requestLocationUpdates(mGoogleApiClient, locationRequest, this);

        Util.showToast(getApplicationContext(), "Conectado!");
    }

    @Override
    public void onConnectionSuspended(int i) {

    }

    @Override
    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {

    }

    private boolean checkPlayServices() {
        GoogleApiAvailability apiAvailability = GoogleApiAvailability.getInstance();
        int resultCode = apiAvailability.isGooglePlayServicesAvailable(this);
        if (resultCode != ConnectionResult.SUCCESS) {
            if (apiAvailability.isUserResolvableError(resultCode)) {
                apiAvailability.getErrorDialog(this, resultCode, Util.PLAY_SERVICES_REQUEST_CODE)
                        .show();
            } else {
                Util.showToast(getApplicationContext(),
                        "Por favor actualize Google Play Services para usar todos nuestros servicios.");
                finish();
            }
            return false;
        }
        return true;
    }

    private void connectAPIGoogle() {

        if (checkPlayServices()) {

            if (mGoogleApiClient == null) {
                mGoogleApiClient = new GoogleApiClient.Builder(this)
                        .addConnectionCallbacks(this)
                        .addOnConnectionFailedListener(this)
                        .addApi(LocationServices.API)
                        .build();
                mGoogleApiClient.connect();

                // Make a request for locations
                LocationRequest locationRequest = LocationRequest.create();
                locationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
                locationRequest.setInterval(3000);
                locationRequest.setFastestInterval(1000);

                LocationSettingsRequest.Builder builder = new LocationSettingsRequest.Builder()
                        .addLocationRequest(locationRequest);

                //**************************
                builder.setAlwaysShow(true); //this is the key ingredient
                //**************************

                PendingResult<LocationSettingsResult> result =
                        LocationServices.SettingsApi.checkLocationSettings(mGoogleApiClient, builder.build());
                result.setResultCallback(new ResultCallback<LocationSettingsResult>() {
                    @Override
                    public void onResult(LocationSettingsResult result) {
                        final Status status = result.getStatus();
                        final LocationSettingsStates state = result.getLocationSettingsStates();

                        switch (status.getStatusCode()) {
                            case LocationSettingsStatusCodes.SUCCESS:
                                // All location settings are satisfied. The client can initialize location
                                // requests here.

                                break;
                            case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
                                // Location settings are not satisfied. But could be fixed by showing the user
                                // a dialog.
                                try {
                                    // Show the dialog by calling startResolutionForResult(),
                                    // and check the result in onActivityResult().
                                    status.startResolutionForResult(
                                            MapActivity.this, 1000);
                                } catch (IntentSender.SendIntentException e) {
                                    // Ignore the error.
                                }
                                break;
                            case LocationSettingsStatusCodes.SETTINGS_CHANGE_UNAVAILABLE:
                                // Location settings are not satisfied. However, we have no way to fix the
                                // settings so we won't show the dialog.
                                break;
                        }
                    }
                });
            }

        }
    }

    private void disconnectAPIGoogle() {
        lastLong = 0;
        lastLong = 0;

        if(mGoogleApiClient!=null) {
            if (mGoogleApiClient.isConnected() || mGoogleApiClient.isConnecting()){
                mGoogleApiClient.disconnect();
                mGoogleApiClient = null;
            }
        }
    }

    private void removeWorkshops() {
        if (!markerList.isEmpty()) {
            for (Marker marker : markerList) {
                marker.remove();
            }

            // Remove all marker from map
            if (mMap != null) mMap.clear();
        }
    }

    private void addWorkshops(List<WorkShop> workShops) {

        // prevent override of workshops
        removeWorkshops();

        for (WorkShop workShop : workShops) {
            LatLng position = new LatLng(workShop.getLatitude(), workShop.getLongitude());
            MarkerOptions markerOptions = new MarkerOptions()
                    //.icon(BitmapDescriptorFactory.fromResource(R.drawable.workshop_marker))
                    .position(position)
                    .snippet(workShop.getAddress() +
                            "\nSe encuentra ha " + String.format("%.2f", workShop.getDistance()) +"Km")
                    .title(workShop.getWorkshopName());

            Marker marker = mMap.addMarker(markerOptions);
            markerList.add(marker);
        }
    }

    void searchWorkshops(){

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(MapActivity.this, "Buscando talleres...");

            ApiService auth = ServiceGenerator.createApiService();

            Map<String, String> params = new HashMap<>();
            params.put("servicio", service.getName());
            params.put("marca", String.valueOf(vehicle.getBrand().getId()));
            params.put("longitud", String.valueOf(lastLong));
            params.put("latitud", String.valueOf(lastLat));
            params.put("distancia", String.valueOf(distance));

            Call<Api<List<WorkShop>>> call = auth.searchWorkshops(params);
            call.enqueue(new Callback<Api<List<WorkShop>>>() {
                @Override
                public void onResponse(@NonNull Call<Api<List<WorkShop>>> call,
                                       @NonNull retrofit2.Response<Api<List<WorkShop>>> response) {

                    if (response.isSuccessful()) {
                        Api<List<WorkShop>> api = response.body();

                        if (api.isError()) {
                            // Show message error
                            Util.showToast(getApplicationContext(), api.getMsg());
                        } else {
                            List<WorkShop> workShopList = api.getData();
                            addWorkshops(workShopList);
                        }
                    } else {
                        Util.showToast(getApplicationContext(),
                                getString(R.string.message_service_server_failed));
                    }
                    Util.hideLoading();
                }

                @Override
                public void onFailure(@NonNull Call<Api<List<WorkShop>>> call, @NonNull Throwable t) {

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