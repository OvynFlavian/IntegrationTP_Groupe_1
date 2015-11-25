package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.os.Bundle;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

public class ListeActivite extends AppCompatActivity {

    private static final String intentCat = "categorie";
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;
    private SessionManager session;
    private ListView liste = null;
    private ArrayList<String> list = new ArrayList<String>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.listeactivite_layout);
        liste = (ListView) findViewById(R.id.listViewActivite);

        Intent intent = getIntent();
        String categorie = intent.getStringExtra(intentCat);

        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        session = new SessionManager(getApplicationContext());

        afficherListe(categorie);

    }

    public void afficherListe(String cat) {
        try {
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://109.89.122.61/scripts_android/afficherListeActivite.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("categorie", cat.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONArray jsonArray = new JSONArray(response);

            //final String note = jObj.getString("note");


            String activite = new String();

            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject jsonObject = jsonArray.getJSONObject(i);
                final String nom = jsonObject.getString("libelle");
                final String description = jsonObject.getString("description");
                activite = nom + "\n" + description;
                list.add(activite);
            }

            ArrayAdapter<String> activiteAdapter = new ArrayAdapter<String>(getApplicationContext(), android.R.layout.simple_list_item_1, list);
            liste.setAdapter(activiteAdapter);

            addOptionOnClick(list);

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
    }

    private void addOptionOnClick(final ArrayList<String> list) {

        liste.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, final int position, long id) {
                afficherActivite(position, list);
            }
        });
    }

    public void afficherActivite(int position, ArrayList<String> list){
        String activite = list.get(position).toString();
        System.out.println("string : " + "." + activite + ".");

        String str[] = activite.split("\n");
        String nom = str[0];
        String description = str[1];

        System.out.println("activite : " + "." + nom + "." + description + ".");

        Intent intent = new Intent(this, ActiviteFromListe.class);
        intent.putExtra("nom", nom );
        intent.putExtra("description", description);

        startActivity(intent);
    }

    /**
     * Ajoute des option dans le menu
     */
    private void addDrawerItems() {
        String[] osArray = { "profil", "activités", "Amis","messages", "se déconecter" };
        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(ListeActivite.this, ModifProfil.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(ListeActivite.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(ListeActivite.this, AfficherAmis.class);
                    startActivity(intent);
                }

                if (position == 3) {
                    AfficherMessage();
                }

                if (position == 4) {
                    logoutUser();
                }

                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
    }


    private void AfficherMessage(){
        Intent intent = new Intent(ListeActivite.this, Messagerie.class);
        startActivity(intent);
    }

    /**
     * Initialise le menu
     */
    private void setupDrawer() {
        mDrawerToggle = new ActionBarDrawerToggle(this, mDrawerLayout, R.string.drawer_open, R.string.drawer_close) {

            /** Called when a drawer has settled in a completely open state. */
            public void onDrawerOpened(View drawerView) {
                super.onDrawerOpened(drawerView);
                getSupportActionBar().setTitle("Navigation!");
                invalidateOptionsMenu(); // creates call to onPrepareOptionsMenu()
            }

            /** Called when a drawer has settled in a completely closed state. */
            public void onDrawerClosed(View view) {
                super.onDrawerClosed(view);
                getSupportActionBar().setTitle(mActivityTitle);
                invalidateOptionsMenu(); // creates call to onPrepareOptionsMenu()
            }
        };

        mDrawerToggle.setDrawerIndicatorEnabled(true);
        mDrawerLayout.setDrawerListener(mDrawerToggle);
    }

    /**
     * Action après la création du menu
     */
    @Override
    protected void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        // Sync the toggle state after onRestoreInstanceState has occurred.
        mDrawerToggle.syncState();
    }

    /**
     * Action si la configuration est changée
     */
    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
        mDrawerToggle.onConfigurationChanged(newConfig);
    }

    /**
     * Création du menu
     */
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    /**
     * Action en fonction de l'onglet selectionné
     */
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        // Activate the navigation drawer toggle
        if (mDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    private void logoutUser() {
        session.setLogin(false);
        session.setEmail(null);
        session.setPublics(null);
        session.setUsername(null);
        session.setId(null);

        // Launching the login activity
        Intent intent = new Intent(ListeActivite.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}
