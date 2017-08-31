package com.example.karen.tallerguayaquil.activities;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.animation.AnimatorSet;
import android.animation.ObjectAnimator;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Matrix;
import android.graphics.Point;
import android.graphics.Rect;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.animation.DecelerateInterpolator;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.example.karen.tallerguayaquil.R;
import com.example.karen.tallerguayaquil.models.Api;
import com.example.karen.tallerguayaquil.models.Brand;
import com.example.karen.tallerguayaquil.models.Evaluation;
import com.example.karen.tallerguayaquil.models.Person;
import com.example.karen.tallerguayaquil.models.Service;
import com.example.karen.tallerguayaquil.models.WorkShop;
import com.example.karen.tallerguayaquil.utils.ApiService;
import com.example.karen.tallerguayaquil.utils.ServiceGenerator;
import com.example.karen.tallerguayaquil.utils.SessionManager;
import com.example.karen.tallerguayaquil.utils.Util;
import com.github.chrisbanes.photoview.PhotoView;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.MultiFormatWriter;
import com.google.zxing.WriterException;
import com.google.zxing.common.BitMatrix;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import co.lujun.androidtagview.TagContainerLayout;
import retrofit2.Call;
import retrofit2.Callback;


public class WorkShopProfileActivity extends AppCompatActivity
        implements OnMapReadyCallback {

    private LinearLayout mEvaluationView, mLyDescountCodeView, mLyCommentView;
    private RelativeLayout mContainerView;
    private TextView mTitleView, mAddressView, mPhoneView, mNameView, mCodeTextView,
            mTotalHonestyView, mTotalEfficiencyView, mTotalCosteView, mTotalView, mEmptyText;
    private ImageView mCodeView;
    private TagContainerLayout mServicesView, mBrandsView;
    private ProgressBar mHonestyView, mEfficiencyView, mCosteView;
    private Button mRequestView;

    private GoogleMap mMap;
    private Bitmap bitmap;
    private Animator mCurrentAnimator;
    private PhotoView mImageZoomView;
    private int mShortAnimationDuration;

    public final static int WIDTH=500;
    public final static int HEIGHT=500;

    private Rect startBounds;
    private Rect finalBounds;
    private Point globalOffset;
    private float startScaleFinal;

    private WorkShop workShop;
    private String serviceSelected;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_workshop_profile);

        workShop = (WorkShop) getIntent().getExtras().getSerializable("profile");
        serviceSelected = getIntent().getExtras().getString("service");

        mContainerView = (RelativeLayout) findViewById(R.id.rl_container);
        mTitleView = (TextView) findViewById(R.id.txt_title);
        mAddressView = (TextView) findViewById(R.id.txt_address);
        mPhoneView = (TextView) findViewById(R.id.txt_phone);
        mCodeTextView = (TextView) findViewById(R.id.txt_code);
        mCodeView = (ImageView) findViewById(R.id.img_code);
        mImageZoomView = (PhotoView) findViewById(R.id.img_zoom);
        mNameView = (TextView) findViewById(R.id.txt_name);

        mLyDescountCodeView = (LinearLayout) findViewById(R.id.ly_descount_code);
        mLyCommentView = (LinearLayout) findViewById(R.id.ly_comments);

        mServicesView = (TagContainerLayout) findViewById(R.id.tag_services);
        mBrandsView = (TagContainerLayout) findViewById(R.id.tag_brands);


        mTitleView.setText(workShop.getWorkshopName());
        mAddressView.setText(workShop.getAddress());
        mPhoneView.setText(workShop.getPhone());
        mNameView.setText(workShop.getManagerName());

        mHonestyView = (ProgressBar) findViewById(R.id.pb_honesty);
        mEfficiencyView = (ProgressBar) findViewById(R.id.pb_efficiency);
        mCosteView = (ProgressBar) findViewById(R.id.pb_coste);

        mTotalHonestyView = (TextView) findViewById(R.id.txt_honesty);
        mTotalEfficiencyView = (TextView) findViewById(R.id.txt_efficiency);
        mTotalCosteView = (TextView) findViewById(R.id.txt_coste);
        mTotalView = (TextView) findViewById(R.id.txt_total);


        mEvaluationView = (LinearLayout) findViewById(R.id.list);
        mEmptyText = (TextView) findViewById(R.id.empty);

        mRequestView = (Button) findViewById(R.id.btn_request);
        mRequestView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                requestVisit(workShop.getId());
            }
        });

        populateServices();
        populateBrands();

        if (!TextUtils.isEmpty(workShop.getCodeDesc())) {
            populateCode();
            populateComments();
            populateEvaluations();

            showEvaAndCom();
        }

        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map_address);
        mapFragment.getMapAsync(this);
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;

        LatLng position = new LatLng(workShop.getLatitude(), workShop.getLongitude());
        MarkerOptions markerOptions = new MarkerOptions()
                .icon(BitmapDescriptorFactory.fromResource(R.drawable.tallericon))
                .position(position);

        Marker marker = mMap.addMarker(markerOptions);
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(position, 16));
    }

    @Override
    public void onBackPressed() {

        if(mImageZoomView.getVisibility() == View.VISIBLE) {

            if (mCurrentAnimator != null) {
                mCurrentAnimator.cancel();
            }

            // Animate the four positioning/sizing properties in parallel,
            // back to their original values.
            AnimatorSet set = new AnimatorSet();
            set.play(ObjectAnimator
                    .ofFloat(mImageZoomView, View.X, startBounds.left))
                    .with(ObjectAnimator
                            .ofFloat(mImageZoomView,
                                    View.Y, startBounds.top))
                    .with(ObjectAnimator
                            .ofFloat(mImageZoomView,
                                    View.SCALE_X, startScaleFinal))
                    .with(ObjectAnimator
                            .ofFloat(mImageZoomView,
                                    View.SCALE_Y, startScaleFinal));
            set.setDuration(mShortAnimationDuration);
            set.setInterpolator(new DecelerateInterpolator());
            set.addListener(new AnimatorListenerAdapter() {
                @Override
                public void onAnimationEnd(Animator animation) {
                    mCodeView.setAlpha(1f);
                    mImageZoomView.setVisibility(View.GONE);
                    mCurrentAnimator = null;
                }

                @Override
                public void onAnimationCancel(Animator animation) {
                    mCodeView.setAlpha(1f);
                    mImageZoomView.setVisibility(View.GONE);
                    mCurrentAnimator = null;
                }
            });
            set.start();
            mCurrentAnimator = set;
        } else {
            super.onBackPressed();
        }
    }

    private void populateServices() {

        List<Service> servicesList = workShop.getServiceList();
        String services[] = new String[servicesList.size()];
        for (int i=0; i<servicesList.size(); i++) {
            Service service = servicesList.get(i);
            String s = service.getCategory();

            Log.i("", "**************");
            Log.i("serviceSelected", serviceSelected);
            Log.i("service", s.toLowerCase());
            Log.i("", "**************");

            if (s.toLowerCase().equals(serviceSelected.toLowerCase()))
                services[i] = s.toUpperCase();
            else
                services[i] = s;
        }

        mServicesView.setTags(services);
    }

    private void populateBrands() {

        List<Brand> brandList = workShop.getBrandList();
        String brands[] = new String[brandList.size()];
        for (int i=0; i<brandList.size(); i++) {
            Brand brand = brandList.get(i);
            brands[i] = brand.getName();
        }

        mBrandsView.setTags(brands);
    }

    private void populateComments() {

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(WorkShopProfileActivity.this, "Buscando comentarios...");

            SessionManager sessionManager = new SessionManager(getApplicationContext());
            ApiService auth = ServiceGenerator.createApiService();

            Map<String, String> params = new HashMap<>();
            params.put("api_token", sessionManager.getToken());

            String url = String.format("calificaciones/%s", workShop.getId());

            Call<Api<List<Evaluation>>> call = auth.getComments(url, params);
            call.enqueue(new Callback<Api<List<Evaluation>>>() {
                @Override
                public void onResponse(@NonNull Call<Api<List<Evaluation>>> call,
                                       @NonNull retrofit2.Response<Api<List<Evaluation>>> response) {

                    if (response.isSuccessful()) {
                        Api<List<Evaluation>> api = response.body();

                        if (api.isError()) {
                            // Show message error
                            Util.showToast(getApplicationContext(), api.getMsg());
                        } else {
                            List<Evaluation> evaluations = api.getData();

                            if (evaluations != null && evaluations.size() > 0) {
                                for (Evaluation evaluation : evaluations) {
                                    mEvaluationView.addView(getEvaluationView(evaluation));
                                }
                            } else {
                                mEvaluationView.removeAllViews();
                                mEmptyText.setVisibility(View.VISIBLE);
                            }
                        }
                    } else {
                        Util.showToast(getApplicationContext(),
                                getString(R.string.message_service_server_failed));
                    }
                    Util.hideLoading();
                }

                @Override
                public void onFailure(@NonNull Call<Api<List<Evaluation>>> call, @NonNull Throwable t) {

                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_network_local_failed));
                    Util.hideLoading();
                }
            });
        } else {
            Util.showToast(
                    getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }

    }

    private void populateEvaluations() {

        List<Evaluation> evaluations = workShop.getEvaluationList();

        if (evaluations != null) {
            double honestyCount = workShop.getHonesty();
            double efficiencyCount = workShop.getEfficiency();
            double costeCount = workShop.getCoste();
            int total = evaluations.size();

            mTotalView.setText(total + " usuarios han comentado eso");

            mTotalHonestyView.setText(String.valueOf(honestyCount));
            mHonestyView.setProgressDrawable(getResources().getDrawable(getColorRange(honestyCount)));
            mHonestyView.setProgress((int)honestyCount);

            mTotalEfficiencyView.setText(String.valueOf(efficiencyCount));
            mEfficiencyView.setProgressDrawable(getResources().getDrawable(getColorRange(efficiencyCount)));
            mEfficiencyView.setProgress((int)efficiencyCount);

            mTotalCosteView.setText(String.valueOf(costeCount));
            mCosteView.setProgressDrawable(getResources().getDrawable(getColorRange(costeCount)));
            mCosteView.setProgress((int)costeCount);
        }
    }

    private void populateCode() {
        mCodeTextView.setText(workShop.getCodeDesc());
        try {
            bitmap = encodeAsBitmap(workShop.getCodeDesc());
            mCodeView.setImageBitmap(bitmap);

            // QR Code
            mCodeView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    zoomImageFromThumb(view, bitmap);
                }
            });
        } catch (Exception ignore){}
    }

    private void showEvaAndCom() {
        mRequestView.setVisibility(View.GONE);
        mLyDescountCodeView.setVisibility(View.VISIBLE);
        mLyCommentView.setVisibility(View.VISIBLE);
    }

    public View getEvaluationView(Evaluation evaluation) {
        LayoutInflater inflater = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View rowView = inflater.inflate(R.layout.comment_item, null, false);

        TextView mUserView = (TextView) rowView.findViewById(R.id.txt_user);
        mUserView.setText(evaluation.getUser().getUsername());

        TextView mDescriptionView = (TextView) rowView.findViewById(R.id.txt_description);
        mDescriptionView.setText(evaluation.getComentario());

        TextView mDateView = (TextView) rowView.findViewById(R.id.txt_date);
        mDateView.setText(evaluation.getDateCreated());


        double honestyCount = evaluation.getHonesty();
        double efficiencyCount = evaluation.getEfficiency();
        double costeCount = evaluation.getCoste();

        ProgressBar mHonestyView = (ProgressBar) rowView.findViewById(R.id.pb_honesty);
        ProgressBar mEfficiencyView = (ProgressBar) rowView.findViewById(R.id.pb_efficiency);
        ProgressBar mCosteView = (ProgressBar) rowView.findViewById(R.id.pb_coste);

        TextView mTotalHonestyView = (TextView) rowView.findViewById(R.id.txt_honesty);
        TextView mTotalEfficiencyView = (TextView) rowView.findViewById(R.id.txt_efficiency);
        TextView mTotalCosteView = (TextView) rowView.findViewById(R.id.txt_coste);

        mTotalHonestyView.setText(String.valueOf(honestyCount));
        mHonestyView.setProgressDrawable(getDrawable(getColorRange(honestyCount)));
        mHonestyView.setProgress((int)honestyCount);

        mTotalEfficiencyView.setText(String.valueOf(efficiencyCount));
        mEfficiencyView.setProgressDrawable(getDrawable(getColorRange(efficiencyCount)));
        mEfficiencyView.setProgress((int)efficiencyCount);

        mTotalCosteView.setText(String.valueOf(costeCount));
        mCosteView.setProgressDrawable(getDrawable(getColorRange(costeCount)));
        mCosteView.setProgress((int)costeCount);

        return rowView;
    }

    private int getColorRange(double value) {

        /**
            Malo: color rojo para valores entre 0 y valores menores de 5
            Regular: color naranja para valores entre 5 y valores menores a 8
            Bueno: color verde para valores mayores a 8
         **/
        int color;

        if (value >= 0 && value < 5) color = R.drawable.round_progress_red;
        else if (value >= 5 && value < 8) color = R.drawable.round_progress_orange;
        else color = R.drawable.round_progress_green;

        return color;
    }

    private Bitmap encodeAsBitmap(String str) throws WriterException {
        BitMatrix result;
        Bitmap bitmap=null;
        try {
            result = new MultiFormatWriter().encode(str,
                    BarcodeFormat.QR_CODE, WIDTH, HEIGHT, null);

            int w = result.getWidth();
            int h = result.getHeight();
            int[] pixels = new int[w * h];
            for (int y = 0; y < h; y++) {
                int offset = y * w;
                for (int x = 0; x < w; x++) {
                    pixels[offset + x] = result.get(x, y) ? Color.BLACK: Color.WHITE;
                }
            }
            bitmap = Bitmap.createBitmap(w, h, Bitmap.Config.ARGB_8888);
            bitmap.setPixels(pixels, 0, 500, 0, 0, w, h);
        } catch (Exception iae) {
            iae.printStackTrace();
            return null;
        }
        return bitmap;
    }

    private Bitmap mergeBitmaps(Bitmap logo, Bitmap qrcode) {

        Bitmap combined = Bitmap.createBitmap(qrcode.getWidth(), qrcode.getHeight(), qrcode.getConfig());
        Canvas canvas = new Canvas(combined);
        int canvasWidth = canvas.getWidth();
        int canvasHeight = canvas.getHeight();
        canvas.drawBitmap(qrcode, new Matrix(), null);

        Bitmap resizeLogo = Bitmap.createScaledBitmap(logo, canvasWidth / 7, canvasHeight / 7, true);
        int centreX = (canvasWidth - resizeLogo.getWidth()) /2;
        int centreY = (canvasHeight - resizeLogo.getHeight()) / 2;
        canvas.drawBitmap(resizeLogo, centreX, centreY, null);

        return combined;
    }

    /** Image Zoom **/
    private void zoomImageFromThumb(final View thumbView, Bitmap bitmap) {

        if (mCurrentAnimator != null) {
            mCurrentAnimator.cancel();
        }

        // Load the high-resolution "zoomed-in" image.
        mImageZoomView.setImageBitmap(null);
        mImageZoomView.setImageBitmap(bitmap);

        // Calculate the starting and ending bounds for the zoomed-in image.
        // This step involves lots of math. Yay, math.
        startBounds = new Rect();
        finalBounds = new Rect();
        globalOffset = new Point();

        // The start bounds are the global visible rectangle of the thumbnail,
        // and the final bounds are the global visible rectangle of the container
        // view. Also set the container view's offset as the origin for the
        // bounds, since that's the origin for the positioning animation
        // properties (X, Y).
        thumbView.getGlobalVisibleRect(startBounds);
        mContainerView.getGlobalVisibleRect(finalBounds, globalOffset);
        startBounds.offset(-globalOffset.x, -globalOffset.y);
        finalBounds.offset(-globalOffset.x, -globalOffset.y);

        // Adjust the start bounds to be the same aspect ratio as the final
        // bounds using the "center crop" technique. This prevents undesirable
        // stretching during the animation. Also calculate the start scaling
        // factor (the end scaling factor is always 1.0).
        float startScale;
        if ((float) finalBounds.width() / finalBounds.height()
                > (float) startBounds.width() / startBounds.height()) {
            // Extend start bounds horizontally
            startScale = (float) startBounds.height() / finalBounds.height();
            float startWidth = startScale * finalBounds.width();
            float deltaWidth = (startWidth - startBounds.width()) / 2;
            startBounds.left -= deltaWidth;
            startBounds.right += deltaWidth;
        } else {
            // Extend start bounds vertically
            startScale = (float) startBounds.width() / finalBounds.width();
            float startHeight = startScale * finalBounds.height();
            float deltaHeight = (startHeight - startBounds.height()) / 2;
            startBounds.top -= deltaHeight;
            startBounds.bottom += deltaHeight;
        }

        // Hide the thumbnail and show the zoomed-in view. When the animation
        // begins, it will position the zoomed-in view in the place of the
        // thumbnail.
        thumbView.setAlpha(0f);
        mImageZoomView.setVisibility(View.VISIBLE);

        // Set the pivot point for SCALE_X and SCALE_Y transformations
        // to the top-left corner of the zoomed-in view (the default
        // is the center of the view).
        mImageZoomView.setPivotX(0f);
        mImageZoomView.setPivotY(0f);

        // Construct and run the parallel animation of the four translation and
        // scale properties (X, Y, SCALE_X, and SCALE_Y).
        AnimatorSet set = new AnimatorSet();
        set
                .play(ObjectAnimator.ofFloat(mImageZoomView, View.X,
                        startBounds.left, finalBounds.left))
                .with(ObjectAnimator.ofFloat(mImageZoomView, View.Y,
                        startBounds.top, finalBounds.top))
                .with(ObjectAnimator.ofFloat(mImageZoomView, View.SCALE_X,
                        startScale, 1f)).with(ObjectAnimator.ofFloat(mImageZoomView,
                View.SCALE_Y, startScale, 1f));
        set.setDuration(mShortAnimationDuration);
        set.setInterpolator(new DecelerateInterpolator());
        set.addListener(new AnimatorListenerAdapter() {
            @Override
            public void onAnimationEnd(Animator animation) {
                mCurrentAnimator = null;
            }

            @Override
            public void onAnimationCancel(Animator animation) {
                mCurrentAnimator = null;
            }
        });
        set.start();
        mCurrentAnimator = set;

        // Upon clicking the zoomed-in image, it should zoom back down
        // to the original bounds and show the thumbnail instead of
        // the expanded image.
        startScaleFinal = startScale;
    }

    void requestVisit(final int id){

        if (Util.isNetworkAvailable(getApplicationContext())) {
            Util.showLoading(WorkShopProfileActivity.this, "Solicitando visita...");

            SessionManager sessionManager = new SessionManager(getApplicationContext());
            Person person = sessionManager.getPerson();

            Map<String, String> params = new HashMap<>();
            params.put("api_token", person.getToken());

            ApiService auth = ServiceGenerator.createApiService();
            String url = String.format("nuevaevaluacion/%s", id);

            Call<Api<WorkShop>> call = auth.createEvaluation(url, params);
            call.enqueue(new Callback<Api<WorkShop>>() {
                @Override
                public void onResponse(@NonNull Call<Api<WorkShop>> call,
                                       @NonNull retrofit2.Response<Api<WorkShop>> response) {

                    if (response.isSuccessful()) {
                        Api<WorkShop> api = response.body();

                        if (api.isError()) {
                            // Show message error
                            Util.showToast(getApplicationContext(), api.getMsg());
                        } else {
                            Util.showToast(getApplicationContext(), api.getMsg());

                            workShop = api.getData();

                            populateCode();
                            populateComments();
                            populateEvaluations();

                            showEvaAndCom();
                        }
                    } else {
                        Util.showToast(getApplicationContext(),
                                getString(R.string.message_service_server_failed));
                        Util.hideLoading();
                    }
                }

                @Override
                public void onFailure(@NonNull Call<Api<WorkShop>> call, @NonNull Throwable t) {
                    Log.e("workshop-evaluation", t.toString());
                    t.printStackTrace();
                    Util.showToast(getApplicationContext(),
                            getString(R.string.message_network_local_failed));
                    Util.hideLoading();
                }
            });
        } else {
            Util.showToast(
                    getApplicationContext(), getString(R.string.message_network_connectivity_failed));
        }
    }
}
