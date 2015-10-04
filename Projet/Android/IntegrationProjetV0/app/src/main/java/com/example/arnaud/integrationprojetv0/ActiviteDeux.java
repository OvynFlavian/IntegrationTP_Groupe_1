package com.example.arnaud.integrationprojetv0;


import android.app.Activity;
import android.os.Bundle;
import android.widget.TextView;


/* Created by Arnaud on 30-09-15.
*/

public class ActiviteDeux extends Activity{

    private TextView text = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activite_deux);

       // text = (TextView) findViewById(R.id.textView);
    }
}
