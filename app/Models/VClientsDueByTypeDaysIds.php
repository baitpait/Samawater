<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class VClientsDueByTypeDaysIds extends Model
{
    use CrudTrait;

    protected $table = 'v_clients_due_by_type_days_ids';
    protected $primaryKey = 'client_id';
    public $incrementing = false;
    public $timestamps = false;

    // View = Read Only
    public function setAttribute($key, $value)
    {
        return;
    }
}