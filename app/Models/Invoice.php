<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Business Purpose: فواتير المبيعات للعملاء
 * - تحتوي على أصناف من المخزون
 * - يتم خصم المخزون عند تأكيد الفاتورة
 * - يمكن تعديل وحذف الفواتير المؤكدة
 */
class Invoice extends Model
{
    use CrudTrait;

    protected $table = 'invoices';
    
    protected $fillable = [
        'client_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'status',
        'payment_status',
        'amount_paid',
        'payment_method',
        'payment_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'payment_date' => 'date',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    /**
     * العلاقة مع المشترك
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * العلاقة مع أصناف الفاتورة
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * العلاقة مع المستخدم الذي أنشأ الفاتورة
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Business Purpose: توليد رقم فاتورة تلقائي مع التحقق من عدم التكرار
     * Format: INV-YYYY-XXX (مثال: INV-2026-001)
     * 
     * يستخدم retry logic لضمان عدم التكرار في حالات التزامن
     */
    public static function generateInvoiceNumber(): string
    {
        $year = Carbon::now()->format('Y');
        $maxAttempts = 10; // عدد المحاولات القصوى
        $attempt = 0;
        
        while ($attempt < $maxAttempts) {
            // البحث عن آخر فاتورة في نفس السنة
            $lastInvoice = self::where('invoice_number', 'like', "INV-{$year}-%")
                ->orderBy('invoice_number', 'desc')
                ->first();
            
            if ($lastInvoice) {
                $lastNumber = (int) substr($lastInvoice->invoice_number, -3);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            $invoiceNumber = sprintf('INV-%s-%03d', $year, $newNumber);
            
            // التحقق من عدم وجود الرقم في قاعدة البيانات
            $exists = self::where('invoice_number', $invoiceNumber)->exists();
            
            if (!$exists) {
                return $invoiceNumber;
            }
            
            // إذا كان الرقم موجوداً، نزيد الرقم ونحاول مرة أخرى
            $attempt++;
            $newNumber++;
        }
        
        // في حالة فشل جميع المحاولات، نستخدم timestamp كبديل
        return sprintf('INV-%s-%s', $year, Carbon::now()->format('His'));
    }

    /**
     * Business Purpose: حساب المبلغ الإجمالي من الأصناف
     */
    public function calculateTotalAmount(): float
    {
        return $this->items()->sum('total_price');
    }

    /**
     * Business Purpose: تأكيد الفاتورة (خصم من المخزون)
     */
    public function confirm(): bool
    {
        if ($this->status === 'confirmed') {
            return false; // بالفعل مؤكدة
        }

        // خصم من المخزون (يمكن بيع حتى لو الكمية 0)
        foreach ($this->items as $item) {
            InventoryItem::subtractQuantity($item->item_name, $item->quantity);
        }

        $this->status = 'confirmed';
        $this->total_amount = $this->calculateTotalAmount();
        $this->save();

        return true;
    }

    /**
     * Business Purpose: إلغاء فاتورة مؤكدة (إرجاع المخزون)
     */
    public function cancel(): bool
    {
        if ($this->status !== 'confirmed') {
            return false; // ليست مؤكدة
        }

        // إرجاع الكميات إلى المخزون
        foreach ($this->items as $item) {
            InventoryItem::addQuantity($item->item_name, $item->quantity);
        }

        $this->status = 'cancelled';
        $this->save();

        return true;
    }

    /**
     * Business Purpose: إعادة تأكيد فاتورة ملغاة
     */
    public function reconfirm(): bool
    {
        if ($this->status !== 'cancelled') {
            return false;
        }

        return $this->confirm();
    }
}
