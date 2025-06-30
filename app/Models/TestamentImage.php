<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestamentImage extends Model
{
    protected $fillable = [
        'testament_id',
        'image_path',
    ];

    public function testament(): BelongsTo
    {
        return $this->belongsTo(Testament::class);
    }
}
