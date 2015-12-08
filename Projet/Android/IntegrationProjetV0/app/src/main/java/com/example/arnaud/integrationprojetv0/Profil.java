package com.example.arnaud.integrationprojetv0;

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
import android.widget.CheckBox;
import android.widget.CompoundButton;
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
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

/**
 * <b>Profil est une classe qui permet d'afficher le profil de l'utilisateur connecté.</b>
 * <p>
 * la classe affiche les informations suivantes :
 * <ul>
 * <li>Un nom d'utilisateur.</li>
 * <li>Un email.</li>
 * <li>Si l'utilisateur veut être public ou privé.</li>
 * </ul>
 * </p>
 * @author Willame Arnaud
 */

public class Profil extends ActionBarActivity {

    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;

    TextView user, grade, activite, mail, tel, lastConnect, lastIdea, dateInscr;
    private SessionManager session;
    Button btnmodif;
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;

    @Override
    public void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        setContentView(R.layout.profil_layout);


        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        // Session manager
        session = new SessionManager(getApplicationContext());
        user = (TextView) findViewById(R.id.user);
        grade = (TextView) findViewById(R.id.grade);
        activite = (TextView) findViewById(R.id.activite);
        mail = (TextView) findViewById(R.id.mail);
        tel = (TextView) findViewById(R.id.tel);
        lastConnect = (TextView) findViewById(R.id.lastConnect);
        lastIdea = (TextView) findViewById(R.id.lastIdea);
        dateInscr = (TextView) findViewById(R.id.dateInscription);
        btnmodif = (Button) findViewById(R.id.btnModif);


        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        afficherActiviteChoisie();

        user.setText(user.getText() + session.getUsername());
        grade.setText(grade.getText() + session.getDroit());
        mail.setText(mail.getText() + session.getEmail());
        if (session.getTel().equals("null")) {
            tel.setText(tel.getText() + "N/A");
        } else {
            tel.setText(tel.getText() + session.getTel());
        }
        lastConnect.setText(lastConnect.getText() + session.getLastConnect());
        if (session.getLastIdea().equals("null")) {
            lastIdea.setText(lastIdea.getText() + "N/A");
        } else {
            lastIdea.setText(lastIdea.getText() + session.getLastIdea());
        }
        dateInscr.setText(dateInscr.getText() + session.getInscription());

        btnmodif.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Profil.this, ModifProfil.class);
                startActivity(intent);
            }
        });

    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    public void afficherActiviteChoisie() {
        try {
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/afficherActiviteChoisie.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("userId", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            JSONObject jObj = new JSONObject(response);

            final Boolean error = jObj.getBoolean("error");
            final String activite = jObj.getString("activite");

            if (error) {
                this.activite.setText(this.activite.getText() + "N/A");
            } else {
                this.activite.setText(this.activite.getText() + activite);
            }

        } catch(Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
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
                    Intent intent = new Intent(Profil.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    if(osArray[1].equals("Groupe")) {
                        Intent intent = new Intent(Profil.this, GroupeAccueil.class);
                        startActivity(intent);
                    } else {
                        String url = "http://www.everydayidea.be/Page/connexion.page.php";
                        Intent i = new Intent(Intent.ACTION_VIEW);
                        i.setData(Uri.parse(url));
                        startActivity(i);
                    }
                }
                if (position == 2) {
                    Intent intent = new Intent(Profil.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(Profil.this, ChoixCategorie.class);
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
        Intent intent = new Intent(Profil.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}