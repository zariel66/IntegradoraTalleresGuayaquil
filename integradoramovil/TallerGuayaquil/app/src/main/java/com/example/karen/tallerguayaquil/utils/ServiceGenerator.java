package com.example.karen.tallerguayaquil.utils;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class ServiceGenerator {

    /**
     * Build simple REST adapter
     */

    private static GsonConverterFactory gsonConverterFactory = GsonConverterFactory.create();

    private static Retrofit.Builder mRetrofitBuilder = new Retrofit.Builder()
            .addConverterFactory(gsonConverterFactory);

    public static ApiService createApiService() {
        // Create an instance of our Object API interface.
        return  mRetrofitBuilder.baseUrl(Util.API_URL).build().create(ApiService.class);
    }
}
