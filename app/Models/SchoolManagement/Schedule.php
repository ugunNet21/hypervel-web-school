<?php

declare (strict_types = 1);

namespace App\Models\SchoolManagement;

use App\Models\Model;

class Schedule extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'class_subject_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'start_time'  => 'datetime:H:i',
        'end_time'    => 'datetime:H:i',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // Relationships
    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class);
    }
}
