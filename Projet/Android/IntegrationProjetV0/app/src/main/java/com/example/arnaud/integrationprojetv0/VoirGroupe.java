package com.example.arnaud.integrationprojetv0;


import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
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
import android.widget.ListView;
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

/**
 * <b>MainActivity est la classe qui permet de se connecter à l'application.</b>
 * <p>
 * Une personne se connecte grâce aux informations suivantes :
 * <ul>
 * <li>Un nom d'utilisateur.</li>
 * <li>Un mot de passe.</li>
 * </ul>
 * </p>
 * @author Willame Arnaud
 */
public class VoirGroupe extends ActionBarActivity {
    HttpPost httppost;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;

    private SessionManager session;
    //menu
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;
    private Button addAmis = null;
    private Button btnRequete = null;


    private TextView desc,acti;
    //lister les amis

    private ListView amisList;
    private DrawerLayout mDrawerAmisLayout;
    private ArrayAdapter<String> mAmisAdapter;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.groupe_afficher);
        session = new SessionManager(getApplicationContext());
        addAmis = (Button) findViewById(R.id.btnAdd);
        btnRequete=(Button) findViewById(R.id.btnRequete);
        btnRequete.setVisibility(View.INVISIBLE);
        desc = (TextView) findViewById(R.id.desc);
        acti = (TextView) findViewById(R.id.acti);
        //menu
        mDrawerList = (ListView)findViewById(R.id.navlist);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();
        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        //liste amis
        amisList = (ListView)findViewById(R.id.amisList);
        mDrawerAmisLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        final Context context=getApplicationContext();


        //affichage description
        String descritpion = afficherDesc();
        String activite = afficherActi();
        desc.setText("description : "+descritpion);
        acti.setText("Activité : "+ activite);

        addAmis.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(VoirGroupe.this, AjoutAmisGroupe.class);
                startActivity(intent);
            }
        });


        final ArrayList<String> liste1;
        if ((liste1=isRequete())!= null){
            btnRequete.setVisibility(View.VISIBLE);
            btnRequete.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(VoirGroupe.this, RequeteGroupe.class);
                    intent.putExtra("liste", liste1 );
                    startActivity(intent);



                }
            });
        }

                ArrayList<String> liste = afficherMembre(context);
                addOptionOnClick(liste);

    }

    private String afficherActi() {
        try {
            // String [] liste = (String[]) list.toArray();


            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://109.89.122.61/scripts_android/afficherActiGroupe.php"); // make sure the url is correct.

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 " + session.getId().toString());
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");
            return  response2;


        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());

        }


        return null;


    }

    public String afficherDesc() {

        try {
            // String [] liste = (String[]) list.toArray();


            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://109.89.122.61/scripts_android/voirGroupe.php"); // make sure the url is correct.

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 " + session.getId().toString());
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");
            return  response2;


        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());

        }


        return null;
    }


    private void addOptionOnClick(final ArrayList<String> list) {

        amisList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, final int position, long id) {
               /*new Thread(new Runnable() {
                   @Override
                   public void run() {*/
                afficherProfil(position, list);
                 /*  }
               }).start();
*/


                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
    }


    //modifier pour les requetes de groupe.
    public ArrayList<String> isRequete(){
        try{

            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://109.89.122.61/scripts_android/affRequeteGroupe.php"); // make sure the url is correct.

            //Execute HTTP Post Request
            nameValuePairs = new ArrayList<NameValuePair>(2);

            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : " + JsonArray);
            System.out.println("taille : " + JsonArray.length());


            final ArrayList<String> list = new ArrayList<String>();
            final String[] tbAmis = new String[35];

            for (int i=0;i<JsonArray.length();i++) {
                JSONObject jsonObject = JsonArray.getJSONObject(i);
                System.out.println("taille : " + JsonArray.getJSONObject(i));
                tbAmis[i] = ("Nom d'utilisateur: "+jsonObject.getString("userName") +"\n"+"Description: "+ jsonObject.getString("description")).toString();
                list.add(tbAmis[i]);

            }


            return list;





        }catch(Exception e){
           /* dialog.dismiss();*/
            System.out.println("Exception : " + e.getMessage());
        }
        return null;

    }




    public void afficherProfil(int position, ArrayList<String> list){
        String username = list.get(position).toString();


        Intent intent = new Intent(this, AfficherProfilAmis.class);
        intent.putExtra("username", username );

        startActivity(intent);

    }


    public ArrayList<String> afficherMembre(Context context){
        //modifier pour ajouter les amis du groupe.
        try{

            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://109.89.122.61/scripts_android/afficherMembreGroupe.php"); // make sure the url is correct.

            //Execute HTTP Post Request
            nameValuePairs = new ArrayList<NameValuePair>(2);

            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response444 : " + JsonArray);
            System.out.println("taille : " + JsonArray.length());


            final ArrayList<String> list = new ArrayList<String>();
            final String[] tbAmis = new String[35];

            for (int i=0;i<JsonArray.length();i++) {
                JSONObject jsonObject = JsonArray.getJSONObject(i);
                System.out.println("taille : " + JsonArray.getJSONObject(i));
                tbAmis[i] = ("Nom d'utilisateur: "+jsonObject.getString("userName") +"\n"+"Email: "+ jsonObject.getString("email")).toString();
                list.add(tbAmis[i]);

            }
            mAmisAdapter = new ArrayAdapter<String>(context, android.R.layout.simple_list_item_1, list);
            amisList.setAdapter(mAmisAdapter);

            return list;





        }catch(Exception e){
           /* dialog.dismiss();*/
            System.out.println("Exception : " + e.getMessage());
        }
        return null;
    }

    /**
     * Affiche les erreurs
     */
    public void showAlert(){
        VoirGroupe.this.runOnUiThread(new Runnable() {
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(VoirGroupe.this);
                builder.setTitle("connexion erreur.");
                builder.setMessage("utilisateur non trouvé.")
                        .setCancelable(false)
                        .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                            }
                        });
                AlertDialog alert = builder.create();
                alert.show();
            }
        });
    }


    //menu
    private void addDrawerItems() {
        String[] osArray = new String[] {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter"};

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(VoirGroupe.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(VoirGroupe.this, GroupeAccueil.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(VoirGroupe.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(VoirGroupe.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
            }
        });
    }

    private void AfficherMessage(){
        Intent intent = new Intent(VoirGroupe.this, GroupeAccueil.class);
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

    private void logoutUser() {
        session.setLogin(false);
        session.setEmail(null);
        session.setPublics(null);
        session.setUsername(null);
        session.setId(null);

        // Launching the login activity
        Intent intent = new Intent(VoirGroupe.this, Accueil.class);
        startActivity(intent);
        finish();
    }


}