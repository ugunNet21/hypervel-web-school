<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model;
use App\Models\Permission;
use App\Models\ModelHasRole;

class Role extends Model
{
    protected string $primaryKey = 'id';
    protected string $keyType = 'string';
    public bool $incrementing = false;
    protected array $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected array $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * Get the permissions associated with the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    /**
     * Assign this role to a model (e.g., User).
     */
    public function assignTo($user): void
    {
        if ($user instanceof User) {
            ModelHasRole::create([
                'role_id' => $this->id,
                'model_type' => get_class($user),
                'model_id' => $user->id,
            ]);
        } else {
            throw new \InvalidArgumentException('Expected instance of User');
        }
    }
}
