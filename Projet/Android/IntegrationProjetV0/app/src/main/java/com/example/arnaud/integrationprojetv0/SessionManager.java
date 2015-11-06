package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.util.Log;

public class SessionManager {
    // LogCat tag
    private static String TAG = SessionManager.class.getSimpleName();

    // Shared Preferences
    SharedPreferences pref;

    Editor editor;
    Context _context;
    String id,username,email,publics;

    // Shared pref mode
    int PRIVATE_MODE = 0;

    // Shared preferences file name
    private static final String PREF_NAME = "AndroidHiveLogin";

    private static final String KEY_IS_LOGGEDIN = "isLoggedIn";

    public SessionManager(Context context) {
        this._context = context;
        pref = _context.getSharedPreferences(PREF_NAME, PRIVATE_MODE);
        editor = pref.edit();

    }

    public void setLogin(boolean isLoggedIn) {

        editor.putBoolean(KEY_IS_LOGGEDIN, isLoggedIn);


        // commit changes
        editor.commit();

        Log.d(TAG, "User login session modified!");
    }

    public boolean isLoggedIn(){
        return pref.getBoolean(KEY_IS_LOGGEDIN, false);
    }

    public void setUsername(String username) {
        editor.putString("USERNAME", username);
        editor.commit();

    }

    public String getUsername(){
        return pref.getString("USERNAME", null);

    }

    public void setEmail(String email) {
        editor.putString("EMAIL",email );
        editor.commit();

    }

    public String getEmail(){
        return pref.getString("EMAIL",null);

    }

    public void setId(String id) {
        editor.putString("ID",id );
        editor.commit();

    }

    public String getId(){
        return pref.getString("ID",null);

    }

    public void setPublics(String publics) {
        editor.putString("publics",publics );
        editor.commit();

    }

    public String getPublics(){
        return pref.getString("publics",null);

    }
}