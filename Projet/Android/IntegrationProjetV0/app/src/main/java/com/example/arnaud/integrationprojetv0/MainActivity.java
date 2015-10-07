package com.example.arnaud.integrationprojetv0;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {
    private Button bLogin = null;
    private EditText username = null;
    private EditText password = null;
    private TextView titreUsrName = null;
    private TextView titrePwd = null;

    public final static int CHOOSE_BUTTON_REQUEST = 0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        bLogin = (Button) findViewById(R.id.login);
        username =(EditText) findViewById(R.id.username);
        password =(EditText) findViewById(R.id.password);
        titreUsrName = (TextView) findViewById(R.id.titreUsrName);
        titrePwd = (TextView) findViewById(R.id.titrePwd);

        titreUsrName.setText("UserName");
        titrePwd.setText("Password");

        bLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                //ajouter securite sur les infos donnée dans les champs
                Intent secondeActivite = new Intent(MainActivity.this, AfficheUsers.class);
                startActivityForResult(secondeActivite, CHOOSE_BUTTON_REQUEST);
            }
        });


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

        return super.onOptionsItemSelected(item);
    }
}
