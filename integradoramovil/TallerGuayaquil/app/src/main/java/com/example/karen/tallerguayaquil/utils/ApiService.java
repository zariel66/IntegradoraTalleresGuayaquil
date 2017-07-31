package com.example.karen.tallerguayaquil.utils;

import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.models.Service;
import com.example.karen.tallerguayaquil.models.WorkShop;

import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;

public interface ApiService {

    /** Services **/

    @GET("marcas/")
    Call<List<Brand>> getBrands();

    @GET("marcas/")
    Call<List<Service>> getServices();


    /** SignUp**/
    @POST("registrotallersubmit/")
    Call<Void> signupWorkshop(@Body WorkShop workShop);

    @POST("registroclientesubmit/")
    Call<Void> signupPerson(@Body Person person);


    /** Login **/
    @FormUrlEncoded
    @POST("iniciarsesion/")
    Call<Person> login(@FieldMap Map<String, String> params);
}
