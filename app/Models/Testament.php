<?php

namespace App\Models;

use App\Casts\ConvertDateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;

class Testament extends Model
{
    use HasFactory;

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

    protected $casts = [
        'created_at' => ConvertDateCast::class,
        'updated_at' => ConvertDateCast::class,
        'send_at' => ConvertDateCast::class,
        'sent_at' => ConvertDateCast::class,
    ];

    public function images(): HasMany
    {
        return $this->hasMany(TestamentImage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function paginateTestaments(int $perPage): LengthAwarePaginator
    {
        return auth()->user()->testaments()
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }
}
