package com.example.arnaud.integrationprojetv0;

import android.app.ProgressDialog;
import android.content.Context;
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
import android.widget.RelativeLayout;
import android.widget.TextView;

import org.apache.http.HttpResponse;
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
import java.util.List;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;


public class AfficherProfilAmis extends ActionBarActivity {

    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;
    private SessionManager session;
    private TextView user;
    private TextView mail;
    private TextView activite;
    private Button btnSuppr;
    private Button btnNon;

    //menu
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;
    private Button btnActi = null;

    private RelativeLayout confirmationActivite = null;



    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        setContentView(R.layout.affich_profil_amis);

        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        // Session manager
        session = new SessionManager(getApplicationContext());
        String idUser = session.getId();

        user = (TextView) findViewById(R.id.User);
        mail = (TextView) findViewById(R.id.Mail);
        activite = (TextView) findViewById(R.id.acti);
        btnSuppr = (Button) findViewById(R.id.btnSuppr);
        btnActi = (Button) findViewById(R.id.btnActi);

        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        Intent intent = getIntent();

        final String username = intent.getStringExtra("username");

        final String[] tb1 = affFriend(username);

        btnSuppr.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                supprFriend(username);
            }
        });

        btnActi.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //Intent intent2 = new Intent(AfficherProfilAmis.this, ActiviteFromListe.class);
                //intent2.putExtra("nom", );

                Intent intent2 = new Intent(AfficherProfilAmis.this, ActiviteFromListe.class);
                intent2.putExtra("idActi", tb1[0] );
                intent2.putExtra("idUser", tb1[1] );
                intent2.putExtra("nom", tb1[2] );
                intent2.putExtra("description", tb1[3] );
                intent2.putExtra("catLib", tb1[4] );
                startActivity(intent2);
            }
        });
    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    public String[] affFriend(String username) {

        try{

            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://www.everydayidea.be/scripts_android/afficherProfilAmis.php"); // make sure the url is correct.

            //Execute HTTP Post Request
            nameValuePairs = new ArrayList<NameValuePair>(2);

            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("userName", username.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : " + JsonArray);
            System.out.println("taille : " + JsonArray.length());


            JSONObject jsonObject = JsonArray.getJSONObject(0);
            System.out.println("taille : " + JsonArray.getJSONObject(0));
            user.setText("  Nom d'utilisateur: " + jsonObject.getString("userName"));
            mail.setText("  Email: " + jsonObject.getString("email"));
            if(jsonObject.getString("libelle")=="null") activite.setText("pas d'activité aujourd'hui.");
            else activite.setText("  Activité: " + jsonObject.getString("libelle"));
            String idActi = jsonObject.getString("idActivity");
            String idUser = jsonObject.getString("idUser");
            String libelle = jsonObject.getString("libelle");
            String description = jsonObject.getString("description");
            String catLib= jsonObject.getString("catLib");
            System.out.println("taille33 : " +idActi+ idUser );


            String[] tb = new String[5];
            tb[0]=idActi;
            tb[1]=idUser;
            tb[2]=libelle;
            tb[3]= description;
            tb[4]= catLib;

            System.out.println("tb : " +tb[0]+ tb[1] );

            return tb;


        }catch(Exception e){
           /* dialog.dismiss();*/
            System.out.println("Exception : " + e.getMessage());
        }
        return null;
    }


    public void supprFriend(String username) {

        //String username = list.get(position).toString();


        Intent intent = new Intent(this, SupprFriend.class);
        intent.putExtra("username", username );
     /*  intent.putStringArrayListExtra("liste", list);
       intent.putExtra("position", position);*/


        startActivity(intent);
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
                    Intent intent = new Intent(AfficherProfilAmis.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(AfficherProfilAmis.this, GroupeAccueil.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(AfficherProfilAmis.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(AfficherProfilAmis.this, ChoixCategorie.class);
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

    private void AfficherMessage(){
        Intent intent = new Intent(AfficherProfilAmis.this, GroupeAccueil.class);
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
        Intent intent = new Intent(AfficherProfilAmis.this, Accueil.class);
        startActivity(intent);
        finish();
    }


}

