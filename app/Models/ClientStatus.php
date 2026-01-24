<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientStatus extends Model
{
    use CrudTrait;

    protected $table = 'client_statuses';

    protected $fillable = [
        'status_name',
        'min_percentage',
        'max_percentage',
    ];
}