<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
//db
use App\Packages;
use App\Payments;
use App\User;

class PaymentController extends Controller
{

    use \App\Payment\Payment;
    public $Currency = 'USD';

    public function __construct()
    {
        $this->middleware('auth')->except([
            'price_details',
            'event_price_details',
        ]);
    }

    public function price_details(Request $req){

        $check = $this->CheckItem($req->package_id, 'package');
        if(!$check){
            return [
                'error' => 'This Item is not available .',
            ];
        }

        return $this->PriceDetails($req->coupon_code, $req->package_id, 'package');
    }

    public function event_price_details(Request $req){
        $check = $this->CheckItem($req->event_id, 'event');
        if(!$check){
            return [
                'error' => 'This Item is not available .',
            ];
        }

        return $this->PriceDetails($req->coupon_code, $req->event_id, 'event');
    }


    public function payV2Event(Request $req){
        $pd = new Payments;
        /**
         * orderID: data.orderID,
         * payer_id: details.payer.payer_id,
         * paypalEmail: details.payer.email_address,
         * countryCode: details.payer.address.country_code,
         * totalPaid: details.purchase_units[0].amount.value,
         * paymentID: details.purchase_units[0].payments.captures[0].id
         */


        $event = \App\Event::find($req->input('event_id'));


        $pd->user_id            =  Auth::user()->id;
        $pd->buyerID            = $req->input('payer_id');
        $pd->paymentID          = $req->input('paymentID');
        $pd->cartID             = $req->input('orderID');
        $pd->totalPaid          = $req->input('totalPaid');
        if($req->input('paypalEmail') != ''){
            $pd->paypalEmail        = $req->input('paypalEmail');
        }else{
            $pd->paypalEmail        = Auth::user()->email;
        }

        $pd->countryCode        = $req->input('countryCode');
        $pd->paymentMethod      = 'Paypal Checkout Express';
        $pd->complete           = 1;

        $coupon = \App\Coupon::where('code', '=', $req->input('coupon'))->get()->first();
        if($coupon){
            $pd->coupon_code        = $coupon->code;
        }

        $pd->save();


        $newEvent = new \App\EventUser;
        $newEvent->user_id = Auth::user()->id;
        $newEvent->event_id = $req->event_id;
        $newEvent->payment_id = $pd->id;
        $newEvent->save();
        
        /**
         * updata notification table
         */

        $noti = new \App\Notification;
        $noti->description = 'Paypal Checkout Express: Requested by User: '.Auth::user()->name.'and Accepted, Event: '.$event->name;
        $noti->save();



        $coupon = \App\Coupon::where('code', '=', $req->input('coupon'))->get()->first();

        if($coupon){
            /**
             * check expiration
             */

            if(\Carbon\Carbon::parse($coupon->expire_date)->gt(\Carbon\Carbon::now()) && ($coupon->no_use) > 0 && $coupon->event_id == $event->id){
                /**
                 * not expired
                 */

                $coupon->no_use -= 1;
                $coupon->save();

            }

        }

        $free_packages = \App\EventFreePackage::where('event_id', $event->id)->get();

        if(count($free_packages)){
            foreach($free_packages as $package){

                $approve = new \App\PaymentApproveHistory;
                $approve->user_id = Auth::user()->id;
                $approve->package_id = $package->package_id; // package id from parameters
                $approve->payment_id = null;
                $approve->save();

                $up = new \App\UserPackages;
                $up->package_id = $package->package_id;
                $up->user_id = Auth::user()->id;
                $up->save();
            }


        }
        
        return 0;
    }

    public function payV2(Request $req){
        
        
        $pd = new Payments;
        /**
        * orderID: data.orderID,
        * payer_id: details.payer.payer_id,
        * paypalEmail: details.payer.email_address,
        * countryCode: details.payer.address.country_code,
        * totalPaid: details.purchase_units[0].amount.value,
        * paymentID: details.purchase_units[0].payments.captures[0].id
         */


        $package = \App\Packages::find($req->input('package_id'));


        $pd->user_id            =  Auth::user()->id;
        $pd->buyerID            = $req->input('payer_id');
        $pd->paymentID          = $req->input('paymentID');
        $pd->cartID             = $req->input('orderID');
        $pd->totalPaid          = $req->input('totalPaid');
        if($req->input('paypalEmail') != ''){
            $pd->paypalEmail        = $req->input('paypalEmail');
        }else{
            $pd->paypalEmail        = Auth::user()->email;
        }        
        
        $pd->countryCode        = $req->input('countryCode');
        $pd->paymentMethod      = 'Paypal Checkout Express';
        $pd->complete           = 1;

        $coupon = \App\Coupon::where('code', '=', $req->input('coupon'))->get()->first();
        if($coupon){
            $pd->coupon_code        = $coupon->code;
        }

        $pd->save();

        // update payment_approves table
        $approve = new \App\PaymentApproveHistory;
        $approve->user_id = Auth::user()->id;
        $approve->package_id = $req->package_id; // package id from parameters
        $approve->payment_id = $pd->id;
        $approve->save();
        
        $up = new \App\UserPackages;
        $up->package_id = $req->package_id;
        $up->user_id = Auth::user()->id;
        $up->save();

        /**
         * updata notification table
         */
        
        $noti = new \App\Notification;
        $noti->description = 'Paypal Checkout Express: Requested by User: '.Auth::user()->name.'and Accepted, Package: '.\App\Packages::find($req->input('package_id'))->name;
        $noti->save();

        
        try{
            Mail::to(Auth::user()->email)->send(new \App\Mail\EnrollConfirmationMail($package->enroll_msg));
        }catch(\Exception $e){
            /**
             * do nothing !
             */
        }
       


        $coupon = \App\Coupon::where('code', '=', $req->input('coupon'))->get()->first();

        if($coupon){
            /**
             * check expiration
             */
            
            if(\Carbon\Carbon::parse($coupon->expire_date)->gt(\Carbon\Carbon::now()) && ($coupon->no_use) > 0 && $coupon->package_id == $package->id){
                /**
                 * not expired
                 */


                $coupon->no_use -= 1;
                $coupon->save();

            }
             
        }
        
        session(['lastPayment' => \Carbon\Carbon::now()]);

        return 0;
    }

    public function is_package_expired($package_id){

        $package = \App\Packages::find($package_id);
        if(!$package){
            return 1;
        }

        $user_package = \App\UserPackages::where('user_id', '=' ,Auth::user()->id)->where('package_id', '=', $package_id)->get()->first();
        if(!$user_package){
            return 1;
        }

        if(\Carbon\Carbon::parse($user_package->created_at)->addDays($package->expire_in_days)->gte(\Carbon\Carbon::now())){ // original package still not expired
            return 0;
        }else{
            $extension = \App\PackageExtension::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package_id)->orderBy('expire_at', 'desc')->first();
            if(!$extension){
                return  1;
            }else{
                if(\Carbon\Carbon::parse($extension->expire_at)->gte(\Carbon\Carbon::now())){
                    return 0;
                }else{
                    return 1;
                }
            }
        }

    }

    public function extend($package_id){
        
        
        
        $package = Packages::where('id', '=', $package_id)->get()->first();
        if(!$package){
            return back()->with('error', 'Error !');
        }

        /**
         * make sure package belongs to the user
         */
        $user_package = \App\UserPackages::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package_id)->get()->first();
        if(!$user_package){
            return back()->with('error', 'You may first pay the package !');
        }

        /**
         * make sure package is expired !
         */

        if(!$this->is_package_expired($package_id)){
            return back()->with('error', 'Package does not expired !');
        }

        /**
         * make sure payment extension approve table is empty
         */

        $approve = \App\PaymentExtensionApprove::where('package_id', '=', $package_id)->where('user_id', '=', Auth::user()->id)->get()->first();
        if($approve){
            return back()->with('error', 'You already have requested , and your request is processing !');
        }


        /** max extension */
        $history = \App\ExtensionHistory::where('user_id', '=', Auth::user()->id)->where('package_id', '=' , $package_id)->get()->first();
        if($history){
            if($history->extend_num >= $package->max_extension_in_days){
                return back()->with('error', 'you have exceed the max extension number of days !');       
            }
        }
        



        /**
        * consider the price !
        */

        $pd = new Payments;
        $pd->user_id            =  Auth::user()->id;
        $pd->buyerID            = '';
        $pd->paymentID          = '';
        $pd->cartID             = '';
        $pd->totalPaid          = 0;
        $pd->paypalEmail        = Auth::user()->email;
        $pd->city               = '';
        $pd->state              = '';
        $pd->postalCode         = '';
        $pd->countryCode        = '';
        $pd->address            = '';
        $pd->paymentMethod      = 'freeExtension';
        $pd->complete           = 0;
        $pd->save();



        /**
        * update payment extension approve table
        */

        $approve = new \App\PaymentExtensionApprove;
        $approve->user_id = Auth::user()->id;
        $approve->package_id = $package_id;
        $approve->payment_id = $pd->id;
        $approve->save();


        /**
        * updata notification table
        */

        $noti = new \App\Notification;
        $noti->description = 'Free Extension: Package Extended by User: '.Auth::user()->name;
        $noti->save();

        $this->extension_payment_approve($approve->id);

        return back()->with('success', 'Package Extended Free !');

    }


}
