package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.graphics.drawable.BitmapDrawable;
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
import android.widget.ImageView;
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
import org.w3c.dom.Text;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

/**
 * Created by Thomas on 2/12/2015.
 */
public class NoterActivite extends AppCompatActivity {

    private TextView titre, description;
    private RatingBar note;

    private SessionManager session;

    //menu
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;

    //gestion des groupes
    private int idGroupe = 0;
    private Boolean isLeader = false;
    private Boolean seulDansGroupe = false;
    private String textBase;

    //image des activités
    private Bitmap bitmap = null;
    private ImageView imageActivite;
    private URL urlImage = null;
    private Boolean imageTrouvee = true;
    private RelativeLayout layoutActivite = null;
    private String idActivite;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        setContentView(R.layout.noteractivite_layout);

        titre = (TextView) findViewById(R.id.titre);
        description = (TextView) findViewById(R.id.description);
        layoutActivite = (RelativeLayout) findViewById(R.id.layoutActivite);
        imageActivite = (ImageView) findViewById(R.id.image);
        note = (RatingBar) findViewById(R.id.note);

        session = new SessionManager(getApplicationContext());
        Intent intent = getIntent();

        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();
        addDrawerItems();
        setupDrawer();
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        titre.setText(intent.getStringExtra("titre"));
        description.setText(intent.getStringExtra("description"));
        idActivite = intent.getStringExtra("id");

        getNote(intent.getStringExtra("titre"));

        System.out.println("après récupération de la session");
    }

    public void envoyerNote(View v) {
        Float note = this.note.getRating();
        String dansGroupe = checkGroupe();
        String isLeader = checkLeader();
        String isSeul = checkSeul();

        try {
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/setNote.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(7);
            nameValuePairs.add(new BasicNameValuePair("idActivite", idActivite.trim()));
            nameValuePairs.add(new BasicNameValuePair("userName", session.getUsername().trim()));
            nameValuePairs.add(new BasicNameValuePair("note", String.valueOf(note).trim()));
            nameValuePairs.add(new BasicNameValuePair("idUser", session.getId().trim()));
            nameValuePairs.add(new BasicNameValuePair("idGroupe", String.valueOf(idGroupe)));
            nameValuePairs.add(new BasicNameValuePair("dansGroupe", dansGroupe));
            nameValuePairs.add(new BasicNameValuePair("isLeader", isLeader));
            nameValuePairs.add(new BasicNameValuePair("isSeul", isSeul));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            httpclient.execute(httppost, responseHandler);

            Toast.makeText(NoterActivite.this, "Votre avis a été enregistré !", Toast.LENGTH_SHORT).show();

            startActivity(new Intent(NoterActivite.this, ChoixCategorie.class));

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }

    }

    public String checkGroupe() {
        try {
            String dansGroupe = "false";
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/getGroupe.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("idUser", session.getId().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);

            JSONObject jsonObject = new JSONObject(response);

            idGroupe = jsonObject.getInt("idGroupe");

            if (idGroupe == 0) {
                dansGroupe = "false";
            } else {
                dansGroupe = "true";
            }

            return dansGroupe;
        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
            return "";
        }
    }

    public String checkLeader() {
        try {
            String retour;
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
                retour = "true";
            } else {
                isLeader = false;
                retour = "false";
            }

            return retour;
        } catch (Exception e) {
            return "";
        }
    }

    public String checkSeul() {
        try {
            String retour = null;
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
                retour = "false";
            } else if (nbUsers <= 1) {
                seulDansGroupe = true;
                retour = "true";
            }

            return retour;
        } catch (Exception e) {
            return "";
        }
    }

    public void getNote(String libelle) {
        Boolean activiteTrouvee = false;
        layoutActivite.removeView(imageActivite);
        RelativeLayout.LayoutParams p = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
        p.addRule(RelativeLayout.BELOW, R.id.proposition);
        p.addRule(RelativeLayout.CENTER_HORIZONTAL);
        p.setMargins(5,200,5,60);
        titre.setLayoutParams(p);
        titre.setTextSize(25);
        try {
            Float note = null;

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/getNote.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("libelle", libelle.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);

            JSONObject jObj = new JSONObject(response);

            note = Float.valueOf(jObj.getString("note"));
            final String categorie = jObj.getString("categorie");
            idActivite = jObj.getString("idActivite");

            activiteTrouvee = true;

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }

        try {
            String url = "http://www.everydayidea.be/Images/activite/" + idActivite + ".jpg";
            urlImage = new URL(url);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }

        if(activiteTrouvee) {
            downloadImage();
        } else {
            imageActivite.setVisibility(View.INVISIBLE);
        }
    }

    private void downloadImage() {
        try {
            System.out.println("fin de download 1");
            String url = "http://www.everydayidea.be/Images/activite/" + idActivite + ".jpg";
            urlImage = new URL(url);
            System.out.println("fin de download 2");
            HttpURLConnection connection = (HttpURLConnection) urlImage.openConnection();
            System.out.println("fin de download 3");
            InputStream inputStream = connection.getInputStream();
            System.out.println("fin de download 4");
            bitmap = BitmapFactory.decodeStream(inputStream);
            System.out.println("fin de download 5");
            layoutActivite.addView(imageActivite);
            System.out.println("fin de download 6");
            RelativeLayout.LayoutParams p = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
            p.addRule(RelativeLayout.BELOW, R.id.image);
            p.addRule(RelativeLayout.CENTER_HORIZONTAL);
            p.setMargins(5, 20, 5, 20);
            titre.setLayoutParams(p);
            titre.setTextSize(25);
            scaleImage();
            System.out.println("fin de download");
        } catch (MalformedURLException e) {
            imageTrouvee = false;
            e.printStackTrace();
        } catch (IOException e) {
            imageTrouvee = false;
            e.printStackTrace();
        }
    }

    private void scaleImage() {
        // Get current dimensions AND the desired bounding box
        int width = bitmap.getWidth();
        int height = bitmap.getHeight();
        int bounding = dpToPx(200);

        // Determine how much to scale: the dimension requiring less scaling is
        // closer to the its side. This way the image always stays inside your
        // bounding box AND either x/y axis touches it.
        float xScale = ((float) bounding) / width;
        float yScale = ((float) bounding) / height;
        float scale = (xScale <= yScale) ? xScale : yScale;

        // Create a matrix for the scaling and add the scaling data
        Matrix matrix = new Matrix();
        matrix.postScale(scale, scale);

        // Create a new bitmap and convert it to a format understood by the ImageView
        Bitmap scaledBitmap = Bitmap.createBitmap(bitmap, 0, 0, width, height, matrix, true);
        width = scaledBitmap.getWidth(); // re-use
        height = scaledBitmap.getHeight(); // re-use
        BitmapDrawable result = new BitmapDrawable(scaledBitmap);

        // Apply the scaled bitmap
        imageActivite.setImageDrawable(result);

        // Now change ImageView's dimensions to match the scaled image
        RelativeLayout.LayoutParams params = (RelativeLayout.LayoutParams) imageActivite.getLayoutParams();
        params.width = width;
        params.height = height;
        imageActivite.setLayoutParams(params);
    }

    private int dpToPx(int dp) {
        float density = getApplicationContext().getResources().getDisplayMetrics().density;
        return Math.round((float)dp * density);
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
        session.setLastIdea(null);
        session.setInscription(null);
        session.setDroit(null);
        session.setLastConnect(null);
        session.setTel(null);

        // Launching the login activity
        Intent intent = new Intent(NoterActivite.this, Accueil.class);
        startActivity(intent);
        finish();
    }

    //menu
    private void addDrawerItems() {
        String[] osArray;

        osArray = new String[] {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter"};

        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(NoterActivite.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(NoterActivite.this, GroupeAccueil.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(NoterActivite.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(NoterActivite.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
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
        //getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (mDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

}
