<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\DB;

Route::get('/testme', function(){return 'work';});

/** Packages */
// search package by name
Route::post('/packages/search', 'API\API_PackageController@search');
Route::get('/package/{id}', 'API\API_PackageController@show');
Route::get('/packages', 'API\API_PackageController@index');

Route::group(['middleware' => ['auth:api', 'api.request.log']], function () {

    Route::get('/user', function (Request $request) {
        // return $request->user();
        $profile_pic =asset('assets/layouts/layout/img/avatar3_small.jpg');
        $check = \App\UserDetail::where('user_id', '=', $request->user()->id)->first();
        if($check){
            if($check->profile_pic){
                $profile_pic =url('storage/profile_picture/'.basename($check->profile_pic));
            }
        }
        $user = DB::table('users')->where('id', $request->user()->id)->first();
        return response()->json([
            'id' => $request->user()->id,
            'provider' => $request->user()->provider,
            'provider_id' => $request->user()->provider_id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'city' => $request->user()->city,
            'country' => $request->user()->country,
            'phone' => $request->user()->phone,
            'last_login' => $request->user()->last_login,
            'last_action' => $request->user()->last_action,
            'last_ip' => $request->user()->last_ip,
            'last_server_ip' => $request->user()->last_server_ip,
            'last_session_id' => $request->user()->last_session_id,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'profile_picture' => $profile_pic,


        ], 200);




    });

    /** Auth */
    Route::post('user/logout', 'API\API_UsersController@logout')->name('APIlogout');
    /**
     * Profile
     */
    Route::post('/user/profile/update/password', 'API\API_UsersController@UserUpdatePasswordRequest');
    Route::post('/user/profile/update/info', 'API\API_UsersController@UserUpdateProfileInfo');
    /** Packages */
    Route::get('/packages/own', 'API\API_PackageController@ownPackage')->name('APIownPackage.list');    
    Route::get('/package/belongs/{package_id}', 'API\API_PackageController@belongsToMe')->name('package.belongs');
    /** Events */
    Route::get('/events', 'API\API_EventController@allEvents');
    Route::get('/event/{id}', 'API\API_EventController@show');
    Route::post('/event/search', 'API\API_EventController@search');
    Route::get('/events/own', 'API\API_EventController@own');
    /**
     * Generate Question for Preim-Quiz
     */
    Route::get('/generate/bychapter/{package_id}/{topic_id}', 'API\API_PremiumQuizController@generate_bychapter')->name('APIpremiumQuizByChapter.generate');
    Route::get('/generate/bydomain/{package_id}/{topic_id}', 'API\API_PremiumQuizController@generate_byprocess')->name('APIpremiumQuizByProcess.generate');
    Route::get('/generate/exam/{package_id}/{topic_id}/', 'API\API_PremiumQuizController@generate_exam')->name('APIpremiumQuizExam.generate');
    // store user answers
    Route::post('/store/userAnswer', 'API\API_PremiumQuizController@storeAnswer');
    Route::post('/store/userScore/', 'API\API_PremiumQuizController@storeScore');
    // quiz list
    Route::post('/myQuiz/list', 'API\API_PremiumQuizController@showQuiz');
    Route::post('/myQuiz/reviews', 'API\API_PremiumQuizController@reviewQuiz');
    // score history
    Route::get('/scoreHistory', 'API\API_ScoreHistoryController@show')->name('APIscoreHistory.show');
    Route::post('/scoreHistory/store', 'API\API_ScoreHistoryController@store')->name('APIscoreHistory.store');
    Route::post('/payment/response', 'API\API_AdminController@paymentStatus')->name('APIpaymentStatus');
    Route::get('/study/material', 'API\API_PremiumQuizController@studyMaterial');
    // Mark Video as watched
    Route::post('/video/mark/watched', 'API\API_PackageController@VideoComplete');
    // return reviews
    Route::post('/package/reviews/get', 'API\API_ReviewController@reviewByPackage');
    Route::post('/package/reviews/push', 'API\API_ReviewController@push_review');
    Route::post('/package/reviews/overall', 'API\API_ReviewController@overallPackageReview');
    // return feedback
    Route::post('/feedback/get', 'API\API_FeedbackController@index');
    Route::post('/feedback/send', 'API\API_FeedbackController@send_feedback');
    // top search
    Route::get('/packages/top/search', 'API\API_PackageController@get_top_search');
    // send vidoe page
    Route::get('/vimeo/video/{vimeo_id}', function($id){
        return view('androidView.video')->with('vimeo_id', $id);
    });
    Route::get('/courses/get', 'API\API_PackageController@getAllCourses');
    Route::get('/get/package/byCourse', 'API\API_PackageController@packageByCourse');
    Route::get('/free/videos', 'API\API_PackageController@free_videos');
    Route::get('/vimeo/get/specific/video', 'API\API_PackageController@getSpecificVideo');

    // Notification
    Route::get('/notifications', 'API\API_NotificationController@index');

    // Messages
    Route::get('/messages/', 'API\API_MessageController@index');
    Route::post('/messages/send', 'API\API_MessageController@store');

    // Library
    Route::get('domains', 'API\API_GeneralController@domains');
    Route::get('courses', 'API\API_GeneralController@courses');
    Route::get('chapters/{course_id}', 'API\API_GeneralController@chapters');

    // Certifications
    Route::post('/certification/create', 'API\API_CertificationController@create');
    Route::get('/certification/user', 'API\API_CertificationController@index');
});

/**
 * Auth
 */
Route::post('/registration', 'API\API_UsersController@new_user')->name('APInewUser');
Route::post('/sendResetLink', 'API\API_UsersController@sendResetLinkEmail');


// generate Question for free quiz
Route::get('/freequiz/info', 'API\API_FreeQuizController@generate_info')->name('APIfreeQuizInfo.generate');
Route::get('/freequiz/{process_id}', 'API\API_FreeQuizController@generate')->name('APIfreeQuiz.generate');
Route::get('/paypal/config', 'API\API_AdminController@PaypalConfig')->name('APIConfig');

Route::get('get/faq', 'API\API_PremiumQuizController@faq');
Route::get('get/flashcard', 'API\API_PremiumQuizController@flashcard');
Route::get('about', 'API\API_GeneralController@about');
Route::post('contact-us', 'API\API_GeneralController@contactUs');





