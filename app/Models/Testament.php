<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Testament extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'send_at',
        'recipient_email',
        'is_encrypted',
        'sent_at',
        'status',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(TestamentImage::class);
    }
}
