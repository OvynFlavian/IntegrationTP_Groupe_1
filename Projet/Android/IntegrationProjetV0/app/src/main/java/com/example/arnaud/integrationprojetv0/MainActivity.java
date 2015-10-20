package com.example.arnaud.integrationprojetv0;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
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
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;


public class MainActivity extends Activity {
    Button b,b2;
    EditText et,pass;
    TextView tv;
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        b = (Button)findViewById(R.id.Button01);
        b2= (Button)findViewById(R.id.Button02);
        et = (EditText)findViewById(R.id.username);
        pass= (EditText)findViewById(R.id.password);
        tv = (TextView)findViewById(R.id.tv);

        b.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog = ProgressDialog.show(MainActivity.this, "",
                        "Validation de l'utilisateur...", true);
                new Thread(new Runnable() {
                    public void run() {
                        login();
                    }
                }).start();
            }
        });

        b2.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(MainActivity.this, Register.class));
                setContentView(R.layout.register_layout);
            }
        });
    }

    void login(){
        try{

            httpclient=new DefaultHttpClient();
            httppost= new HttpPost("http://192.168.1.15/my_folder_inside_htdocs/login.php"); // make sure the url is correct.
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be similar,
            nameValuePairs.add(new BasicNameValuePair("username", et.getText().toString().trim()));  // $Edittext_value = $_POST['Edittext_value'];
            nameValuePairs.add(new BasicNameValuePair("password", pass.getText().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));


            //Execute HTTP Post Request
            // response=httpclient.execute(httppost);
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            JSONObject jObj = new JSONObject(response);

            final String error = jObj.getString("error");
            final String id = jObj.getString("id");
            final String userName = jObj.getString("userName");
            final String password = jObj.getString("password");
            final String email = jObj.getString("email");

            System.out.println("Response : " + error + id + userName + password + email);

            runOnUiThread(new Runnable() {
                public void run() {
                    // tv.setText("Response from PHP : " + response);
                    dialog.dismiss();
                }
            });

            //if(response.equalsIgnoreCase("User Found")){
            if(error=="FALSE"){
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast.makeText(MainActivity.this,"Connexion réussie", Toast.LENGTH_SHORT).show();
                        //System.out.println("reponse2: "+ id+userName+ password + email);
                    }
                });

                startActivity(new Intent(MainActivity.this, User.class));
            }else{
                System.out.println("reponse2: "+ id+userName+ password + email);
                showAlert();
            }

        }catch(Exception e){
            dialog.dismiss();
            System.out.println("Exception : " + e.getMessage());
        }
    }
    public void showAlert(){
        MainActivity.this.runOnUiThread(new Runnable() {
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
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

}