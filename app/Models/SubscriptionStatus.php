<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;


class SubscriptionStatus extends Model
{
    use CrudTrait; // ✅ هذا السطر هو الحل

    protected $table = 'subscription_statuses';

    protected $fillable = [
        'status_name'
    ];

    // protected $guarded = ['id'];

    /**
     * العلاقة مع المشتركين
     */
    public function clients()
    {
        return $this->hasMany(\App\Models\Client::class, 'subscription_status_id');
    }

    /**
     * التحقق من إمكانية الحذف
     */
    public function canBeDeleted()
    {
        return $this->clients()->count() === 0;
    }

    /**
     * عدد المشتركين الذين يستخدمون هذه الحالة
     */
    public function getClientsCountAttribute()
    {
        return $this->clients()->count();
    }
}