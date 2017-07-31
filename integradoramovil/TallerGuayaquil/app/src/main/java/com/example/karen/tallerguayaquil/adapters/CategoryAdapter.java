package com.example.karen.tallerguayaquil.adapters;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Category;

import java.util.List;

public class CategoryAdapter extends RecyclerView.Adapter<CategoryAdapter.CategoryViewHolder> {

    private List<Category> mCategoryList;
    private Context mContext;

    public CategoryAdapter(Context context, List<Category> categoryList) {
        this.mCategoryList = categoryList;
        this.mContext = context;
    }

    public static class CategoryViewHolder
            extends RecyclerView.ViewHolder
            implements View.OnClickListener{

        public TextView mNameView;
        public ImageView mImageView;

        public CategoryViewHolder(View itemView) {
            super(itemView);

            mImageView = (ImageView) itemView.findViewById(R.id.img_category);
            mNameView = (TextView) itemView.findViewById(R.id.txt_name);
        }

        @Override
        public void onClick(View v) {
            Log.d("click",v.toString());
        }
    }

    private Context getContext() {
        return mContext;
    }

    @Override
    public CategoryViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        Context context = parent.getContext();

        // Inflate the custom layout
        View categoryView = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.category_item, parent, false);

        // Return a new holder instance
        CategoryViewHolder categoryViewHolder = new CategoryViewHolder(categoryView);
        return categoryViewHolder;
    }

    @Override
    public void onBindViewHolder(CategoryViewHolder categoryHolder, int position) {

        // Get element
        Category mCategory = mCategoryList.get(position);

        // Set service image
        ImageView mCategoryImageView = categoryHolder.mImageView;
        mCategoryImageView.setImageResource(mCategory.getImage());

        TextView mNameView = categoryHolder.mNameView;
        mNameView.setText(mCategory.getName());
    }

    @Override
    public int getItemCount() {
            return mCategoryList.size();
    }

}
