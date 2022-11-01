<?php
//\App\Config::where('x','=',1)->get()->first() ? 'AaNKJjPBv3AsN6SwcXNTGnybD-j_h6RWKJKNlgFib75-N-72NxyWqcesNdRkI1ul_IFVYj-0-GmVjSna' :
//\App\Config::where('x','=',1)->get()->first() ? 'ECB9NtbxKe2Brvpa1UGlt92x4BZMxxDpXVTiKa_xFuEJLi42c-vD_kvOy1PNMwVwde9RMHAzyOiaYLfb' : 
    return [ 
        'client_id' =>  env('PAYPAL_CLIENT_ID',''),
        'secret' => env('PAYPAL_SECRET',''),
        'settings' => array(
            'mode' => env('PAYPAL_MODE','sandbox'),
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        ),
    ];