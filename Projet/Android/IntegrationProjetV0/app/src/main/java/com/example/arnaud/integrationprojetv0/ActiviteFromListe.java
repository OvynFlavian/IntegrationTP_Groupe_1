package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.graphics.drawable.BitmapDrawable;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
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

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

/**
 * Created by Thomas on 19/10/2015.
 */
public class ActiviteFromListe extends AppCompatActivity {

    private static final String intentCat = "categorie";
    private static String categorie = null;
    private TextView titre = null;
    private TextView description = null;
    private TextView textConfirm = null;
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
    private int id = 0;

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

    //signalement
    private int signalee = 0;

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
        textConfirm = (TextView) findViewById(R.id.textConfirmation);
        textBase = textConfirm.getText().toString();
        layoutActivite = (RelativeLayout) findViewById(R.id.layoutActivite);

        imageActivite = (ImageView) findViewById(R.id.image);

        Intent intent = getIntent();
        final String libelle = intent.getStringExtra("nom");
        final String description1 = intent.getStringExtra("description");
        session = new SessionManager(getApplicationContext());

        titre.setText(libelle);
        description.setText(description1);
        getNote(libelle);
        checkGroupe();

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
            btnOk.setText("Connectez-vous");
            btnOk.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    startActivity(new Intent(ActiviteFromListe.this, MainActivity.class));
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
            categorie = jObj.getString("categorie");
            idActivite = jObj.getString("idActivite");
            description.setText(jObj.getString("description"));
            signalee = jObj.getInt("signalee");

            if (note != 99) {
                this.note.setVisibility(View.VISIBLE);
                this.note2.setVisibility(View.INVISIBLE);
            } else {
                this.note.setVisibility(View.INVISIBLE);
                this.note2.setVisibility(View.VISIBLE);
            }

            System.out.println("note : " + note);
            this.note.setStepSize(0.1f);
            this.note.setRating(note);
            activiteTrouvee = true;
            confirmationActivite.setVisibility(View.INVISIBLE);

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
            HttpURLConnection connection = (HttpURLConnection) urlImage.openConnection();
            InputStream inputStream = connection.getInputStream();
            bitmap = BitmapFactory.decodeStream(inputStream);
            layoutActivite.addView(imageActivite);
            RelativeLayout.LayoutParams p = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
            p.addRule(RelativeLayout.BELOW, R.id.image);
            p.addRule(RelativeLayout.CENTER_HORIZONTAL);
            p.setMargins(5, 20, 5, 20);
            titre.setLayoutParams(p);
            titre.setTextSize(25);
            scaleImage();
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

    public void ajouterActivite(View view) {
        Intent intent = new Intent(ActiviteFromListe.this, AjouterActivite.class);
        intent.putExtra(intentCat, categorie);
        startActivity(intent);
    }

    public void activiteSuivante(View view) {
        Boolean activiteTrouvee = false;
        layoutActivite.removeView(imageActivite);
        RelativeLayout.LayoutParams p = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
        p.addRule(RelativeLayout.BELOW, R.id.proposition);
        p.addRule(RelativeLayout.CENTER_HORIZONTAL);
        p.setMargins(5,200,5,60);
        titre.setLayoutParams(p);
        titre.setTextSize(25);
        try{
            textConfirm.setText(textBase);
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/activite.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("categorie", categorie.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
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

            titre.setText(libelle);
            this.description.setText(description);
            this.note.setStepSize(0.1f);
            this.note.setRating(note);
            activiteTrouvee = true;
            confirmationActivite.setVisibility(View.INVISIBLE);

        } catch(Exception e) {
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



    public void enregistrerActivite() {
        try{
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/enregistrerActivite.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("idUser", idUser.trim()));
            nameValuePairs.add(new BasicNameValuePair("idActivite", idActivite.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("response : " + response);
            JSONObject jObj = new JSONObject(response);

            final String id = jObj.getString("idUser");


            if(id == null) {
                Context context = getApplicationContext();
                CharSequence s = "Activité enregistrée !";
                int duration = Toast.LENGTH_SHORT;
                Toast toast = Toast.makeText(context, s, duration);
                toast.show();
            } else {
                final Boolean dansGroupe = checkGroupe();
                if (dansGroupe) {
                    isLeader = checkLeader();
                    seulDansGroupe = checkSeul();
                }
                Animation animation = AnimationUtils.loadAnimation(getApplicationContext(), R.anim.animactivite);
                confirmationActivite.startAnimation(animation);
                confirmationActivite.setVisibility(View.VISIBLE);

                textBase = textConfirm.getText().toString();

                final String url;

                if (!isLeader && !seulDansGroupe) {
                    url = "http://www.everydayidea.be/scripts_android/deleteFromGroupe.php";
                    textConfirm.setText(textConfirm.getText() + "\nVous quitterez votre groupe.");
                } else if (seulDansGroupe) {
                    url = "http://www.everydayidea.be/scripts_android/deleteGroupe.php";
                    textConfirm.setText(textConfirm.getText() + "\nVous êtes seul dans votre groupe, celui-ci sera supprimé.");
                } else if (!seulDansGroupe && isLeader) {
                    url = "http://www.everydayidea.be/scripts_android/deleteFromGroupeLeader.php";
                    textConfirm.setText(textConfirm.getText() + "\nVous êtes le chef de votre groupe, un autre membre héritera de ce statut et vous quitterez votre groupe.");
                } else {
                    url = "http://www.everydayidea.be/scripts_android/updateUserActivite.php";
                }

                btnOui.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        try {
                            HttpClient httpclient = new DefaultHttpClient();
                            HttpPost httppost = new HttpPost(url);
                            ArrayList<NameValuePair> nameValuePairs;
                            if (dansGroupe) {
                                nameValuePairs = new ArrayList<NameValuePair>(3);
                                nameValuePairs.add(new BasicNameValuePair("idUser", idUser.trim()));
                                nameValuePairs.add(new BasicNameValuePair("userName", session.getUsername().trim()));
                                nameValuePairs.add(new BasicNameValuePair("idGroupe", String.valueOf(idGroupe).trim()));
                                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                                ResponseHandler<String> responseHandler = new BasicResponseHandler();
                                httpclient.execute(httppost, responseHandler);
                            }

                            httppost = new HttpPost("http://www.everydayidea.be/scripts_android/updateUserActivite.php");
                            nameValuePairs = new ArrayList<NameValuePair>(2);
                            nameValuePairs.add(new BasicNameValuePair("idUser", idUser.trim()));
                            nameValuePairs.add(new BasicNameValuePair("idActivite", idActivite.trim()));
                            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

                            ResponseHandler<String> responseHandler = new BasicResponseHandler();
                            httpclient.execute(httppost, responseHandler);

                            Context context = getApplicationContext();
                            CharSequence s = "Activité enregistrée !";
                            int duration = Toast.LENGTH_SHORT;
                            Toast toast = Toast.makeText(context, s, duration);
                            toast.show();

                            textConfirm.setText(textBase);
                            confirmationActivite.setVisibility(View.INVISIBLE);

                        } catch (Exception e) {
                            System.out.println("Exception : " + e.getMessage());
                        }
                    }
                });
            }

        }catch(Exception e){
            System.out.println("Exception : " + e.getMessage());
        }
    }

    public boolean checkGroupe() {
        try {
            Boolean dansGroupe = false;
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

    //menu
    private void addDrawerItems() {
        final String[] osArray = {"Amis", "Groupe", "Profil", "Activités", "Se déconnecter" };
        if (session.getDroit().equals("Normal")) {
            osArray[1] = "Devenir Premium !";
        }
        mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, osArray);
        mDrawerList.setAdapter(mAdapter);

        mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (position == 0) {
                    Intent intent = new Intent(ActiviteFromListe.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    if(osArray[1].equals("Groupe")) {
                        Intent intent = new Intent(ActiviteFromListe.this, GroupeAccueil.class);
                        startActivity(intent);
                    } else {
                        String url = "http://www.everydayidea.be/Page/connexion.page.php";
                        Intent i = new Intent(Intent.ACTION_VIEW);
                        i.setData(Uri.parse(url));
                        startActivity(i);
                    }
                }
                if (position == 2) {
                    Intent intent = new Intent(ActiviteFromListe.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(ActiviteFromListe.this, ChoixCategorie.class);
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
        if (session.isLoggedIn()) {
            if (signalee == 0) {
                getMenuInflater().inflate(R.menu.menu_activitesignaler, menu);
            } else {
                getMenuInflater().inflate(R.menu.menu_activite, menu);
            }
        }
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.listeActivite) {
            Intent intent = new Intent(ActiviteFromListe.this, ListeActivite.class);
            intent.putExtra(intentCat, categorie);
            startActivity(intent);
        }

        if (id == R.id.signalerActivite) {
            signalerActivite();

            Context context = getApplicationContext();
            CharSequence s = "L'activité a été signalée !";
            int duration = Toast.LENGTH_SHORT;
            Toast toast = Toast.makeText(context, s, duration);
            toast.show();

            Intent intent = new Intent(ActiviteFromListe.this, ActiviteFromListe.class);
            intent.putExtra("nom", titre.getText());
            intent.putExtra("description", description.getText());
            startActivity(intent);
        }

        // Activate the navigation drawer toggle
        if (mDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    public void signalerActivite() {
        try {

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://www.everydayidea.be/scripts_android/signalerActivite.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("titre", titre.getText().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            httpclient.execute(httppost, responseHandler);

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }
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
        Intent intent = new Intent(ActiviteFromListe.this, Accueil.class);
        startActivity(intent);
        finish();
    }

}
