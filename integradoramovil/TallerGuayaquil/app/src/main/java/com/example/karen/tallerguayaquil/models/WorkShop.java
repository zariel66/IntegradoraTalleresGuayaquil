package com.example.karen.tallerguayaquil.models;

import com.google.gson.annotations.SerializedName;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

public class WorkShop implements Serializable {

    @SerializedName("id")
    private int id;

    @SerializedName("distance")
    private float distance;

    @SerializedName("nombre")
    private String firstName;

    @SerializedName("apellido")
    private String lastName;

    @SerializedName("username")
    private String username;

    @SerializedName("password")
    private String password;

    @SerializedName("password_confirmation")
    private String passwordConfirmation;

    @SerializedName("correo")
    private String email;

    @SerializedName("nombre_taller")
    private String workshopName;

    @SerializedName("direccion")
    private String address;

    @SerializedName("telefono")
    private String phone;

    @SerializedName("nombre_empleado")
    private String managerName;

    @SerializedName("code")
    private String codeDesc;

    @SerializedName("latitud")
    private double latitude;

    @SerializedName("longitud")
    private double longitude;

    @SerializedName("honestidad")
    private double honesty;

    @SerializedName("eficiencia")
    private double efficiency;

    @SerializedName("precio")
    private double coste;

    @SerializedName("marcas")
    private List<Brand> brandList;

    @SerializedName("servicios")
    private List<Service> serviceList;

    @SerializedName("calificaciones")
    private List<Evaluation> evaluationList;

    public WorkShop(){
        this.brandList = new ArrayList<>();
        this.serviceList = new ArrayList<>();
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public float getDistance() {
        return distance;
    }

    public void setDistance(float distance) {
        this.distance = distance;
    }

    public double getLatitude() {
        return latitude;
    }

    public void setLatitude(double latitude) {
        this.latitude = latitude;
    }

    public double getLongitude() {
        return longitude;
    }

    public void setLongitude(double longitude) {
        this.longitude = longitude;
    }

    public double getHonesty() {
        return honesty;
    }

    public void setHonesty(double honesty) {
        this.honesty = honesty;
    }

    public double getEfficiency() {
        return efficiency;
    }

    public void setEfficiency(double efficiency) {
        this.efficiency = efficiency;
    }

    public double getCoste() {
        return coste;
    }

    public void setCoste(double coste) {
        this.coste = coste;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
        this.passwordConfirmation = password;
    }

    public String getPasswordConfirmation() {
        return passwordConfirmation;
    }

    public void setPasswordConfirmation(String passwordConfirmation) {
        this.passwordConfirmation = passwordConfirmation;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public String getManagerName() {
        return managerName;
    }

    public void setManagerName(String managerName) {
        this.managerName = managerName;
    }

    public String getWorkshopName() {
        return workshopName;
    }

    public void setWorkshopName(String workshopName) {
        this.workshopName = workshopName;
    }

    public String getCodeDesc() {
        return codeDesc;
    }

    public void setCodeDesc(String codeDesc) {
        this.codeDesc = codeDesc;
    }

    public List<Brand> getBrandList() {
        return brandList;
    }

    public void setBrandList(List<Brand> brandList) {
        this.brandList = brandList;
    }

    public List<Service> getServiceList() {
        return serviceList;
    }

    public void setServiceList(List<Service> serviceList) {
        this.serviceList = serviceList;
    }

    public List<Evaluation> getEvaluationList() {
        return evaluationList;
    }

    public void setEvaluationList(List<Evaluation> evaluationList) {
        this.evaluationList = evaluationList;
    }
}
