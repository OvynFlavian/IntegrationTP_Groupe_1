package com.example.arnaud.integrationprojetv0;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.os.StrictMode;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
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
 * Created by nauna on 19-11-15.
 */
public class AccepterAmis extends Activity {

    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;
    private SessionManager session;
    private TextView user;
    private Button btnOui;
    private Button btnNon;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.confirmajout_layout);

        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        user = (TextView) findViewById(R.id.User);
        btnOui = (Button) findViewById(R.id.btnOui);
        btnNon = (Button) findViewById(R.id.btnNon);

        // Session manager
        session = new SessionManager(getApplicationContext());

        Intent intent = getIntent();
// On suppose que tu as mis un String dans l'Intent via le putExtra()

        final String username = intent.getStringExtra("username");

        user.setText("Voulez-vous vraiment accepter cette invitation? \n \n " + username);

        btnOui.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                accepterAmis(username);
                Toast.makeText(AccepterAmis.this, "Amis ajouté !", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(AccepterAmis.this, AfficherAmis.class);
                startActivity(intent);
            }
        });

        btnNon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                supprimerAmis(username);
                Intent intent = new Intent(AccepterAmis.this, AfficherAmis.class);
                startActivity(intent);
                Toast.makeText(AccepterAmis.this, "Demande refusée.", Toast.LENGTH_SHORT).show();

            }
        });



    }

    private void supprimerAmis(String username) {
        try {
            // String [] liste = (String[]) list.toArray();


            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://91.121.151.137/scripts_android/supprimerAmis.php"); // make sure the url is correct.

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", username.trim()));
            System.out.println("Response 22:" + username);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 ");
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request

            System.out.println("Response : 2");
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");


        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());
        }
    }


    public void accepterAmis(String username) {

        try {
            // String [] liste = (String[]) list.toArray();


            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://91.121.151.137/scripts_android/confDemande.php"); // make sure the url is correct.

            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", username.trim()));
            System.out.println("Response 22:" + username);
            nameValuePairs.add(new BasicNameValuePair("id", session.getId().toString().trim()));
            System.out.println("Response :1 ");
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request

            System.out.println("Response : 2");
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            // httpclient.execute(httppost);
            String response2 = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response2);
            // JSONArray JsonArray = new JSONArray(response);

            System.out.println("Response : sisiiii ");


        } catch (Exception e) {

            System.out.println("Exception : " + e.getMessage());
        }
    }

}

