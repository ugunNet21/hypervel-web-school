<?php

declare(strict_types=1);

namespace App\Models\PPDB;

use App\Models\Model;
use App\Models\User;

class PpdbTest extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'registration_id',
        'test_type',
        'score',
        'test_date',
        'administrator_id',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'test_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class);
    }

    public function administrator()
    {
        return $this->belongsTo(User::class, 'administrator_id');
    }
}
