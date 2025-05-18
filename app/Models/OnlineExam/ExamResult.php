<?php

declare(strict_types=1);

namespace App\Models\OnlineExam;

use App\Models\Model;
use App\Models\SchoolManagement\Student;

class ExamResult extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'exam_id',
        'student_id',
        'start_time',
        'end_time',
        'total_score',
        'passing_status',
        'proctoring_notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_score' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class);
    }
}
