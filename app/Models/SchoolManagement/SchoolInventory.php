<?php

declare (strict_types = 1);

namespace App\Models\SchoolManagement;

use App\Models\Model;

class SchoolInventory extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'location',
        'condition',
        'purchase_date',
        'last_maintenance',
    ];

    protected $casts = [
        'purchase_date'    => 'date',
        'last_maintenance' => 'date',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];
}
