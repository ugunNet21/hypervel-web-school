<?php

declare(strict_types=1);

namespace App\Models\PPDB;

use App\Models\Model;

class PpdbRegistration extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'registration_number',
        'full_name',
        'birth_date',
        'birth_place',
        'gender',
        'parent_name',
        'parent_phone',
        'address',
        'previous_school',
        'intended_class',
        'status',
        'registration_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'registration_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function documents()
    {
        return $this->hasMany(PpdbAnnouncement::class);
    }

    public function tests()
    {
        return $this->hasMany(PpdbTest::class);
    }

    public function announcements()
    {
        return $this->hasMany(PpdbAnnouncement::class);
    }
}
