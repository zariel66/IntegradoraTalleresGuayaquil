package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.karen.tallerguayaquil.R;


public class SignupPersonActivity extends AppCompatActivity implements View.OnClickListener {

    //Definiendo Views
     EditText txtnombre, txtapellido, txtcorreo, txtusuario, txtpassword;
    private Button btnsiguiente;
    //Variable tipo cliente


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_person);

        //Inicializando Views
        txtnombre = (EditText) findViewById(R.id.txtnombre);
        txtapellido = (EditText) findViewById(R.id.txtapellido);
        txtcorreo = (EditText) findViewById(R.id.txtcorreo);
        txtusuario = (EditText) findViewById(R.id.txtusuario);
        txtpassword = (EditText) findViewById(R.id.txtpassword);
        btnsiguiente = (Button) findViewById(R.id.btn_siguiente);
        btnsiguiente.setOnClickListener(this);
    }

<<<<<<< HEAD
    @Override
    public void onClick(View v) {
       if (txtnombre.getText().toString().equals("") || txtapellido.getText().toString().equals("") || txtcorreo.getText().toString().equals("") || txtusuario.getText().toString().equals("") || txtpassword.getText().toString().equals("")) {
            Toast.makeText(SignupPersonActivity.this, "Por favor, llene todos los campos", Toast.LENGTH_LONG).show();
           } else {
                  String nombre=txtnombre.getText().toString();
                  String apellido=txtapellido.getText().toString();
                  String correo=txtcorreo.getText().toString();
                  String usuario=txtusuario.getText().toString();
                  String password=txtpassword.getText().toString();

                  Bundle parametros = new Bundle();
                  parametros.putString("nombre", nombre);
                  parametros.putString("apellido", apellido);
                  parametros.putString("correo", correo);
                  parametros.putString("usuario", usuario);
                  parametros.putString("password", password);

=======
    public void attemptNext(View v) {

        // Init progress message
        Util.showLoading(this, getString(R.string.title_progress_validation_message));

        // Reset errors.
        mFirstNameView.setError(null);
        mLastNameView.setError(null);
        mEmailView.setError(null);
        mUsernameView.setError(null);
        mPasswordView.setError(null);

        String firsName = mFirstNameView.getText().toString();
        String lastName = mLastNameView.getText().toString();
        String email = mEmailView.getText().toString().trim();
        String username = mUsernameView.getText().toString().trim();
        String password = mPasswordView.getText().toString();


        boolean cancel = false;
        View focusView = null;

        if (TextUtils.isEmpty(username)) {
            mUsernameView.setError(getString(R.string.error_field_required));
            focusView = mUsernameView;
            cancel = true;
        }

        if (TextUtils.isEmpty(password) || password.length() < 6) {
            mPasswordView.setError(getString(R.string.error_len_password));
            focusView = mPasswordView;
            cancel = true;
        }

        if (TextUtils.isEmpty(email)) {
            mEmailView.setError(getString(R.string.error_field_required));
            focusView = mEmailView;
            cancel = true;
        } else if (!Util.isEmailValid(email)) {
            mEmailView.setError(getString(R.string.error_invalid_email));
            focusView = mEmailView;
            cancel = true;
        }

        if (TextUtils.isEmpty(lastName) || lastName.length() < 4) {
            mLastNameView.setError(getString(R.string.error_incorrect_text_field));
            focusView = mLastNameView;
            cancel = true;
        }

        if (!Util.isNameValid(firsName) || firsName.length() < 4) {
            mFirstNameView.setError(getString(R.string.error_incorrect_text_field));
            focusView = mFirstNameView;
            cancel = true;
        }


        if (cancel) {
            focusView.requestFocus();
        } else {

            if ( type ==1 ) {
                Person person = new Person();
                person.setFirstName(firsName);
                person.setLastName(lastName);
                person.setEmail(email);
                person.setUsername(username);
                person.setPassword(password);

                Bundle bundle = new Bundle();
                bundle.putSerializable("person", person);
>>>>>>> master

                Intent i = new Intent(this, SignupVehicleActivity.class);

                i.putExtras(parametros);
                startActivity(i);
       }
    }
}





