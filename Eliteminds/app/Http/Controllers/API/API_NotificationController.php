<?php


namespace App\Http\Controllers\API;


use Carbon\Carbon;

class API_NotificationController
{
    public function index(){
        return response()->json([
            'notifications' => [
//                [
//                    'description'   => 'Payment Completed',
//                    'read_at'       => null,
//                    'created_at'    => Carbon::now()->subHour(),
//                ],
                [
                    'description'   => 'Welcome to '.env('APP_NAME'),
                    'read_at'       => Carbon::now(),
                    'created_at'    => Carbon::now()->subDay(),
                ]
            ]
        ], 200);
    }
}
