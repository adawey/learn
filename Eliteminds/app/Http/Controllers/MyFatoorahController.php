<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Payment\Payment as PaymentHelper;
use \App\Payments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MyFatoorahController extends Controller
{
    /**
     * Payment Helper Functions
     */
    use PaymentHelper;

    /**
     * MyFatoorah API Variables
     * @var string
     */
    //private $baseURL            = "https://apitest.myfatoorah.com";
    private $baseURL            = "https://api.myfatoorah.com";
    private $currency           = 'USD';
    //private $token              = 'cxu2LdP0p0j5BGna0velN9DmzKJTrx3Ftc0ptV8FmvOgoDqvXivkxZ_oqbi_XM9k7jgl3SUriQyRE2uaLWdRumxDLKTn1iNglbQLrZyOkmkD6cjtpAsk1_ctrea_MeOQCMavsQEJ4EZHnP4HoRDOTVRGvYQueYZZvVjsaOLOubLkdovx6STu9imI1zf5OvuC9rB8p0PNIR90rQ0-ILLYbaDZBoQANGND10HdF7zM4qnYFF1wfZ_HgQipC5A7jdrzOoIoFBTCyMz4ZuPPPyXtb30IfNp47LucQKUfF1ySU7Wy_df0O73LVnyV8mpkzzonCJHSYPaum9HzbvY5pvCZxPYw39WGo8pOMPUgEugtaqepILwtGKbIJR3_T5Iimm_oyOoOJFOtTukb_-jGMTLMZWB3vpRI3C08itm7ealISVZb7M3OMPPXgcss9_gFvwYND0Q3zJRPmDASg5NxRlEDHWRnlwNKqcd6nW4JJddffaX8p-ezWB8qAlimoKTTBJCe5CnjT4vNjnWlJWscvk38VNIIslv4gYpC09OLWn4rDNeoUaGXi5kONdEQ0vQcRjENOPAavP7HXtW1-Vz83jMlU3lDOoZsdEKZReNYpvdFrGJ5c3aJB18eLiPX6mI4zxjHCZH25ixDCHzo-nmgs_VTrOL7Zz6K7w6fuu_eBK9P0BDr2fpS';
    private $token              = 'R-R7OnHcW35Q3DwJPzInEbbtxuCyam6EbGBWTRfk73AbaTvrY6xst8oeRDyGEOPfQVhOzdwXXqcZ2sj7tjSMgbDorLZk8mknc5ZsB8ZXV3y39arH7D14j9Ed6x13tKgJasCdH8sUysXt10L_0UD4qiwdp32vr5uckMiRfrTHFe01K7DsgUGY1xzlM2gRX7ef3BQ6nbJsHvteAVVkRTYVz9I0IDTHYHwXYYKKX6pAOsQ44XNVzdlqKAF1_W8mjC2lcrqe0lHJR_lEH0VThB2FULT43gE_qxf7XwVummRZpGqX0DeCpl_5PVDdl3vEkcr0uBbdRq_b2dj5tWHLfiI48xHSqxBc6rmrtkEM130YLSz1B533MZysGNnD9P3FqAWmgAQNcOf169vrWhOvulOfAN-VU0RegGUrLPYvOZTMPmefYHzsKuyAz_wK4T90MNvfDx3dGleGM3YW5ChtvGTTTIEquGefWK4w4QlfoWipxVQuTR811qbzNkZXxzR-9Cq9B0k8chkIAJDBj_dlXVlp5FCuvk_3W9fVcMkCNTb8XWW8R6ra_KsIek44S6PwaS-V_DiHeXc_SAB0FcZ5y4uDbr0ZxzLqkklf8D2h3C76rMWBXc7gDhnG56hYAeJ66neUHgAnF5XUdTS4dx8-VES6aUl1Xc_8hG7PkySeir8wd2ajzDNhIfgjXEfT1L7qleIT12Yklg';

    /**
     * Only Authenticated Users.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * check item is available and active and user do not have it
     * @param $item_id
     * @param $item_type
     * @return int
     */
    public function MyFatoorah_CheckItem($item_id, $item_type){
        return $this->CheckItem($item_id, $item_type);
    }

    /**
     *
     * @param $coupon
     * @param $item_id
     * @param $item_type
     * @return array|object
     */
    public function MyFatoorah_PriceDetails($coupon, $item_id, $item_type){
        return $this->PriceDetails($coupon, $item_id, $item_type);
    }

    public function init_payment($total_price){
        ####### Initiate Payment ######
        $body = [
            'InvoiceAmount'     => $total_price,
            'CurrencyIso'       => $this->currency,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->baseURL."/v2/InitiatePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $this->token","Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if($response->Message == 'Initiated Successfully!'){
            return ($response);
        }
        return null;
    }

    public function exec_payment($product_name, $total_price, $product_ref){
        ####### Execute Payment ######
        $user = Auth::user();

        $curl = curl_init();
        $body = [
            'PaymentMethodId'   => '2',
            'CustomerName'      => $user->name,
            'DisplayCurrencyIso'=> $this->currency,
            'MobileCountryCode' => '',
            'CustomerMobile'    => '',
            'CustomerEmail'     => $user->email,
            'InvoiceValue'      => $total_price,
            'CallBackUrl'       => route('myfatoorah.callback'),
            'ErrorUrl'          => route('myfatoorah.error.callback'),
            'Language'          => 'en',
            'CustomerReference' => "$user->id",
            'CustomerCivilId'   => '',
            'UserDefinedField'  => "$product_ref",
            'ExpireDate'        => '',
            'CustomerAddress'   => [
                'Block'                 => '',
                'Street'                => '',
                'HouseBuildingNo'       => '',
                'Address'               => '',
                'AddressInstructions'   => '',
            ],
            'InvoiceItems'      => [
                [
                    'ItemName'  => $product_name,
                    'Quantity'  => 1,
                    'UnitPrice' => $total_price,
                ],
            ],
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->baseURL."/v2/ExecutePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $this->token","Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        return ($response);
    }

    public function get_payment_status($payment_id){


        //####### Prepare Data ######
        $url    = $this->baseURL."/v2/getPaymentStatus";
        $data   = array(
            'KeyType' => 'paymentId',
            'Key'     => "$payment_id" //the callback paymentID
        );
        $fields = json_encode($data);

        //####### Call API ######
        $curl = curl_init($url);

        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $fields,
            CURLOPT_HTTPHEADER     => array("Authorization: Bearer $this->token", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $res = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);
        return ($res);
    }

    public function charge(Request $req){

        $item_type = $req->item_type;
        $item_id = $req->item_id;
        $coupon_code = $req->coupon_code;
        $thisUser = Auth::user();


        if(!$thisUser){
            return response()->json([
                'error'     => 'Something Went Wrong',
                'url'       => ''
            ], 200);
        }

        $item = $this->MyFatoorah_CheckItem($item_id, $item_type);
        if(!$item){
            return response()->json([
                'error'     => 'This Item is not Available.',
                'url'       => ''
            ], 200);
        }

        $price = 0;
        $price_details = $this->MyFatoorah_PriceDetails($coupon_code, $item_id, $item_type);


        if($price_details['price'] > $price_details['discount']){
            $price = $price_details['price'] - $price_details['discount'];
        }

        /**
         * Init Payment
         */
        $init = $this->init_payment($price); // USD
        /**
         * Execute Payment
         */
        $exec = $this->exec_payment($item->name, $price, $item_type.','.$item_id.','.$coupon_code);
        if($exec->IsSuccess){
            return response()->json([
                'error'     => '',
                'url'       => $exec->Data->PaymentURL
            ], 200);

        }

        return response()->json([
            'error'     => 'payment could not be executed.',
            'url'       => '',
            'dump'      => $exec,
            'price'     => $price,
        ], 200);

    }

    public function callBack(){
        $status = $this->get_payment_status(request()->paymentId);

        if(!$status->IsSuccess || $status->ValidationErrors){
            return \Redirect::to(route('user.dashboard'))->with('error', 'Your Payment was Declined. Please choose another payment method.');
        }

        if($status->Data->InvoiceStatus != 'Paid'){
            return \Redirect::to(route('user.dashboard'))->with('error', 'Your Payment was Declined. Please choose another payment method.');
        }

        $user_id = (int)$status->Data->CustomerReference;
        $product = explode(',', $status->Data->UserDefinedField);
        $item_type = $product[0];
        $item_id = (int)$product[1];
        $coupon_code = $product[2];

        $user = \App\User::find($user_id);


        // add item to user
        $pd = new Payments;
        $pd->user_id            = $user->id;
        $pd->buyerID            = $status->Data->InvoiceReference;
        $pd->paymentID          = request()->paymentId;
        $pd->cartID             = '';
        $pd->totalPaid          = $status->Data->InvoiceTransactions[0]->PaidCurrencyValue;
        $pd->currency           = $status->Data->InvoiceTransactions[0]->PaidCurrency;
        $pd->paypalEmail        = $user->email;
        $pd->countryCode        = '';
        $pd->paymentMethod      = 'MyFatoorah';
        $pd->complete           = 1;
        $coupon = \App\Coupon::where('code', '=', $coupon_code)->get()->first();
        if($coupon){
            /**
             * check expiration
             */
            if(\Carbon\Carbon::parse($coupon->expire_date)->gt(\Carbon\Carbon::now()) && ($coupon->no_use) > 0){
                /**
                 * not expired
                 */
                $pd->coupon_code = $coupon->code;
                $coupon->no_use -= 1;
                $coupon->save();

            }
        }
        $pd->save();

        if($item_type == 'package'){
            // update payment_approves table
            $approve = new \App\PaymentApproveHistory;
            $approve->user_id = $user->id;
            $approve->package_id = $item_id; // package id from parameters
            $approve->payment_id = $pd->id;
            $approve->save();

            $up = new \App\UserPackages;
            $up->package_id = $item_id;
            $up->user_id = $user->id;
            $up->save();

            $package = \App\Packages::find($item_id);
            /**
             * update notification table
             */
            $noti = new \App\Notification;
            $noti->description = 'MyFatoorah Payment: Requested by User: '.$user->email.'and Accepted, '.$package->name;
            $noti->save();

            try{
                Mail::to($user->email)->send(new \App\Mail\EnrollConfirmationMail($package->enroll_msg));
            }catch(\Exception $e){
                /**
                 * do nothing !
                 */
            }

        }

        if($item_type == 'event'){
            $newEvent = new \App\EventUser;
            $newEvent->user_id = $user->id;
            $newEvent->event_id = $item_id;
            $newEvent->payment_id = $pd->id;
            $newEvent->save();

            $event_details = \App\Event::find($item_id);

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
        
        $invoiceData = [
            'name'  =>  $user->name,
            'email' =>  $user->email,
            'price' => $pd->totalPaid,
            'currency'  => $pd->currency,
            'payment_id'    => $pd->paymentID,
            'product_name'  => $item_type == 'package' ? $package->name: $event_details->name,
            'date'  => $pd->created_at
            
        ];
        $this->invoiceEmail($invoiceData, 'MyFatoorah');

        return redirect()->route('my.package.view')->with('success', 'Payment complete.');
    }

    public function errorCallBack(){
        $status = $this->get_payment_status(request()->paymentId);
        return \Redirect::to(route('my.package.view'))->with('error', 'Your Payment was Declined. Please choose another payment method.');
    }

    public function test()
    {
        
        $invoiceData = [
            'name'  =>  'mohamed',
            'email' =>  'mrgeek.mohamed@gmail.com',
            'price' => '10',
            'currency'  => '$',
            'payment_id'    => '234234234',
            'product_name'  => 'good item',
            'date'  => 'date'
            
        ];
        $this->invoiceEmail($invoiceData);
        return 'done';
        /**
         * Get Payment Status
         */
        $status = $this->get_payment_status('060628430019582161');
        dd($status);

        /**
         * Init Payment
         */
        $init = $this->init_payment(100); // USD
        /**
         * Execute Payment
         */
        $exec = $this->exec_payment('Product 1', 100);

        dd($exec);
    }

}
