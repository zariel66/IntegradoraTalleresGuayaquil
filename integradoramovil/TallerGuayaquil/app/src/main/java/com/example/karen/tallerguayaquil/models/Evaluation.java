package com.example.karen.tallerguayaquil.models;

import com.google.gson.annotations.SerializedName;

import java.util.Date;

public class Evaluation {

    @SerializedName("id")
    private int id;

    @SerializedName("honesty")
    private double honesty;

    @SerializedName("efficiency")
    private double efficiency;

    @SerializedName("precio")
    private double coste;

    @SerializedName("comentario")
    private String comentario;

    @SerializedName("idusuario")
    private int usuario;

    @SerializedName("idtaller")
    private int workshop;

    @SerializedName("estado")
    private int status;

    @SerializedName("fecha_hora")
    private Date dateCreated;

    @SerializedName("desc_code")
    private double code;

    @SerializedName("precio_original")
    private double price;

    @SerializedName("descuento")
    private double descuento;

    @SerializedName("total")
    private double total;


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
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

    public String getComentario() {
        return comentario;
    }

    public void setComentario(String comentario) {
        this.comentario = comentario;
    }

    public int getUsuario() {
        return usuario;
    }

    public void setUsuario(int usuario) {
        this.usuario = usuario;
    }

    public int getWorkshop() {
        return workshop;
    }

    public void setWorkshop(int workshop) {
        this.workshop = workshop;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public Date getDateCreated() {
        return dateCreated;
    }

    public void setDateCreated(Date dateCreated) {
        this.dateCreated = dateCreated;
    }

    public double getCode() {
        return code;
    }

    public void setCode(double code) {
        this.code = code;
    }

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
    }

    public double getDescuento() {
        return descuento;
    }

    public void setDescuento(double descuento) {
        this.descuento = descuento;
    }

    public double getTotal() {
        return total;
    }

    public void setTotal(double total) {
        this.total = total;
    }
}