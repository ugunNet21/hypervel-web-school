<?php

declare (strict_types = 1);

namespace App\Models\SchoolManagement;

use App\Models\ELearning\VirtualClass;
use App\Models\Grading\Grade;
use App\Models\Grading\Report;
use App\Models\Model;
use App\Models\OnlineExam\Exam;

class ClassModel extends Model
{

    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'name',
        'level',
        'homeroom_teacher_id',
        'academic_year',
        'capacity',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

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

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
