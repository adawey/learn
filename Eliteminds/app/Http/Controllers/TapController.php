<?php

namespace App\Http\Controllers;


use App\Payment\Payment as PaymentHelper;
use App\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TapController extends Controller
{

    use PaymentHelper;

    public $Currency = 'USD';
    // public $TAP_secret = 'sk_test_b3CAPO4HfmiIXN2G5uTxUQ8M';
    public $TAP_secret;


    function __construct() {
        $this->TAP_secret = config('tap.TAPsecretKey');
    }

    /**
     * check item is available and active and user do not have it
     * @param $item_id
     * @param $item_type
     * @return int
     */
    public function TAP_CheckItem($item_id, $item_type){
        return $this->CheckItem($item_id, $item_type);
    }

    /**
     *
     * @param $coupon
     * @param $item_id
     * @param $item_type
     * @return array|object
     */
    public function TAP_PriceDetails($coupon, $item_id, $item_type){
        return $this->PriceDetails($coupon, $item_id, $item_type);
    }

    public function TAP_Charge(Request $req){

        $charge_id = $req->tapToken;
        $coupon_code = $req->coupon;
        $item_id = $req->item_id;
        $item_type = $req->item_type;

        $thisUser = Auth::user();
        if(!$thisUser){
            return redirect()->route('login')->with('error', 'something went wrong');
        }

        $item = $this->TAP_CheckItem($item_id, $item_type);
        if(!$item){
            return redirect()->route('user.dashboard')->with('error', 'This Item is not Available.');
        }

        $price = 0;
        $price_details = $this->TAP_PriceDetails($coupon_code, $item_id, $item_type);


        if($price_details['price'] > $price_details['discount']){
            $price = $price_details['price'] - $price_details['discount'];
        }

        $charge_request = [
            'amount' => round($price),
            'currency' => $this->Currency,
            'threeDSecure' => true,
            'save_card' => false,
            'description' => $item->name,
            'statement_descriptor' => mb_substr($item->name, 0, 50),
            'metadata' => [
                'coupon' => $coupon_code,
                'item_type' => $item_type,
                'item_id'   => $item_id,
                'user_id'   => Auth::user()->id,
                
            ],
            'reference' => [],
            'receipt' => [
                'email' => false,
                'sms' => true,
            ],
            'customer' => [
                'first_name' => $thisUser->name,
                'email'      => $thisUser->email,
            ],
            'source' => [
                'id' => $charge_id
            ],
            'redirect' => [
                'url' => route('chargeRedirect')
            ]
        ];
            
        
        //https://api.tap.company/v2/charges
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.tap.company/v2/charges",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($charge_request),
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->TAP_secret,
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $res = json_decode($response);
            
            if($res){
                
                if(isset($res->errors)){
                    return redirect()->to(route('user.dashboard'))->with('error', $res->errors[0]->description);
                }
                
                if($res->status == 'INITIATED'){
                    // redirect ..
                    return \Redirect::to($res->transaction->url);
                }else{
                    return redirect()->route('user.dashboard')->with('error', 'payment error !');
                }    
            }else{
                return back()->with('error', 'payment failed');
            }
            
        }
    }

    public function TAP_ChargeRedirect(Request $req){
        $charge_id = $req->tap_id;
        
        

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.tap.company/v2/charges/".$charge_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->TAP_secret,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $res = json_decode($response);
            
            $user = \App\User::find($res->metadata->user_id);
            
            if($res->response->code == '000'){ // '000' = Captured
                // add item to user
                $pd = new Payments;
                $pd->user_id            =  $user->id;
                $pd->buyerID            = $res->id;
                $pd->paymentID          = $res->reference->payment;
                $pd->cartID             = '';
                $pd->totalPaid          = $res->amount;
                $pd->paypalEmail        = $user->email;
                $pd->countryCode        = '';
                $pd->paymentMethod      = 'TAP';
                $pd->complete           = 1;
                $coupon = \App\Coupon::where('code', '=', $res->metadata->coupon)->get()->first();
                if($coupon){
                    $pd->coupon_code = $coupon->code;
                    /**
                     * check expiration
                     */
                    if(\Carbon\Carbon::parse($coupon->expire_date)->gt(\Carbon\Carbon::now()) && ($coupon->no_use) > 0){
                        /**
                         * not expired
                         */
                        $coupon->no_use -= 1;
                        $coupon->save();

                    }
                }
                $pd->save();

                /**
                 * update notification table
                 */
                $noti = new \App\Notification;
                $noti->description = 'TAP Payment: Requested by User: '.$user->name.'and Accepted, '.$res->description;
                $noti->save();

                if($res->metadata->item_type == 'package'){
                    // update payment_approves table
                    $approve = new \App\PaymentApproveHistory;
                    $approve->user_id = $user->id;
                    $approve->package_id = $res->metadata->item_id; // package id from parameters
                    $approve->payment_id = $pd->id;
                    $approve->save();

                    $up = new \App\UserPackages;
                    $up->package_id = $res->metadata->item_id;
                    $up->user_id = $user->id;
                    $up->save();

                    $package = \App\Packages::find($res->metadata->item_id);
                    try{
                        Mail::to($user->email)->send(new \App\Mail\EnrollConfirmationMail($package->enroll_msg));
                    }catch(\Exception $e){
                        /**
                         * do nothing !
                         */
                    }
                }

                if($res->metadata->item_type == 'event'){
                    $newEvent = new \App\EventUser;
                    $newEvent->user_id = $user->id;
                    $newEvent->event_id = $res->metadata->item_id;
                    $newEvent->payment_id = $pd->id;
                    $newEvent->save();

                    $event_details = \App\Event::find($res->metadata->item_id);

                    $noti = new \App\Notification;
                    $noti->description = 'TAP Payment: Requested by User: '.$user->email.'and Accepted, '.$event_details->name;
                    $noti->save();

                    try{

                        Mail::to($user->email)->send(new \App\Mail\EnrollConfirmationMail($event_details->enroll_msg));
                    }catch(\Exception $e){
                        /**
                         * do nothing !
                         */
                    }

                    // attach additional package if included ..
                    if($event_details){
                        $free_packages = \App\EventFreePackage::where('event_id', $event_details->id)->get();

                        if(count($free_packages)){
                           foreach($free_packages as $package){

                               $approve = new \App\PaymentApproveHistory;
                               $approve->user_id = $user->id;
                               $approve->package_id = $package->package_id; // package id from parameters
                               $approve->payment_id = null;
                               $approve->save();

                               $up = new \App\UserPackages;
                               $up->package_id = $package->package_id;
                               $up->user_id = $user->id;
                               $up->save();
                           }


                        }

                    }
                }

                return redirect()->route('my.package.view')->with('success', 'Payment complete.');
            }elseif($res->response->code == '200'){ // '200' = in progress
                return redirect()->route('user.dashboard')->with('success', $res->response->message);
            }else{
                return redirect()->route('user.dashboard')->with('error', $res->response->message);
            }
        }

    }
}
