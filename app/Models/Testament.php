<?php

namespace App\Models;

use App\Casts\ConvertDateCast;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class Testament extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'recipient_email',
        'is_encrypted',
        'sent_at',
        'status',
    ];

    protected $casts = [
        'created_at' => ConvertDateCast::class,
        'updated_at' => ConvertDateCast::class,
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

    public function scopeFilterTestaments(Builder $query, Request $request): LengthAwarePaginator
    {
        $query = auth()->user()->testaments();

        $query->when($request->filled('title'), function ($q) use ($request) {
            $q->where('title', 'like', "%{$request->title}%");
        });

        return $query->orderBy('id')
            ->paginate(5)
            ->withQueryString();
    }
}
