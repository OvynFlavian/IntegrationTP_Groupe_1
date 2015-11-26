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

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;

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
public class RequeteGroupe extends ActionBarActivity {
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

    //lister les amis

    private ListView amisList;
    private DrawerLayout mDrawerAmisLayout;
    private ArrayAdapter<String> mAmisAdapter;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.requete_amis);

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
        // Session manager
        session = new SessionManager(getApplicationContext());


                ArrayList<String> liste = afficherAmis(context);
                addOptionOnClick(liste);



    }




    private void addOptionOnClick(final ArrayList<String> list) {

        amisList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, final int position, long id) {
                AcceptDemande(position, list);

                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
    }


    public void AcceptDemande(int position, ArrayList<String> list){
        String username = list.get(position).toString();
        Intent intent = new Intent(this, AccepterGroupe.class);
        intent.putExtra("username", username );
        startActivity(intent);

    }


    public ArrayList<String> afficherAmis(Context context){

        try{

            Intent intent = getIntent();
            final ArrayList<String> liste = intent.getStringArrayListExtra("liste");

            mAmisAdapter = new ArrayAdapter<String>(context, android.R.layout.simple_list_item_1, liste);
            amisList.setAdapter(mAmisAdapter);

            return liste;

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
        RequeteGroupe.this.runOnUiThread(new Runnable() {
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(RequeteGroupe.this);
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
        String[] osArray = { "profil", "activités", "amis","groupe", "se déconnecter" };
        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(RequeteGroupe.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(RequeteGroupe.this, ChoixCategorie.class);
                    startActivity(intent);

                }
                if (position == 2) {
                    Intent intent = new Intent(RequeteGroupe.this, AfficherAmis.class);
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

    private void AfficherMessage(){
        Intent intent = new Intent(RequeteGroupe.this, GroupeAccueil.class);
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
        Intent intent = new Intent(RequeteGroupe.this, Accueil.class);
        startActivity(intent);
        finish();
    }


}