<?php

declare(strict_types=1);

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use CrudTrait;

    public const NAME_SUPER_ADMIN = 'super_admin';
    public const NAME_ADMIN = 'admin';
    public const NAME_DISTRIBUTOR = 'distributor';

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_super_admin',
    ];

    protected $casts = [
        'is_super_admin' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدمين
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
