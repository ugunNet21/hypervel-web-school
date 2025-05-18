<?php

declare(strict_types=1);

namespace App\Models\OnlineExam;

use App\Models\Model;

class ExamQuestion extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'exam_id',
        'question_id',
        'points',
        'question_order',
    ];

    protected $casts = [
        'points' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function question()
    {
        return $this->belongsTo(QuestionBank::class, 'question_id');
    }
}
