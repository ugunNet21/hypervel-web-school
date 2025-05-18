<?php

declare(strict_types=1);

namespace App\Models\Grading;

use App\Models\Model;
use App\Models\SchoolManagement\Student;

class StudentPortfolio extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'title',
        'description',
        'file_url',
        'portfolio_type',
        'date_added',
        'is_public',
    ];

    protected $casts = [
        'date_added' => 'date',
        'is_public' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
