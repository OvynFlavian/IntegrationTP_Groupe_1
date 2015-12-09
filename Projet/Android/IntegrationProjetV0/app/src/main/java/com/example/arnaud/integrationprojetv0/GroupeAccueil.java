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


/**
 * Created by nauna on 24-11-15.
 */
public class GroupeAccueil extends ActionBarActivity {

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
    private Button btnAffGroupe;
    private Button btnRequeteAjout;
    private Button btnListeUsers;

    private Boolean dansGroupe;
    private int idGroupe;
    private Boolean isLeader;
    private Boolean seulDansGroupe;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        session = new SessionManager(getApplicationContext());

        dansGroupe = checkGroupe();
        checkSeul();
        checkLeader();

        setContentView(R.layout.groupe_accueil);

        btnCreerGroupe = (Button) findViewById(R.id.btnCreerGroupe);

        btnVoirGroupe = (Button) findViewById(R.id.btnVoirGroupe);
        btnAffGroupe = (Button) findViewById(R.id.btnAffGroupe);
        btnRequeteAjout = (Button) findViewById(R.id.btnRequete);
        btnListeUsers = (Button) findViewById(R.id.btnListeUsers);

        //menu
        mDrawerList = (ListView) findViewById(R.id.amisList);
        mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);



        if(!dansGroupe){
            btnVoirGroupe.setVisibility(View.INVISIBLE);
        } else {
            btnCreerGroupe.setVisibility(View.INVISIBLE);
            btnAffGroupe.setVisibility(View.INVISIBLE);
            btnRequeteAjout.setVisibility(View.INVISIBLE);
        }

        btnCreerGroupe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(GroupeAccueil.this, CreerGroupe.class);
                startActivity(intent);
            }
        });

        btnVoirGroupe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(GroupeAccueil.this, VoirGroupe.class);
                intent.putExtra("isLeader", isLeader);
                intent.putExtra("seulDansGroupe", seulDansGroupe);
                startActivity(intent);
            }
        });

        btnAffGroupe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(GroupeAccueil.this, AfficherGroupe.class);
                startActivity(intent);
            }
        });

        btnListeUsers.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(GroupeAccueil.this, AjoutAmisGroupe.class);
                startActivity(intent);
            }
        });

        final ArrayList<String> liste1;
        if ((liste1 = isRequete()) != null){
            btnRequeteAjout.setVisibility(View.VISIBLE);
            btnRequeteAjout.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(GroupeAccueil.this, RequeteGroupe.class);
                    intent.putExtra("liste", liste1 );
                    startActivity(intent);
                }
            });
        } else {
            btnRequeteAjout.setVisibility(View.INVISIBLE);
        }

    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    public ArrayList<String> isRequete(){
        try{
            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://www.everydayidea.be/scripts_android/affRequeteGroupe.php");
            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            JSONArray JsonArray = new JSONArray(response);

            final ArrayList<String> list = new ArrayList<String>();
            final String[] tbAmis = new String[35];

            if (!JsonArray.getJSONObject(0).getString("error").equals("TRUE")) {
                for (int i = 0; i < JsonArray.length(); i++) {
                    JSONObject jsonObject = JsonArray.getJSONObject(i);
                    tbAmis[i] = ("Nom d'utilisateur: " + jsonObject.getString("userName") + "\n" + "Description: " + jsonObject.getString("description")).toString();
                    list.add(tbAmis[i]);
                }
                return list;
            } else {
                tbAmis[0] = ("Aucune invitation trouvée");
                list.add(tbAmis[0]);
                return null;
            }

        }catch(Exception e){
            System.out.println("Exception : " + e.getMessage());
        }
        return null;
    }

    public boolean checkGroupe() {
        try {
            Boolean dansGroupe = false;
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/getGroupe.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("idUser", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);

            JSONObject jsonObject = new JSONObject(response);

            idGroupe = jsonObject.getInt("idGroupe");

            if (idGroupe == 0) {
                dansGroupe = false;
            } else {
                dansGroupe = true;
            }

            return dansGroupe;
        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
            return false;
        }
    }

    public boolean checkLeader() {
        try {
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/checkLeader.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("idUser", session.getId().trim()));
            nameValuePairs.add(new BasicNameValuePair("idGroupe", String.valueOf(idGroupe).trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);

            JSONObject jsonObject = new JSONObject(response);

            int idLeader = 0;
            idLeader = jsonObject.getInt("idLeader");
            if (idLeader == Integer.valueOf(session.getId())) {
                isLeader = true;
            } else {
                isLeader = false;
            }

            return isLeader;
        } catch (Exception e) {
            return false;
        }
    }

    public Boolean checkSeul() {
        try {
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/checkSeul.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("idUser", session.getId().trim()));
            nameValuePairs.add(new BasicNameValuePair("idGroupe", String.valueOf(idGroupe).trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            JSONObject jsonObject = new JSONObject(response);

            int nbUsers = 0;
            nbUsers = jsonObject.getInt("nbUsers");

            if (nbUsers > 1) {
                seulDansGroupe = false;
            } else if (nbUsers <= 1) {
                seulDansGroupe = true;
            }

            return seulDansGroupe;
        } catch (Exception e) {
            return false;
        }
    }

    public boolean isGroup(){
        try {

            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://www.everydayidea.be/scripts_android/isGroup.php");

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            String response2 = httpclient.execute(httppost, responseHandler);

            if (response2.equals("true")) {
                return true;
            } else {
                return false;
            }

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
        return false;
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
                    Intent intent = new Intent(GroupeAccueil.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    if(osArray[1].equals("Groupe")) {
                        Intent intent = new Intent(GroupeAccueil.this, GroupeAccueil.class);
                        startActivity(intent);
                    } else {
                        String url = "http://www.everydayidea.be/Page/connexion.page.php";
                        Intent i = new Intent(Intent.ACTION_VIEW);
                        i.setData(Uri.parse(url));
                        startActivity(i);
                    }
                }
                if (position == 2) {
                    Intent intent = new Intent(GroupeAccueil.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(GroupeAccueil.this, ChoixCategorie.class);
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
        Intent intent = new Intent(GroupeAccueil.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}
