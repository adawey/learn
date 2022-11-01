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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:api']], function () {
    // Packages routes
    Route::get('/packages', 'API\API_PackageController@index')->name('APIpackage.list');
    Route::get('/package/{id}', 'API\API_PackageController@show')->name('APIpackage.show');
    Route::get('/packages/own', 'API\API_PackageController@ownPackage')->name('APIownPackage.list');    
    Route::get('/package/belongs/{package_id}', 'API\API_PackageController@belongsToMe')->name('package.belongs');
    
    // User routes
    Route::post('user/logout', 'API\API_UsersController@logout')->name('APIlogout');

    // Questions route..
//    Route::get('question/{id}', 'API\API_QuestionController@show')->name('APIquestion.show');
//    Route::get('questions', 'API\API_QuestionController@index')->name('APIquestion.list');

    //generate Question for prim_quiz
    Route::get('/generate/bychapter/{package_id}/{topic_id}', 'API\API_PremiumQuizController@generate_bychapter')->name('APIpremiumQuizByChapter.generate');
    Route::get('/generate/byprocess/{package_id}/{topic_id}', 'API\API_PremiumQuizController@generate_byprocess')->name('APIpremiumQuizByProcess.generate');
    Route::get('/generate/exam/{package_id}/{topic_id}/', 'API\API_PremiumQuizController@generate_exam')->name('APIpremiumQuizExam.generate');

    // store user answers
    Route::post('/store/userAnswer', 'API\API_PremiumQuizController@storeAnswer');

    Route::post('/store/userScore/', 'API\API_PremiumQuizController@storeScore');

    // quiz list
    Route::post('/myQuiz/list', 'API\API_PremiumQuizController@showQuiz');


    // score history 
    Route::get('/scoreHistory', 'API\API_ScoreHistoryController@show')->name('APIscoreHistory.show');
    Route::post('/scoreHistory/store', 'API\API_ScoreHistoryController@store')->name('APIscoreHistory.store');
    Route::post('/payment/response', 'API\API_AdminController@paymentStatus')->name('APIpaymentStatus');
    
    Route::get('/study/material', 'API\API_PremiumQuizController@studyMaterial');
    
});

// generate Question for free quiz
Route::get('/freequiz/info', 'API\API_FreeQuizController@generate_info')->name('APIfreeQuizInfo.generate');
Route::get('/freequiz/{process_id}', 'API\API_FreeQuizController@generate')->name('APIfreeQuiz.generate');
Route::post('/registration', 'API\API_UsersController@new_user')->name('APInewUser');
Route::get('/paypal/config', 'API\API_AdminController@PaypalConfig')->name('APIConfig');

Route::get('get/faq', 'API\API_PremiumQuizController@faq');
