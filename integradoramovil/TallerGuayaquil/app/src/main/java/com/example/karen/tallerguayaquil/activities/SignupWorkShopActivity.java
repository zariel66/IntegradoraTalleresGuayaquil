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
import com.example.karen.tallerguayaquil.models.WorkShop;
import com.example.karen.tallerguayaquil.utils.Util;

public class SignupWorkShopActivity extends AppCompatActivity {

    private EditText mWorkShopNameView, mAddressView, mPhoneView,
            mEmailView, mUsernameView, mPasswordView;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_workshop);

        mWorkShopNameView = (EditText) findViewById(R.id.txt_workshop);
        mAddressView = (EditText) findViewById(R.id.txt_address);
        mPhoneView = (EditText) findViewById(R.id.txt_phone);
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
        Util.showLoading(SignupWorkShopActivity.this, getString(R.string.title_progress_validation_message));

        // Reset errors.
        mWorkShopNameView.setError(null);
        mAddressView.setError(null);
        mPhoneView.setError(null);
        mEmailView.setError(null);
        mUsernameView.setError(null);
        mPasswordView.setError(null);

        String workshopName = mWorkShopNameView.getText().toString();
        String address = mAddressView.getText().toString();
        String phone = mPhoneView.getText().toString().trim();
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

        if (TextUtils.isEmpty(phone)) {
            mPhoneView.setError(getString(R.string.error_field_required));
            focusView = mPhoneView;
            cancel = true;
        } else if (phone.length() < 10) {
            mPhoneView.setError(getString(R.string.error_incorrect_number_field));
            focusView = mPhoneView;
            cancel = true;
        }

        if (TextUtils.isEmpty(address)) {
            mAddressView.setError(getString(R.string.error_field_required));
            focusView = mAddressView;
            cancel = true;
        }

        if (!Util.isNameValid(workshopName)) {
            mWorkShopNameView.setError(getString(R.string.error_incorrect_text_field));
            focusView = mWorkShopNameView;
            cancel = true;
        }


        if (cancel) {
            focusView.requestFocus();
        } else {
            WorkShop workShop = new WorkShop();
            workShop.setWorkshopName(workshopName);
            workShop.setAddress(address);
            workShop.setPhone(phone);
            workShop.setEmail(email);
            workShop.setUsername(username);
            workShop.setPassword(password);

            Bundle bundle = new Bundle();
            bundle.putSerializable("workshop", workShop);

            Intent i = new Intent(this, SignupServiceActivity.class);
            i.putExtras(bundle);
            startActivity(i);
        }

        Util.hideLoading();
    }
}