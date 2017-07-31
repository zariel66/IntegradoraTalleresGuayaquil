package com.example.karen.tallerguayaquil.activities;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.EditText;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.utils.Util;


public class SignupPersonActivity extends AppCompatActivity {

    private EditText mFirstNameView, mLastNameView,
            mEmailView, mUsernameView, mPasswordView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_person);

        mFirstNameView = (EditText) findViewById(R.id.txt_first_name);
        mLastNameView = (EditText) findViewById(R.id.txt_last_name);
        mEmailView = (EditText) findViewById(R.id.txt_email);
        mUsernameView = (EditText) findViewById(R.id.txt_username);
        mPasswordView = (EditText) findViewById(R.id.txt_password);

        mPasswordView.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                if (id == EditorInfo.IME_ACTION_DONE) {
                    Util.hideSoftKeyboard(getApplicationContext(), getCurrentFocus());
                    attemptNext(null);
                    return true;
                }
                return false;
            }
        });
    }

    public void attemptNext(View v) {

        // Init progress message
        Util.showLoading(SignupPersonActivity.this, getString(R.string.title_progress_validation_message));

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

        if (TextUtils.isEmpty(password)) {
            mPasswordView.setError(getString(R.string.error_field_required));
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

        if (TextUtils.isEmpty(lastName)) {
            mLastNameView.setError(getString(R.string.error_incorrect_text_field));
            focusView = mLastNameView;
            cancel = true;
        }

        if (!Util.isNameValid(firsName)) {
            mFirstNameView.setError(getString(R.string.error_incorrect_text_field));
            focusView = mFirstNameView;
            cancel = true;
        }


        if (cancel) {
            focusView.requestFocus();
        } else {

            Person person = new Person();
            person.setFirstName(firsName);
            person.setLastName(lastName);
            person.setEmail(email);
            person.setUsername(username);
            person.setPassword(password);

            Bundle bundle = new Bundle();
            bundle.putSerializable("person", person);

            Intent i = new Intent(SignupPersonActivity.this, SignupVehicleActivity.class);
            i.putExtras(bundle);
            startActivity(i);
        }

        Util.hideLoading();
    }
}





