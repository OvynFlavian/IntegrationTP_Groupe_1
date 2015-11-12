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
public class AjoutAmis extends ActionBarActivity {
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


    //lister les amis

    private ListView amisList;
    private DrawerLayout mDrawerAmisLayout;
    private ArrayAdapter<String> mAmisAdapter;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ajoutamis_layout);
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

        Thread thread = new Thread(new Runnable() {
            public void run() {
                ArrayList<String> liste = afficheUserPublic(context);
                addOptionOnClick(context, liste);
            }


        });
        thread.start();
    }



    private void addOptionOnClick(Context context, final ArrayList<String> list) {
          mAmisAdapter = new ArrayAdapter<String>(context, android.R.layout.simple_list_item_1, list);
        amisList.setAdapter(mAmisAdapter);

        amisList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, final int position, long id) {
               new Thread(new Runnable() {
                   @Override
                   public void run() {
                       ajouterAmis(position,list);
                   }
               }).start();

                /*
                if (position == 0) {
                    Intent intent = new Intent(AjoutAmis.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(AjoutAmis.this, ChoixCategorie.class);
                    startActivity(intent);

                }
                if (position == 2) {
                    Intent intent = new Intent(AjoutAmis.this, AjoutAmis.class);
                    startActivity(intent);

                }*/
                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
    }

   public void ajouterAmis(int position,  ArrayList<String> list){
       try{
          // String [] liste = (String[]) list.toArray();


           httpclient=new DefaultHttpClient();
           httppost= new HttpPost("http://192.168.0.13/my_folder_inside_htdocs/ajouterAmis.php"); // make sure the url is correct.

           nameValuePairs = new ArrayList<NameValuePair>(2);
           nameValuePairs.add(new BasicNameValuePair("userName", list.get(position).toString().trim()));
           System.out.println("Response 22:"+ list.get(position).toString() );
           nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
           System.out.println("Response :1 ");
           httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
           //Execute HTTP Post Request

           System.out.println("Response : 2" );
           ResponseHandler<String> responseHandler = new BasicResponseHandler();
           final String response2 = httpclient.execute(httppost, responseHandler);
           System.out.println("Response : " + response2);
          // JSONArray JsonArray = new JSONArray(response);

           System.out.println("Response : " );



       }catch(Exception e){
           /* dialog.dismiss();*/
           System.out.println("Exception : " + e.getMessage());
       }


   }

public ArrayList<String> afficheUserPublic(Context context){

    try{

        httpclient=new DefaultHttpClient();
        httppost= new HttpPost("http://192.168.0.13/my_folder_inside_htdocs/afficherUserPublic.php"); // make sure the url is correct.

        //Execute HTTP Post Request
        response=httpclient.execute(httppost);
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
            tbAmis[i] = ("Nom d'utilisateur: "+jsonObject.getString("userName") +"\n"+"Email: "+ jsonObject.getString("email")).toString();
            list.add(tbAmis[i]);

        }

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
        AjoutAmis.this.runOnUiThread(new Runnable() {
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(AjoutAmis.this);
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
        String[] osArray = { "profil", "activités", "amis", "se déconnecter" };
        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(AjoutAmis.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(AjoutAmis.this, ChoixCategorie.class);
                    startActivity(intent);

                }
                if (position == 2) {
                    Intent intent = new Intent(AjoutAmis.this, AfficherAmis.class);
                    startActivity(intent);

                }
                if (position == 3) {
                    logoutUser();

                }
                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
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

    public void logoutUser() {
        session.setLogin(false);

        // Launching the login activity
        Intent intent = new Intent(AjoutAmis.this, MainActivity.class);
        startActivity(intent);
        finish();
    }


}