package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.FrameLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class ChoixCategorie extends AppCompatActivity {

    private String categorie = null;
    private static final String test = "categorie";
    private SessionManager session;
    private RelativeLayout layoutCat = null;
    //private int hauteur = 1500;
    private TextView activiteChoisieTV = null;
    private TextView activiteChoisie = null;
    //menu
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        setContentView(R.layout.categorie_layout);

        afficherCategorie();

        // session manager
        session = new SessionManager(getApplicationContext());



        layoutCat = (RelativeLayout) findViewById(R.id.layoutCat2);
        activiteChoisieTV = (TextView) findViewById(R.id.activiteChoisieTV);
        activiteChoisie = (TextView) findViewById(R.id.activiteChoisie);

        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        if (!session.isLoggedIn()) {
            activiteChoisieTV.setVisibility(View.INVISIBLE);
            activiteChoisie.setVisibility(View.INVISIBLE);
        } else {
            afficherActiviteChoisie();
        }
    }

    @Override
    public void onBackPressed() {
    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    private void logoutUser() {
        session.setLogin(false);
        session.setEmail(null);
        session.setPublics(null);
        session.setUsername(null);
        session.setId(null);

        // Launching the login activity
        Intent intent = new Intent(ChoixCategorie.this, Accueil.class);
        startActivity(intent);
        finish();
    }

    /**
     * affiche l'activité du jour choisie par l'utilisateur
     */
    public void afficherActiviteChoisie() {
        try {
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://109.89.122.61/scripts_android/afficherActiviteChoisie.php");

            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("userId", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            System.out.println("avant execute");
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONObject jObj = new JSONObject(response);
            final Boolean error = jObj.getBoolean("error");
            final String activite = jObj.getString("activite");

            System.out.println("activite : " + activite);
            System.out.println("error : " + error);
            if (error) {
                activiteChoisieTV.setVisibility(View.INVISIBLE);
                activiteChoisie.setText("Vous n'avez pas d'activité");
            } else {
                activiteChoisie.setText(activite);
            }

        } catch(Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
    }

    /**
     * cherche les différentes catégories disponibles
     */
    public void afficherCategorie() {
        try{

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://109.89.122.61/scripts_android/afficherCategorie.php"); // make sure the url is correct.

            //Execute HTTP Post Request
            // response=httpclient.execute(httppost);
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            System.out.println("avant execute");
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONObject jObj = new JSONObject(response);

            final String nbCategorie = jObj.getString("0");
            int i = 1;
            for (i = 1; i < Integer.valueOf(nbCategorie); i++) {
                String j = String.valueOf(i);
                String categorie = jObj.getString(j);
                System.out.println("test zouloulou : " + categorie);
                newCategorie(categorie, i);
                System.out.println("test zouloulou : " + categorie);
            }


        }catch(Exception e){
            System.out.println("Exception : " + e.getMessage());
        }
    }
    /**
     * Affiche les différentes catégories disponibles
     * @param cat : nom de la catégorie
     * @param id : numéro de la catégorie
     */
    public void newCategorie(String cat, int id) {
        final Button categorie = new Button(this);
        categorie.setText(cat);
        categorie.setTextColor(getResources().getColor(R.color.transparent));
        categorie.setId(id);
        int resId;
        if (cat.equals("jeux video")) {
            resId = getResources().getIdentifier("jeuxvideo", "drawable", this.getPackageName());
        } else {
            resId = getResources().getIdentifier(cat, "drawable", this.getPackageName());
    }
        categorie.setBackgroundResource(resId);
        RelativeLayout.LayoutParams p = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);

        if ((id -2) > 0) {
            p.addRule(RelativeLayout.BELOW, id - 2);
        }

        if (id%2 == 0) {
            p.addRule(RelativeLayout.ALIGN_PARENT_RIGHT);
            p.setMargins(10, 50, 30, 10);
        } else {
            p.addRule(RelativeLayout.ALIGN_PARENT_LEFT);
            p.setMargins(30, 50, 10, 10);
        }
        categorie.setLayoutParams(p);

        categorie.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie.getText());
                startActivity(intent);
            }
        });

        ((RelativeLayout) findViewById(R.id.layoutCat2)).addView(categorie);

        FrameLayout.LayoutParams p2 = new FrameLayout.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
        ((RelativeLayout) findViewById(R.id.layoutCat3)).setLayoutParams(p2);


    }

    //menu
    private void addDrawerItems() {
        System.out.println("session droit " + session.getDroit());
        String[] osArray;

        if(session.isLoggedIn()) {
            osArray = new String[] {"Amis", "Groupe", "Profil", "Se déconnecter"};
        } else {
            osArray = new String[] {"Accueil", "Se connecter", "S'inscrire"};
        }

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    if (session.isLoggedIn()) {
                        Intent intent = new Intent(ChoixCategorie.this, AfficherAmis.class);
                        startActivity(intent);
                    } else {
                        Intent intent = new Intent(ChoixCategorie.this, Accueil.class);
                        startActivity(intent);
                    }
                }
                if (position == 1) {
                    if (session.isLoggedIn()) {
                        Intent intent = new Intent(ChoixCategorie.this, GroupeAccueil.class);
                        startActivity(intent);
                    } else {
                        Intent intent = new Intent(ChoixCategorie.this, MainActivity.class);
                        startActivity(intent);
                    }
                }
                if (position == 2) {
                    if (session.isLoggedIn()) {
                        Intent intent = new Intent(ChoixCategorie.this, Profil.class);
                        startActivity(intent);
                    } else {
                        Intent intent = new Intent(ChoixCategorie.this, Register.class);
                        startActivity(intent);
                    }
                }
                if (position == 3) {
                    logoutUser();
                }
            }
        });
    }


    private void AfficherMessage(){
        Intent intent = new Intent(ChoixCategorie.this, GroupeAccueil.class);
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

    @Override
    protected void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        // Sync the toggle state after onRestoreInstanceState has occurred.
        mDrawerToggle.syncState();
    }

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
        mDrawerToggle.onConfigurationChanged(newConfig);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

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

}
