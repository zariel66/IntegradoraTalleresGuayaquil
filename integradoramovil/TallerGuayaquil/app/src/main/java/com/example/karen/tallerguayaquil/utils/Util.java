package com.example.karen.tallerguayaquil.utils;

import android.app.ProgressDialog;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.Toast;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Util {

    /**
     * URL
     **/
    public static final String API_URL = "http://198.211.105.132:9999/api/";

    /**
     * UI LOADING
     */
    private static ProgressDialog mLoading = null;
    private static Toast mToast = null;


    /**
     * RESULT CODES
     */
    public static final int LOCATION_REQUEST_CODE = 003;


    /**
     * LOG TAG
     */
    public static final String TAG_KEYBOARD = "SM-KEYBOARD";
    public static final String TAG_SIGNUP_WORKSHOP = "SM-SIGNUP-WORKSHOP";


    /**
     * PATTERNS
     */
    private static final String EMAIL_PATTERN =
            "^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"
                    + "[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";


    /**
     * EMAIL VALIDATOR
     **/
    public static boolean isEmailValid(String email) {
        try {
            // Compiles the given regular expression into a pattern.
            Pattern pattern = Pattern.compile(EMAIL_PATTERN);
            // Match the given input against this pattern
            Matcher matcher = pattern.matcher(email);
            return matcher.matches();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return false;
    }


    /**
     * NAME VALIDATOR
     */
    public static boolean isNameValid(String name) {
        if (TextUtils.isEmpty(name) || !(name.length()>4) || !name.replace(" ", "").matches("[a-zA-Z]+")) return false;
        return true;
    }


    /**
     *  HANDLER PROGRESS
     */

    public static void showLoading(Context context, String message){

        if (mLoading != null)
            mLoading.dismiss();
            mLoading = null;

        mLoading = new ProgressDialog(context);
        mLoading.setCancelable(false);
        mLoading.setMessage(message);
        mLoading.show();
    }

    public static void hideLoading() {
        if (mLoading != null) {
            mLoading.dismiss();
            mLoading = null;
        }
    }


    /**
     *  HANDLER TOAS
     */
    public static void showToast(Context context, String msg) {
        if (mToast != null) {
            mToast.cancel();
        }

        mToast = Toast.makeText(context, msg, Toast.LENGTH_LONG);
        mToast.show();
    }


    /**
     * Hide Softf Keyboard
     **/
    public static void hideSoftKeyboard(Context context, View view) {
        try {
            InputMethodManager imm = (InputMethodManager) context.getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
        }catch (Exception e){
            Log.e(TAG_KEYBOARD, "Cannot close soft keyboard");
        }
    }


    /**
     * Obtain network status
     **/
    public static boolean isNetworkAvailable(Context context) {

        ConnectivityManager connectivityMgr = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityMgr.getActiveNetworkInfo();

        // if no network is available networkInfo will be null
        if (networkInfo != null && networkInfo.isConnected()) {
            return true;
        }
        return false;
    }
}
