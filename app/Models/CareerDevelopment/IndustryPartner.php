<?php

declare (strict_types = 1);

namespace App\Models\CareerDevelopment;

use App\Models\Model;

class IndustryPartner extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'name',
        'industry',
        'contact_person',
        'contact_email',
        'contact_phone',
        'partnership_details',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
