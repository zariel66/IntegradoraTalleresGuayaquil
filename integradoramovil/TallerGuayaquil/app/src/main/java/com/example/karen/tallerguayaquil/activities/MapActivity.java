package com.example.karen.tallerguayaquil.activities;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;

import com.example.karen.tallerguayaquil.R;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

public class MapActivity extends AppCompatActivity
        implements OnMapReadyCallback {
    private GoogleMap mMap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);
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
}