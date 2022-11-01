<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentApproveHistory extends Model
{
    protected $table = 'payment_approve_histories';
    public $primaryKey = 'id';
    public $timestamps = true;
}
