package com.example.arnaud.integrationprojetv0;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.net.Uri;
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

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

/**
 * Created by nauna on 19-11-15.
 */
public class AccepterAmis extends ActionBarActivity {

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
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
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

        user.setText("Voulez-vous vraiment accepter cette invitation? \n \n " + username);

        btnOui.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                accepterAmis(username);
                Toast.makeText(AccepterAmis.this, "Amis ajouté !", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(AccepterAmis.this, AfficherAmis.class);
                startActivity(intent);
            }
        });

        btnNon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                supprimerAmis(username);
                Intent intent = new Intent(AccepterAmis.this, AfficherAmis.class);
                startActivity(intent);
                Toast.makeText(AccepterAmis.this, "Demande refusée.", Toast.LENGTH_SHORT).show();

            }
        });
    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    private void supprimerAmis(String username) {
        try {
            // String [] liste = (String[]) list.toArray();


            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://www.everydayidea.be/scripts_android/supprimerAmis.php"); // make sure the url is correct.

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", username.trim()));
            System.out.println("Response 22:" + username);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 ");
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request

            System.out.println("Response : 2");
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");


        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());
        }
    }


    public void accepterAmis(String username) {

        try {
            // String [] liste = (String[]) list.toArray();


            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://www.everydayidea.be/scripts_android/confDemande.php"); // make sure the url is correct.

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", username.trim()));
            System.out.println("Response 22:" + username);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 ");
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request

            System.out.println("Response : 2");
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");


        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());
        }
    }

    /**
     * Ajoute des option dans le menu
     */
    //menu
    private void addDrawerItems() {
        System.out.println("session droit " + session.getDroit());
        final String[] osArray = new String[] {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter"};
        if (session.getDroit().equals("Normal")) {
            osArray[1] = "Devenir Premium !";
        }

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(AccepterAmis.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    if (session.isLoggedIn()) {
                        if(osArray[1].equals("Groupe")) {
                            Intent intent = new Intent(AccepterAmis.this, GroupeAccueil.class);
                            startActivity(intent);
                        } else {
                            String url = "http://www.everydayidea.be/Page/connexion.page.php";
                            Intent i = new Intent(Intent.ACTION_VIEW);
                            i.setData(Uri.parse(url));
                            startActivity(i);
                        }
                    } else {
                        Intent intent = new Intent(AccepterAmis.this, ChoixCategorie.class);
                        startActivity(intent);
                    }
                }
                if (position == 2) {
                    Intent intent = new Intent(AccepterAmis.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(AccepterAmis.this, ChoixCategorie.class);
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
        //getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    /**
     * Action en fonction de l'onglet selectionné
     */
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (id == R.id.action_settings) {
            return true;
        }

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
        Intent intent = new Intent(AccepterAmis.this, Accueil.class);
        startActivity(intent);
        finish();
    }
}
