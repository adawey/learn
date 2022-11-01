<?php

namespace App\Http\Controllers;

use App\Localization\Locale;
use App\Transcode\Transcode;
use Illuminate\Http\Request;
use App\Question;
use App\Payments;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Illuminate\Support\Facades\Input;
use App\Mail\PromotionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function clearDevices($user_id)
    {
        $user = DB::table('agents')
            ->where('agents.user_id', $user_id)
            ->delete();
        return back()->with('success', 'User Devices Have Been Deleted.');
    }


    public function manual_time_extends(Request $request){

        if($request->n_days <= 0){
            return response()->json([
                'message'   => 'Number of Days can not be negative !',
            ], 200);
        }

        if(!filter_var($request->n_days, FILTER_VALIDATE_INT)){
            return response()->json([
                'message'   => 'Number of Days must be Integer Value !',
            ], 200);
        }

        if($request->item_type == 'package'){
            $item = \App\Packages::where([
                'id' => $request->item_id
            ])->first();
            $user_item = \App\UserPackages::where([
                'user_id'       => $request->user_id,
                'package_id'    => $request->item_id,
            ])
                ->first();

        }elseif($request->item_type == 'event'){
            $item = \App\Event::where([
                'id' => $request->item_id
            ])->first();
            $user_item = \App\EventUser::where([
                'user_id'       => $request->user_id,
                'event_id'      => $request->item_id,
            ])
                ->first();

        }

        if($user_item){

            if($user_item->created_at){
                $user_item->created_at = \Carbon\Carbon::parse($user_item->created_at)
                    ->addDays($request->n_days);
            }else{
                $user_item->created_at = \Carbon\Carbon::now()
                    ->addDays($request->n_days);
            }
            $user_item->save();

            return response()->json([
                'message'   => 'Item Extended To : '.\Carbon\Carbon::parse($user_item->created_at)
                        ->addDays($item->expire_in_days),
            ], 200);

        }

        return response()->json([
            'message'   => 'Record not found !',
        ], 200);

    }


    public function removeUserPackage($user_id,$package_id){

        $check = \App\UserPackages::where('user_id', $user_id)->where('package_id', $package_id)->get()->first();
        if($check){
            $d1 = DB::table('quizzes')
                ->where('user_id', $user_id)
                ->where('package_id', $package_id)
                ->select('quizzes.id')
                ->get()
                ->pluck(['id'])
                ->toArray();

            if(count($d1)){
                $d21 = DB::table('correct_answers')
                    ->whereIn('quiz_id', $d1)
                    ->delete();
                $d21 = DB::table('wrong_answers')
                    ->whereIn('quiz_id', $d1)
                    ->delete();
                $d22 = DB::table('active_answers')
                    ->whereIn('quiz_id', $d1)
                    ->delete();
            }

            $d3 = DB::table('quizzes')
                ->where('user_id', $user_id)
                ->where('package_id', $package_id)
                ->delete();


            DB::table('video_progresses')
                ->where('user_id', $user_id)
                ->where('package_id', $package_id)
                ->delete();

            $check->delete();
        }


        return back()->with('success', 'Package removed.');
    }

    public function removeUserEvent($user_id,$event_id){

        $check = \App\EventUser::where('user_id', $user_id)->where('event_id', $event_id)->get()->first();
        if($check){

            DB::table('video_progresses')
                ->where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->delete();

            $check->delete();
        }


        return back()->with('success', 'Event removed.');
    }

    public function updateEmail(Request $req){
        $user = \App\User::find($req->userId);

        if(!$user){
            return [(object)[
                'code' => 404,
                'error' => 'User Not Found !',
                'data' => [
                    'email' => $req->newEmailValue
                ]
            ]];
        }

        if($user->email == $req->newEmailValue){
            return [(object)[
                'code' => 200,
                'success' => 'Updated.',
                'data' => [
                    'email' => $req->newEmailValue
                ]
            ]];
        }

        $check = \App\User::where('email', $req->newEmailValue)->get()->first();
        if($check){
            return [(object)[
                'code' => 500,
                'error' => 'Email Already Taken.',
                'data' => [
                    'email' => $user->email
                ]
            ]];
        }

        $user->email = $req->newEmailValue;
        $user->save();

        return [(object)[
            'code' => 200,
            'success' => 'Updated.',
            'data' => [
                'email' => $req->newEmailValue
            ]
        ]];
    }


    public function comments_show($page){
        $comments = \App\PageComment::where('page', $page)->pluck('comment_id')->toArray();
        $comments = \App\Comment::whereIn('id', $comments)->paginate(15);


        return view('admin.comments')
            ->with('page', $page)
            ->with('comments', $comments);

    }

    public function rearrange_index($course_id){

        return view('admin.rearrangeVideo')
            ->with('course_id', $course_id);
    }

    public function getChapterVideos(Request $req){

        $chapter = \App\Chapters::find($req->input('chapter_id'));
        if($chapter){

            $videos = \App\Video::where('chapter', $chapter->id)->orderBy('index_z')->get();
            $item = (object)[];
            $item->chapter_id = $chapter->id;
            $item->chapter_name = $chapter->name;
            $item->videos = $videos;
            return [$item];



        }else{
            return null;
        }
    }

    public function videoReplace(Request $req){
        $video_one = \App\Video::where('index_z', $req->input('video_one_index_z'))->get()->first();
        $video_two = \App\Video::where('index_z', $req->input('video_two_index_z'))->get()->first();
        $switch = 0;

        if($video_one && $video_two){
            $switch = $video_one->index_z;
            $video_one->index_z = $video_two->index_z;
            $video_one->save();
            $video_two->index_z = $switch;
            $video_two->save();


            return 0;
        }

        return 1;


    }

    public function statics_query(Request $req){


        $product_details = explode('_', $req->product);
        $product = $product_details[0];
        $product_id = $product_details[1];
        $product_price = '--';

        if($product == 'p'){ // Package
            $payments = DB::table('packages')
                ->where(function($query)use($product_id){
                    if($product_id != 'all'){
                        return $query->where('packages.id', $product_id);
                    }
                })
                ->where('course_id', $req->course_id)
                ->join('payment_approve_histories', 'packages.id', '=', 'payment_approve_histories.package_id')
                ->join('payments', 'payment_approve_histories.payment_id', '=', 'payments.id')
                ->where('payments.complete', '=', 1)
                ->join('users', 'payments.user_id', '=', 'users.id')
                ->select(
                    'payments.*',
                    DB::raw('(packages.name) AS product_name'),
                    DB::raw('(users.name) AS user_name')
                )
                ->get();


            if($product_id != 'all'){
                $product_price = DB::table('packages')
                    ->where('id', $product_id)
                    ->first()->price;
            }

        }elseif($product == 'e'){ // Event
            $payments = DB::table('events')
                ->where(function($query)use($product_id){
                    if($product_id != 'all'){
                        return $query->where('events.id', $product_id);
                    }
                })
                ->where('course_id', $req->course_id)
                ->join('event_user', 'events.id', '=', 'event_user.event_id')
                ->join('payments', 'event_user.payment_id', '=', 'payments.id')
                ->where('payments.complete', '=', 1)
                ->join('users', 'payments.user_id', '=', 'users.id')
                ->select(
                    'payments.*',
                    DB::raw('(events.name) AS product_name'),
                    DB::raw('(users.name) AS user_name')
                )
                ->get();

            if($product_id != 'all'){
                $product_price = DB::table('events')
                    ->where('id', $product_id)
                    ->first()->price;
            }
        }


        if($req->year != 'all'){
            $payments = $payments->filter(function($payment) use($req){
                return \Carbon\Carbon::parse($payment->created_at)->year == $req->year;
            });
        }

        if($req->month != 'all'){
            $payments = $payments->filter(function($payment) use($req){
                return \Carbon\Carbon::parse($payment->created_at)->month == $req->month;
            });
        }

        /**
         * required data
         */
        $tap_payments = $payments->filter(function($payment){
            return $payment->paymentMethod == 'TAP';
        });


        $paypal_payments = $payments->filter(function($payment){
            return ($payment->paymentMethod == 'paypal') || $payment->paymentMethod == 'Paypal Checkout Express';
        });




        return response()->json([
            'payments'          => $payments,
            'tap_payments'      => $tap_payments,
            'paypal_payments'   => $paypal_payments,
            'product_price'     => $product_price,
            'payments_no'       => count($payments),
        ], 200);

    }


    public function statics_index($course_id){
        return view('admin.statics')
            ->with('course_id', $course_id);
    }

    public function promotion_send(Request $req){

        $failToSendArray = [];

        $this->validate($req, [
            'package_id'    =>  'numeric',
            'msg'           =>  'required',
            'subject'       =>  'required',
        ]);



        $mail_subject = $req->subject;

        
        $package_id = $req->package_id;
        
        if($req->all_users == 'on'){
            $users = DB::table('users')
                ->select(
                    'name',
                    'email'
                )
                ->get();
        }else{
            if($package_id){
                $users = DB::table('user_packages')
                    ->where('package_id', $package_id)
                    ->join('users', 'user_packages.user_id', '=', 'users.id')
                    ->select(
                        'name',
                        'email'
                    )
                    ->get();
            }else{
                return back()->with('error', 'Package is required');
            }

        }

        $users_chunk = ($users->chunk(500));

        // dd($users_chunk);

        foreach($users_chunk as $users){

            $addTos = [];
            foreach($users as $u){
                if (filter_var($u->email, FILTER_VALIDATE_EMAIL)) {
                    $x = new \SendGrid\Mail\To();
                    $x->setEmailAddress($u->email);
                    $x->setName($u->name);
                    $x->setSubject($mail_subject);
                    array_push($addTos, $x);
                }
            }




            $email = new \SendGrid\Mail\Mail();
            $email->setFrom(env('NO_REPLY_EMAIL'), env('APP_NAME'));
            $email->setSubject($mail_subject);
            $email->addTos($addTos);
            $email->addContent(
                "text/html", $req->input('msg')
            );

            $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
            try {
                $response = $sendgrid->send($email);
                //            print $response->statusCode() . "\n";

            } catch (Exception $e) {
                dd('Caught exception: '. $e->getMessage() ."\n");
            }
        }


        return back()->with('success', 'Promotion Sent to total '.count($users).' User');


    }

    public function promotion_view(){
        return view('admin.promotion');
    }


    public function FeedbackView(){
        return view('admin.feedbackView');
    }

    public function toggle_feedback($id){
        $feed = \App\Feedback::find($id);

        if($feed){
            if($feed->disable == 1){
                $feed->disable = 0;
                $feed->save();

                return back()->with('success', 'Feedback Enabled.');
            }else{
                $feed->disable = 1;
                $feed->save();

                return back()->with('error', 'Feedback Disabled');
            }
        }else{
            return back()->with('error');
        }
    }

    public function FlashCard_update(Request $req, $id){
        $this->validate($req, [
            'title'=>'required',
            'contant'=>'required'
        ]);

        $f = \App\FlashCard::find($id);
        $f->title = $req->input('title');
        if($req->hasFile('img')){
            if(Storage::exists($f->img)){
                Storage::delete($f->img);
            }
            $f->img = $req->file('img')->store('public/flashcard');
        }
        $f->contant = $req->input('contant');
        $f->save();

        return back()->with('success','Item updated successfully.');

    }

    public function FlashCard_edit($id){
        return view('admin.FlashCard_edit')->with('f',\App\FlashCard::find($id));
    }

    public function faq_update(Request $req, $id){

        $this->validate($req, [
            'title'     =>'required',
            'content'   =>'required',
            // 'title_ar'  =>'required',
            // 'content_ar'=>'required',

        ]);

        $f = \App\FAQ::find($id);
        $f->title = $req->input('title');
        $f->contant = $req->input('content');
        $f->save();

        // Transcode::update($f, [
        //     'title'     => $req->title_ar,
        //     'contant'   => $req->content_ar,
        // ]);


        return back()->with('success','FAQ has been Updated.');
    }

    public function faq_edit($id){
        return view('admin.FAQ_edit')->with('q',\App\FAQ::find($id));
    }


    public function material_delete($id){
        $f = \App\Material::find($id);
        if($f){

            $url = $f->file_url;
            
            DB::table('videos')->where('attachment_url', $url)->update(['attachment_url' => null]);
            
            $f->delete();
            return back()->with('success', 'deleted !');


        }else{
            return back()->with('success', 'deleted !');
        }
    }

    public function studyPlan_delete($id){
        $f = \App\StudyPlan::find($id);
        if($f){
            if($f->video_url != null){
                if(Storage::exists($f->video_url)){
                    Storage::delete($f->video_url);
                }
            }
            $f->delete();
            return back()->with('success', 'deleted !');
        }else{
            return back()->with('success', 'deleted !');
        }
    }

    public function FlashCard_delete($id){
        $f = \App\FlashCard::find($id);
        if($f){
            if($f->img != null){
                if(Storage::exists($f->img)){
                    Storage::delete($f->img);
                }
            }
            $f->delete();
            return back()->with('success', 'deleted !');
        }else{
            return back()->with('success', 'deleted !');
        }
    }

    public function faq_delete($id){
        $faq = \App\FAQ::find($id);
        if($faq){
            $faq->delete();
            Transcode::delete($faq);
            return back()->with('success', 'deleted !');
        }else{
            return back()->with('success', 'deleted !');
        }
    }

    public function faq_add(Request $req){
        $this->validate($req, [
            'title'         =>'required',
            // 'title_ar'      =>'required',
            'content'       =>'required',
            // 'content_ar'    =>'required',
        ]);

        $f = new \App\FAQ;
        $f->title = $req->input('title');
        $f->contant = $req->input('content');
        $f->save();

        // Transcode::add($f, [
        //     'title'     => $req->title_ar,
        //     'contant'   => $req->content_ar,
        // ]);

        return back()->with('success','New FAQ has been added .');

    }

    public function faq_show(){
        return view('admin.FAQ');
    }



    public function flashCard_show(){
        return view('admin.flashCard');
    }

    public function flashCard_add(Request $req){
        $this->validate($req, [
            'title'=>'required',
            'contant'=>'required'
        ]);

        $f = new \App\FlashCard;
        $f->title = $req->input('title');
        if($req->hasFile('img')){
            $f->img = $req->file('img')->store('public/flashcard');
        }
        $f->contant = $req->input('contant');
        $f->save();

        return back()->with('success','New FlashCard has been added .');
    }

    public function studyPlan_show(){
        return view('admin.studyPlan');
    }

    public function studyPlan_add(Request $req){
        $this->validate($req, [
            'title' => 'required',
            'course_id' => 'required|numeric',
            'description' => 'required'
        ]);

        if(!$req->hasFile('video')){
            return back()->with('error', 'Video file is required');
        }

        $s = new \App\StudyPlan;
        $s->title = $req->input('title');
        $s->description = $req->input('description');
        $s->course_id = $req->input('course_id');
        $s->video_url = $req->file('video')->store('public/studyPlan');
        $s->save();

        return back()->with('success', 'New Study Plan has been loaded successfully');
    }

    public function material_update(Request $req){
        $this->validate($req, [
            'cover' => 'required',
            'material_id' => 'required',
        ]);

        $material = \App\Material::find($req->material_id);

        if(Storage::exists($material->cover)){
            Storage::delete($material->cover);
        }
        $material->cover_url = $req->file('cover')->store('public/material');
        $material->save();

        return back()->with('success', 'Cover has been changed.');
    }

    public function material_add(Request $req){


        $this->validate($req,[
            'title'=>'required',
            'course_id'=>'required|numeric',
            'file'=>'required',
            'cover'=>'required',
        ]);


        $m = new \App\Material;
        $m->title = $req->input('title');
        $m->course_id = $req->input('course_id');
        $m->cover_url = $req->file('cover')->store('public/material');
        $m->file_url = $req->file('file')->store('public/material');
        $m->save();

        return back()->with('success', 'Saved.');
    }

    public function material_show(){
        $materials = DB::table('materials')
            ->orderBy('materials.created_at', 'desc')
            ->join('courses', 'materials.course_id', '=', 'courses.id')
            ->select(
                'materials.id',
                'materials.title',
                'materials.created_at',
                DB::raw('(courses.title) AS course_title')
                )->get();
        
        return view('admin.material')->with('materials',$materials);
    }



    public function ScreenShotView(){
        return view('admin.screenshot');
    }


    public function searchByEmail(){
        $users = \App\User::where('email', 'LIKE', '%'.Input::get('email').'%' )
//            ->join('user_details', 'users.id', '=', 'user_details.user_id')
//            ->select('users.*', 'user_details.*', 'users.id')
            ->get();
        return view('admin.users')->with('users', $users)->with('email', Input::get('email'));

    }

    public function searchByEvent(){
        $userPackage = \App\EventUser::where('event_id','=', Input::get('event_id'))->get();
        $ids = [];
        foreach ($userPackage as $user){
            array_push($ids, $user->user_id);
        }

        $users = \App\User::whereIn('users.id', $ids)
//            ->join('user_details', 'users.id', '=', 'user_details.user_id')
//            ->select('users.*', 'user_details.*', 'users.id')
            ->get();
        return view('admin.users')->with('users', $users)->with('event_id', Input::get('event_id'));

    }

    public function searchByPackage(){
        $userPackage = \App\UserPackages::where(function($query){
            if(Input::get('package_id')){
                $query->where('package_id','=', Input::get('package_id'));    
            }
            
        })->get();
        $ids = [];
        foreach ($userPackage as $user){
            array_push($ids, $user->user_id);
        }

        $users = \App\User::whereIn('id', $ids)->get();
        return view('admin.users')->with('users', $users)->with('package_id', Input::get('package_id'));

    }


    public function manual_add_package($user_id){
        $user = User::find($user_id);
        return view('admin.ManualAddPackage')->with('user', $user);
    }

    public function manual_add_package_post(Request $req){
        if($req->input('package_id') == 'null' || $req->input('package_id') == ''){
            return back()->with('error', 'Please, select a package !');
        }


        // create a virual payment
        $payment = new Payments;
        $payment->user_id = $req->input('user_id');
        $payment->totalPaid = \App\Packages::find($req->input('package_id'))->price;
        $payment->paypalEmail = \App\User::find($req->input('user_id'))->email;
        $payment->paymentMethod = 'manual';
        $payment->complete = 1;
        $payment->save();

        // add to approve history
        $approve = new \App\PaymentApproveHistory;
        $approve->payment_id = $payment->id;
        $approve->package_id = $req->input('package_id');
        $approve->user_id = $req->input('user_id');
        $approve->save();

        // add to user_packages
        $user_package = new \App\UserPackages;
        $user_package->user_id = $req->input('user_id');
        $user_package->package_id = $req->input('package_id');
        $user_package->save();

        $package = \App\Packages::find($user_package->package_id);
        try{
            Mail::to(\App\User::find($user_package->user_id)->email)->send(new \App\Mail\EnrollConfirmationMail($package->enroll_msg));
        }catch(\Exception $e){
            /**
             * do nothing !
             */
        }

        return back()->with('success', 'New Package has been added.');
    }


    public function disabled_users_view(){
        $users = DB::table('disabled_users')
            ->leftJoin(DB::raw('(SELECT COUNT(*) count, payments.user_id FROM payments) AS payments'), 'disabled_users.user_id', '=', 'payments.user_id')
            ->select(
                'disabled_users.id',
                'disabled_users.user_id',
                'disabled_users.name',
                'disabled_users.email',
                'disabled_users.country',
                'disabled_users.city',
                'disabled_users.phone',
                DB::raw('(CASE WHEN payments.count IS NULL THEN 0 ELSE payments.count END) AS payments_no'),
                'disabled_users.created_at'
            )
            ->orderBy('created_at', 'desc')
            ->get();


        return view('admin.disabled-users')
            ->with('users', $users);
    }


    public function user_disable(Request $req, $user_id){
        $user = \App\User::find($user_id);
        $disUser = new \App\DisabledUser;
        $disUser->user_id = $user->id;
        $disUser->name = $user->name;
        $disUser->email = $user->email;
        $disUser->city = $user->city;
        $disUser->country = $user->country;
        $disUser->phone = $user->phone;
        $disUser->last_login = $user->last_login;
        $disUser->last_action = $user->last_action;
        $disUser->last_ip = $user->last_ip;
        $disUser->password = $user->password;
        $disUser->remember_token = $user->remember_token;
        $disUser->created_at = $user->created_at;
        $disUser->updated_at = $user->updated_at;
        $disUser->save();
        $user->delete();
        return back()->with('success', 'User Disabled !');
    }

    public function user_enable(Request $req, $id){
        // $id is the field id in the table , not the user id
        $disabled = \App\DisabledUser::find($id);
        $user = new \App\User;
        $user->id = $disabled->user_id;
        $user->name = $disabled->name;
        $user->email = $disabled->email;
        $user->city = $disabled->city;
        $user->country = $disabled->country;
        $user->phone = $disabled->phone;
        $user->last_login = $disabled->last_login;
        $user->last_action = $disabled->last_action;
        $user->last_ip = $disabled->last_ip;
        $user->password = $disabled->password;
        $user->remember_token = $disabled->remember_token;
        $user->created_at = $disabled->created_at;
        $user->updated_at = $disabled->updated_at;
        $user->save();

        $disabled->delete();
        return back()->with('success', 'User Enabled !');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // calculate the question number
        $q_num = count(Question::all());

        //total orders number
        $o_num = count(Payments::where('complete','=', 1)->get());

        // total users
        $u_num = count(User::all());

        //total profit
        $p_num = 0;
        
        // covert from LE to USD
        foreach(Payments::where('complete', '=', 1)->get() as $pay){
            $price = explode(',', $pay->totalPaid);
            $n_price = '';
            foreach($price as $i){
                $n_price .= $i;
            }
            $p_num += $n_price;
        }


        return view('admin')
            ->with('q_num', $q_num)
            ->with('o_num', $o_num)
            ->with('u_num', $u_num)
            ->with('p_num', $p_num);
    }

    public function allUsersIndex(){
        $users = \App\User::orderBy('last_action','desc')->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.users')->with('users', $users);
    }

    public function payment_approve_index(){
        return view('admin.paymentApprove');
    }

    public function payment_approve($approve_id){
        $approve = \App\PaymentApprove::find($approve_id);
        if(!$approve){
            return Redirect::to(route('payment.approve.index'))->with('error','Cant find such a Approve id !');
        }

        $payment = \App\Payments::find($approve->payment_id);
        $payment->complete = 1;
        $payment->save();

        $up = \App\UserPackages::where('package_id', '=', $approve->package_id)->where('user_id','=',$approve->user_id)->get();
        if($up->first()){
            return Redirect::to(route('payment.approve.index'))->with('error','The User Already have this Package !');
        }

        $up = new \App\UserPackages;
        $up->package_id = $approve->package_id;
        $up->user_id = $approve->user_id;
        $up->save();


        /** Store in history */
        $history = new \App\PaymentApproveHistory;
        $history->user_id = $approve->user_id;
        $history->package_id = $approve->package_id;
        $history->payment_id = $approve->payment_id;
        if($approve->img){
            $history->img = $approve->img;
        }else{
            $history->img = null;
        }
        $history->save();

        $package = \App\Packages::find($approve->package_id);
        try{
            Mail::to($approve->user_id)->send(new \App\Mail\EnrollConfirmationMail($package->enroll_msg));
        }catch(\Exception $e){
            /**
             * do nothing !
             */
        }

        $approve->delete();
        return Redirect::to(route('payment.approve.index'))->with('success','Payment Approved !');
    }

    public function payment_cancel(Request $req, $approve_id){
        $approve = \App\PaymentApprove::find($approve_id);
        if(!$approve){
            return Redirect::to(route('payment.approve.index'))->with('error','Cant find such a Approve id !');
        }

        // $payment = \App\Payments::find($approve->payment_id);


        $approve->delete();



        return Redirect::to(route('payment.approve.index'))->with('error','Payment Canceled !');


    }

    public function extension_payment_approve_index(){
        return view('admin.extensionApprove');
    }

    public function extension_payment_approve(Request $req, $approve_id){
        $approve = \App\PaymentExtensionApprove::find($approve_id);
        if(!$approve){
            return Redirect::to(route('extension.payment.approve.index'))->with('error','Cant find such a Approve id !');
        }

        $package = \App\Packages::find($approve->package_id);
        if(!$package){
            return back()->with('error','package not found !');
        }


        $payment = \App\Payments::find($approve->payment_id);


        /**
         * update extension table
         */
        $expire_at = \Carbon\Carbon::now()->addDays($package->expire_in_days);

        $exten = new \App\PackageExtension;
        $exten->user_id = $approve->user_id;
        $exten->payment_id = $payment->id;
        $exten->package_id = $package->id;
        $exten->expire_at = $expire_at;
        $exten->save();


        $history = \App\ExtensionHistory::where('user_id','=', $approve->user_id)->where('package_id', '=', $package->id)->get()->first();
        if(!$history){
            $history = new \App\ExtensionHistory;
            $history->package_id = $package->id;
            $history->user_id = $approve->user_id;
            $history->extend_num = 0;
        }
        $history->extend_num += $package->extension_in_days;
        $history->save();

        $approve->delete();

        return back()->with('success', 'Payment Approved !');
    }

    public function extension_payment_cancel(Request $req, $approve_id){
        $approve = \App\PaymentExtensionApprove::find($approve_id);
        if(!$approve){
            return Redirect::to(route('extension.payment.approve.index'))->with('error','Cant find such a Approve id !');
        }



        $approve->delete();



        return Redirect::to(route('extension.payment.approve.index'))->with('error','Payment Canceled !');
    }
}
