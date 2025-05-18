<?php

declare (strict_types = 1);

namespace App\Models\PPDB;

use App\Models\Model;
use App\Models\User;

class PpdbAnnouncement extends Model
{

    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'registration_id',
        'announcement_type',
        'content',
        'published_by',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // Relationships
    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class);
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }
}
