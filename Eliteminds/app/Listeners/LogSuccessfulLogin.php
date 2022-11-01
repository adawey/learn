<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {



        try{

            $user = \App\User::find($event->user->id);
            $user->last_action = 'loged in';
            $user->last_ip     = getenv('REMOTE_ADDR');
            $user->last_login  = date('Y-m-d H:i:s');
            $user->save();


            /**
             * Check Device
             */
            // $agent = new Agent();
            // $browser = $agent->browser();
            // $platform = $agent->platform();

            // // store current
            // $check = DB::table('agents')
            //     ->where([
            //         'user_id'           => $event->user->id,
            //         'platform'          => $platform,
            //         'platform_version'  => $agent->version($platform),
            //         'browser'           => $browser,
            //         // 'browser_version'   => $agent->version($browser)
            //     ])
            //     ->first();
            // if(!$check){
            //     DB::table('agents')
            //         ->insert([
            //             'user_id'           => $event->user->id,
            //             'platform'          => $platform,
            //             'platform_version'  => $agent->version($platform),
            //             'browser'           => $browser,
            //             'browser_version'   => $agent->version($browser),
            //             'created_at'        => Carbon::now(),
            //             'updated_at'        => Carbon::now(),
            //         ]);
            // }else{
            //     DB::table('agents')
            //         ->where('id', $check->id)
            //         ->update([
            //             'updated_at' => Carbon::now(),
            //             'browser_version'   => $agent->version($browser),
            //         ]);
            // }



            if(\Session('attempt_user_id') != $event->user->id && Auth::guard('web')->check()){
                \Storage::append('loginErrorLog.txt', '['.\Carbon\Carbon::now().'] - [listener][ERROR] Atempted_from_user: '.\Session('attempt_user_id').' - Logged_In_user: '.$event->user->id);
                Auth::logout();
                return back()->with('error', 'Authentication Error, Please try Again!');
            }


        }catch(\Exception $ex){

        }





    }
}
