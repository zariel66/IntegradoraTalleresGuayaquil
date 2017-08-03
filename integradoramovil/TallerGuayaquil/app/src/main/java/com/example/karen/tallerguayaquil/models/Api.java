package com.example.karen.tallerguayaquil.models;

import com.google.gson.annotations.SerializedName;

public class Api<T> {

    @SerializedName("is_error")
    private boolean isError;

    @SerializedName("msg")
    private String msg;

    @SerializedName("data")
    private Person person;

    public boolean isError() {
        return isError;
    }

    public void setError(boolean error) {
        isError = error;
    }

    public String getMsg() {
        return msg;
    }

    public void setMsg(String msg) {
        this.msg = msg;
    }

    public Person getPerson() {
        return person;
    }

    public void setPerson(Person person) {
        this.person = person;
    }
}
