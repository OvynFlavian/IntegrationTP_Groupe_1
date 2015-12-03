package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.os.Bundle;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.support.v7.app.ActionBarDrawerToggle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import java.util.ArrayList;
import java.util.List;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;


/**
 * Created by nauna on 24-11-15.
 */
public class CreerGroupe extends ActionBarActivity {
    HttpPost httppost;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;

    HttpPost httppost2;
    HttpResponse response2;
    HttpClient httpclient2;
    List<NameValuePair> nameValuePairs2;


    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;
    private SessionManager session;

    private EditText descGroupe;
    private Button b2;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        setContentView(R.layout.groupe_creer);

        session = new SessionManager(getApplicationContext());
        //menu
        mDrawerList = (ListView) findViewById(R.id.amisList);
        mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);




        descGroupe=(EditText)findViewById(R.id.descrGroupe);
        b2= (Button) findViewById((R.id.b2));

        b2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                creerGroupe();

                finirCreation();

                startActivity(new Intent(CreerGroupe.this, GroupeAccueil.class));
                //setContentView(R.layout.register_layout);
            }
        });
    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    public void creerGroupe() {


        try {
            // String [] liste = (String[]) list.toArray();


            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://www.everydayidea.be/scripts_android/creerGroupe.php"); // make sure the url is correct.

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 "+session.getId().toString());
            nameValuePairs.add(new BasicNameValuePair("desc", descGroupe.getText().toString().trim()));
             httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request

            System.out.println("Response : 2"+descGroupe.getText());
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");
            Toast.makeText(CreerGroupe.this, "Groupe Créé avec succès", Toast.LENGTH_SHORT).show();

        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());
        }


    }

    public void finirCreation(){
        try {
            // String [] liste = (String[]) list.toArray();


            httpclient2 = new DefaultHttpClient();
            httppost2 = new HttpPost("http://www.everydayidea.be/scripts_android/finirCreationGroupe.php"); // make sure the url is correct.

            nameValuePairs2 = new ArrayList<NameValuePair>(2);
            nameValuePairs2.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 " + session.getId().toString());


            httppost2.setEntity(new UrlEncodedFormEntity(nameValuePairs2));
            //Execute HTTP Post Request
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response2 = httpclient2.execute(httppost2, responseHandler);
            System.out.println("Response : " + response2);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");
            Toast.makeText(CreerGroupe.this, "Groupe Créé avec succès", Toast.LENGTH_SHORT).show();

        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());
        }


    }




    /**
     * Ajoute des option dans le menu
     */
    private void addDrawerItems() {
        String[] osArray = new String[] {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter"};

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(CreerGroupe.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(CreerGroupe.this, GroupeAccueil.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(CreerGroupe.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(CreerGroupe.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
            }
        });
    }


    private void AfficherMessage(){
        Intent intent = new Intent(CreerGroupe.this, GroupeAccueil.class);
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
        //getMenuInflater().inflate(R.menu.menu_main, menu);
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
        session.setLastIdea(null);
        session.setInscription(null);
        session.setDroit(null);
        session.setLastConnect(null);
        session.setTel(null);

        // Launching the login activity
        Intent intent = new Intent(CreerGroupe.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}
