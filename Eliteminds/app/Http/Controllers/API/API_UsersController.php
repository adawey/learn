<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\OauthRefreshTokens as OauthTokens;

class API_UsersController extends Controller
{


    public function logout(){

        $accessToken = Auth::user()->token();
        if($accessToken){
            $query = OauthTokens::where('access_token_id', '=', $accessToken->id );
            if($query){
                $query->update([
                    'revoked' => true
                ]);

                $accessToken->revoke();

                return response()->json([
                    'meta' => [
                        'code' => 200,
                    ]
                ]);
            }else{
                return response()->json(null, 204);
            }
        }else{
            return response()->json(null, 204);
        }


    }

    public function new_user(Request $req){
        
        $this->validate($req, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
        ]);

        $new_user = User::create([
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
            'city' => $req->input('city'),
            'country' => $req->input('country'),
            'phone' => $req->input('phone'),
        ]);


        /** Success ! */
        return response()->json([
            'messge' => 'Account Created',
            'errors' => (object)[],
        ], 201);
    }

    public function UserUpdatePasswordRequest(Request $req){
        $this->validate($req, [
            'old_password'              =>  'required|string|min:6',
            'password'                  =>  'required|string|min:6|confirmed',
        ]);


        if(!\Hash::check($req->input('old_password'), Auth::user()->password)){
            return response()->json([
                'message'=> 'The given data was invalid',
                'errors' => [
                    'password'  => 'the old password is incorrect.'
                ],
            ],422);
        }
        $user = \App\User::find(Auth::user()->id);
        $user->password = \Hash::make($req->input('password'));
        $user->save();

        return response()->json([
            'message'   => 'Password Updated',
            'errors'    => [],
        ], 200);
    }

    public function UserUpdateProfileInfo(Request $req){
        $this->validate($req, [
            'name'      =>'required|string',
            'email'     =>'required',
            'phone'     =>'required',
            'city'      =>'required',
            'occupation'=>'required',
        ]);

        $user1 = \App\User::where('email','=',$req->input('email'))
            ->where('id', '!=', Auth::user()->id)
            ->get()->first();
        if($user1){
            return response()->json([
                'message'   => 'The given data was invalid',
                'errors'    => ['email' => 'The given Email is already in use.'],
            ], 200);
        }


        $user = \App\User::find(Auth::user()->id);
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->phone = $req->input('phone');
        $user->city = $req->input('city');
        if($req->input('country') != ''){
            $user->country = $req->input('country');
        }
        $user->save();

        $info = \App\UserDetail::where('user_id', '=', $user->id)->get()->first();
        if(!$info){
            $info = new \App\UserDetail;
            $info->user_id = $user->id;
        }

        $info->interests = $req->input('interests');
        $info->occupation = $req->input('occupation');
        $info->about = $req->input('about');
        $info->fb_url = $req->input('fb_url');
        $info->tw_url = $req->input('tw_url');
        $info->website_url = $req->input('website_url');
        $info->save();

        return response()->json([
            'message'   => 'Profile Updated',
            'errors'    => [],
        ], 200);


    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return response()->json([
            'message'   => trans($response),
            'errors'    => [],
            ], 200);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json([
            'message'   => trans($response),
            'errors'    => ['email' => trans($response)],
        ], 422);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
