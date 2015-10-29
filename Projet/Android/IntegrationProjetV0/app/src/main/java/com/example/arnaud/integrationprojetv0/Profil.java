package com.example.arnaud.integrationprojetv0;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class Profil extends Activity {
    TextView user,mail;
    private SessionManager session;
    Button btnmodif;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.profil_layout);

        user = (TextView)findViewById(R.id.User);
        mail = (TextView)findViewById(R.id.Mail);
        btnmodif = (Button) findViewById(R.id.btnModif);

        // Session manager
        session = new SessionManager(getApplicationContext());

        user.setText("Nom d'utilisateur : "+session.getUsername());
        mail.setText("Addresse Mail : "+(session.getEmail()));
        System.out.println("réponse: " + session.id);


        btnmodif.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Profil.this, ModifProfil.class);
                startActivity(intent);
            }
        });


    }
}