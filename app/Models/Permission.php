<?php

declare(strict_types=1);

namespace App\Models;

use Hyperf\Database\Model\Model;

class Permission extends Model
{
    protected string $primaryKey = 'id'; // ✅ ubah dari ?string ke string
    protected string $keyType = 'string';
    public bool $incrementing = false;

    protected array $fillable = [
        'name',
        'guard_name',
    ];

    protected array $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the roles associated with the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    /**
     * Assign this permission to a role.
     */
    public function assignToRole(Role $role): void
    {
        RoleHasPermission::create([
            'permission_id' => $this->id,
            'role_id'       => $role->id,
        ]);
    }
}
