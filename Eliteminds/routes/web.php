<?php





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;


// Route::get('vii', function(){
//     $video = \App\Video::first();
    
//     $video->html = (app('App\Http\Controllers\VideoController')->Vimeo_GetVideo($video->vimeo_id))->embed->html;
//     dd($video);
// });

// Route::get('test/fatoorah', 'MyFatoorahController@test');


// Route::get('/rearange', function(){
//     $question_not_to_include = DB::table('question_answers')
//         ->select('question_id')
//         ->groupBy('question_id')
//         ->get()
//         ->pluck(['question_id']);
//     $questions = DB::table('questions')
//         ->where('question_type_id', 1)
//         ->whereNotIn('id', $question_not_to_include)
//         ->limit(100)
//         ->get();
        
//         // ->count();
//         // dd($questions);
    
    
//     foreach($questions as $question){
        
//         $translations = DB::table('transcodes')
//             ->where('table_', 'questions')
//             ->whereIn('column_', ['a', 'b', 'c', 'correct_answer'])
//             ->where('row_', $question->id)
//             ->get();
        
//         $answer_a = DB::table('question_answers')
//             ->insertGetId([
//                 'question_id'   => $question->id,
//                 'answer'        => $question->a,
//                 'is_correct'    => 0,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//                 ]);
//         $answer_b = DB::table('question_answers')
//             ->insertGetId([
//                 'question_id'   => $question->id,
//                 'answer'        => $question->b,
//                 'is_correct'    => 0,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//             ]);
//         $answer_c = DB::table('question_answers')
//             ->insertGetId([
//                 'question_id'   => $question->id,
//                 'answer'        => $question->c,
//                 'is_correct'    => 0,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//             ]);
//         $correct_answer = DB::table('question_answers')
//             ->insertGetId([
//                 'question_id'   => $question->id,
//                 'answer'        => $question->correct_answer,
//                 'is_correct'    => 1,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//             ]);
            
//         $translation_query = [];

//         if($translations->filter(function($row){ return $row->column_ == 'a';})->first()){
//             array_push($translation_query, [
//                 'table_' => 'question_answers',
//                 'column_'=> 'answer',
//                 'row_'   => $answer_a,
//                 'transcode' => $translations->filter(function($row){ return $row->column_ == 'a';})->first()->transcode,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//             ]);    
//         }
        
//         if($translations->filter(function($row){ return $row->column_ == 'b';})->first()){
//             array_push($translation_query, [
//                 'table_' => 'question_answers',
//                 'column_'=> 'answer',
//                 'row_'   => $answer_b,
//                 'transcode' => $translations->filter(function($row){ return $row->column_ == 'b';})->first()->transcode,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//             ]);
//         }
        
//         if($translations->filter(function($row){ return $row->column_ == 'c';})->first()){
//             array_push($translation_query, [
//                 'table_' => 'question_answers',
//                 'column_'=> 'answer',
//                 'row_'   => $answer_c,
//                 'transcode' => $translations->filter(function($row){ return $row->column_ == 'c';})->first()->transcode,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//             ]);
//         }
        
//         if($translations->filter(function($row){ return $row->column_ == 'correct_answer';})->first()){
//             array_push($translation_query, [
//                 'table_' => 'question_answers',
//                 'column_'=> 'answer',
//                 'row_'   => $correct_answer,
//                 'transcode' => $translations->filter(function($row){ return $row->column_ == 'correct_answer';})->first()->transcode,
//                 'created_at'    => \Carbon\Carbon::now(),
//                 'updated_at'    => \Carbon\Carbon::now(),
//             ]);
//         }
        
//         if(count($translation_query)){
//             DB::table('transcodes')->insert($translation_query);    
//         }
        
//     }
    
//     // dd($questions);
    
// });

Route::post('MyFatoorah/charge', 'MyFatoorahController@charge')->name('myfatoorah.charge');
Route::get('MyFatoorah/callback', 'MyFatoorahController@callBack')->name('myfatoorah.callback');
Route::get('MyFatoorah/error/callback', 'MyFatoorahController@errorCallBack')->name('myfatoorah.error.callback');

/**
 * Setup Localization
 */
Route::get('/locale/{lang}', function($lang){
    \Session(['locale'=>$lang]);
    return back();
})->name('set.localization');

Route::post('/ckeditor/images/upload', 'CKEditorController@uploadFile')->name('ckeditor.upload');

Route::view('/calculator', 'user/calculator')->middleware('auth')->name('calculator');

Route::post('dropzone/upload', 'DropzoneController@handler')->name('dropzone.handler');

Route::post('TAP/charge', 'TapController@TAP_Charge')->name('charge');
Route::get('TAP/redirect', 'TapController@TAP_ChargeRedirect')->name('chargeRedirect');


Route::get('/', 'HomeController@index')->name('index');
Route::get('/package/{id}', 'HomeController@package_view')->name('public.package.view');
Route::get('/blog/{post_id}', 'HomeController@showPost')->name('public.post.view');
Route::get('/blogs', 'HomeController@indexBlog')->name('public.blog.index');



Route::get('/confirm/account/i/{id}/code', 'HomeController@activateAccount')->name('activateAccount')->middleware('guest');

Route::get('/about-us', 'HomeController@aboutUs')->name('aboutUs');

Route::view('course-details', 'courseDetails')->name('course.detail');

Route::get('delete/comment/review/{id}', function($id){
    $c = \App\Comment::find($id);
    if($c){
        $c->delete();
    }
    return back()->with('success', 'comment deleted !');
})->middleware('auth:admin')->name('delete.comment.on.review');

Route::get('delete/package/review/{id}', function($id){
    $rate = \App\Rating::find($id);
    $rate->delete();
    return back()->with('success', 'Review has been deleted.');
})->middleware('auth:admin')->name('delete.package.review');


Route::get('sessionDBs', function(illuminate\Http\Request $req) {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return 0;

    //Artisan::call('config:clear');
    //echo "Cache is cleared";

    // dd(\Illuminate\Support\Facades\Auth::user());

    // \Session(['name' => 'mohamed Ahmed']);
    $req->session()->put('name', 'Mohamed');
    $all = [];
    $sessions = \App\Session::where('user_id', '!=', null)->get();
    foreach($sessions as $x){
        $y = (object)[];
        $y->decode = unserialize(base64_decode($x->payload));
        $y->user_id = $x->user_id;
        $y->session_id = $x->id;
        array_push($all, $y);
    }

    return $req->session()->get('name');

    dd($all);




    $x= (object)[];
    $x->session = $req->session()->all();
    $z = \App\Session::where('user_id', Auth::user()->id)->get()->first();

    $x->user_decode = unserialize(base64_decode($z->payload));
    dd($x);
});


/**
 * Social Login
 */
Route::post('login/step/setup', 'Auth\LoginController@setupAccount')->name('socialite.setup.account');
Route::post('login/password/step', 'Auth\LoginController@SocialLogin')->name('socialite.login.account');
Route::get('login/{provider}', 'Auth\SocialController@redirect')->name('social.login');
Route::get('login/{provider}/callback','Auth\SocialController@Callback');




Route::get('user/Inboxv2', 'MessageController@user_inbox_show')->middleware('auth')->name('user.inboxv2');
Route::post('user/Inboxv2', 'MessageController@user_inbox_send')->middleware('auth')->name('user.inboxv2.send');

Route::post('sendEmail/Customer', 'HomeController@sendEmailCustomer')->name('send.mail.customer');
Route::get('contact', 'HomeController@contactPage')->name('contact.page');

Route::get('/load/first/topic/{package_id}', 'Users\PremiumQuizController@attachThePackageContent')->middleware('auth')->name('attach.package');


Route::post('certification/Course/img', 'CertificationController@generate')->middleware('auth')->name('generate.certification');
Route::get('certification/download/{id}', 'CertificationController@sendCertification')->middleware('auth')->name('download.certification');


Route::get('/Video/Secure/{id}/{package_id}', 'VideoStreamController@stream_video')->middleware('auth')->name('tv');


Route::get('QuizHistory/review/{id}', 'Users\PremiumQuizController@QuizHistory_show')->middleware('auth')->name('QuizHistory.show');
Route::post('QuizHistory/review/load', 'Users\PremiumQuizController@QuizHistory_load')->middleware('auth')->name('QuizHistory.load');
Route::post('QuizHistory/review/score-feedback', 'Users\PremiumQuizController@QuizHistory_scoreFeedback')->middleware('auth')->name('QuizHistory.score.feedback');



/**
 * Public Views
 */
Route::get('FreeResource/demo/videos', 'HomeController@freeResourceDemoVideos')->name('FreeVideo');
Route::get('reviews', 'HomeController@reviews')->name('reviews');

Route::get('PublicFAQ', function(){
    return view('faq');
})->name("public.faq");



Route::get('user/dashboard', 'HomeController@user_board')->name('user.dashboard');

Route::get('/PackageByCourse', 'packageController@packageByCourse')->name('package.by.course');







Route::get('/mobileVersion', function(){
    return view('indexNoLogin');
});



Route::post('/package/view/video-html' ,'HomeController@getVimeoVideoHtml')->name('public.package.view.video');

Auth::routes();
Route::post('login/withstateResponse', 'Auth\LoginController@loginWithStateResponse')->name('loginWithStateResponse');

Route::get('/home', function(){
    return \Redirect::to(route('my.package.view'));


})->name('home');

Route::prefix('admin')->group(function(){
    // login interfaces and home pages
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('', 'AdminController@index')->name('admin.dashboard');


    /**
     *  Blog
     */
    Route::prefix('blog')->middleware('auth:admin')->group(function(){
        Route::get('/', 'PostController@index')->name('blog.index');
        Route::post('/show/{id}', 'PostController@show')->name('blog.show');
        Route::get('/create', 'PostController@create')->name('blog.create');
        Route::get('/edit/{id}', 'PostController@edit')->name('blog.edit');
        Route::post('/store', 'PostController@store')->name('blog.store');
        Route::post('/update/{id}', 'PostController@update')->name('blog.update');
        Route::get('/destroy/{id}', 'PostController@destroy')->name('blog.destroy');
    });

    /**
     * Explanation
     */
    Route::prefix('explanation')->middleware('auth:admin')->group(function(){
        Route::get('/', 'ExplanationController@index')->name('explanation.index');
        Route::post('/show/{id}', 'ExplanationController@show')->name('explanation.show');
        Route::get('/create', 'ExplanationController@create')->name('explanation.create');
        Route::get('/edit/{id}', 'ExplanationController@edit')->name('explanation.edit');
        Route::post('/store', 'ExplanationController@store')->name('explanation.store');
        Route::post('/update/{id}', 'ExplanationController@update')->name('explanation.update');
        Route::get('/destroy/{id}', 'ExplanationController@destroy')->name('explanation.destroy');
    });

    /** Library */
    Route::prefix('library')->group(function(){
        Route::get('/index', 'LibraryController@index')->name('library.index');
        Route::get('/create', 'LibraryController@create')->name('library.create');
        Route::post('/store/single/{topic_type}', 'LibraryController@singleStore')->name('library.single.store');
        Route::post('/store', 'LibraryController@store')->name('library.store');
        Route::get('/edit/{id}', 'LibraryController@edit')->name('library.edit');
        Route::post('/loader/{id}', 'LibraryController@loader')->name('library.loader');
        Route::post('/update/single/{topic_type}', 'LibraryController@singleUpdate')->name('library.single.update');
        Route::put('/update/{id}', 'LibraryController@update')->name('library.update');
        Route::post('/show/{id}', 'LibraryController@show')->name('library.show');
        Route::post('/destroy/single/{topic_type}', 'LibraryController@singleDestroy')->name('library.single.destroy');
        Route::get('/destroy/{id}', 'LibraryController@destroy')->name('library.destroy');
        Route::post('/fetch', 'LibraryController@fetchLibrary')->name('library.fetch');
        
        // Section | Blog
        Route::post('/section/store', 'LibraryController@storeSection')->name('library.section.store');
        Route::post('/section/index', 'LibraryController@indexSection')->name('library.section.index');
        Route::get('/section/destroy/{id}', 'LibraryController@destroySection')->name('library.section.destroy');
        Route::POST('/section/update/{id}', 'LibraryController@updateSection')->name('library.section.update');

        // Exams
        Route::post('/exam/store', 'LibraryController@storeExam')->name('library.exam.store');
        Route::post('/exam/index', 'LibraryController@indexExam')->name('library.exam.index');
        Route::get('/exam/destroy/{id}', 'LibraryController@destroyExam')->name('library.exam.destroy');
        Route::POST('/exam/update/{id}', 'LibraryController@updateExam')->name('library.exam.update');
        // Domains
        Route::post('/domain/store', 'LibraryController@storeDomain')->name('library.domain.store');
        Route::post('/domain/index', 'LibraryController@indexDomain')->name('library.domain.index');
        Route::get('/domain/destroy/{id}', 'LibraryController@destroyDomain')->name('library.domain.destroy');
        Route::POST('/domain/update/{id}', 'LibraryController@updateDomain')->name('library.domain.update');

    });

    // question management
    Route::get('/question/create', 'QuestionsController@create')->name('question.create');
    Route::get('/question/show', 'QuestionsController@show')->name('question.show');
    Route::get('/question/index', 'QuestionsController@index')->name('question.index');
    Route::get('/questions', 'QuestionsController@search')->name('question.search');
    Route::post('/question/create', 'QuestionsController@store')->name('question.store');
    Route::put('/question/update/{id}', 'QuestionsController@update')->name('question.update');
    Route::post('/question/edit/loader', 'QuestionsController@editLoader')->name('question.edit.loader');
    Route::get('/question/edit/{id}', 'QuestionsController@edit')->name('question.edit');
    Route::get('/question/editV2/{id}', 'QuestionsController@editV2')->name('question.editV2');

    Route::delete('/question/destroy/{id}', 'QuestionsController@destroy')->name('question.destroy');
    Route::post('/question/batch-destroy', 'QuestionsController@batchDestory')->name('question.batchDestory');
    Route::get('/question/translate/{id}', 'QuestionsController@translate')->name('question.translate');
    Route::post('/library/fetch', 'QuestionsController@fetchLibrary')->name('library.fetch');


    // Route::get('/question/review/{title}/{a}/{b}/{c}/{d}', 'QuestionsController@showReview')->name('question.review');
    // section handle creation of question form ..

    Route::post('/question/searchCourse', 'QuestionsController@searchCourse')->name('question.searchCourse');
    Route::post('/question/searchChapter', 'QuestionsController@searchChapter')->name('question.searchChapter');
    Route::post('/question/searchPMG', 'QuestionsController@searchPMG')->name('question.searchPMG');
    Route::post('/question/showProcess', 'QuestionsController@showProcess')->name('question.showProcess');

    // Route::resource('video', 'VideoController');
    Route::get('/video/create', 'VideoController@create')->name('video.create');
    Route::get('/video/index', 'VideoController@index')->name('video.index');
    Route::post('/video', 'VideoController@store')->name('video.store');
    Route::get('/video/{id}/edit', 'VideoController@edit')->name('video.edit');
    Route::post('/video/{id}', 'VideoController@update')->name('video.update');
    Route::delete('/video/destroy/{id}', 'VideoController@destroy')->name('video.destroy');
    Route::get('/videos','VideoController@search')->name('video.search');
    Route::post('/videos/render/data', 'VideoController@render')->name('render.video.data');

    // admin password reset 
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    
    // Packages Management
    Route::post('/packages', 'packageController@store')->name('packages.store');
    Route::get('/packages/{id}/edit', 'packageController@edit')->name('packages.edit');
    Route::delete('/packages/destroy', 'packageController@destroy')->name('packages.destroy');
    Route::put('/packages/update/{id}', 'packageController@update')->name('packages.update');
    Route::get('/packages/create', 'packageController@create')->name('packages.create');
    Route::get('/packages/index', 'packageController@index')->name('packages.index');
    Route::delete('/packages/destroy/{id}', 'packageController@destroy')->name('packages.destroy');

    Route::get('paypal/config', 'PayPalController@index')->name('paypal.config.index');
    Route::post('paypal/config', 'PayPalController@update')->name('paypal.config.store');

    Route::get('/inbox','MessageController@adminIndex')->middleware('auth:admin')->name('admin.inbox');
    Route::post('/inbox', 'MessageController@adminSend')->middleware('auth:admin')->name('admin.sendMessage');

    Route::get('/AllUsers', 'AdminController@allUsersIndex')->name('showAllUsers');
    Route::get('/AllUsers/search/', 'AdminController@searchByEMail')->name('search.user.by.email');
    Route::get('/AllUsers/search/package', 'AdminController@searchByPackage')->name('search.user.by.package');
    Route::get('/AllUsers/search/event', 'AdminController@searchByEvent')->name('search.user.by.event');
    Route::post('/user/update/email', 'AdminController@updateEmail')->name('update.email');
    Route::get('/user/clear/devices/{user_id}', 'AdminController@clearDevices')->name('clear.devices');
    Route::get('/user/{user_id}/delete/{package_id}/package', 'AdminController@removeUserPackage')->name('remove.user.package');
    Route::get('/user/{user_id}/delete/{package_id}/event', 'AdminController@removeUserEvent')->name('remove.user.event');

    Route::get('/disabled/users','AdminController@disabled_users_view')->name('disabled.user.view');

    Route::get('/payment_approve', 'AdminController@payment_approve_index')->name('payment.approve.index');
    Route::get('/payment_approve/approve/{approve_id}', 'AdminController@payment_approve')->name('payment.approve.approve');
    Route::get('/payment_approve/cancel/{approve_id}', 'AdminController@payment_cancel')->name('payment.approve.cancel');

    Route::get('/extension_payment_approve', 'AdminController@extension_payment_approve_index')->name('extension.payment.approve.index');
    Route::get('/extension_payment_approve/approve/{approve_id}', 'AdminController@extension_payment_approve')->name('extension.payment.approve');
    Route::get('/extension_payment_appprove/cancel/{approve_id}', 'AdminController@extension_payment_cancel')->name('extension.payment.cancel');

    Route::get('/user/disable/{user_id}', 'AdminController@user_disable')->name('admin.user.disable');
    Route::get('/user/enable/{user_id}', 'AdminController@user_enable')->name('admin.user.enable');
    Route::get('/user/add_package/{user_id}', 'AdminController@manual_add_package')->name('admin.user.manual.add.package');
    Route::post('/user/add_package/', 'AdminController@manual_add_package_post')->name('admin.user.manual.add.package.post');
    Route::post('/user/manual/time/extends', 'AdminController@manual_time_extends')->name('admin.user.manual.time.extends');

    /*
        Screen shot 
    */
    Route::get('/ScreenShot', 'AdminController@ScreenShotView')->name('ScreenShotAttempts');


    /*
        Coupons
    */
    Route::get('/coupons/create', 'CouponController@create_coupons')->middleware('auth:admin')->name('coupon.create');
    Route::post('/coupons/generate','CouponController@generate')->middleware('auth:admin')->name('coupon.generate');
    Route::get('/coupons', 'CouponController@show')->middleware('auth:admin')->name('coupon.show');
    Route::get('/coupons/delete/{id}', 'CouponController@destroy')->middleware('auth:admin')->name('coupon.destroy');
    Route::get('/coupons/promote/{id}', 'CouponController@promote')->middleware('auth:admin')->name('coupon.promote');
    Route::get('/coupons/demote/{id}', 'CouponController@demote')->middleware('auth:admin')->name('coupon.demote');

    /**
     * add material
     */
    Route::get('/material/add', 'AdminController@material_show')->middleware('auth:admin')->name('material.show.admin');
    Route::post('/material/add', 'AdminController@material_add')->middleware('auth:admin')->name('material.add');
    Route::post('/material/update', 'AdminController@material_update')->middleware('auth:admin')->name('material.update');
    Route::get('/material/delete/{id}', 'AdminController@material_delete')->middleware('auth:admin')->name('material.delete');

    /**
     * study plan
     */
    Route::get('/StudyPlan/add', 'AdminController@studyPlan_show')->middleware('auth:admin')->name('studyPlan.show.admin');
    Route::post('/StudyPlan/store', 'AdminController@studyPlan_add')->middleware('auth:admin')->name('studyPlan.add');
    Route::get('/StudyPlan/delete/{id}', 'AdminController@studyPlan_delete')->middleware('auth:admin')->name('studyPlan.delete');
    /**
     * Flash Card
     */
    Route::get('/FlashCard/add', 'AdminController@flashCard_show')->middleware('auth:admin')->name('flashCard.show.admin');
    Route::post('/FlashCard/store', 'AdminController@flashCard_add')->middleware('auth:admin')->name('flashCard.add');
    Route::get('/FlashCard/delete/{id}', 'AdminController@FlashCard_delete')->middleware('auth:admin')->name('flashCard.delete');
    Route::get('/FlashCard/edit/{id}', 'AdminController@FlashCard_edit')->middleware('auth:admin')->name('flashCard.edit');
    Route::post('/FlashCard/edit/{id}', 'AdminController@FlashCard_update')->middleware('auth:admin')->name('flashCard.update');

    /**
     * FAQs
     */
    Route::get('/FAQ/add','AdminController@faq_show')->middleware('auth:admin')->name('faq.show.admin');
    Route::post('/FAQ/store','AdminController@faq_add')->middleware('auth:admin')->name('faq.add');
    Route::get('/FAQ/delete/{id}', 'AdminController@faq_delete')->middleware('auth:admin')->name('faq.delete');
    Route::get('/FAQ/edit/{id}', 'AdminController@faq_edit')->middleware('auth:admin')->name('faq.edit');
    Route::post('/FAQ/edit/{id}', 'AdminController@faq_update')->middleware('auth:admin')->name('faq.update');

    Route::get('/users/FeedBack', 'AdminController@FeedbackView')->name('users.feedback.view');
    Route::get('/users/feedback/disable/{id}', 'AdminController@toggle_feedback')->name('users.feedback.disable.toggle');

    /**
     * Promotion Email
     */
    Route::get('/promotion/email', 'AdminController@promotion_view')->middleware('auth:admin')->name('promotion.index');
    Route::post('/promotion/email/send', 'AdminController@promotion_send')->middleware('auth:admin')->name('promotion.send');

    /**
     * Statistics
     */
    Route::get('/statics/course/{id}', 'AdminController@statics_index')->middleware('auth:admin')->name('statics.index');
    Route::post('/statics/query', 'AdminController@statics_query')->middleware('auth:admin')->name('statics.query');

    /**
     * Rearrange
     */
    Route::get('/videos/rearrange/index/{course_id}', 'AdminController@rearrange_index')->middleware('auth:admin')->name('rearrange.index');
    Route::post('/videos/getChapterVideos', 'AdminController@getChapterVideos')->middleware('auth:admin')->name('getChapterVideos');
    Route::post('/videos/videoReplace', 'AdminController@videoReplace')->middleware('auth:admin')->name('videoReplace');

    /**
     * admin manage comments replies
     */
    Route::get('/comments/{page}', 'AdminController@comments_show')->middleware('auth:admin')->name('admin.comments.show');
    Route::get('/RatingComments/{page}', 'AdminController@RatingComments_show')->middleware('auth:admin')->name('admin.Rating.comment.show');

    /**
     * admin inbox
     */
    Route::get('/inboxV2', 'MessageController@inbox_show')->middleware('auth:admin')->name('admin.inboxv2');
    Route::post('/inboxV2', 'MessageController@inbox_send')->middleware('auth:admin')->name('admin.inboxv2.send');

    /**
     * Terms Of Service
     */
    Route::get('/termsOfService', 'HomeController@index_termsOfSevice')->middleware('auth:admin')->name('admin.terms.index');
    Route::post('/termsOfService', 'HomeController@store_termsOfSevice')->middleware('auth:admin')->name('admin.terms.store');

    /**
     * Events
     */
    Route::get('event/create', 'EventController@create')->name('event.create')->middleware('auth:admin');
    Route::post('event/store', 'EventController@store')->name('event.store')->middleware('auth:admin');
    Route::get('event/store', 'EventController@index')->name('event.index')->middleware('auth:admin');
    Route::get('event/edit/{id}', 'EventController@edit')->name('event.edit')->middleware('auth:admin');
    Route::post('event/update', 'EventController@update')->name('event.update')->middleware('auth:admin');
    Route::post('event/add/to/user', 'EventController@add_manual')->name('event.add.manual')->middleware('auth:admin');
    Route::get('event/delete/{id}', 'EventController@delete')->name('event.delete')->middleware('auth:admin');

    /**
     * Zones
     */
    Route::get('zone/create', 'ZoneController@create')->name('zone.create');
    Route::post('zone/store', 'ZoneController@store')->name('zone.store');
    Route::get('zone/edit/{id}', 'ZoneController@edit')->name('zone.edit');
    Route::put('zone/update/{id}', 'ZoneController@update')->name('zone.update');
    Route::get('zone/', 'ZoneController@index')->name('zone.index');
    Route::delete('zone/destroy/{id}', 'ZoneController@destroy')->name('zone.destroy');

    Route::get('activation-group/create', 'ActivationGroupController@create')->middleware('auth:admin')->name('activation.group.create');
    Route::post('activation-group/store', 'ActivationGroupController@store')->middleware('auth:admin')->name('activation.group.store');
});

Route::post('/makeallasreadnotifications', function(){
    $all= \App\Notification::where('sight','=','0')->get();
    foreach($all as $i){
        $i->sight = 1;
        $i->save();
    }
})->name('MakeRead');

Route::post('/makeallasreadmessages', function(){
    $all= \App\Message::where('sight','=','0')->where('to_user_id','=',Auth::user()->id)->get();
    foreach($all as $i){
        $i->sight = 1;
        $i->save();
    }
})->name('MakeReadMsg');
Route::post('/admin/makeallasreadmessages', function(){
    $all= \App\Message::where('sight','=','0')->where('to_user_type','=','admin')->get();
    foreach($all as $i){
        $i->sight = 1;
        $i->save();
    }
})->name('MakeReadMsg.admin');



/**
 * Free Quiz
 */


Route::get('/allPackages/course/{id}','HomeController@showAllPackages')->name('showAllPackages');


Route::get('/quiz', 'Users\QuizController@index')->name('FreeQuiz');
Route::post('/quiz/generate', 'Users\QuizController@generate')->name('quiz.generate');
Route::post('/quiz/reloadQuestionsNumber', 'Users\QuizController@reloadQuestionsNumber')->name('quiz.reloadQuestionsNumber');
Route::get('/quiz/feedback/{id}', 'Users\QuizController@showFeedback')->name('feedback');

Route::get('/Free/Video', 'Users\QuizController@videoIndex')->name('video.index.free');
Route::get('/Free/Video/{video_id}', 'Users\QuizController@videoShow')->name('video.show.free');

Route::get('/contactAdmin', 'MessageController@userIndex')->name('user.index')->middleware('auth');
Route::post('/contactAdmin/post', 'MessageController@userSend')->name('user.send')->middleware('auth');

/**
 * Premium Quiz
 */
Route::get('/PremiumQuiz/exams', 'Users\PremiumQuizController@indexSt1')->name('PremiumQuiz-st1');
Route::get('/PremiumQuiz/videos', 'Users\PremiumQuizController@indexSt1Video')->name('PremiumQuiz-st1-videos');

Route::get('/my-packages', 'Users\PremiumQuizController@myPackages_view')->middleware('auth')->name('my.package.view');
Route::get('/packageDetails/{package_id}', 'Users\PremiumQuizController@packageDetails')->middleware('auth')->name('package.details');

Route::get('/rest-videos-progress/{package_id}', 'Users\PremiumQuizController@restVideosProgress')->middleware('auth')->name('restVideosProgress');
Route::get('/complete-videos-progress/{package_id}', 'Users\PremiumQuizController@completeVideosProgress')->middleware('auth')->name('completeVideosProgress');

Route::post('/PremiumQuiz/generate', 'Users\PremiumQuizController@generate')->name('PremiumQuiz.generate');
Route::post('/PremiumQuiz/generateCX', 'Users\PremiumQuizController@generateCX')->name('PremiumQuiz.generateCX');
Route::get('/PremiumQuiz/{package_id}/{topic}/{topic_id}/preview/{quiz_id}', 'Users\PremiumQuizController@reloadQuestionsNumber')->name('PremiumQuiz-st3');
Route::post('PremiumQuiz/init/topic', 'Users\PremiumQuizController@initTopic')->name('init.topic');
Route::post('PremiumQuiz/load/topic', 'Users\PremiumQuizController@generatePackageContent')->name('load.topic');
Route::post('/PremiumQuiz/score/store', 'Users\PremiumQuizController@scoreStore')->name('PremiumQuiz.scoreStore');
Route::get('/PremiumQuiz/score/history', 'Users\PremiumQuizController@scoreHistory')->name('scoreHistory');
Route::get('/PremiumQuiz/feedback/{id}', 'Users\PremiumQuizController@showFeedback')->name('feedback')->middleware('auth');
Route::post('/PremiumQuiz/store/answers','Users\PremiumQuizController@SaveAnswersForLaterOn')->name('saveForLaterOn');
Route::get('/PremiumQuiz/reset_package/{package_id}', 'Users\PremiumQuizController@reset_package')->middleware('auth')->name('reset.package');
Route::get('/Quiz_hisory', 'Users\PremiumQuizController@QuizHistoryShow')->middleware('auth')->name('QuizHistoryShow');
Route::get('/material/show/{course_id}', 'Users\PremiumQuizController@material_show')->middleware('auth')->name('material.show');
Route::get('/material/download/{id}', 'Users\PremiumQuizController@download_material')->middleware('auth')->name('download.material');
Route::get('/studyPlan/show/{course_id}', 'Users\PremiumQuizController@studyPlan_show')->middleware('auth')->name('studyPlan.show');

Route::get('/flashCard', 'Users\PremiumQuizController@flashCard_index')->middleware('auth')->name('flashCard.index');
Route::get('/flashCard/{id}', 'Users\PremiumQuizController@flashCard_show')->middleware('auth')->name('flashCard.show');
Route::get('/FAQ', 'Users\PremiumQuizController@faq_index')->middleware('auth')->name('faq.index');
Route::get('/user/feedback', 'Users\PremiumQuizController@feedback_index')->middleware('auth')->name('user.feedback.index');
Route::post('/user/store', 'Users\PremiumQuizController@feedback_store')->middleware('auth')->name('user.feedback.store');
Route::get('/user/delete/{id}', 'Users\PremiumQuizController@feedback_delete')->middleware('auth')->name('user.feedback.delete');
Route::post('/PremiumQuiz/VideoComplete', 'Users\PremiumQuizController@VideoComplete')->middleware('auth')->name('PremiumQuiz.VideoComplete');
Route::post('/PremiumQuiz/Event/VideoComplete', 'Users\PremiumQuizController@EventVideoComplete')->middleware('auth')->name('Event.PremiumQuiz.VideoComplete');

/** Rating System */
Route::post('/user/rate', 'Users\PremiumQuizController@rate')->name('user.rate');
Route::post('/user/review', 'Users\PremiumQuizController@storeReview')->middleware('auth')->name('user.review');


/**
 * Event Page
 */
Route::get('/event/view/{event_id}', 'HomeController@eventPage')->name('public.event.view');


Route::get('/PremiumQuiz/vid/{package_id}/{topic}/{topic_id}', 'Users\PremiumQuizController@st3_vid')->name('st3_vid');
Route::get('/PremiumQuiz/vid/{package_id}/{topic}/{topic_id}/{video_id}', 'Users\PremiumQuizController@st4_vid')->name('st4_vid');
Route::get('/Event/vid/{event_id}/{topic}/{topic_id}/{video_id}', 'Users\PremiumQuizController@event_vid')->name('event_vid');
Route::get('/Event/{event_id}/whatsapp/join', function($event_id){
    $event = DB::table('event_user')
        ->where([
            'event_id'  => $event_id,
            'user_id'   => Auth::user()->id,
            'show_whatsapp_link'    => 1,
        ])
        ->join('events', 'event_user.event_id', '=', 'events.id')
        ->select('show_whatsapp_link', 'whatsapp')
        ->first();
    if($event){
        DB::table('event_user')
            ->where([
                'event_id'  => $event_id,
                'user_id'   => Auth::user()->id,
            ])->update(['show_whatsapp_link' => 0]);

        return \Redirect::to($event->whatsapp);
    }
    return back()->with('error', 'WhatsApp Link is only available One Time');
})->middleware('auth')->name('open.whatsapp');
/* 
    Payment Routes
*/

Route::post('generate/payment/link', function(\Illuminate\Http\Request $req){
    if($req->input('coupon_code') != ''){
        return route('pay', [$req->input('package_id'), $req->input('coupon_code')]);

    }else{
        // return \Redirect::to(route('public.package.view', $req->input('package_id')));
        return route('pay', [$req->input('package_id'), 'ignore']);
    }


})->name('generate.payment.link');

Route::get('generate/payment/coupon/{id}', function(\Illuminate\Http\Request $req, $id /** Coupon Code */){

    $coupon = \App\Coupon::where('code', '=', $id)->get()->first();
    if($coupon){
        if($coupon->package_id){
            return \Redirect::to(  route('public.package.view',  $coupon->package_id ).'?coupon='.$id);
        }else if($coupon->event_id){
            //
            return \Redirect::to(  route('public.event.view',  $coupon->event_id ).'?coupon='.$id);
        }
    }
    return back();

    // return \Redirect::to(route('pay', [\App\Coupon::where('code', '=', $id)->get()->first()->package_id , $id]));
})->name('generate.payment.with.coupon');

Route::get('/payment/package/{id}/{coupon}', 'PaymentController@pay')->name('pay');
Route::get('/payment/status/{payment_status}/{package_id}/{coupon_code}', 'PaymentController@paymentStatus')->name('payment.status');

Route::post('/payment/check','PaymentController@check')->name('pay.check');

Route::get('/payment/extend/package/{id}', 'PaymentController@extend')->name('extend');
Route::get('/payment/extend/status/{payment_status}/{package_id}', 'PaymentController@extendStatus')->name('extend.status');
Route::post('/payment/package/price/details', 'PaymentController@price_details')->name('price.details');
Route::post('/payment/event/price/details', 'PaymentController@event_price_details')->name('event.price.details');
Route::post('/payment/pay/method2', 'PaymentController@payV2')->name('confirmPaymentMethod2');
Route::post('/payment/event/pay/method2', 'PaymentController@payV2Event')->name('event.confirmPaymentMethod2');

/**
 * mobile redirect
 */

Route::get('/mobile/redirect/', function(){
    return view('layouts.app-mobile');
})->name('mobile.redirect');

/*
    User Routes
*/
Route::get('profile', 'HomeController@showProfile')->name('show.profile');
Route::post('user/change/password', 'HomeController@UserUpdatePasswordRequest')->name('user.update.password');
Route::post('user/update/profile', 'HomeController@UserUpdateProfileInfo')->name('user.update.profile');
Route::post('user/update/profile/pic','HomeController@UserUpdateProfilePic')->name('user.update.profile.pic');

/*
    Screen shot 
*/
Route::get('user/screenShot', 'Users\PremiumQuizController@ScreenShot')->middleware('auth')->name('ScreenShot');


/**
 * Comments
 */

Route::post('user/comment/store', 'CommentController@store')->name('comment.store')->middleware('auth');
Route::post('user/comment/reply', 'CommentController@reply')->name('comment.reply')->middleware('auth');
Route::post('user/comment/admin/reply','CommentController@AdminReply')->name('comment.admin.reply')->middleware('auth:admin');

Route::post('nested/rating', 'CommentController@nested_rate')->name('rate.store.nested')->middleware('auth:admin');



Route::get('/Policy', function(){
    return view('policy');
})->name('policy.show.public');
Route::get('/terms', function(){
    return view('terms');
})->name('terms.show.public');
Route::get('/Refund', function(){
    return view('Refund_polices');
})->name('Refund.show.polices');


/**
 * security check AUTH::check()PaytabsController@index
 */
//  Route::post('security/auth/check', 'HomeController@securityCheck')->name('security.check');
// Route::post('/paytabs_payment', 'PaytabsController@index');
Route::post('/paytabs/charge', 'PaytabsController@charge')->name('paytabs.charge');
//Route::get('/paytabs/test', 'PaytabsController@redirect');
Route::post('/paytabs/payment_redirect', 'PaytabsController@redirect')->name('paytabs.redirect');
Route::post('/paytabs/payment_call_back', 'PaytabsController@callback')->name('paytabs.callback');
