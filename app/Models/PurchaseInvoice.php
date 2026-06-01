<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Business Purpose: فاتورة مشتريات من مورد — عند التأكيد تُضاف الكميات إلى المخزون.
 */
class PurchaseInvoice extends Model
{
    use CrudTrait;
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
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
     * Business Purpose: المورد المرتبط بالفاتورة.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Business Purpose: بنود الأصناف المشتراة.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseInvoiceItem::class, 'purchase_invoice_id');
    }

    /**
     * Business Purpose: مدفوعات المورد المرتبطة بهذه الفاتورة.
     */
    public function vendorPayments(): HasMany
    {
        return $this->hasMany(VendorPayment::class, 'purchase_invoice_id');
    }

    /**
     * Business Purpose: من أنشأ الفاتورة.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Business Purpose: توليد رقم فاتورة مشتريات فريد (PUR-YYYY-XXX).
     */
    public static function generateInvoiceNumber(): string
    {
        $year = Carbon::now()->format('Y');
        $maxAttempts = 10;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $last = self::query()
                ->where('invoice_number', 'like', 'PUR-' . $year . '-%')
                ->orderByDesc('id')
                ->value('invoice_number');

            $next = 1;
            if (is_string($last) && preg_match('/PUR-' . $year . '-(\d+)$/', $last, $matches)) {
                $next = (int) $matches[1] + 1;
            }

            $candidate = sprintf('PUR-%s-%03d', $year, $next);

            if (! self::query()->where('invoice_number', $candidate)->exists()) {
                return $candidate;
            }

            $attempt++;
        }

        return sprintf('PUR-%s-%s', $year, Carbon::now()->format('His'));
    }

    /**
     * Business Purpose: مجموع بنود الفاتورة.
     */
    public function calculateTotalAmount(): float
    {
        return (float) $this->items()->sum('total_cost');
    }

    /**
     * Business Purpose: تأكيد الفاتورة وإضافة الكميات للمخزون.
     */
    public function confirm(): bool
    {
        if ($this->status === 'confirmed') {
            return false;
        }

        foreach ($this->items as $item) {
            InventoryItem::addQuantity($item->item_name, (int) $item->quantity);
        }

        $this->status = 'confirmed';
        $this->total_amount = $this->calculateTotalAmount();
        $this->save();

        return true;
    }

    /**
     * Business Purpose: إلغاء فاتورة مؤكدة وعكس إدخال المخزون.
     */
    public function cancel(): bool
    {
        if ($this->status !== 'confirmed') {
            return false;
        }

        foreach ($this->items as $item) {
            InventoryItem::subtractQuantity($item->item_name, (int) $item->quantity);
        }

        $this->status = 'cancelled';
        $this->save();

        return true;
    }
}
