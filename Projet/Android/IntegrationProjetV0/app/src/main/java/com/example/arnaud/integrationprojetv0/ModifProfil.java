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
 * <b>ModifProfil  est une classe qui permet de modifier le profil d'un utilisateur.</b>
 * <p>
 * Une personne peut modifier les informations suivantes :
 * <ul>
 * <li>nom d'utilisateur.</li>
 * <li>email.</li>
 * <li>Mot de passe .</li>
 * </ul>
 * </p>
 * @author Willame Arnaud
 */
public class ModifProfil extends Activity {


    private SessionManager session;
    Button btnAppli;
    ProgressDialog dialog = null;
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    EditText usr,pass,email,confPass;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.modif_layout);

        usr = (EditText)findViewById(R.id.username);
        email = (EditText)findViewById(R.id.email);
        pass= (EditText)findViewById(R.id.password);
        confPass = (EditText)findViewById(R.id.confPass);
        btnAppli = (Button) findViewById(R.id.btnAppli);

        session = new SessionManager(getApplicationContext());

        usr.setText(session.getUsername());
        email.setText((session.getEmail()));

        btnAppli.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog = ProgressDialog.show(ModifProfil.this, "",
                        "Validation de l'inscription...", true);
                new Thread(new Runnable() {
                    public void run() {
                        modifProfil();
                    }
                }).start();
            }
        });

    }

    /**
     * modification du profil d'un utilisateur
     */
    void modifProfil(){
        try{

            session = new SessionManager(getApplicationContext());

            String id = null;
            id = session.getId();


            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://192.168.0.9/my_folder_inside_htdocs/modifProfil.php"); // make sure the url is correct.
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userName", usr.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("email", email.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("mdp", pass.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("mdpConfirm", confPass.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("id", id.toString().trim()));
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
                        Toast.makeText(ModifProfil.this, "Modification Effectuees", Toast.LENGTH_SHORT).show();
                    }
                });
                session.setUsername(usr.getText().toString().trim());
                session.setEmail(email.getText().toString().trim());

                startActivity(new Intent(ModifProfil.this, MainActivity.class));
            }else{
                showAlert(response);
            }

        }catch(Exception e){
            dialog.dismiss();
            System.out.println("Exception : " + e.getMessage());
        }
    }

    /**
     * Affiche les erreurs
     */
    public void showAlert(final String response){
        ModifProfil.this.runOnUiThread(new Runnable() {
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(ModifProfil.this);
                builder.setTitle("erreur modification.");
                builder.setMessage("" + response)
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