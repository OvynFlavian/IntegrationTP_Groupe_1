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
import android.widget.EditText;
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
public class GroupMessage extends ActionBarActivity {
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


    private EditText message;
    private Button btnEnvoyer;
    //lister les amis

    private ListView amisList;
    private DrawerLayout mDrawerAmisLayout;
    private ArrayAdapter<String> mAmisAdapter;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        setContentView(R.layout.groupe_message);
        session = new SessionManager(getApplicationContext());
        message = (EditText) findViewById(R.id.message);
        btnEnvoyer = (Button) findViewById(R.id.btnEnvoyer);
        //menu
        mDrawerList = (ListView)findViewById(R.id.navlist);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();
        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        //liste message
        amisList = (ListView)findViewById(R.id.amisList);
        mDrawerAmisLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        final Context context=getApplicationContext();


        ArrayList<String> liste = afficherMembre(context);
        addOptionOnClick(liste);

        btnEnvoyer .setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
               envoiMessage(message);
                Intent intent = new Intent(GroupMessage.this, GroupMessage.class);
                startActivity(intent);

            }
        });

    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }




    private void addOptionOnClick(final ArrayList<String> list) {

        amisList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, final int position, long id) {

                //on click.... do...

            }
        });
    }

    public void envoiMessage(EditText message){
        try{

            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://www.everydayidea.be/scripts_android/envoiMess.php"); // make sure the url is correct.

            //Execute HTTP Post Request
            nameValuePairs = new ArrayList<NameValuePair>(2);

            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("desc", message.getText().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);





        }catch(Exception e){
           /* dialog.dismiss();*/
            System.out.println("Exception : " + e.getMessage());
        }

    }

    public ArrayList<String> afficherMembre(Context context){
        //modifier pour ajouter les amis du groupe.
        try{

            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://www.everydayidea.be/scripts_android/affMessGroup.php"); // make sure the url is correct.

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
            final String[] tbAmis = new String[120];

            for (int i=0;i<JsonArray.length();i++) {
                JSONObject jsonObject = JsonArray.getJSONObject(i);
                System.out.println("taille : " + JsonArray.getJSONObject(i));
                tbAmis[i] = (jsonObject.getString("userName")+" :" +"\n"+ jsonObject.getString("description")).toString();
                list.add(tbAmis[i]);

            }
            mAmisAdapter = new ArrayAdapter<String>(context, R.layout.spinner_theme2, list);
            amisList.setAdapter(mAmisAdapter);

            return list;





        }catch(Exception e){
           /* dialog.dismiss();*/
            System.out.println("Exception : " + e.getMessage());
        }
        return null;
    }


    //menu
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
                    Intent intent = new Intent(GroupMessage.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    if(osArray[1].equals("Groupe")) {
                        Intent intent = new Intent(GroupMessage.this, GroupeAccueil.class);
                        startActivity(intent);
                    } else {
                        String url = "http://www.everydayidea.be/Page/connexion.page.php";
                        Intent i = new Intent(Intent.ACTION_VIEW);
                        i.setData(Uri.parse(url));
                        startActivity(i);
                    }
                }
                if (position == 2) {
                    Intent intent = new Intent(GroupMessage.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(GroupMessage.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
            }
        });
    }

    private void AfficherMessage(){
        Intent intent = new Intent(GroupMessage.this, GroupeAccueil.class);
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
        Intent intent = new Intent(GroupMessage.this, Accueil.class);
        startActivity(intent);
        finish();
    }


}