<?php

declare (strict_types = 1);

namespace App\Models\ParentPortal;

use App\Models\Model;
use App\Models\SchoolManagement\Student;
use App\Models\User;

class ParentOrtu extends Model
{
    /**
     * The attributes that are mass assignable.
     */

    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'user_id',
        'occupation',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
