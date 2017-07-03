package com.example.karen.tallerguayaquil;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.maps.*;
import com.google.android.gms.maps.model.*;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

public class Mapa extends AppCompatActivity implements OnMapReadyCallback {


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mapa);

        MapFragment mapFragment = (MapFragment) getFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

    }

    public void onMapReady(GoogleMap map) {
        map.moveCamera(CameraUpdateFactory.newLatLngZoom(
                new LatLng(41.889, -87.622), 16));

        // You can customize the marker image using images bundled with
        // your app, or dynamically generated bitmaps.
        map.addMarker(new MarkerOptions()
                .icon(BitmapDescriptorFactory.fromResource(R.drawable.location))
                //.anchor(0.0f, 1.0f) // Anchors the marker on the bottom left
                .position(new LatLng(41.889, -87.622)));
    }

}
