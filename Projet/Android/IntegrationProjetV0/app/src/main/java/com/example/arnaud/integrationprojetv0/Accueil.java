package com.example.arnaud.integrationprojetv0;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;

public class Accueil extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.content_accueil);

        Button btnConnexion = (Button) findViewById(R.id.connexion);
        Button btnInscription = (Button) findViewById(R.id.inscription);

        SessionManager session = new SessionManager(getApplicationContext());

        if (session.isLoggedIn()) {
            btnConnexion.setVisibility(View.INVISIBLE);
            btnInscription.setVisibility(View.INVISIBLE);
        }

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        int id = item.getItemId();

        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    public void connexion(View view) {
        startActivity(new Intent(Accueil.this, MainActivity.class));
    }

    public void inscription(View view) {
        startActivity(new Intent(Accueil.this, Register.class));
    }

    public void trouverActivite(View view) {
        startActivity(new Intent(Accueil.this, ChoixCategorie.class));
    }

}
