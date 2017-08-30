package com.example.karen.tallerguayaquil.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Evaluation;

import java.util.List;

public class CommentAdapter extends ArrayAdapter<Evaluation> {
    private final Context context;
    private final List<Evaluation> evaluations;

    public CommentAdapter(Context context, List<Evaluation> evaluations) {
        super(context, -1, evaluations);
        this.context = context;
        this.evaluations = evaluations;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        Evaluation evaluation = evaluations.get(position);
        View rowView = inflater.inflate(R.layout.reservation_item, parent, false);

        TextView mUsernameView = (TextView) rowView.findViewById(R.id.txt_username);
        mUsernameView
                .setText(evaluation.getUser().getUsername());

        TextView mUserView = (TextView) rowView.findViewById(R.id.txt_name);
        mUserView.setText(evaluation.getUser().getFullName());

        TextView mCodeView = (TextView) rowView.findViewById(R.id.txt_code);
        mCodeView.setText(evaluation.getCode());

        TextView mDateView = (TextView) rowView.findViewById(R.id.txt_date);
        mDateView.setText(evaluation.getDateCreated());

        return rowView;
    }
}