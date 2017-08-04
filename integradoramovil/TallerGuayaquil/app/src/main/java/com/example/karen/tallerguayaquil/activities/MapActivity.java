package com.example.karen.tallerguayaquil.activities;

import android.content.DialogInterface;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Toast;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Service;
import com.example.karen.tallerguayaquil.models.Vehicle;
import com.example.karen.tallerguayaquil.utils.Util;
import com.getbase.floatingactionbutton.FloatingActionButton;
import com.getbase.floatingactionbutton.FloatingActionsMenu;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import java.util.List;

import io.realm.Realm;
import io.realm.RealmResults;
import io.realm.Sort;

public class MapActivity extends AppCompatActivity
        implements OnMapReadyCallback {
    private GoogleMap mMap;
    private ArrayAdapter<Vehicle> vehicleArrayAdapter;
    private ArrayAdapter<Service> serviceArrayAdapter;

    private Vehicle vehicle = null;
    private Service service = null;

    private List<Marker> markerList = null;

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
    }


    @Override
    protected void onResume() {
        super.onResume();

        populateServices();
        populateVehicles();
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;

        LatLng guayaquil = new LatLng(-2.203816, -79.897453);
        Marker marker = mMap.addMarker(
                new MarkerOptions()
                        .position(guayaquil)
                        .draggable(true));
        mMap.moveCamera(CameraUpdateFactory.newLatLng(guayaquil));

    }

    void populateServices(){
        // Options services
        if (serviceArrayAdapter==null)
            serviceArrayAdapter = new ArrayAdapter<Service>(getApplicationContext(),
                    R.layout.dialog_item);

        serviceArrayAdapter.addAll(Util.getServices());

        // Select first service by default;
        service = serviceArrayAdapter.getItem(0);
    }

    void populateVehicles(){

        // Options services
        if (vehicleArrayAdapter==null)
            vehicleArrayAdapter = new ArrayAdapter<Vehicle>(getApplicationContext(),
                    R.layout.dialog_item);

        Brand b1 = new Brand();
        b1.setName("Chevrolet");

        Brand b2 = new Brand();
        b2.setName("Audi");


        Vehicle v1 = new Vehicle();
        v1.setModel("Aveo");
        v1.setBrand(b1);

        Vehicle v2 = new Vehicle();
        v2.setModel("C5");
        v2.setBrand(b2);

        vehicleArrayAdapter.add(v1);
        vehicleArrayAdapter.add(v2);

        // Select first vehicle by default;
        vehicle = vehicleArrayAdapter.getItem(0);

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
            alert.setTitle("Servicios");
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

    private void search() {
        /*if (marker != null){
            marker.remove();
            marker = null;
        }*/

        if (vehicle != null && service != null) {
            // Remove all marker from map
            if (mMap != null) mMap.clear();
            Util.showToast(getApplicationContext(), "Buscando talleres para " + vehicle.toString() + " - " + service.toString());
        } else {
            Util.showToast(getApplicationContext(), "Hubo problemas, cierre y vuelva abrir la aplicación");
        }
    }
}