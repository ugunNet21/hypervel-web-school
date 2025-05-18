<?php

declare(strict_types=1);

namespace App\Models;

use Hyperf\Database\Model\Model;

class RoleHasPermission extends Model
{
    protected array $fillable = [
        'permission_id',
        'role_id',
    ];
    public bool $timestamps = false; // ✅
    protected array $casts = [];
}