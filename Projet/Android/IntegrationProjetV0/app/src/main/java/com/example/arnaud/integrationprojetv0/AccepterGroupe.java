package com.example.arnaud.integrationprojetv0;

import android.app.ProgressDialog;
import android.content.Intent;
import android.content.res.Configuration;
import android.os.Bundle;
import android.os.StrictMode;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.support.v7.app.ActionBarDrawerToggle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
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

/**
 * Created by nauna on 19-11-15.
 */
public class AccepterGroupe extends ActionBarActivity {

    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;
    private SessionManager session;
    private TextView user;
    private Button btnOui;
    private Button btnNon;
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.confirmajout_layout);

        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        session = new SessionManager(getApplicationContext());

        user = (TextView) findViewById(R.id.User);
        btnOui = (Button) findViewById(R.id.btnOui);
        btnNon = (Button) findViewById(R.id.btnNon);


        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        // Session manager


        Intent intent = getIntent();
// On suppose que tu as mis un String dans l'Intent via le putExtra()

        final String username = intent.getStringExtra("username");

        user.setText("Voulez-vous vraiment accepter cette invitation ?");

        btnOui.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                accepterGroupe(username);
                Toast.makeText(AccepterGroupe.this, "groupe enregistré !", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(AccepterGroupe.this, VoirGroupe.class);
                startActivity(intent);
            }
        });

        btnNon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                supprimerGroupe(username);
                Intent intent = new Intent(AccepterGroupe.this, VoirGroupe.class);
                startActivity(intent);
                Toast.makeText(AccepterGroupe.this, "Demande refusée.", Toast.LENGTH_SHORT).show();

            }
        });



    }

    private void supprimerGroupe(String username) {
        try {
            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://109.89.122.61/site/html/scripts_android/supprimerGroupe.php");
            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", username.trim()));
            System.out.println("Response 22:" + username);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 ");
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            System.out.println("Response : 2");
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
    }


    public void accepterGroupe(String username) {

        try {
            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://109.89.122.61/scripts_android/confGroupe.php");
            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", username.trim()));
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            System.out.println("Response : 2");
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
    }

    /**
     * Ajoute des option dans le menu
     */
    private void addDrawerItems() {
        String[] osArray = {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter"};

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(AccepterGroupe.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(AccepterGroupe.this, GroupeAccueil.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(AccepterGroupe.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(AccepterGroupe.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
            }
        });
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
        Intent intent = new Intent(AccepterGroupe.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}

