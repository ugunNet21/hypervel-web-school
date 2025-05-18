<?php

declare (strict_types = 1);

namespace App\Models\System;

use App\Models\Model;

class SystemSetting extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
