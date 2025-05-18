<?php

declare (strict_types = 1);

namespace App\Models\PPDB;

use App\Models\Model;
use App\Models\User;

class PpdbDocument extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'registration_id',
        'document_type',
        'file_url',
        'verification_status',
        'verified_by',
        'verified_at',
        'notes',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // Relationships
    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
