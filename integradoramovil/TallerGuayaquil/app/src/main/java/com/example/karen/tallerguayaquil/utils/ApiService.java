package com.example.karen.tallerguayaquil.utils;

import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Evaluation;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.models.Vehicle;
import com.example.karen.tallerguayaquil.models.WorkShop;

import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Url;

public interface ApiService {

    /** Services **/

    @GET("marcas")
    Call<List<Brand>> getBrands();

    @POST("vehiculos")
    Call<Api<List<Vehicle>>> getVehicles(@Body Person person);

    @FormUrlEncoded
    @POST("busquedataller")
    Call<Api<List<WorkShop>>> searchWorkshops(@FieldMap Map<String, String> params);

    @FormUrlEncoded
    @POST
    Call<Api<WorkShop>> getWorkshopProfile(@Url String url, @FieldMap Map<String, String> params);

    @FormUrlEncoded
    @POST
    Call<Api<WorkShop>> createEvaluation(@Url String url, @FieldMap Map<String, String> params);

    @FormUrlEncoded
    @POST
    Call<Api<List<Evaluation>>> getComments(@Url String url, @FieldMap Map<String, String> params);

    @FormUrlEncoded
    @POST("reservaciones")
    Call<Api<List<Evaluation>>> getReservations(@FieldMap Map<String, String> params);

    @FormUrlEncoded
    @POST("reservacion")
    Call<Api<Evaluation>> getReservation(@FieldMap Map<String, String> params);

    @FormUrlEncoded
    @POST("cerrarticket")
    Call<Api> closeTicket(@FieldMap Map<String, String> params);


    /** SignUp**/
    @POST("registrotallersubmit")
    Call<Api> signupWorkshop(@Body WorkShop workShop);

    @POST("registroclientesubmit")
    Call<Api> signupPerson(@Body Person person);


    /** Login **/
    @FormUrlEncoded
    @POST("iniciarsesion")
    Call<Api<Person>> login(@FieldMap Map<String, String> params);

}

