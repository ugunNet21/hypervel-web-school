<?php

declare (strict_types = 1);

namespace App\Models\SchoolManagement;

use App\Models\AIAssistant\AiTutorSession;
use App\Models\ELearning\VirtualClass;
use App\Models\Grading\Compentency;
use App\Models\Grading\Grade;
use App\Models\Model;
use App\Models\OnlineExam\Exam;
use App\Models\OnlineExam\QuestionBank;

class Subject extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'code',
        'name',
        'description',
        'credit_hours',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function classSubjects()
    {
        return $this->hasMany(ClassSubject::class);
    }

    public function virtualClasses()
    {
        return $this->hasMany(VirtualClass::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function competencies()
    {
        return $this->hasMany(Compentency::class);
    }

    public function questions()
    {
        return $this->hasMany(QuestionBank::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function aiTutorSessions()
    {
        return $this->hasMany(AiTutorSession::class);
    }
}
