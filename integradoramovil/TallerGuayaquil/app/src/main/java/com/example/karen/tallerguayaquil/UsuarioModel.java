package com.example.karen.tallerguayaquil;

import java.io.Serializable;
/**
 * Created by Karen on 10/07/2017.
 */

public class UsuarioModel implements Serializable {

    private int id_usuario;
    private String nombre;
    private String apellido;
    private int tipo;
    private String username;
    private String password;
    private String correo;

    public UsuarioModel(int id_usuario, String nombre, String apellido, int tipo, String username, String password, String correo) {
        this.id_usuario = id_usuario;
        this.nombre = nombre;
        this.apellido = apellido;
        this.tipo = tipo;
        this.username = username;
        this.password = password;
        this.correo = correo;
    }

    public int getId_usuario() {
        return id_usuario;
    }

    public void setId_usuario(int id_usuario) {
        this.id_usuario = id_usuario;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public String getApellido() {
        return apellido;
    }

    public void setApellido(String apellido) {
        this.apellido = apellido;
    }

    public int getTipo() {
        return tipo;
    }

    public void setTipo(int tipo) {
        this.tipo = tipo;
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
    }

    public String getCorreo() {
        return correo;
    }

    public void setCorreo(String correo) {
        this.correo = correo;
    }
}
