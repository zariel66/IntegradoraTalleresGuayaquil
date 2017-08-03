package com.example.karen.tallerguayaquil.application;

import io.realm.Realm;
import io.realm.RealmConfiguration;

public class Application extends android.app.Application{

    private static Application application;

    @Override
    public void onCreate() {
        super.onCreate();

        Application.application = this;

        // Realm
        Realm.init(this);
        RealmConfiguration config = new RealmConfiguration.Builder()
                .name("taller.realm")
                //.encryptionKey(getKey())
                .schemaVersion(1)
                //.modules(new MySchemaModule())
                //.migration(new MyMigration())
                .build();
        Realm.setDefaultConfiguration(config);
    }

}
