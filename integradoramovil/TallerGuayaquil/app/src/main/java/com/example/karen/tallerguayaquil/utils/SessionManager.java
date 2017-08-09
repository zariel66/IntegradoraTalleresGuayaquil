package com.example.karen.tallerguayaquil.utils;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.content.res.Resources;
import android.preference.PreferenceManager;
import android.text.TextUtils;
import android.util.Log;
import android.widget.Toast;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.models.Vehicle;

import java.util.List;

import io.realm.Realm;
import io.realm.RealmList;
import io.realm.RealmResults;
import io.realm.Sort;


public class SessionManager {
    private Context mContext;
    private SharedPreferences mSharedPreferences;
    private SharedPreferences.Editor mEditor;
    private Resources mResources;

    public SessionManager(Context mContext){
        this.mContext = mContext;
        this.mSharedPreferences = mContext.getSharedPreferences("WORKSHOP", Context.MODE_PRIVATE);
        this.mEditor = mSharedPreferences.edit();
        this.mResources =  mContext.getResources();
    }

    public boolean savePerson(Person person){

        // Person
        mEditor.putInt(mContext.getString(R.string.preferences_person_id), person.getId());
        mEditor.putString(mContext.getString(R.string.preferences_person_first_name), person.getFirstName());
        mEditor.putString(mContext.getString(R.string.preferences_person_last_name), person.getLastName());
        mEditor.putString(mContext.getString(R.string.preferences_person_username), person.getUsername());
        mEditor.putString(mContext.getString(R.string.preferences_person_email), person.getEmail());
        mEditor.putString(mContext.getString(R.string.preferences_person_token), person.getToken());

        /*
        Realm realm = Realm.getDefaultInstance();
        try {
            realm.beginTransaction();
            realm.copyToRealm(person.getVehicles());
            realm.commitTransaction();

            RealmResults<Vehicle> result = realm.where(Vehicle.class).findAll();
            if(result.isEmpty()){
                Util.showToast(mContext, mContext.getString(R.string.message_service_server_failed));
                return false;
            }

        } finally {
            realm.close();
        }*/

        return mEditor.commit();
    }

    public Person getPerson(){

        // Person
        int id = mSharedPreferences.getInt(mContext.getString(R.string.preferences_person_id), 0);
        String first_name = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_first_name), "");
        String last_name = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_last_name), "");
        String username = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_username), "");
        String email = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_email), "");
        String token = mSharedPreferences.getString(mContext.getString(R.string.preferences_person_token), "");

        Person person = new Person();
        person.setId(id);
        person.setFirstName(first_name);
        person.setLastName(last_name);
        person.setUsername(username);
        person.setEmail(email);
        person.setToken(token);

        /*
        Realm realm = Realm.getDefaultInstance();
        try {
            RealmResults<Vehicle> result = realm.where(Vehicle.class).findAllSorted("id", Sort.DESCENDING);
            if(!result.isEmpty()){
                person.setVehicles(realm.copyFromRealm(result));
            } else {
                Util.showToast(mContext, "Problemas en la BD, intente nuevamente");
            }

        } finally {
            realm.close();
        }*/

        return person;
    }

    public String getToken(){
        return mSharedPreferences.getString(mResources.getString(R.string.preferences_person_token), null);
    }


    public boolean hasToken(){
        return !TextUtils.isEmpty(getToken());
    }


    public void clear(){
        mEditor.clear();
        mEditor.apply();
    }
}