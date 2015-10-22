package com.example.arnaud.integrationprojetv0;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;

public class ChoixCategorie extends AppCompatActivity {

    private Button animaux = null;
    private Button famille = null;
    private Button film = null;
    private Button visite = null;
    private String categorie = null;
    private static final String test = "categorie";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.categorie_layout);

        animaux = (Button) findViewById(R.id.animaux);
        famille = (Button) findViewById(R.id.famille);
        film = (Button) findViewById(R.id.film);
        visite = (Button) findViewById(R.id.visite);

        animaux.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = "animaux";
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        famille.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = "famille";
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        film.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = "film";
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        visite.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = "visite";
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        super.onCreateOptionsMenu(menu);
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_main, menu);
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
}
