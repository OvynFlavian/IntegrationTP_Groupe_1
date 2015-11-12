package com.example.arnaud.integrationprojetv0;

import android.content.Intent;
import android.content.res.Configuration;
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

import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

public class ChoixCategorie extends AppCompatActivity {

    private Button animaux = null;
    private Button famille = null;
    private Button film = null;
    private Button visite = null;
    private Button profil = null;
    private Button btnLogout = null;
    private String categorie = null;
    private static final String test = "categorie";
    private SessionManager session;
    private RelativeLayout layoutCat = null;
    private int hauteur = 1350;
    //menu
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.categorie_layout);

        afficherCategorie();

        // session manager
        session = new SessionManager(getApplicationContext());

        /*animaux = (Button) findViewById(R.id.animaux);
        enfant = (Button) findViewById(R.id.enfant);
        film = (Button) findViewById(R.id.film);
        visite = (Button) findViewById(R.id.visite);*/
        profil = (Button) findViewById(R.id.profil);
        btnLogout = (Button) findViewById(R.id.btnLogout);
        layoutCat = (RelativeLayout) findViewById(R.id.layoutCat2);

        btnLogout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                logoutUser();
            }
        });

        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);


        /*animaux.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = animaux.getText().toString();
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        enfant.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = "enfant";
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        film.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = "film";
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        visite.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categorie = "visite";
                Intent intent = new Intent(ChoixCategorie.this, AfficherActivite.class);
                intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });*/

        profil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ChoixCategorie.this, Profil.class);
                //intent.putExtra(test, categorie);
                startActivity(intent);
            }
        });

        if (!session.isLoggedIn()) {
            profil.setVisibility(View.INVISIBLE);
            btnLogout.setVisibility(View.INVISIBLE);
        }
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

    public void afficherCategorie() {
        try{

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://91.121.151.137/scripts_android/afficherCategorie.php"); // make sure the url is correct.

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

    public void newCategorie(String cat, int id) {
        final Button categorie = new Button(this);
        categorie.setText(cat);
        categorie.setTextColor(getResources().getColor(R.color.transparent));
        categorie.setId(id);
        int resId = getResources().getIdentifier(cat, "drawable", this.getPackageName());
        categorie.setBackgroundResource(resId);
        RelativeLayout.LayoutParams p = new RelativeLayout.LayoutParams(400, 400);

        if(id > 4) {
            hauteur = hauteur + 500;
            System.out.println("xjkdfhsxdflsdf");
        }

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

        FrameLayout.LayoutParams p2 = new FrameLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, hauteur);
        ((RelativeLayout) findViewById(R.id.layoutCat3)).setLayoutParams(p2);


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
                    Intent intent = new Intent(ChoixCategorie.this, Profil.class);
                    startActivity(intent);
                }
                if(position==1){
                    Intent intent = new Intent(ChoixCategorie.this, ChoixCategorie.class);
                    startActivity(intent);

                }
                if(position==2){
                    Intent intent = new Intent(ChoixCategorie.this, AfficherAmis.class);
                    startActivity(intent);

                }
                if(position==3){
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

}