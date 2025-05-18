<?php

declare(strict_types=1);

namespace App\Models\AIAssistant;

use App\Models\Model;
use App\Models\SchoolManagement\Subject;
use App\Models\User;

class AiTutorSession extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'subject_id',
        'session_topic',
        'conversation_history',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'conversation_history' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
