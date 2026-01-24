<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    use CrudTrait;
    protected $table = 'subscription_types';

    protected $fillable = [
        'type_name',
        'description',
        'distribution_days'
    ];

    /**
     * العلاقة مع المشتركين
     */
    public function clients()
    {
        return $this->hasMany(\App\Models\Client::class, 'subscription_type_id');
    }

    /**
     * التحقق من إمكانية الحذف
     */
    public function canBeDeleted()
    {
        return $this->clients()->count() === 0;
    }

    /**
     * عدد المشتركين الذين يستخدمون هذا النوع
     */
    public function getClientsCountAttribute()
    {
        return $this->clients()->count();
    }
}