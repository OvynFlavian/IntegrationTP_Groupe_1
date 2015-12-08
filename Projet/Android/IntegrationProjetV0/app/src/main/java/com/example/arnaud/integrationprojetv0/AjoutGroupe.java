package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.net.Uri;
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
import android.widget.ListView;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;

import java.util.List;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;


/**
 * Created by nauna on 24-11-15.
 */
public class AjoutGroupe extends ActionBarActivity {

    HttpPost httppost;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;

    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;
    private SessionManager session;

    private Button btnCreerGroupe;
    private Button btnVoirGroupe;
    private Button btnAjoutGroupe;


    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        setContentView(R.layout.message_groupe_layout);

        session = new SessionManager(getApplicationContext());

        btnCreerGroupe = (Button) findViewById(R.id.btnCreerGroupe);
        btnVoirGroupe = (Button) findViewById(R.id.btnVoirGroupe);
       // btnAjoutGroupe = (Button) findViewById(R.id.btnAjoutGroupe);

        //menu
        mDrawerList = (ListView) findViewById(R.id.amisList);
        mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        btnCreerGroupe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(AjoutGroupe.this, CreerGroupe.class);
                //intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        btnVoirGroupe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(AjoutGroupe.this, VoirGroupe.class);
                //intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });


        btnAjoutGroupe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(AjoutGroupe.this, AjoutGroupe.class);
                //intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    /**
     * Ajoute des option dans le menu
     */
    private void addDrawerItems() {
        final String[] osArray = new String[] {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter"};
        if (!session.getDroit().equals("Premium")) {
            osArray[1] = "Devenir Premium !";
        }

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(AjoutGroupe.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    if(osArray[1].equals("Groupe")) {
                        Intent intent = new Intent(AjoutGroupe.this, GroupeAccueil.class);
                        startActivity(intent);
                    } else {
                        String url = "http://www.everydayidea.be/Page/connexion.page.php";
                        Intent i = new Intent(Intent.ACTION_VIEW);
                        i.setData(Uri.parse(url));
                        startActivity(i);
                    }
                }
                if (position == 2) {
                    Intent intent = new Intent(AjoutGroupe.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(AjoutGroupe.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
            }
        });
    }


    private void AfficherMessage(){
        Intent intent = new Intent(AjoutGroupe.this, GroupeAccueil.class);
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
        Intent intent = new Intent(AjoutGroupe.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}
