<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{

    public function promote($coupon_id){
        $all = \App\Coupon::all();
        foreach($all as $coupon){
            $coupon->promote = 0;
            $coupon->save();
        }

        // promote me
        $coupon = \App\Coupon::find($coupon_id);
        if($coupon){
            if(\Carbon\Carbon::parse($coupon->expire_date)->gt(\Carbon\Carbon::now()) && ($coupon->no_use) > 0) {
                $coupon->promote = 1;
                $coupon->save();
                return back()->with('success', 'promoted.');
            }
            return back()->with('error', 'this coupon is expired !');
        }
        return back();

    }

    public function demote($coupon_id){
        $coupon = \App\Coupon::find($coupon_id);
        if($coupon){
            $coupon->promote = 0;
            $coupon->save();
            return back()->with('success', 'Demoted');
        }
        return back();
    }

    public function generate_5digit(){
        return rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }
    public function generate_coupon(){
        return env('APP_NAME').'-'.$this->generate_5digit().'-'.$this->generate_5digit().'-'.$this->generate_5digit();
    }

    public function create_coupons(){
        return view('admin.coupons.create');
    }

    public function generate(Request $req){
        
        
        /**
         * calculate if its expired or not
         */
        // $c = \App\Coupon::all()->first();
        // $expires_at = Carbon::parse($c->expire_date);
        
        // if(Carbon::parse($c->expire_date)->diffInHours(Carbon::now()) > 0){
        //     return 'expire in '.$expires_at->diffInDays(Carbon::now()).'days';
        // }
        // return 'expired !';


        /**
         * check numbers
         * 
         * coupons_num
         * coupon_price
         * coupons_expire_after
         * 
         */



        if( 
            !is_numeric($req->input('coupon_price'))  ||
            !is_numeric($req->input('coupons_expire_after'))  ||
            !is_numeric($req->input('coupon_no_use')) 
        )
        {
            return back()->with('error', 'please, enter numbers !');
        }

        if( 
            ($req->input('coupon_price') <= 0) ||
            ($req->input('coupons_expire_after') <= 0) ||
            ($req->input('coupon_no_use') <= 0)
            )
        {
            return back()->with('error', 'please, enter a valid values !');
        }
        
        
        
        if($req->package_id){
            if(!\App\Packages::find($req->input('package_id')) ){
                return back()->with('error', 'please, select valid package !');
            }
        }else if($req->event_id){
            if(!\App\Event::find($req->event_id)){
                return back()->with('error', 'please, select valid event');
            }
        }else{
            return back()->with('error', 'at lest choose event or package .');
        }








        $current = Carbon::now();
        $expire = $current->addDays($req->input('coupons_expire_after'));

        $check = 1;

        if($req->input('coupon_code') != '' && $req->input('coupon_code') != null){
            $code = $req->input('coupon_code');
            $check = \App\Coupon::where('code', '=', $code)->get()->first();
            if($check){
                return back()->with('error','Please Choose another Coupon Code');
            }
        }else{
            
            while($check){
                $code = $this->generate_coupon();    
                $check = \App\Coupon::where('code', '=', $code)->get()->first();
            }
        }
        
        

        

        if(!$check){

            $coupon = new \App\Coupon;
            $coupon->code = $code;
            $coupon->expire_date = $expire;
            $coupon->price = $req->input('coupon_price');
            $coupon->no_use = $req->input('coupon_no_use');
            if($req->package_id){
                $coupon->package_id = $req->input('package_id');
            }
            if($req->event_id){
                $coupon->event_id = $req->input('event_id');
            }
            $coupon->save();

        }
        // else pass the loop
        

        return \Redirect::to(route('coupon.show'))->with('success', 'Process Complete !');
        

    }


    public function show(){
        return view('admin.coupons.show');
    }

    public function destroy(Request $req, $id){ 
        $coupon = \App\Coupon::find($id);
        $coupon->delete();
        return back()->with('success', 'Coupon Deleted !');
    }

}
