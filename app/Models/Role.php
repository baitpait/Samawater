<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use CrudTrait;

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
