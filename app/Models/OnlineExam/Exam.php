<?php

declare(strict_types=1);

namespace App\Models\OnlineExam;

use App\Models\Grading\Grade;
use App\Models\Model;
use App\Models\SchoolManagement\ClassModel;
use App\Models\SchoolManagement\Subject;
use App\Models\User;

class Exam extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'exam_type',
        'subject_id',
        'class_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'passing_grade',
        'is_published',
        'proctoring_enabled',
        'created_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'passing_grade' => 'decimal:2',
        'is_published' => 'boolean',
        'proctoring_enabled' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
