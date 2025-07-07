<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestamentAttachment extends Model
{
    protected $fillable = [
        'testament_id',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    public function testament(): BelongsTo
    {
        return $this->belongsTo(Testament::class);
    }
}
