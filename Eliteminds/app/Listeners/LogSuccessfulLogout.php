<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {

        try{
            $user = \App\User::find($event->user->id);
            if($user->email == $event->user->email){
                $user->last_action = 'loged out';
                $user->save();    
            }
            
            $session = \App\Session::where('user_id', $user->id)->get()->first();
            if($session){
                $session->delete();
            }else{
                return 'logged out';
            }
        }catch(\Exception $ex){
            
        }
    }
}
