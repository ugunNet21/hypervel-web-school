<?php

declare (strict_types = 1);

namespace App\Models\SchoolManagement;

use App\Models\CareerDevelopment\CounselingSession;
use App\Models\ELearning\VirtualClass;
use App\Models\Model;
use App\Models\User;

class Teacher extends Model
{

    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'user_id',
        'nip',
        'expertise',
        'join_date',
        'status',
    ];

    protected $casts = [
        'join_date'  => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'homeroom_teacher_id');
    }

    public function classSubjects()
    {
        return $this->hasMany(ClassSubject::class);
    }

    public function virtualClasses()
    {
        return $this->hasMany(VirtualClass::class);
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class, 'counselor_id');
    }
}
