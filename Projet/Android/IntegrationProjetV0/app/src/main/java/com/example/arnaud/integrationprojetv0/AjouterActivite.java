package com.example.arnaud.integrationprojetv0;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;

//import org.apache.http.HttpResponse;


/**
 * Created by Thomas on 3/11/2015.
 */
public class AjouterActivite extends AppCompatActivity {

    private final String intentCat = "categorie";
    Spinner listView = null;
    String categorie = null;
    EditText titreView = null;
    EditText descriptionView = null;
    private String titre = null;
    private String description = null;
    RelativeLayout layoutPincipal = null;

    private View.OnClickListener listener = new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            InputMethodManager imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(titreView.getWindowToken(), 0);
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ajoutactivite_layout);
        listView = (Spinner) findViewById(R.id.listeView);
        titreView = (EditText) findViewById(R.id.titreActivite);
        descriptionView = (EditText) findViewById(R.id.descriptionActivite);
        layoutPincipal = (RelativeLayout) findViewById(R.id.relLayout1);
        Intent intent = getIntent();

        categorie = intent.getStringExtra(intentCat);

        layoutPincipal.setOnClickListener(listener);

        listView.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                InputMethodManager imm = (InputMethodManager) getApplicationContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                imm.hideSoftInputFromWindow(titreView.getWindowToken(), 0);
                return false;
            }
        }) ;

        String[] data = new String[] {"animaux", "enfant", "film", "visite"};
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getApplicationContext(), android.R.layout.simple_spinner_dropdown_item, data);
        listView.setAdapter(adapter);

        listView.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                categorie = parent.getItemAtPosition(position).toString();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

    }

    public void envoyerActivite(View view) {
        try{

            DefaultHttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost= new HttpPost("http://91.121.151.137/scripts_android/ajouterActivite.php"); // make sure the url is correct.
            //add your data
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(3);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be similar,
            nameValuePairs.add(new BasicNameValuePair("titre", titreView.getText().toString().trim()));  // $Edittext_value = $_POST['Edittext_value'];
            nameValuePairs.add(new BasicNameValuePair("description", descriptionView.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("categorie", categorie.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            // Execute HTTP Post Request
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
                s = "Activité enregistrée !";
            } else if (existe.equals("TRUE")) {
                s = "Cette activité existe déjà";
            } else if (champsVide.equals("TRUE")){
                s = "Veuillez remplir tous les champs";
            } else {
                s = "Erreur, veuillez ré-essayer";
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

}
