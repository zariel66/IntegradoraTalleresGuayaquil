package com.example.karen.tallerguayaquil;
import android.content.ContentValues;
import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.widget.Toast;

public class DatabaseHelper extends SQLiteOpenHelper {

    private static final String DATABASE_NAME="dbintegradora"; //nombre de la base
    private static final int DATABASE_VERSION = 2; //si agregas un nuevo campo o eliminas una tabla debes cambiar la version
    private static final String NAME_USUARIO = "Usuarios";


    /*Campos de la tabla Usuarios*/
    static final String idUsuario="idUsuario";
    static final String Nombre="nombre";
    static final String Apellido = "apellido";
    static final String Tipo = "tipo";
    static final String Username ="username";
    static final String Password = "password";
    static final String Correo = "correo";

    /*Campos de la tabla Marca*/
    static final String idMarca="idMarca";
    static final String Codigo="codigo";
    static final String Name="nombre";

    /*Campos de la tabla Vehiculo*/
    static final String idvehiculo="idvehiculo";
    static final String fkUsuario = "fkUsuario";
    static final String fkMarca  = "fkMarca";


    Context context;

    /*Tabla de Usuarios*/
    private static final String USER_TABLE = "create table usuarios" +
            "(" + idUsuario + " INTEGER primary key autoincrement, "
            + Nombre+ " TEXT , "
            + Apellido + " TEXT , "
            + Tipo + " INT, "
            + Username + " TEXT,"
            + Password+ " TEXT,"
            + Correo+ " TEXT,"
            + "UNIQUE (idMedicamento))";

    /*Tabla de Marcas*/
    private static final String MARCA_TABLE = "create table marca" +
            "(" + idMarca + " INTEGER primary key autoincrement, "
            + Codigo+ " TEXT , "
            + Name + " TEXT , "
            + "UNIQUE (idMarca))";



    /*Tabla de Vehiculo*/
    private static final String VEHICULO_TABLE = "create table vehiculo" +
            "("+idvehiculo  + " INTEGER primary key autoincrement, "
            + fkMarca + " INTEGER, "
            + fkUsuario + " INTEGER, "
            + "UNIQUE (idvehiculo))";

      //constructor de la clase
    public DatabaseHelper(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
        this.context = context;
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(USER_TABLE);
        db.execSQL(MARCA_TABLE);
        db.execSQL(VEHICULO_TABLE);

    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {

    }


    /***METODO PARA INSERTAR UN NUEVO MEDICAMENTOS EN LA BDD*/
    public void insert_usuario(String nombre,String apellido,int tipo,String username, String password,String correo){
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put("nombre", nombre);
        values.put("apellido", apellido);
        values.put("tipo", tipo);
        values.put("username", username);
        values.put("password",password);
        values.put("correo",correo);
        db.insert("usuarios", null, values);
        db.close();
        Toast.makeText(context, nombre+" creado con éxito", Toast.LENGTH_LONG);

    }

    /***METODO PARA INSERTAR UN NUEVO MARCA EN LA BDD*/
    public void insert_marca(String codigo,String nombre){
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put("codigo", codigo);
        values.put("nombre", nombre);
        db.insert("marca", null, values);
        db.close();
        Toast.makeText(context, codigo+" creado con éxito", Toast.LENGTH_LONG);

    }





}
