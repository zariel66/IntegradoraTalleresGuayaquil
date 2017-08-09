package com.example.karen.tallerguayaquil.models;

import com.google.gson.annotations.SerializedName;

public class Api<T> {

    @SerializedName("is_error")
    private boolean isError;

    @SerializedName("msg")
    private String msg;

    @SerializedName("data")
    private T data;

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

    public T getData() {
        return data;
    }

    public void setData(T data) {
        this.data = data;
    }
}
