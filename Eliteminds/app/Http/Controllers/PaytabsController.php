<?php

namespace App\Http\Controllers;

use App\PaymentApprove;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\PaytabsInvoice;
use Basel\Paytabs\Paytabs;
use Illuminate\Http\Request;
use \App\Payment\Payment as PaymentHelper;
use \App\Payments;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use App\Zone\Zone;

use Illuminate\Support\Facades\Log;


class PaytabsController extends Controller
{
    use PaymentHelper;

    public function charge(Request $request){

        $item_type = $request->item_type;
        $item_id = $request->item_id;
        $coupon_code = $request->coupon_code;
        $thisUser = Auth::user();

        if(!$thisUser){
            return response()->json([
                'error' => '',
                'url'   => route('login'),
            ], 200);
        }

        $item = $this->CheckItem($item_id, $item_type);
        if(!$item){
            return response()->json([
                'error' => 'This Item is not Available',
                'url'   => '',
            ], 200);
        }
        $price_details = $this->PriceDetails($coupon_code, $item_id, $item_type);
        

        if($price_details['price'] > $price_details['discount']){
            $price = $price_details['price'] - $price_details['discount'];
        }else{
            $price = $price_details['price'];
        }
        
        $price_in_JOD = Zone::currencyExchange([[$price, 'JOD']]);
        $price_in_JOD = ceil($price_in_JOD[0]);

        /**
         * Initiate Payment request
         */
        $pay = paypage::sendPaymentCode('all')
            ->sendTransaction('sale')
            ->sendCart($thisUser->id ,$price , $item->name)
            ->sendCustomerDetails( $thisUser->name,  $thisUser->email, $thisUser->phone, '--',  $thisUser->city ,'--' , $price_details['country_code'], '1234',$price_details['ip'])
            ->sendShippingDetails($item->name,' ', ' ', '  ', '  ', '  ', '  ', '','  ')
            ->sendUserDefined((object)[ "udf1" => $item->id, "udf2" => $item_type])
            ->sendURLs(route('paytabs.redirect'), route('paytabs.redirect'))
            ->sendLanguage('en')
            ->create_pay_page();

        
        $response = $pay['response'];
        $pp_params = $pay['pp_params'];


        if($response->success){
            /**
             * Update Payment and Payment approve table
             */
            $paymentModel = $this->insertPayment($thisUser, $response->tran_ref, $price, $price_details['currency_code'], $coupon_code);
            Log::channel('paytabs')->debug(json_encode(['model' => $paymentModel, 'user' => $thisUser])); /** Log for debugging */
        
            $paymentApproveModel = $this->insertPaymentApprove($thisUser->id, $item_id, $item_type, $paymentModel->id);
            Log::channel('paytabs')->debug(json_encode(['model' => $paymentApproveModel, 'user' => $thisUser])); /** Log for debugging */

            /**
             * redirect to payment page
             */
            $redirect_url = $response->redirect_url;
            return response()->json([
                'error' => '',
                'url'   => $redirect_url,
            ], 200);

//            if (isset($pp_params['framed']) &&  $pp_params['framed'] == true)
//            {
//                return $redirect_url;
//            }
//            return Redirect::to($redirect_url);
        }
        
        

//        return redirect()->route('user.dashboard')->with('error', 'Payment Could not be executed: '. $response->message);
        return response()->json([
            'error' => 'Payment Could not be executed: '. $response->message,
            'url'   => '',
        ], 200);
    }

    /**
     *  Function accept 2nd parameter so it can be another controller 
     * 
     */
    public function redirect(Request $request, $ransfer_id = null){
        /**
         * Query the Payment
         */
        if($request->tran_ref){
            // handle callback
            $transRef = $request->tran_ref;
            $call = 'callback';
            
        }else{
            // handle redirect
            $transRef = $request->tranRef;
            $call = 'redirect';
        }
        
        if($ransfer_id){
            $transRef = $ransfer_id;
        }
        
        $response = paypage::queryTransaction($transRef);
        

        // if ($response->success == true && $response->payment_result->response_status == 'A' && $response->payment_result->response_message == "Authorised") {
        if (($response->success == true || $response->success == 'true') && $response->payment_result->response_status == 'A') {
            /** Payment Accepted .. */
            $payment = Payments::where('paymentID', $transRef)->first();
            if(!$payment){
                Log::channel('paytabs')->debug(json_encode(['error' => 'Payment Model Not found', 'paymentModel' => $payment, 'trans_ref' => $transRef])); /** Log for debugging */
                return redirect()->route('user.dashboard')->with('error', 'Payment Not Found, please contact customer support for help.');
            }
            
            if($payment->complete){
                if($call == 'redirect'){
                    return redirect()->route('user.dashboard')->with('success', 'Payment Completed.');
                }else{
                    return response()->json(null, 200);    
                }
                
            }

            $paymentApprove = PaymentApprove::where('payment_id', $payment->id)->first();

            if(!$paymentApprove){
                Log::channel('paytabs')->debug(json_encode(['error' => 'PaymentApprove Model Not found', 'paymentModel' => $paymentApprove, 'payment_id' => $payment->id, 'trans_ref' => $transRef])); /** Log for debugging */
                return redirect()->route('user.dashboard')->with('error', 'Payment Approve Not Found, please contact customer support for help.');
            }
            
            $payment->complete = 1;
            $payment->cartID = $response->cart_id;
            $payment->countryCode = $response->customer_details->country;
            $payment->save();
            
            $user = \App\User::find($paymentApprove->user_id);

            $coupon = \App\Coupon::where('code', '=', $payment->coupon_code)->get()->first();
            if($coupon){
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

            $approve = new \App\PaymentApproveHistory;
            $approve->user_id = $paymentApprove->user_id;
            $approve->package_id = $paymentApprove->package_id;
            $approve->event_id = $paymentApprove->event_id;
            $approve->payment_id = $paymentApprove->payment_id;
            $approve->save();

            if($approve->package_id){


                $up = new \App\UserPackages;
                $up->package_id = $approve->package_id;
                $up->user_id = $approve->user_id;
                $up->save();

                $package = \App\Packages::find($approve->package_id);
                /**
                 * update notification table
                 */
                $noti = new \App\Notification;
                $noti->description = 'Paytabs Payment: Requested by User: '.$user->email.'and Accepted, '.$package->name;
                $noti->save();

                try{
                    Mail::to($user->email)->send(new \App\Mail\EnrollConfirmationMail($package->enroll_msg));
                }catch(\Exception $e){
                    /**
                     * do nothing !
                     */
                }

            }elseif($approve->event_id){

                $newEvent = new \App\EventUser;
                $newEvent->user_id = $user->id;
                $newEvent->event_id = $approve->event_id;
                $newEvent->payment_id = $approve->payment_id;
                $newEvent->save();

                $event_details = \App\Event::find($approve->event_id);

                $noti = new \App\Notification;
                $noti->description = 'MyFatoorah Payment: Requested by User: '.$user->email.'and Accepted, '.$event_details->name;
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

            /** CLear from Payment Approve table */
            PaymentApprove::find($paymentApprove->id)->delete();

            $invoiceData = [
                'name'  =>  $user->name,
                'email' =>  $user->email,
                'price' => $payment->totalPaid,
                'currency'  => $payment->currency,
                'payment_id'    => $payment->paymentID,
                'product_name'  => $approve->package_id ? $package->name: $event_details->name,
                'date'  => $payment->created_at

            ];
            $this->invoiceEmail($invoiceData, 'PayTabs');

            Log::channel('paytabs')->debug(json_encode(['status' => 'Package Catptured.', 'redirect_response' => $response])); /** Log for debugging */
            
            if($call == 'redirect'){
                return redirect()->route('user.dashboard')->with('success', 'Payment Completed.');    
            }
        }else{
            /** Payment Error */
            Log::channel('paytabs')->debug(json_encode(['redirect_response' => $response])); /** Log for debugging */
            $payment = Payments::where('paymentID', $transRef)->first();
            if($payment){
                $paymentApprove = PaymentApprove::where('payment_id', $payment->id)->first();
                if($paymentApprove)
                    $paymentApprove->delete();
                $payment->delete();
            }
            
            if($call == 'redirect'){
                return redirect()->route('user.dashboard')->with('error', 'Payment Error ['.$response->payment_result->response_status.']['.$response->payment_result->response_message.']: Payment Could not be completed.');
            }
        }
    }

    /**
     * Deprecated: this function will do nothing ...
     * @param Request $request
     * @return mixed
     */
    public function callback(Request $request)
    {
        // $response = paypage::queryTransaction($request->tran_ref);
        Log::channel('paytabs')->debug(json_encode(['callback_response' => $request->all()]));
    }

    public function insertPayment(User $thisUser, $tran_ref, $price, $currency, $coupon){
        $pd = new Payments();
        $pd->user_id            = $thisUser->id;
        $pd->buyerID            = '';
        $pd->paymentID          = $tran_ref;
        $pd->cartID             = '';
        $pd->totalPaid          = $price;
        $pd->currency           = $currency;
        $pd->paypalEmail        = $thisUser->email;
        $pd->countryCode        = '';
        $pd->paymentMethod      = 'PayTabs';
        $pd->complete           = 0;
        $pd->coupon_code        = $coupon;
        $pd->save();
        return $pd;
    }

    public function insertPaymentApprove($user_id, $item_id, $item_type, $payment_id){
        $paymentApprove = new PaymentApprove;
        $paymentApprove->payment_id = $payment_id;
        $paymentApprove->user_id = $user_id;
        if($item_type == 'package'){
            $paymentApprove->package_id = $item_id;
        }elseif($item_type == 'event'){
            $paymentApprove->event_id = $item_id;
        }
        $paymentApprove->save();
        return $paymentApprove;
    }



    /**
     * Check this function, if not important just delete them
     */
    public function index(){

        // $pt = app('paytabs'); //the instance through the register service provider singleton

        $result = Paytabs::getInstance()->create_pay_page(array(

            //Customer's Personal Information
            'cc_first_name' => "john",          //This will be prefilled as Credit Card First Name
            'cc_last_name' => "Doe",            //This will be prefilled as Credit Card Last Name
            'cc_phone_number' => "00973",
            'phone_number' => "33333333",
            'email' => "customer@gmail.com",

            //Customer's Billing Address (All fields are mandatory)
            //When the country is selected as USA or CANADA, the state field should contain a String of 2 characters containing the ISO state code otherwise the payments may be rejected.
            //For other countries, the state can be a string of up to 32 characters.
            'billing_address' => "manama bahrain",
            'city' => "manama",
            'state' => "manama",
            'postal_code' => "00973",
            'country' => "BHR",

            //Customer's Shipping Address (All fields are mandatory)
            'address_shipping' => "Juffair bahrain",
            'city_shipping' => "manama",
            'state_shipping' => "manama",
            'postal_code_shipping' => "00973",
            'country_shipping' => "BHR",

            //Product Information
            "products_per_title" => "Product1 || Product 2 || Product 4",   //Product title of the product. If multiple products then add “||” separator
            'quantity' => "1 || 1 || 1",                                    //Quantity of products. If multiple products then add “||” separator
            'unit_price' => "2 || 2 || 6",                                  //Unit price of the product. If multiple products then add “||” separator.
            "other_charges" => "91.00",                                     //Additional charges. e.g.: shipping charges, taxes, VAT, etc.
            'amount' => "101.00",                                          //Amount of the products and other charges, it should be equal to: amount = (sum of all products’ (unit_price * quantity)) + other_charges
            'discount' => "1",                                                //Discount of the transaction. The Total amount of the invoice will be= amount - discount

            //Invoice Information
            'title' => "John Doe",               // Customer's Name on the invoice
            "reference_no" => "1231231",        //Invoice reference number in your system

        ));


        //  dd($result);

        if ($result->response_code == 4012) {
            return redirect($result->payment_url);
        }
        if ($result->response_code == 4094) {
            return $result->details;
        }

        return $result->result;
    }
    /**
     * Check this function, if not important just delete them
     */
    public function response(Request $request)
    {

        $result = Paytabs::getInstance()->verify_payment($request->payment_reference);

        if ($result->response_code == 100) {
            //success
            $this->createInvoice((array)$result);
        }
        return $result->result;
    }
    /**
     * Check this function, if not important just delete them
     */
    public function createInvoice($request)
    {
        $request['order_id'] = $request["reference_no"];
        PaytabsInvoice::create($request);
    }
}

