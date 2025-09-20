<?php

namespace App\Models;

use App\Casts\ConvertDateCast;
use App\Casts\DecryptContentCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Testament extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'recipient_email',
        'sent_at',
        'status',
    ];

    protected $casts = [
        'created_at' => ConvertDateCast::class,
        'updated_at' => ConvertDateCast::class,
        'sent_at' => ConvertDateCast::class,
    ];

    public function testamentAttachments(): HasMany
    {
        return $this->hasMany(TestamentAttachment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
