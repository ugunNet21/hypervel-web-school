<?php

declare (strict_types = 1);

namespace App\Models\Grading;

use App\Models\Model;
use App\Models\SchoolManagement\ClassModel;
use App\Models\SchoolManagement\Student;
use App\Models\User;

class Report extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'student_id',
        'class_id',
        'semester',
        'academic_year',
        'average_grade',
        'rank_in_class',
        'homeroom_notes',
        'principal_notes',
        'is_published',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'average_grade' => 'decimal:2',
        'semester'      => 'integer',
        'is_published'  => 'boolean',
        'published_at'  => 'datetime',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class ()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
