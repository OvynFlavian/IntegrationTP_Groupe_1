package com.example.thomas.testmenus;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

/**
 * Created by Thomas on 19/10/2015.
 */
public class AfficherActivite extends AppCompatActivity {

    private static final String test = "categorie";
    private TextView textView = null;
    private Button b1 = null;
    private Button b2 = null;
    private String[][] tbActivity = new String[8][2];
    private int i = 0;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activite_layout);
        tbActivity[0][0] = "1";
        tbActivity[0][1] = "promener son chien";
        tbActivity[1][0] = "2";
        tbActivity[1][1] = "Cours de dressage";
        tbActivity[2][0] = "3";
        tbActivity[2][1] = "Promenade en famille";
        tbActivity[3][0] = "4";
        tbActivity[3][1] = "Randonnée à vélo";
        tbActivity[4][0] = "5";
        tbActivity[4][1] = "Seul sur Mars";
        tbActivity[5][0] = "6";
        tbActivity[5][1] = "Mad Max : Fury Road";
        tbActivity[6][0] = "7";
        tbActivity[6][1] = "Museum d'histoire naturelle de Bruxelles";
        tbActivity[7][0] = "8";
        tbActivity[7][1] = "Lion de Waterloo";



        Intent intent = getIntent();
        textView = (TextView) findViewById(R.id.activite);
        b1 = (Button) findViewById(R.id.ok);
        b2 = (Button) findViewById(R.id.suivant);


        if (intent != null) {
            switch (intent.getStringExtra(test)) {
                case "animaux" :
                    i = 0;
                    textView.setText(tbActivity[i][1]);
                    break;
                case "famille" :
                    i = 2;
                    textView.setText(tbActivity[i][1]);
                    break;
                case "film" :
                    i = 4;
                    textView.setText(tbActivity[i][1]);
                    break;
                case "visite" :
                    i = 6;
                    textView.setText(tbActivity[i][1]);
                    break;
            }
        }

        b1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Context context = getApplicationContext();
                CharSequence s = "Activité enregistrée !";
                int duration = Toast.LENGTH_SHORT;
                Toast toast = Toast.makeText(context, s, duration);
                toast.show();
            }
        });

        b2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (i % 2 == 0) {
                    i++;
                } else {
                    i--;
                }
                textView.setText(tbActivity[i][1]);
            }
        });

    }

}
