package com.example.arnaud.integrationprojetv0;

import android.app.AlertDialog;
import android.app.ProgressDialog;
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
import android.widget.EditText;
import android.widget.ListView;
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

/**
 * <b>ModifProfil  est une classe qui permet de modifier le profil d'un utilisateur.</b>
 * <p>
 * Une personne peut modifier les informations suivantes :
 * <ul>
 * <li>nom d'utilisateur.</li>
 * <li>email.</li>
 * <li>Mot de passe .</li>
 * </ul>
 * </p>
 * @author Willame Arnaud
 */
public class ModifProfil extends ActionBarActivity {

    //menu
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;

    private SessionManager session;
    Button btnAppli;
    ProgressDialog dialog = null;
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    EditText usr,pass,email,confPass;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.modif_layout);

        usr = (EditText)findViewById(R.id.username);
        email = (EditText)findViewById(R.id.email);
        pass= (EditText)findViewById(R.id.password);
        confPass = (EditText)findViewById(R.id.confPass);
        btnAppli = (Button) findViewById(R.id.btnAppli);
        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        session = new SessionManager(getApplicationContext());

        usr.setText(session.getUsername());
        email.setText((session.getEmail()));

        btnAppli.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog = ProgressDialog.show(ModifProfil.this, "",
                        "Validation de l'inscription...", true);
                new Thread(new Runnable() {
                    public void run() {
                        modifProfil();
                    }
                }).start();
            }
        });

    }

    /**
     * modification du profil d'un utilisateur
     */
    void modifProfil(){
        try{

            session = new SessionManager(getApplicationContext());

            String id = null;
            id = session.getId();


            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://10.99.2.237/my_folder_inside_htdocs/modifProfil.php"); // make sure the url is correct.
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", usr.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("email", email.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("mdp", pass.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("mdpConfirm", confPass.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("id", id.toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            runOnUiThread(new Runnable() {
                public void run() {
                    //  tv.setText("Response from PHP : " + response);
                    dialog.dismiss();
                }
            });

            if(response.equalsIgnoreCase("erreur.")){
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast.makeText(ModifProfil.this, "Modification Effectuees", Toast.LENGTH_SHORT).show();
                    }
                });
                session.setUsername(usr.getText().toString().trim());
                session.setEmail(email.getText().toString().trim());

                startActivity(new Intent(ModifProfil.this, MainActivity.class));
            }else{
                showAlert(response);
            }

        }catch(Exception e){
            dialog.dismiss();
            System.out.println("Exception : " + e.getMessage());
        }
    }


    //menu
    private void addDrawerItems() {
        String[] osArray = { "profil", "activités", "amis", "se déconnecter" };
        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if(position==0){
                    Intent intent = new Intent(ModifProfil.this, Profil.class);
                    startActivity(intent);
                }
                if(position==1){
                    Intent intent = new Intent(ModifProfil.this, ChoixCategorie.class);
                    startActivity(intent);

                }
                if(position==2){
                    Intent intent = new Intent(ModifProfil.this, AfficherAmis.class);
                    startActivity(intent);

                }
                if(position==3){
                    logoutUser();

                }
                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
    }

    public void logoutUser() {
        session.setLogin(false);

        // Launching the login activity
        Intent intent = new Intent(ModifProfil.this, MainActivity.class);
        startActivity(intent);
        finish();
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


    /**
     * Affiche les erreurs
     */
    public void showAlert(final String response){
        ModifProfil.this.runOnUiThread(new Runnable() {
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(ModifProfil.this);
                builder.setTitle("erreur modification.");
                builder.setMessage("" + response)
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
}