package com.example.karen.tallerguayaquil.activities;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Service;
import com.example.karen.tallerguayaquil.models.WorkShop;
import com.example.karen.tallerguayaquil.utils.Util;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import java.util.List;

import me.gujun.android.taggroup.TagGroup;


public class WorkShopProfileActivity extends AppCompatActivity
        implements OnMapReadyCallback {

    private WorkShop workShop;
    private TextView mTitleView, mAddressView, mPhoneView, mNameView, mCodeTextView;
    private ImageView mCodeView;
    private TagGroup mServicesView, mBrandsView;

    private GoogleMap mMap;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_workshop_profile);

        workShop = (WorkShop) getIntent().getExtras().getSerializable("profile");

        mTitleView = (TextView) findViewById(R.id.txt_title);
        mAddressView = (TextView) findViewById(R.id.txt_address);
        mPhoneView = (TextView) findViewById(R.id.txt_phone);
        mCodeTextView = (TextView) findViewById(R.id.txt_code);
        mCodeView = (ImageView) findViewById(R.id.img_code);
        mNameView = (TextView) findViewById(R.id.txt_name);

        mServicesView = (TagGroup) findViewById(R.id.tag_services);
        mBrandsView = (TagGroup) findViewById(R.id.tag_brands);


        mTitleView.setText(workShop.getWorkshopName());
        mAddressView.setText(workShop.getAddress());
        mPhoneView.setText(workShop.getPhone());
        mNameView.setText(workShop.getManagerName());
        mCodeTextView.setText(workShop.getCodeDesc());

        populateServices();
        populateBrands();

        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map_address);
        mapFragment.getMapAsync(this);
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;

        LatLng position = new LatLng(workShop.getLatitude(), workShop.getLongitude());
        MarkerOptions markerOptions = new MarkerOptions().position(position);

        Marker marker = mMap.addMarker(markerOptions);
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(position, 15));
    }

    private void populateServices(){

        List<Service> servicesList = workShop.getServiceList();
        String services[] = new String[servicesList.size()];
        for (int i=0; i<servicesList.size(); i++) {
            Service service = servicesList.get(i);
            services[i] = service.getCategory();
        }

        mServicesView.setTags(services);
    }

    private void populateBrands(){

        List<Brand> brandList = workShop.getBrandList();
        String brands[] = new String[brandList.size()];
        for (int i=0; i<brandList.size(); i++) {
            Brand brand = brandList.get(i);
            brands[i] = brand.getName();
        }

        mBrandsView.setTags(brands);
    }
}
