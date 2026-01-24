<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Distributor extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasApiTokens;

    protected $table = 'distributors';

    protected $fillable = [
        'name',
        'phone',
        'username',
        'password_hash',
        'status',
        'notes',
        'latitude',
        'longitude',
        'last_update',
    ];
 
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];
// public function setPasswordHashAttribute($value)
// {
//     // ✅ إذا كان نصًا => شفّره
//     if (!empty($value) && substr($value, 0, 4) !== '$2y$') {
//         $this->attributes['password_hash'] = Hash::make($value);
//     }

//     // ✅ إذا كان Hash جاهز => خزنه كما هو
//     elseif (substr($value, 0, 4) === '$2y$') {
//         $this->attributes['password_hash'] = $value;
//     }
// }

//     protected $hidden = [
//         'password_hash',
//     ];

    /* ===============================
       العلاقات المالية
       =============================== */

    /**
     * الدفعات (دخل) - جدول delivery
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'distributor_id');
    }

    /**
     * السحوبات (خرج) - جدول cash_withdraws
     */
    public function cashWithdraws()
    {
        return $this->hasMany(CashWithdraw::class, 'distributor_id');
    }

    /**
     * العلاقة مع المشتركين
     */
    public function clients()
    {
        return $this->hasMany(\App\Models\Client::class, 'distributor_id');
    }

    /**
     * التحقق من إمكانية الحذف
     */
    public function canBeDeleted()
    {
        return $this->clients()->count() === 0;
    }

    /**
     * عدد المشتركين المرتبطين بهذا الموزع
     */
    public function getClientsCountAttribute()
    {
        return $this->clients()->count();
    }

    /* ===============================
       الحقول المحسوبة
       =============================== */

    /**
     * إجمالي الدفعات
     */
    public function getTotalPaymentsAttribute()
    {
        return $this->deliveries()->sum('paymant');
    }

    /**
     * إجمالي السحوبات
     */
    public function getTotalWithdrawsAttribute()
    {
        return $this->cashWithdraws()->sum('total_amount');
    }

    /**
     * الرصيد الحالي 🔥
     */
    public function getBalanceAttribute()
    {
        return $this->total_payments - $this->total_withdraws;
    }
}