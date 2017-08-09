package com.example.karen.tallerguayaquil.utils;

import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.models.Service;
import com.example.karen.tallerguayaquil.models.Vehicle;
import com.example.karen.tallerguayaquil.models.WorkShop;

import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.Field;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;

public interface ApiService {

    /** Services **/

    @GET("marcas/")
    Call<List<Brand>> getBrands();

    @POST("vehiculos/")
    Call<Api<List<Vehicle>>> getVehicles(@Body Person person);

    @FormUrlEncoded
    @POST("busquedataller/")
    Call<Api<List<WorkShop>>> searchWorkshops(@FieldMap Map<String, String> params);


    /** SignUp**/
    @POST("registrotallersubmit/")
    Call<Api> signupWorkshop(@Body WorkShop workShop);

    @POST("registroclientesubmit/")
    Call<Api> signupPerson(@Body Person person);


    /** Login **/
    @FormUrlEncoded
    @POST("iniciarsesion/")
    Call<Api<Person>> login(@FieldMap Map<String, String> params);

}

