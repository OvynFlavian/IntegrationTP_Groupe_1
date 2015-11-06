package com.example.arnaud.integrationprojetv0;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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

public class Register extends Activity {
    Button b,b2;
    EditText usr,pass,email,confPass;
    TextView tv;
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;
    private SessionManager session;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.register_layout);

        b = (Button) findViewById(R.id.btnAppli);
        //b2 = (Button) findViewById(R.id.Button02);
        usr = (EditText) findViewById(R.id.username);
        email = (EditText) findViewById(R.id.email);
        pass = (EditText) findViewById(R.id.password);
        confPass = (EditText) findViewById(R.id.confPass);

        // Session manager
        session = new SessionManager(getApplicationContext());



        tv = (TextView) findViewById(R.id.tv);

        if (session.isLoggedIn()) {
            // User is already logged in. Take him to main activity
            Intent intent = new Intent(Register.this,ChoixCategorie.class);
            startActivity(intent);
            finish();
        }

        b.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog = ProgressDialog.show(Register.this, "",
                        "Validation de l'inscription...", true);
                new Thread(new Runnable() {
                    public void run() {
                        register();
                    }
                }).start();
            }
        });
    }


    void register(){
        try{

            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://192.168.0.9/my_folder_inside_htdocs/inscription.php"); // make sure the url is correct.
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", usr.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("email", email.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("mdp", pass.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("mdpConfirm", confPass.getText().toString().trim()));
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
                        Toast.makeText(Register.this, "Inscription Réussie", Toast.LENGTH_SHORT).show();
                    }
                });

                startActivity(new Intent(Register.this, MainActivity.class));
            }else{
                showAlert(response);
            }

        }catch(Exception e){
            dialog.dismiss();
            System.out.println("Exception : " + e.getMessage());
        }
    }
    public void showAlert(final String response){
        Register.this.runOnUiThread(new Runnable() {
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(Register.this);
                builder.setTitle("erreur inscription.");
                builder.setMessage(""+response)
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