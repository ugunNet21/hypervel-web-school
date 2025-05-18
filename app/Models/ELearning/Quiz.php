<?php

declare(strict_types=1);

namespace App\Models\ELearning;

use App\Models\Grading\Grade;
use App\Models\Model;
use App\Models\User;

class Quiz extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'virtual_class_id',
        'title',
        'description',
        'time_limit_minutes',
        'max_attempts',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
