<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorBalance extends Model
{
    protected $table = 'v_distributor_balance';

    public $timestamps = false;

    protected $fillable = [
        'distributor_id',
        'total_payments',
        'total_withdraws',
        'balance'
    ];
}