package com.example.karen.tallerguayaquil.utils;

<<<<<<< HEAD
<<<<<<< HEAD
import android.content.Context;
import android.content.SharedPreferences;
import android.content.res.Resources;
import android.text.TextUtils;

import com.example.karen.tallerguayaquil.R;

/**
 * Created by karen on 25/07/17.
 */
=======
import android.app.Activity;
=======
>>>>>>> master
import android.content.Context;
import android.content.SharedPreferences;
import android.content.res.Resources;
import android.text.TextUtils;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Person;

>>>>>>> master

public class SessionManager {
    private Context mContext;
    private SharedPreferences mSharedPreferences;
    private SharedPreferences.Editor mEditor;
    private Resources mResources;

    public SessionManager(Context mContext){
        this.mContext = mContext;
        this.mSharedPreferences = mContext.getSharedPreferences("WORKSHOP", Context.MODE_PRIVATE);
        this.mEditor = mSharedPreferences.edit();
<<<<<<< HEAD
        this. mResources =  mContext.getResources();
    }

    public boolean hasToken(){
        return !TextUtils.isEmpty(mSharedPreferences.getString(mResources.getString(R.string.preference_user_token), null));
    }

    public String getToken(){
        return "Token " + mSharedPreferences.getString(mResources.getString(R.string.preference_user_token), null);
    }

=======
        this.mResources =  mContext.getResources();
    }

    public boolean savePerson(Person person){

        // Person
        mEditor.putInt(mContext.getString(R.string.preferences_person_id), person.getId());
        mEditor.putInt(mContext.getString(R.string.preferences_person_type), person.getType());
        mEditor.putString(mContext.getString(R.string.preferences_person_first_name), person.getFirstName());
        mEditor.putString(mContext.getString(R.string.preferences_person_last_name), person.getLastName());
        mEditor.putString(mContext.getString(R.string.preferences_person_username), person.getUsername());
        mEditor.putString(mContext.getString(R.string.preferences_person_email), person.getEmail());
        mEditor.putString(mContext.getString(R.string.preferences_person_token), person.getToken());

        return mEditor.commit();
    }

    public Person getPerson(){

        // Person
        int id = mSharedPreferences.getInt(mContext.getString(R.string.preferences_person_id), 0);
        int type = mSharedPreferences.getInt(mContext.getString(R.string.preferences_person_type), 0);
        String first_name = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_first_name), "");
        String last_name = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_last_name), "");
        String username = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_username), "");
        String email = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_email), "");
        String token = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_token), "");

        Person person = new Person();
        person.setId(id);
        person.setType(type);
        person.setFirstName(first_name);
        person.setLastName(last_name);
        person.setUsername(username);
        person.setEmail(email);
        person.setToken(token);

        return person;
    }

    public String getToken(){
        return mSharedPreferences.getString(mResources.getString(R.string.preferences_person_token), null);
    }


    public boolean hasToken(){
        return !TextUtils.isEmpty(getToken());
    }


>>>>>>> master
    public void clear(){
        mEditor.clear();
        mEditor.apply();
    }
}