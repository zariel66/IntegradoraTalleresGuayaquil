package com.example.karen.tallerguayaquil.utils;

import android.content.Context;
import android.content.SharedPreferences;
import android.content.res.Resources;
import android.text.TextUtils;

import com.example.karen.tallerguayaquil.R;

/**
 * Created by karen on 25/07/17.
 */

public class SessionManager {
    private Context mContext;
    private SharedPreferences mSharedPreferences;
    private SharedPreferences.Editor mEditor;
    private Resources mResources;

    public SessionManager(Context mContext){
        this.mContext = mContext;
        this.mSharedPreferences = mContext.getSharedPreferences("WORKSHOP", Context.MODE_PRIVATE);
        this.mEditor = mSharedPreferences.edit();
        this. mResources =  mContext.getResources();
    }

    public boolean hasToken(){
        return !TextUtils.isEmpty(mSharedPreferences.getString(mResources.getString(R.string.preference_user_token), null));
    }

    public String getToken(){
        return "Token " + mSharedPreferences.getString(mResources.getString(R.string.preference_user_token), null);
    }

    public void clear(){
        mEditor.clear();
        mEditor.apply();
    }
}