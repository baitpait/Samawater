<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Models\User;

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
        'for_future_obligation',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'for_future_obligation' => 'boolean',
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

    /**
     * Business Purpose: تسليم واحد على الأكثر يعتمد هذه الدفعة كمدفوع على سطر البيع بالتسليم.
     */
    public function linkedDelivery(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Delivery::class, 'client_payment_id');
    }
}
