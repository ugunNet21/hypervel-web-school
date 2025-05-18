<?php

declare(strict_types=1);

namespace App\Models\OnlineExam;

use App\Models\Model;
use App\Models\SchoolManagement\Subject;
use App\Models\User;

class QuestionBank extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'subject_id',
        'question_type',
        'difficulty_level',
        'question_text',
        'options',
        'correct_answer',
        'explanation',
        'created_by',
    ];

    protected $casts = [
        'options' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class, 'question_id');
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'question_id');
    }
}
