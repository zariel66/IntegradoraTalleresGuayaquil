package com.example.karen.tallerguayaquil.models;

import com.google.gson.annotations.SerializedName;

import java.io.Serializable;

public class Service implements Serializable {

    @SerializedName("id")
    private int id;

    @SerializedName("nombre")
    private String name;

    @SerializedName("categoria")
    private String category;

    public Service(int id, String name) {
        this.id = id;
        this.name = name;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
    }

    @Override
    public String toString() {
        return name;
    }
}
