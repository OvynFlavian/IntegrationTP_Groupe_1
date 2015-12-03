package com.example.arnaud.integrationprojetv0;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.StrictMode;
import android.provider.MediaStore;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.util.Base64;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.Toast;

import com.android.internal.http.multipart.MultipartEntity;

import org.apache.http.Header;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.InputStreamEntity;
import org.apache.http.entity.mime.HttpMultipartMode;
import org.apache.http.entity.mime.MultipartEntityBuilder;
import org.apache.http.entity.mime.content.ByteArrayBody;
import org.apache.http.entity.mime.content.ContentBody;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.BasicHttpContext;
import org.apache.http.protocol.HttpContext;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.Map;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

//import org.apache.http.HttpResponse;


/**
 * Created by Thomas on 3/11/2015.
 */
public class AjouterActivite extends AppCompatActivity {

    private final String intentCat = "categorie";
    Spinner spinner = null;
    String categorie = null;
    EditText titreView = null;
    EditText descriptionView = null;
    private String titre = null;
    private String description = null;
    RelativeLayout layoutPincipal = null;
    private int idActivite;

    //menu
    private ListView mDrawerList;
    private DrawerLayout mDrawerLayout;
    private ArrayAdapter<String> mAdapter;
    private ActionBarDrawerToggle mDrawerToggle;
    private String mActivityTitle;
    private SessionManager session;

    //image
    private Button uploadImage = null;
    private Uri image = null;
    private File fichier;
    private int SELECT_FILE1 = 2;
    private String selectedPath1;
    private String nomFichier = null;
    MultipartEntityBuilder entity = MultipartEntityBuilder.create();
    private Boolean imagePresente = false;

    private View.OnClickListener listener = new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            InputMethodManager imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(titreView.getWindowToken(), 0);
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);
        super.onCreate(savedInstanceState);
        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                        .setDefaultFontPath("fonts/mapolice.otf")
                        .setFontAttrId(R.attr.fontPath)
                        .build()
        );
        session = new SessionManager(getApplicationContext());
        setContentView(R.layout.ajoutactivite_layout);
        spinner = (Spinner) findViewById(R.id.listeView);
        titreView = (EditText) findViewById(R.id.titreActivite);
        descriptionView = (EditText) findViewById(R.id.descriptionActivite);
        layoutPincipal = (RelativeLayout) findViewById(R.id.relLayout1);
        uploadImage = (Button) findViewById(R.id.uploadImage);
        Intent intent = getIntent();

        //menu
        mDrawerList = (ListView)findViewById(R.id.amisList);mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
        mActivityTitle = getTitle().toString();

        addDrawerItems();
        setupDrawer();

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        categorie = intent.getStringExtra(intentCat);

        layoutPincipal.setOnClickListener(listener);

        spinner.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                InputMethodManager imm = (InputMethodManager) getApplicationContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                imm.hideSoftInputFromWindow(titreView.getWindowToken(), 0);
                return false;
            }
        }) ;

        String[] data;
        data = getCategorie();

        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getApplicationContext(), R.layout.spinner_theme, data);

        spinner.setAdapter(adapter);

        spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                categorie = parent.getItemAtPosition(position).toString();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        uploadImage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openGallery(SELECT_FILE1);
            }
        });
    }

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    public void openGallery(int req_code){
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);
        startActivityForResult(Intent.createChooser(intent, "Select file to upload "), req_code);
    }

    public void onActivityResult(int requestCode, int resultCode, Intent data) {

        if (resultCode == RESULT_OK) {
            Uri selectedImageUri = data.getData();

            if (requestCode == SELECT_FILE1) {
                selectedPath1 = getPath(selectedImageUri);
                System.out.println("selectedPath1 : " + selectedPath1);
                fichier = new File(selectedPath1);
                imagePresente = true;
                String[] parts = selectedPath1.split("/");
                nomFichier = parts[parts.length-1];
                uploadImage.setText(nomFichier);

            }

        }

    }

    public String getPath(Uri uri) {
        String[] projection = { MediaStore.Images.Media.DATA };
        Cursor cursor = managedQuery(uri, projection, null, null, null);
        int column_index = cursor.getColumnIndexOrThrow(MediaStore.Images.Media.DATA);
        cursor.moveToFirst();
        return cursor.getString(column_index);

    }

    public void sendImage() {

        String ba1;
        Bitmap bm = BitmapFactory.decodeFile(selectedPath1);
        ByteArrayOutputStream bao = new ByteArrayOutputStream();
        bm.compress(Bitmap.CompressFormat.JPEG, 50, bao);
        byte[] ba = bao.toByteArray();
        ba1 = Base64.encodeToString(ba, Base64.DEFAULT);

        ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
        nameValuePairs.add(new BasicNameValuePair("base64", ba1));
        nameValuePairs.add(new BasicNameValuePair("imageName", idActivite + ".jpg"));

        DefaultHttpClient httpClient = new DefaultHttpClient();
        HttpPost httpPost = new HttpPost("http://www.everydayidea.be/scripts_android/fileUpload.php");
        try {
            httpPost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }

        System.out.println("path de l'image : " + selectedPath1);

        ResponseHandler<String> responseHandler = new BasicResponseHandler();
        String response = "";
        try {
            response = httpClient.execute(httpPost, responseHandler);
        } catch (IOException e) {
            e.printStackTrace();
        }

        System.out.println("réponse du serveur y : " + response);

    }

    public String[] getCategorie() {
        try {

            DefaultHttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost= new HttpPost("http://www.everydayidea.be/scripts_android/getCategorie.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(1);
            nameValuePairs.add(new BasicNameValuePair("categorie", categorie.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("response après execute : " + response);
            JSONObject jsonObject = new JSONObject(response);

            final int nbCategorie = jsonObject.getInt("0");
            String[] liste = new String[nbCategorie];

            for (int i = 0; i < nbCategorie; i++) {
                String j = String.valueOf(i+1);
                liste[i] = jsonObject.getString(j);
            }
            return liste;

        } catch (Exception e) {
            System.out.println("Exception : " + e.getMessage());
            return null;
        }
    }

    public void envoyerActivite(View view) {
        try{

            DefaultHttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost= new HttpPost("http://www.everydayidea.be/scripts_android/ajouterActivite.php");
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(4);
            nameValuePairs.add(new BasicNameValuePair("titre", titreView.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("description", descriptionView.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("categorie", categorie.trim()));
            nameValuePairs.add(new BasicNameValuePair("imagePresente", imagePresente.toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("idUser", session.getId().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONObject jObj = new JSONObject(response);

            final String error = jObj.getString("error");
            final String existe = jObj.getString("existe");
            final String champsVide = jObj.getString("champsVide");


            System.out.println("Response : " + error);

            CharSequence s;
            if (error.equals("FALSE")) {
                DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                Calendar cal = Calendar.getInstance();
                session.setLastIdea(dateFormat.format(cal.getTime()));
                idActivite = jObj.getInt("idActivite");
                s = "Activité enregistrée !";
                sendImage();
            } else if (existe.equals("TRUE")) {
                s = "Cette activité existe déjà";
            } else if (champsVide.equals("TRUE")) {
                s = "Veuillez remplir tous les champs";
            } else {
                s = "Erreur, veuillez ré-essayer";
            }

            if(!imagePresente) {
                s = "Veuillez choisir une image";
            }

            int duration = Toast.LENGTH_SHORT;
            Toast toast = Toast.makeText(getApplicationContext(), s, duration);
            toast.show();

            if (error.equals("FALSE")) {
                startActivity(new Intent(AjouterActivite.this, ChoixCategorie.class));
            }

        } catch(Exception e) {
            System.out.println("Exception : " + e.getMessage());
        }


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
                    Intent intent = new Intent(AjouterActivite.this, AfficherAmis.class);
                    startActivity(intent);
                }
                if (position == 1) {
                    Intent intent = new Intent(AjouterActivite.this, GroupeAccueil.class);
                    startActivity(intent);
                }
                if (position == 2) {
                    Intent intent = new Intent(AjouterActivite.this, Profil.class);
                    startActivity(intent);
                }
                if (position == 3) {
                    Intent intent = new Intent(AjouterActivite.this, ChoixCategorie.class);
                    startActivity(intent);
                }
                if (position == 4) {
                    logoutUser();
                }
            }
        });
    }


    private void AfficherMessage(){
        Intent intent = new Intent(AjouterActivite.this, GroupeAccueil.class);
        startActivity(intent);


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
        Intent intent = new Intent(AjouterActivite.this, Accueil.class);
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

}
