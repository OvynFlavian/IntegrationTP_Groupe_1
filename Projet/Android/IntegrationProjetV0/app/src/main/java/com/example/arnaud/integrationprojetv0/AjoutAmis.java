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
import android.widget.SearchView;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
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
    private SearchView cherchView;


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

        final SearchView searchView = (SearchView) findViewById(R.id.searchView);


        final Context context=getApplicationContext();
        // Session manager
        session = new SessionManager(getApplicationContext());


        //attention thread peut utiliser "syncrhronysed";
     /*   Thread thread = new Thread(new Runnable() {
            public void run() {*/
                final ArrayList<String> liste = afficheUserPublic(context);


                searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
                    @Override
                    public boolean onQueryTextSubmit(String recherche) {
                        return true;
                    }

                    @Override
                    public boolean onQueryTextChange(String recherche) {
                        ArrayList<String> listeRech = rechercheAmis(liste, recherche, context);
                        System.out.println("rech" + recherche);
                        System.out.println("rech2" + listeRech.toString());
                        return true;
                    }


                });
                addOptionOnClick(liste);



         /*   }


        });
        thread.start();*/
    }



        private void addOptionOnClick(final ArrayList<String> list) {

        amisList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, final int position, long id) {
               /*new Thread(new Runnable() {
                   @Override
                   public void run() {*/
                       ajouterAmis(position,list);
                 /*  }
               }).start();
*/


                // Toast.makeText(Profil.this, "Time for an upgrade!", Toast.LENGTH_SHORT).show();
            }
        });
    }

    public ArrayList<String> rechercheAmis(ArrayList<String> liste , String rech, Context context){
        ArrayList<String> liste2 = new ArrayList<String>();
        String search = rech;
        int searchListLength = liste.size();
        for (int i = 0; i < searchListLength; i++) {
            if (liste.get(i).contains(search)) {
                        liste2.add(liste.get(i));
            }
        }


/*
        for (String string : liste) {
            //modifier ca pour que ca fasse une belle recherche
            if(string.matches("(?i)(rech).*")){
                liste2.add(string);
            }
        }
        */

        mAmisAdapter = new ArrayAdapter<String>(context, android.R.layout.simple_list_item_1, liste2);
        amisList.setAdapter(mAmisAdapter);

        return liste2;

    }

   public void ajouterAmis(int position,  ArrayList<String> list){
       String username = list.get(position).toString();


       Intent intent = new Intent(this, ConfirmAjout.class);
       intent.putExtra("username", username );
     /*  intent.putStringArrayListExtra("liste", list);
       intent.putExtra("position", position);*/


       startActivity(intent);

/*
       try{
          // String [] liste = (String[]) list.toArray();


           httpclient=new DefaultHttpClient();
           httppost= new HttpPost("http://91.121.151.137/scripts_android/AjouterAmis.php"); // make sure the url is correct.

           nameValuePairs = new ArrayList<NameValuePair>(2);
           nameValuePairs.add(new BasicNameValuePair("userName", list.get(position).toString().trim()));
           System.out.println("Response 22:"+ list.get(position).toString() );
           nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
           System.out.println("Response :1 ");
           httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
           //Execute HTTP Post Request

           System.out.println("Response : 2" );
           ResponseHandler<String> responseHandler = new BasicResponseHandler();
           String response2 = httpclient.execute(httppost, responseHandler);
           System.out.println("Response : " + response2);
          // JSONArray JsonArray = new JSONArray(response);

           System.out.println("Response : " );



       }catch(Exception e){

           System.out.println("Exception : " + e.getMessage());
       }

*/
   }

public ArrayList<String> afficheUserPublic(Context context){

    try{

        httpclient=new DefaultHttpClient();
        httppost= new HttpPost("http://91.121.151.137/scripts_android/afficherUserPublic.php"); // make sure the url is correct.

        //Execute HTTP Post Request
        response=httpclient.execute(httppost);
        ResponseHandler<String> responseHandler = new BasicResponseHandler();
        final String response = httpclient.execute(httppost, responseHandler);
        System.out.println("Response : " + response);
        JSONArray JsonArray = new JSONArray(response);

        System.out.println("Response : " + JsonArray);
        System.out.println("taille : " + JsonArray.length());


        final ArrayList<String> list = new ArrayList<String>();
       // final String[] tbAmis = new String[4];

        for (int i=0;i<JsonArray.length();i++) {
            JSONObject jsonObject = JsonArray.getJSONObject(i);
            System.out.println("taille : " + JsonArray.getJSONObject(i));
          // tbAmis[i] = ("Nom d'utilisateur: "+jsonObject.getString("userName") +"\n"+"Email: "+ jsonObject.getString("email")).toString();
            list.add(("Nom d'utilisateur: "+jsonObject.getString("userName") +"\n"+"Email: "+ jsonObject.getString("email")).toString());

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

    private void logoutUser() {
        session.setLogin(false);
        session.setEmail(null);
        session.setPublics(null);
        session.setUsername(null);
        session.setId(null);

        // Launching the login activity
        Intent intent = new Intent(AjoutAmis.this, Accueil.class);
        startActivity(intent);
        finish();
    }


}