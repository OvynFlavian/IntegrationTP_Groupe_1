package com.example.arnaud.integrationprojetv0;



import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.widget.ListView;
import android.widget.TextView;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;

public class AfficheUsers extends Activity {

    String myJSON;

    ArrayList<HashMap<String, String>> userList;

    ListView list;
    TextView textview1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activite_deux);
        list = (ListView) findViewById(R.id.listView);
        textview1 = (TextView) findViewById(R.id.textView);
        userList = new ArrayList<HashMap<String,String>>();
        getData();

    }


    public void getData(){
        class getData extends AsyncTask<String, String, String> {

            HttpURLConnection urlConnection;

            @Override
            protected String doInBackground(String... args) {

                StringBuilder result = new StringBuilder();

                try {
                    //placer l'url du fichier php (connection a la BDD + requete)
                    URL url = new URL("http://192.168.0.7/Json.php");
                    urlConnection = (HttpURLConnection) url.openConnection();
                    //ce buffer va lire la réponse de la demande sql
                    BufferedReader reader = new BufferedReader(new InputStreamReader(urlConnection.getInputStream()));
                    String line;
                    while ((line = reader.readLine()) != null) {
                        result.append(line+"\n");
                    }


                } catch (Exception e) {
                    e.printStackTrace();
                } finally {
                    urlConnection.disconnect();
                }

                Log.w("Résultat", result.toString());
                return result.toString();

            }


            @Override
            protected void onPostExecute(String result) {
                myJSON = result;
                //affiche le résultat sur l'appli
                textview1.setText(result.toString());

            }
        }
        getData g = new getData();
        g.execute();

    }
}