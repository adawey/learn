<?php

namespace App\Http\Controllers\API;
use App\ConfigX;
use App\Payments;
use App\UserPackages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class API_AdminController extends Controller
{
    public function PaypalConfig(){

       
        $paypal = \App\PaypalConfig::all()->first();
        $client_id = $paypal->client_id;
        $secret    = $paypal->secret;
        
        return response()->json([
            'data' => [
                'client_id' => 'AVceaZHSssqhJceC6hFiQaqj9GNaANYPAtSMVUz2ohyRxdzBHj8jy7OfqJHPqn_dVZ0oY_weQ0pqlKa1',
                'secret'    => 'EJ1Hmofixi-AcQ7twLYpjRvLTTAKBuTUllHZsZIdi-E8ONZsLpYssWFa4Bu7BlP0qcNbgbwZ4vkIWDPw',
            ]
        ], 200);


        // return response()->json([
        //     'data' => [
        //         'client_id' => $client_id,
        //         'secret'    => $secret,
        //     ]
        // ], 200);
    }


    public function paymentStatus(Request $req){
        
        $pd = new Payments;
        $pd->user_id            = Auth::user()->id;
        $pd->buyerID            = $req->input('buyer_id');
        $pd->paymentID          = $req->input('payment_id');
        $pd->cartID             = $req->input('cart_id');
        $pd->totalPaid          = $req->input('total_paid');
        $pd->paypalEmail        = $req->input('paypal_email');
        $pd->city               = $req->input('city');
        $pd->state              = $req->input('state');
        $pd->postalCode         = $req->input('postal_code');
        $pd->countryCode        = $req->input('country_code');
        $pd->address            = $req->input('address');
        $pd->paymentMethod      = $req->input('payment_method');
        $pd->complete           = 0;
        $pd->save();

        // update payment_approves table
        $approve = new \App\PaymentApprove;
        $approve->user_id = Auth::user()->id;
        $approve->package_id = $req->input('package_id');
        $approve->payment_id = $pd->id;
        $approve->img = null;
        $approve->save();

        /**
         * updata notification table
         */
        
            $noti = new \App\Notification;
            $noti->description = 'New Payment from User: '.Auth::user()->name.', Of '.$req->input('total_paid').'$ is accepted';
            $noti->save();
        

        return response()->json([
            'meta'=> [
                'code' => 200
            ]
        ], 200);
    }

    
    
}
