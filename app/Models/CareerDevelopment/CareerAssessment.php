<?php

declare(strict_types=1);

namespace App\Models\CareerDevelopment;

use App\Models\Model;
use App\Models\SchoolManagement\Student;
use App\Models\User;

class CareerAssessment extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'assessment_type',
        'assessment_date',
        'results',
        'recommendations',
        'created_by',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'results' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
