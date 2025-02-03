<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'gateway_name',
        'gateway_id',
        'gateway_trnx_id',
        'rrn_number',
        'amount',
        'plan',
        'transaction_mode'
    ];
}
