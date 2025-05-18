<?php

declare (strict_types = 1);

namespace App\Models\CareerDevelopment;

use App\Models\Model;
use App\Models\SchoolManagement\Student;
use App\Models\SchoolManagement\Teacher;

class CounselingSession extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'student_id',
        'counselor_id',
        'session_date',
        'session_time',
        'duration_minutes',
        'notes',
        'follow_up_date',
    ];

    protected $casts = [
        'session_date'   => 'date',
        'session_time'   => 'datetime:H:i',
        'follow_up_date' => 'date',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Teacher::class, 'counselor_id');
    }
}
