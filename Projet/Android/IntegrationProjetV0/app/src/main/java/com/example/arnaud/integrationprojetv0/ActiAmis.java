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
import android.widget.RatingBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

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

/**
 * Created by Thomas on 19/10/2015.
 */
public class ActiAmis extends AppCompatActivity {

    private static final String intentCat = "categorie";
    private static String categorie = null;
    private TextView titre = null;
    private TextView description = null;
    private RatingBar note = null;
    private Button btnOk = null;
    private Button btnSuivant = null;
    private Button ajoutActivite = null;
    private Button btnOui = null;
    private SessionManager session = null;
    private TextView note2 = null;
    private String idActivite = null;
    private String idUser = null;
    private RelativeLayout confirmationActivite = null;
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
        setContentView(R.layout.activite_layout);

        //Intent intent = getIntent();
        titre = (TextView) findViewById(R.id.titre);
        description = (TextView) findViewById(R.id.description);
        note = (RatingBar) findViewById(R.id.note);
        note2 = (TextView) findViewById(R.id.note2);
        btnOk = (Button) findViewById(R.id.ok);
        btnSuivant = (Button) findViewById(R.id.suivant);
        ajoutActivite = (Button) findViewById(R.id.ajouterActivite);
        btnOui = (Button) findViewById(R.id.ouiChangeActivite);
        ajoutActivite = (Button) findViewById(R.id.ajouterActivite);
        confirmationActivite = (RelativeLayout) findViewById(R.id.confirmationActivite);
        //categorie = intent.getStringExtra(intentCat);

        Intent intent = getIntent();
        final String libelle = intent.getStringExtra("libelle");
        final String description1 = intent.getStringExtra("description");
        categorie = intent.getStringExtra("catLib");

        session = new SessionManager(getApplicationContext());
        titre.setText(libelle);
        description.setText(description1);

        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);


        idUser = session.getId();
        confirmationActivite.setVisibility(View.INVISIBLE);

        if(!session.isLoggedIn()) {
            //ajoutActivite.setVisibility(View.INVISIBLE);
            btnOk.setText("Connectez-vous");
            btnOk.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    startActivity(new Intent(ActiAmis.this, MainActivity.class));
                }
            });
        } else {
            btnOk.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    enregistrerActivite();
                }
            });
        }

        activiteSuivante(btnSuivant);

        btnSuivant.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                activiteSuivante(v);
            }
        });

    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    public void ajouterActivite(View view) {
        Intent intent = new Intent(ActiAmis.this, AjouterActivite.class);
        intent.putExtra(intentCat, categorie);
        startActivity(intent);
    }

    public void activiteSuivante(View view) {
        try{

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/activite.php"); // make sure the url is correct.
            //add your data
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be similar,
            System.out.println("avant name pair value");
            nameValuePairs.add(new BasicNameValuePair("categorie", categorie.trim()));  // $Edittext_value = $_POST['Edittext_value'];
            System.out.println("après name pair value."+categorie);
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            System.out.println("après setEntity");

            //Execute HTTP Post Request
            // response=httpclient.execute(httppost);
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            System.out.println("avant execute");
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("après execute");
            System.out.println("Response lol : " + response);
            JSONObject jObj = new JSONObject(response);

            final String id = jObj.getString("id");
            idActivite = id;
            final String libelle = jObj.getString("titre");
            final String description = jObj.getString("description");
            Float note = Float.valueOf(jObj.getString("note"));
            if (note != 99) {
                this.note.setVisibility(View.VISIBLE);
                this.note2.setVisibility(View.INVISIBLE);
            } else {
                this.note.setVisibility(View.INVISIBLE);
                this.note2.setVisibility(View.VISIBLE);
            }

            System.out.println("Response : " + id + libelle + description + note);

            titre.setText(libelle);
            this.description.setText(description);
            this.note.setRating(note);

            confirmationActivite.setVisibility(View.INVISIBLE);

        } catch(Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
    }



    public void enregistrerActivite() {
        try{
            Intent intent = getIntent();
            final String idActi = intent.getStringExtra("idActi");
            final String userId = intent.getStringExtra("idUser");
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/enregistrerActivite.php"); // make sure the url is correct.
            //add your data
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be similar,
            nameValuePairs.add(new BasicNameValuePair("idUser", userId.trim()));  // $Edittext_value = $_POST['Edittext_value'];
            nameValuePairs.add(new BasicNameValuePair("idActivite", idActi.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            //Execute HTTP Post Request
            // response=httpclient.execute(httppost);
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("response : " + response);
            JSONObject jObj = new JSONObject(response);

            System.out.println("response : " + response);

            final String id = jObj.getString("idUser");




            if(id == null) {
                Context context = getApplicationContext();
                CharSequence s = "Activité enregistrée !";
                int duration = Toast.LENGTH_SHORT;
                Toast toast = Toast.makeText(context, s, duration);
                toast.show();
            } else {
                confirmationActivite.setVisibility(View.VISIBLE);
                btnOui.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        try {
                            HttpClient httpclient = new DefaultHttpClient();
                            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/updateUserActivite.php");
                            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
                            nameValuePairs.add(new BasicNameValuePair("idUser", userId.trim()));  // $Edittext_value = $_POST['Edittext_value'];
                            nameValuePairs.add(new BasicNameValuePair("idActivite", idActi.trim()));
                            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

                            ResponseHandler<String> responseHandler = new BasicResponseHandler();
                            httpclient.execute(httppost, responseHandler);

                            Context context = getApplicationContext();
                            CharSequence s = "Activité enregistrée !";
                            int duration = Toast.LENGTH_SHORT;
                            Toast toast = Toast.makeText(context, s, duration);
                            toast.show();

                            confirmationActivite.setVisibility(View.INVISIBLE);

                        } catch(Exception e) {
                            System.out.println("Exception : " + e.getMessage());
                        }
                    }
                });
            }

        }catch(Exception e){
            System.out.println("Exception : " + e.getMessage());
        }
    }
    //menu
    private void addDrawerItems() {
        String[] osArray = {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter" };

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(ActiAmis.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(ActiAmis.this, GroupeAccueil.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(ActiAmis.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(ActiAmis.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
            }
        });
    }

    private void AfficherMessage(){
        Intent intent = new Intent(ActiAmis.this, GroupeAccueil.class);
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
        //getMenuInflater().inflate(R.menu.menu_main, menu);
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
        Intent intent = new Intent(ActiAmis.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}
