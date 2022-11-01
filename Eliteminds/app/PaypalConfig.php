<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalConfig extends Model
{
    protected $table = 'paypal_configs';
    public $primaryKey = 'id';
    public $timestamps = true;
    
    public $fillable = [
        'term_of_service',
        'Privacy_Policy',
        'Refund_polices',
    ];

    public $transcodeColumns = [
        'term_of_service',
        'Privacy_Policy',
        'Refund_polices',
    ];
}
