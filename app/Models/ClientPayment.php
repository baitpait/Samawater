<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Business Purpose: مدفوعات المشتركين
 * - المدفوعات مرتبطة بالمشترك فقط (وليس بالفواتير)
 * - يمكن استخدامها لتسجيل أي دفعة من المشترك
 */
class ClientPayment extends Model
{
    use CrudTrait;

    protected $table = 'client_payments';
    
    protected $fillable = [
        'client_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_number',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * العلاقة مع المشترك
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * العلاقة مع المستخدم الذي سجل الدفعة
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
