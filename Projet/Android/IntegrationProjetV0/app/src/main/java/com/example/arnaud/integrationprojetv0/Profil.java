package com.example.arnaud.integrationprojetv0;

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

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

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

    TextView user, mail;
    private SessionManager session;
    Button btnmodif;
    CheckBox cbPublic;
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;

    @Override
    public void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.profil_layout);


        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }


        user = (TextView) findViewById(R.id.User);
        mail = (TextView) findViewById(R.id.Mail);
        btnmodif = (Button) findViewById(R.id.btnModif);
        cbPublic = (CheckBox) findViewById(R.id.cbPublic);


        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);


        // Session manager
        session = new SessionManager(getApplicationContext());

        user.setText("Nom d'utilisateur : " + session.getUsername());
        mail.setText("Addresse Mail : " + (session.getEmail()));
        String publics= session.getPublics();
        if (publics=="FALSE") cbPublic.setChecked(false);
        else if (publics=="TRUE") cbPublic.setChecked(true);
        else cbPublic.setChecked(false);

        System.out.println("réponse: " + session.getId());
        System.out.println("réponse: " + session.getPublics());


        btnmodif.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Profil.this, ModifProfil.class);
                startActivity(intent);
            }
        });




        cbPublic.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            public void onCheckedChanged(CompoundButton cbPublic, boolean isChecked) {
                try {
                    httpclient = new DefaultHttpClient();
                    String id = session.getId();
                    httppost = new HttpPost("http://109.89.122.61/scripts_android/modifPublic.php"); // make sure the url is correct.
                    //add your data
                    nameValuePairs = new ArrayList<NameValuePair>(2);
                    if (cbPublic.isChecked()) {
                        System.out.println("resp : " + "true");
                        nameValuePairs.add(new BasicNameValuePair("isCheck", "TRUE"));
                        session.setPublics("TRUE");
                    } else {
                        System.out.println("resp : " + "true");
                        nameValuePairs.add(new BasicNameValuePair("isCheck", "FALSE"));
                        session.setPublics("FALSE");
                    }
                    nameValuePairs.add(new BasicNameValuePair("id", id.toString().trim()));

                    httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

                    //Execute HTTP Post Request
                    ResponseHandler<String> responseHandler = new BasicResponseHandler();

                    final String response = httpclient.execute(httppost, responseHandler);
                    System.out.println("Response : " + response);

                    if(response.equalsIgnoreCase("TRUE")){
                        cbPublic.setChecked(true);
                        runOnUiThread(new Runnable() {
                            public void run() {
                                Toast.makeText(Profil.this, "Activités publiques", Toast.LENGTH_SHORT).show();
                            }
                        });

                    }else if(response.equalsIgnoreCase("FALSE")){
                        cbPublic.setChecked(false);
                        runOnUiThread(new Runnable() {
                            public void run() {
                                Toast.makeText(Profil.this, "Activités privées", Toast.LENGTH_SHORT).show();
                            }
                        });
                    }
                } catch (IOException e) {
                    e.printStackTrace();
                    System.out.println("Exception : " + e.getMessage());
                }
            }

        });

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
                if(position==0){
                    Intent intent = new Intent(Profil.this, ModifProfil.class);
                    startActivity(intent);
                }
                if(position==1){
                    Intent intent = new Intent(Profil.this, ChoixCategorie.class);
                    startActivity(intent);

                }
                if(position==2){
                    Intent intent = new Intent(Profil.this, AfficherAmis.class);
                    startActivity(intent);

                }


                if(position==3){
                    AfficherMessage();

                }

                if(position==4){
                    logoutUser();

                }


                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
    }



    /**
     * Initialise le menu
     */

    private void AfficherMessage(){
        Intent intent = new Intent(Profil.this, Messagerie.class);
        startActivity(intent);


    }
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
        Intent intent = new Intent(Profil.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}