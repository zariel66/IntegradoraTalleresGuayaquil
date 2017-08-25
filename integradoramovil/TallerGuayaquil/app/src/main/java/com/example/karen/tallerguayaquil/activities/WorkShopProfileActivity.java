package com.example.karen.tallerguayaquil.activities;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Evaluation;
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
    private ProgressBar mHonestyView, mEfficiencyView, mCosteView;

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

        mHonestyView = (ProgressBar) findViewById(R.id.pb_honesty);
        mEfficiencyView = (ProgressBar) findViewById(R.id.pb_efficiency);
        mCosteView = (ProgressBar) findViewById(R.id.pb_coste);


        populateServices();
        populateBrands();
        populateEvaluations();

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
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(position, 16));
    }

    private void populateServices() {

        List<Service> servicesList = workShop.getServiceList();
        String services[] = new String[servicesList.size()];
        for (int i=0; i<servicesList.size(); i++) {
            Service service = servicesList.get(i);
            services[i] = service.getCategory();
        }

        mServicesView.setTags(services);
    }

    private void populateBrands() {

        List<Brand> brandList = workShop.getBrandList();
        String brands[] = new String[brandList.size()];
        for (int i=0; i<brandList.size(); i++) {
            Brand brand = brandList.get(i);
            brands[i] = brand.getName();
        }

        mBrandsView.setTags(brands);
    }

    private void populateComments() {


    }

    private void populateEvaluations() {

        List<Evaluation> evaluations = workShop.getEvaluationList();

        if (evaluations != null) {

            int honestyCount = 0;
            int efficiencyCount = 0;
            int costeCount = 0;
            int total = evaluations.size();

            for (Evaluation evaluation : evaluations) {
                honestyCount += evaluation.getHonesty();
                efficiencyCount += evaluation.getEfficiency();
                costeCount += evaluation.getCoste();
            }

            mHonestyView.setProgress(getColorRange(efficiencyCount / total));
            mEfficiencyView.setProgress(getColorRange(honestyCount / total));
            mCosteView.setProgress(getColorRange(costeCount / total));
        }
    }

    private int getColorRange(int value) {

        /**
            Malo: color rojo para valores entre 0 y valores menores de 5
            Regular: color naranja para valores entre 5 y valores menores a 8
            Bueno: color verde para valores mayores a 8
         **/
        int color;

        if (value >= 0 && value < 5) color = android.R.color.holo_red_dark;
        else if (value >= 5 && value < 8) color = android.R.color.holo_orange_dark;
        else color = android.R.color.holo_green_dark;

        return color;
    }
}
