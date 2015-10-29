package com.example.arnaud.integrationprojetv0;

import android.app.Activity;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

/**
 * Created by nauna on 29-10-15.
 */
public class ModifProfil extends Activity {

    TextView user,mail;
    private SessionManager session;
    Button btnAppli;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.modif_layout);

        user = (EditText)findViewById(R.id.username);
        mail = (EditText)findViewById(R.id.email);
        btnAppli = (Button) findViewById(R.id.btnAppli);

        session = new SessionManager(getApplicationContext());

        user.setText(session.getUsername());
        mail.setText((session.getEmail()));

    }
}