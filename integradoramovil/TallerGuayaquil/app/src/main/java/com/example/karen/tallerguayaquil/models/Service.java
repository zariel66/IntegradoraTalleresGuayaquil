package com.example.karen.tallerguayaquil.models;

import com.google.gson.annotations.SerializedName;

import java.io.Serializable;

public class Service implements Serializable {

    @SerializedName("nombre")
    private String name;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    @Override
    public String toString() {
        return name;
    }
}
