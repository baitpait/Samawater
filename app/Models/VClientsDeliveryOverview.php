<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class VClientsDeliveryOverview extends Model
{
    use CrudTrait;

    protected $table = 'v_clients_delivery_overview';

    // لأن الـ View ليس له auto increment
    protected $primaryKey = 'client_id';
    public $incrementing = false;

    // منع أي محاولة insert/update
    public $timestamps = false;

    protected $guarded = [];
}