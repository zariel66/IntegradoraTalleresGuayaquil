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
        this. mResources =  mContext.getResources();
    }

    public boolean savePerson(Person person){
        SharedPreferences sharedPref = PreferenceManager.getDefaultSharedPreferences(mContext);
        SharedPreferences.Editor editor = sharedPref.edit();

        // Person
        editor.putInt(mContext.getString(R.string.preferences_person_id), person.getId());
        editor.putString(mContext.getString(R.string.preferences_person_first_name), person.getFirstName());
        editor.putString(mContext.getString(R.string.preferences_person_last_name), person.getLastName());
        editor.putString(mContext.getString(R.string.preferences_person_username), person.getUsername());
        editor.putString(mContext.getString(R.string.preferences_person_email), person.getEmail());
        editor.putString(mContext.getString(R.string.preferences_person_token), person.getToken());

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
        }

        return editor.commit();
    }

    public Person getPerson(){

        SharedPreferences sharedPref = PreferenceManager.getDefaultSharedPreferences(mContext);

        // Person
        int id = sharedPref.getInt(mContext.getString(R.string.preferences_person_id), 0);
        String first_name = sharedPref.getString(mContext.getString(R.string.preferences_person_first_name), "");
        String last_name = sharedPref.getString(mContext.getString(R.string.preferences_person_last_name), "");
        String username = sharedPref.getString(mContext.getString(R.string.preferences_person_username), "");
        String email = sharedPref.getString(mContext.getString(R.string.preferences_person_email), "");
        String token = sharedPref.getString(mContext.getString(R.string.preferences_person_token), "");

        Person person = new Person();
        person.setId(id);
        person.setFirstName(first_name);
        person.setLastName(last_name);
        person.setUsername(username);
        person.setEmail(email);
        person.setToken(token);

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
        }

        return person;
    }

    public boolean hasToken(){
        return !TextUtils.isEmpty(mSharedPreferences.getString(mResources.getString(R.string.preferences_person_token), null));
    }

    public String getToken(){
        return "Token " + mSharedPreferences.getString(mResources.getString(R.string.preferences_person_token), null);
    }

    public void clear(){
        mEditor.clear();
        mEditor.apply();
    }
}