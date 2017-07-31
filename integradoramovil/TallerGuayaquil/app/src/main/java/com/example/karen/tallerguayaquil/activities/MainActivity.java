package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.adapters.CategoryAdapter;
import com.example.karen.tallerguayaquil.listeners.RecyclerTouchListener;
import com.example.karen.tallerguayaquil.models.Category;

import java.util.ArrayList;
import java.util.List;

public class MainActivity extends AppCompatActivity {

    private RecyclerView mRecyclerView;
    private GridLayoutManager mGridLayoutManager;
    private CategoryAdapter mCategoryAdapter;
    private List<Category> mCategoryList = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mRecyclerView = (RecyclerView) findViewById(R.id.rv_categories);

        mGridLayoutManager = new GridLayoutManager(this, 2);
        mRecyclerView.setHasFixedSize(true);
        mRecyclerView.setLayoutManager(mGridLayoutManager);

        populate(mCategoryList);
        mCategoryAdapter = new CategoryAdapter(MainActivity.this, mCategoryList);
        mRecyclerView.setAdapter(mCategoryAdapter);

        // Set handler clicked
        mRecyclerView.addOnItemTouchListener(new RecyclerTouchListener(
                this, mRecyclerView, new RecyclerTouchListener.ClickListener() {
            @Override
            public void onClick(View view, int position) {
                Intent i = new Intent(MainActivity.this, MapActivity.class);
                startActivity(i);
            }

            @Override
            public void onLongClick(View view, int position) {

            }
        }));
    }
    private void populate(List<Category> mCategoryList) {

        mCategoryList.add(new Category(1,"Mecánica", R.drawable.tallerm));
        mCategoryList.add(new Category(1,"Electrico", R.drawable.bateria));
        mCategoryList.add(new Category(1,"Carrocería", R.drawable.lata));
        mCategoryList.add(new Category(1,"Tapizado", R.drawable.silla));
    }
}
