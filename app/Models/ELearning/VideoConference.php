<?php

declare(strict_types=1);

namespace App\Models\ELearning;

use App\Models\Model;
use App\Models\User;

class VideoConference extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'virtual_class_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'meeting_id',
        'meeting_password',
        'created_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function virtualClass()
    {
        return $this->belongsTo(VirtualClass::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
