<?php

declare (strict_types = 1);

namespace App\Models\ELearning;

use App\Models\Model;
use App\Models\User;

class DiscussionReply extends Model
{
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'discussion_id',
        'content',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
