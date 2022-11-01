<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayPalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(){
        return view('paypal');
    }

    public function update(Request $req){

        $this->validate($req, [
            'secret'=>'required',
            'client_id'=>'required',
            'bank_account'=>'required',
        ]);

        $paypal = \App\PaypalConfig::all()->first();
        $paypal->secret = $req->input('secret');
        $paypal->client_id = $req->input('client_id');
        $paypal->bank_account = $req->input('bank_account');
        $paypal->save();
        
        return view('paypal')->with('success','Updated Successfully !');
    }
}
