<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class CashWithdraw extends Model
{
    use CrudTrait;

    protected $table = 'cash_withdraws';

    protected $fillable = [
        'distributor_id',
        'total_amount',
        'notes'
        ];
        
        

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id');
    }
}