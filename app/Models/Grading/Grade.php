<?php

declare (strict_types = 1);

namespace App\Models\Grading;

use App\Models\ELearning\AssignMent;
use App\Models\ELearning\Quiz;
use App\Models\Model;
use App\Models\OnlineExam\Exam;
use App\Models\SchoolManagement\ClassModel;
use App\Models\SchoolManagement\Student;
use App\Models\SchoolManagement\Subject;
use App\Models\User;

class Grade extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'grade',
        'semester',
        'grade_type',
        'assignment_id',
        'quiz_id',
        'exam_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'grade'      => 'decimal:2',
        'semester'   => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class ()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function assignment()
    {
        return $this->belongsTo(AssignMent::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
