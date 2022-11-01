<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentApprove extends Model
{
    protected $table = 'payment_approves';
    public $primaryKey = 'id';
    public $timestamps = true;
}
