<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class User extends Authenticatable
{
    use CrudTrait;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'distributor_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * يحدد تحويلات الحقول لضمان قراءة البيانات بشكل صحيح.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * يربط المستخدم بنوعه التشغيلي لإدارة الصلاحيات.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * يربط المستخدم بالموزع المسؤول لتحديد الصلاحيات التشغيلية.
     */
    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class, 'distributor_id');
    }

    /**
     * يتحقق إن كان المستخدم يمتلك دوراً محدداً للتحكم بالوصول.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role !== null && $this->role->name === $roleName;
    }

    /**
     * يتحقق إن كان المستخدم يمتلك أي دور من قائمة أدوار.
     */
    public function hasAnyRole(array $roleNames): bool
    {
        if ($this->role === null) {
            return false;
        }

        return in_array($this->role->name, $roleNames, true);
    }

    /**
     * يحدد إن كان المستخدم مسؤولاً رئيسياً للتحكم الكامل.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role !== null && $this->role->is_super_admin === true;
    }

    /**
     * يحدد إن كان المستخدم مسؤولاً عاماً لإدارة النظام.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(Role::NAME_ADMIN);
    }

    /**
     * يحدد إن كان المستخدم موزعاً بصلاحيات محدودة.
     */
    public function isDistributor(): bool
    {
        return $this->hasRole(Role::NAME_DISTRIBUTOR);
    }

    /**
     * يحدد إن كان المستخدم مسؤولاً (عاماً أو رئيسياً).
     */
    public function isAdminOrSuperAdmin(): bool
    {
        return $this->hasAnyRole([Role::NAME_ADMIN, Role::NAME_SUPER_ADMIN]);
    }

    /**
     * يحدد إن كان المستخدم يستطيع إدارة المستخدمين للحفاظ على الحوكمة.
     */
    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Business Purpose: البحث عن مستخدم برقم الهاتف (للموزعين).
     * 
     * يسمح للموزعين بتسجيل الدخول برقم الهاتف بدلاً من email.
     * 
     * @param string $phone رقم الهاتف
     * @return User|null
     */
    public static function findByPhone(string $phone): ?self
    {
        // البحث عن موزع برقم الهاتف
        $distributor = \App\Models\Distributor::where('phone', $phone)->first();
        
        if ($distributor) {
            // البحث عن المستخدم المرتبط
            return self::where('distributor_id', $distributor->id)->first();
        }
        
        return null;
    }
}
