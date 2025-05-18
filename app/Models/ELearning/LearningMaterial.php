<?php

declare (strict_types = 1);

namespace App\Models\ELearning;

use App\Models\Model;
use App\Models\User;

class LearningMaterial extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'virtual_class_id',
        'title',
        'content',
        'file_url',
        'material_type',
        'is_published',
        'publish_date',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'publish_date' => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // Relationships
    public function virtualClass()
    {
        return $this->belongsTo(VirtualClass::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
