<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Localization\Locale;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username = 'email';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Locale $locale)
    {
        return view('auth.login');
    }


    public function setupAccount(Request $request)
    {

        /**
         * validate form
         */
        if (
            !$request->password ||
            $request->password != $request->password_confirmation ||
            strlen($request->password) < 6
        ) {
            return view('auth.socialiteRegister')
                ->with('provider', $request->provider)
                ->with('provider_id', $request->provider_id)
                ->with('email', $request->email)
                ->with('error', 'password confirmation does not match');
        }

        $user = \App\User::where([
            'provider' => $request->provider,
            'provider_id' => $request->provider_id
        ])->first();

        if (!$user) {
            return \Redirect::to(route('login'))->with('something went wrong !');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        /**
         * log the user in
         */
        return $this->login($request);

    }

    public function login(Request $request)
    {

        

        \Session(['process' => 'login']);
        $attmpt_user = \App\User::where('email', $request->input('email'))->get()->first();
        if ($attmpt_user) {
            \Session(['attempt_user_id' => $attmpt_user->id]);
        } else {
            \Session(['attempt_user_id' => 'not_found']);
        }


        if ($request->withStateResponse) {
            if (!Hash::check($request->password, $attmpt_user->password)) {
                return 500;
            }
        } else {
            $this->validateLogin($request);
        }


        $devices_number = DB::table('users')
            ->where('email', $request->email)
            ->leftJoin('agents', 'users.id', '=', 'agents.user_id')
            ->select(DB::raw('(COUNT(*)) AS devices_count'))
            ->first()->devices_count;

//        if($devices_number > 3){
//            return $request->withStateResponse ? 500: back()->with('error', 'you can login to your account due to security reasons.');
//        }

        if($this->attemptLogin($request)) {


            if (\Session('attempt_user_id') != Auth::user()->id && Auth::guard('web')->check()) {
                \Storage::append('loginErrorLog.txt', '[' . \Carbon\Carbon::now() . '] - User_ID_Bad[authenticatesUsers] - Session_id: ' . \Session('attempt_user_id') . ' - logged_in_id: ' . Auth::user()->id);
                Auth::logout();
                if ($request->withStateResponse) {
                    return 500;
                } else {
                    return back()->with('error', 'Authentication Error, Please try Again!');
                }
            } else {
                // \Storage::append('loginErrorLog.txt', '['.\Carbon\Carbon::now().'] - User_ID_Correct[authenticatesUsers] - Session_id: '.\Session('attempt_user_id').' - logged_in_id: '.Auth::user()->id);
            }
            
            
            // check for pending payment requests
            $userModel = \App\User::where('email', $request->email)->first();
            if($userModel){
                $payment = \App\Payments::where('user_id', $userModel->id)->latest()->get()->first();
                if($payment){
                    $emptyReq = new Request([]);
                    app('App\Http\Controllers\PaytabsController')->redirect($emptyReq, $payment->paymentID);    
                }
                
            }
            

            return $this->sendLoginResponse($request);
        }


        if (\App\DisabledUser::where('email', $request->email)->first()) {
            return \Redirect::to(route('login'))->with('error', 'maybe your account needs to be activated, please check your email.');
        }


        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        if ($request->withStateResponse) {
            return 200;
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }

    protected function sendLoginResponse(Request $request)
    {

        //

        $loginUser = \App\User::find($request->session()->get('attempt_user_id'));
        if ($loginUser) {
            if (Auth::user()->id != $loginUser->id && Auth::guard('web')->check()) {
                \Storage::append('loginErrorLog.txt', '[' . \Carbon\Carbon::now() . '] - [loginController][ERROR] Atempted_from_user: ' . $request->session()->get('attempt_user_id') . ' - Logged_In_user: ' . Auth::user()->id);
                Auth::logout();
                if ($request->withStateResponse) {
                    return 500;
                } else {
                    return back()->with('error', 'Authentication Error, Please try Again!');
                }
            }
        } else {
            if (Auth::guard('web')->check()) {
                \Storage::append('loginErrorLog.txt', '[' . \Carbon\Carbon::now() . '] - [loginController][ERROR] User_id_not_found: ' . $request->session()->get('attempt_user_id'));
                Auth::logout();
                if ($request->withStateResponse) {
                    return 500;
                } else {
                    return back()->with('error', 'Authentication Error, Please try Again!');
                }
            }
        }


        $request->session()->regenerate();


        if (Auth::user()->id != $loginUser->id && Auth::guard('web')->check()) {
            \Storage::append('loginErrorLog.txt', '[' . \Carbon\Carbon::now() . '] - [loginController|afterRegenerate][ERROR] Atempted_from_user: ' . $request->session()->get('attempt_user_id') . ' - Logged_In_user: ' . Auth::user()->id);
            Auth::logout();
            if ($request->withStateResponse) {
                return 500;
            } else {
                return back()->with('error', 'Authentication Error, Please try Again!');
            }
        }


        // one device per account !
        $previous_session = Auth::user()->last_session_id;
        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }
        Auth::user()->last_session_id = \Session::getId();
        Auth::user()->last_server_ip = $_SERVER['SERVER_ADDR'];
        Auth::user()->save();


        $this->clearLoginAttempts($request);


        if ($request->withStateResponse) {
            return 200;
        } else {

            if($request->has('prev_url')){
                return \Redirect::to($request->input('prev_url'));
            }
            if(\Session('prev_url')){
                $url = \Session('prev_url');
                \Session(['prev_url' => null]);
                return \Redirect::to($url);
            }

            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
        }

    }

    public function SocialLogin(Request $request)
    {

        $user = \App\User::where(['email' => $request->email])->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return $this->login($request);
            } else {
                return view('auth.socialiteLogin')
                    ->with('email', $request->email)
                    ->with('error', 'Wrong Password.');
            }
        } else {
            return view('auth.socialiteLogin')
                ->with('email', $request->email)
                ->with('error', 'Account not Exists !');
        }


//        return $this->login($request);
    }

    public function loginWithStateResponse(Request $request)
    {
        $user = \App\User::where(['email' => $request->email])->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                $this->attemptLogin($request);
                $request->session()->regenerate();
                // one device per account !
                $previous_session = Auth::user()->last_session_id;
                if ($previous_session) {
                    \Session::getHandler()->destroy($previous_session);
                }
                Auth::user()->last_session_id = \Session::getId();
                Auth::user()->last_server_ip = $_SERVER['SERVER_ADDR'];
                Auth::user()->save();


                $this->clearLoginAttempts($request);
                return 200;

            } else {
                return 500;
            }
        }

        return 500;
    }


}
