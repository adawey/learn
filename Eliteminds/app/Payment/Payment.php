<?php


namespace App\Payment;


use App\Zone\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use View;

trait Payment
{
    private $accept_payments = true;

    public function PriceDetails($coupon, $item_id, $item_type){

        $locationDetails    = Zone::getLocation();
        $country_code       = $locationDetails->country_code;
        $clientIp           = $locationDetails->ip;

        /**
         * Search by zone price first
         */
        $item = DB::table('countries')
            ->leftJoin('zone_countries', 'countries.id', 'zone_countries.country_id')
            ->leftJoin('zones', 'zone_countries.zone_id', '=', 'zones.id')
            ->leftJoin(DB::raw('(SELECT * FROM zone_prices WHERE item_type=\''.$item_type.'\' AND item_id=\''. $item_id .'\') AS zone_prices'),
                'zones.id', '=', 'zone_prices.zone_id')
            ->where('countries.code', '=', $country_code)
            ->select(
                'zone_prices.zone_id',
                DB::raw('(countries.id) AS country_id'),
                'zone_prices.item_id',
                'zones.name',
                'countries.name',
                'code',
                'currency_name',
                'currency_symbol',
                'currency_code',
                'original_price',
                'price',
                'discount'
            )
            ->first();
        $item->item_id = $item_id;

        /**
         * attach default price if no price found !
         */
        if(!$item->price){
            if($item_type == 'package'){
                $holder = \App\Packages::find($item_id);
                $item->price = $holder->price;
                $item->original_price = $holder->original_price;
                $item->discount = $holder->discount;

            }elseif($item_type == 'event'){
                $holder = \App\Event::find($item_id);
                $item->price = $holder->price;
                $item->original_price = $holder->original_price;
                $item->discount = $holder->discount;

            }
        }





        $dicount = 0;
        $coupon = \App\Coupon::where('code', $coupon)->get()->first();
        if($coupon) {
            if (Carbon::parse($coupon->expire_date)->gt(Carbon::now()) && ($coupon->no_use) > 0) {
                if ($item_type == 'package') {
                    $check = $coupon->package_id == $item->item_id;
                } elseif ($item_type == 'event') {
                    $check = $coupon->event_id == $item->item_id;
                }
                if ($check) {
                    $dicount = $coupon->price;
                }
            }
        }


        /**
         * Convert to user country price
         */
        $price_exChange_list = Zone::currencyExchange([
            [$item->price ,$item->currency_code],
            [$item->original_price ,$item->currency_code],
            [$dicount, $item->currency_code],
        ]);

        return [
            'error' => '',
            'price' => $item->price,
            'discount' => $dicount,
            'country_code'=> $country_code,
            'localized_price'           => $price_exChange_list[0],
            'localized_original_price'  => $price_exChange_list[1],
            'localized_onItem_discount' => $item->discount,
            'localized_coupon_discount' => $price_exChange_list[2],
            'currency_code'             => $item->currency_code,
            'ip'                        => $clientIp,
        ];

    }

    public function CheckItem($item_id, $item_type){


        if(!$this->accept_payments) return null;

        $thisUser = Auth::user();
        if(!$thisUser){
            return null;
        }
 
        $item = null;
        if($item_type == 'package'){
            $item = \App\Packages::find($item_id);
        }elseif($item_type == 'event'){
            $item = \App\Event::find($item_id);
        }
        if($item){
            if($item->active == 0){
                return null;
            }

            if($item_type == 'package'){
                // user do not have this item
                $check = \App\UserPackages::where('user_id', $thisUser->id) //$thisUser
                    ->where('package_id', $item->id)->first();
                if($check){
                    return null;
                }
            }

            if($item_type == 'event') {
                $check = \App\EventUser::where('user_id', $thisUser->id)//$thisUser
                    ->where('event_id', $item->id)->first();
                if ($check) {
                    return null;
                }

                // if event ended.
                if(Carbon::now()->gt(Carbon::parse($item->end))){
                    return null;
                }
            }
        }
        return $item;
    }

    public function extension_payment_approve( $approve_id){
        $approve = \App\PaymentExtensionApprove::find($approve_id);
        if(!$approve){
            return 0;
        }

        $package = \App\Packages::find($approve->package_id);
        if(!$package){
            return 0;
        }


        $payment = \App\Payments::find($approve->payment_id);


        /**
         * update extension table
         */
        $expire_at = Carbon::now()->addDays($package->expire_in_days);

        $exten = new \App\PackageExtension;
        $exten->user_id = $approve->user_id;
        $exten->payment_id = $payment->id;
        $exten->package_id = $package->id;
        $exten->expire_at = $expire_at;
        $exten->save();


        $history = \App\ExtensionHistory::where('user_id','=', $approve->user_id)->where('package_id', '=', $package->id)->get()->first();
        if(!$history){
            $history = new \App\ExtensionHistory;
            $history->package_id = $package->id;
            $history->user_id = $approve->user_id;
            $history->extend_num = 0;
        }
        $history->extend_num += $package->extension_in_days;
        $history->save();

        $approve->delete();

        return 1;
    }
    
    public function invoiceEmail($data, $payment_method = '--'){
        
        /** Send Mail */
        $view = View::make('mails.invoice', [
            'data' => $data,
            'payment_method'    => $payment_method,
        ]);
        $addTos = [];
        $x = new \SendGrid\Mail\To();
        $x->setEmailAddress($data['email']);
        $x->setName($data['name']);
        $x->setSubject(env('APP_NAME').' Invoice');
        array_push($addTos, $x);

        $html = $view->render();
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(env('NO_REPLY_EMAIL'), env('APP_NAME'));
        $email->setSubject(env('APP_NAME').' Invoice');
        $email->addTos($addTos);
        $email->addContent(
            "text/html", $html
        );
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {
            // dd('Caught exception: '. $e->getMessage() ."\n");
        }
        

    }

}
