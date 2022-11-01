<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Welcome;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Socialite;

class SocialController extends Controller
{
    use AuthenticatesUsers;

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    protected function createUser($userSocial, $provider){
        return \App\User::create([
            'name'          => $userSocial->getName(),
            'email'         => $userSocial->getEmail(),
            'provider_id'   => $userSocial->getId(),
            'provider'      => $provider,
            'last_login'    => date('Y-m-d H:i:s'),
            'last_ip'       => getenv('REMOTE_ADDR'),
            'last_action' => 'loged in'
        ]);
    }

    public function Callback($provider)
    {

        $userSocial = Socialite::driver($provider)->user();

        if($userSocial->getEmail() == null || $userSocial->getEmail() == ''){
            return back()->with('error', 'please try another login method !');
        }

        $user = \App\User::where(function($q) use($userSocial, $provider) {
            $q->where('email', $userSocial->getEmail())
                ->orWhere(['provider' => $provider, 'provider_id' => $userSocial->getId()]);
        })->first();

        $newUser = false;
        // Register the user ..
        if(!$user){
            $newUser = true;
            event(new Registered($user = $this->createUser($userSocial, $provider)));

            $detail = new \App\UserDetail;
            $detail->user_id = $user->id;
            $detail->save();

            // email the new user ..
            $i = [
                'name' => $user->name,
            ];
            Mail::to($user->email)->send(new Welcome($i));
            $new_msg = new \App\Message;
            $new_msg->from_user_id = \App\Admin::all()->first()->id;
            $new_msg->from_user_type = 'admin';
            $new_msg->to_user_id = $user->id;
            $new_msg->to_user_type = 'user';
            $new_msg->message = 'Dear, '.$user->name.'Welcome To '.env('APP_NAME');
            $new_msg->save();



            $user->provider = $provider;
            $user->provider_id = $userSocial->getId();
            $user->save();
        }
        
        
        $user->provider = $provider;
        $user->provider_id = $userSocial->getId();
        $user->save();

        /**
         * Download User Profile Pic
         */
        /**
         * Facebook Provider
         */
        if($provider == 'facebook'){
            $contents = file_get_contents($userSocial->avatar);
            $oldPath = 'public/profile_picture/'.$provider.'_'.$user->id.'.jpeg';
            if(Storage::exists($oldPath)){
                Storage::delete($oldPath);
            }
            Storage::put($oldPath, $contents);
            $detail = \App\UserDetail::where('user_id', $user->id)->first();
            $detail->profile_pic = $oldPath;
            $detail->save();
        }


        if($newUser || $user->password == null){
            return view('auth.socialiteRegister')
                ->with('provider', $provider)
                ->with('provider_id', $userSocial->getId())
                ->with('email', $user->email);
        }else{
            return view('auth.socialiteLogin')
                ->with('email', $user->email);
        }

    }


}
